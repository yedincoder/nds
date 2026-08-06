<?php

namespace App\Modules\AdminArea\Controllers;

use App\Modules\FrontArea\Models\ProductModel;
use App\Modules\FrontArea\Models\ProductPriceModel;
use App\Modules\FrontArea\Models\ProductFileModel;
use App\Modules\FrontArea\Models\ProductCategoryModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends \App\Controllers\AdminBaseController
{
    protected ProductModel $productModel;
    protected ProductPriceModel $priceModel;
    protected ProductFileModel $fileModel;
    protected ProductCategoryModel $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->priceModel = new ProductPriceModel();
        $this->fileModel = new ProductFileModel();
        $this->categoryModel = new ProductCategoryModel();
    }

    public function index(): string
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $products = $this->productModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);
        $pager = $this->productModel->pager;

        // Fetch latest price for each product
        $db = \Config\Database::connect();
        $prices = [];
        $priceRows = $db->table('product_prices')
            ->whereIn('product_id', array_map(fn($p) => $p->id, $products ?: []))
            ->orderBy('id', 'DESC')
            ->get()
            ->getResult();
        foreach ($priceRows as $pr) {
            if (!isset($prices[$pr->product_id])) {
                $prices[$pr->product_id] = $pr->price;
            }
        }
        foreach ($products as $p) {
            $p->price = $prices[$p->id] ?? 0;
        }

        $data = [
            'title' => 'Products',
            'page'  => 'admin/products',
            'products' => $products,
            'pager' => $pager,
        ];

        return view('AdminArea/dashboard/products', $data);
    }

    public function create(): string
    {
        $data = [
            'title' => 'Create Product',
            'page'  => 'admin/products',
            'categories' => $this->categoryModel->findAll(),
        ];
        return view('AdminArea/dashboard/product_form', $data);
    }

    public function store(): RedirectResponse
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[255]',
            'slug' => 'required|min_length[2]|max_length[255]|is_unique[products.slug]',
            'category_id' => 'permit_empty|integer',
            'status' => 'required|in_list[draft,active,inactive,archived]',
            'price' => 'permit_empty|decimal',
            'discount_price' => 'permit_empty|decimal',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $productId = $this->productModel->insert([
            'category_id' => $this->request->getPost('category_id') ?: null,
            'name' => $this->request->getPost('name'),
            'slug' => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
            'short_description' => $this->request->getPost('short_description'),
            'thumbnail' => $this->request->getPost('thumbnail'),
            'status' => $this->request->getPost('status'),
            'seo_title' => $this->request->getPost('seo_title'),
            'seo_description' => $this->request->getPost('seo_description'),
            'created_by' => session()->get('user_id'),
        ]);

        // Save price
        $price = $this->request->getPost('price');
        if ($price !== null && $price !== '') {
            $this->priceModel->insert([
                'product_id' => $productId,
                'price' => $price,
                'discount_price' => $this->request->getPost('discount_price') ?: null,
                'currency' => 'IDR',
            ]);
        }

        // Save package ZIP file
        $file = $this->request->getFile('package_file');
        if ($file && $file->isValid()) {
            $this->storePackageFile($productId, $file);
        }

        return redirect()->to('/admin/products/edit/' . $productId)
            ->with('success', 'Product created successfully.');
    }

    public function edit(int $id): string|RedirectResponse
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            return redirect()->to('/admin/products')
                ->with('error', 'Product not found.');
        }

        $db = \Config\Database::connect();
        $price = $db->table('product_prices')->where('product_id', $id)->orderBy('id', 'DESC')->get()->getRow();
        $files = $db->table('product_files')->where('product_id', $id)->orderBy('created_at', 'DESC')->get()->getResult();
        $licenses = $db->table('product_licenses')->where('product_id', $id)->orderBy('created_at', 'DESC')->get()->getResult();

        $data = [
            'title' => 'Edit Product',
            'page'  => 'admin/products',
            'product' => $product,
            'price' => $price,
            'files' => $files,
            'licenses' => $licenses,
            'categories' => $this->categoryModel->findAll(),
        ];

        return view('AdminArea/dashboard/product_form', $data);
    }

    public function update(int $id): RedirectResponse
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            return redirect()->to('/admin/products')
                ->with('error', 'Product not found.');
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[255]',
            'slug' => 'required|min_length[2]|max_length[255]|is_unique[products.slug,id,{id}]',
            'category_id' => 'permit_empty|integer',
            'status' => 'required|in_list[draft,active,inactive,archived]',
            'price' => 'permit_empty|decimal',
            'discount_price' => 'permit_empty|decimal',
            'id' => 'permit_empty|integer',
        ];

        $validationData = $this->request->getPost();
        $validationData['id'] = $id;

        if (!$this->validateData($validationData, $rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $this->productModel->update($id, [
            'category_id' => $this->request->getPost('category_id') ?: null,
            'name' => $this->request->getPost('name'),
            'slug' => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
            'short_description' => $this->request->getPost('short_description'),
            'thumbnail' => $this->request->getPost('thumbnail'),
            'status' => $this->request->getPost('status'),
            'seo_title' => $this->request->getPost('seo_title'),
            'seo_description' => $this->request->getPost('seo_description'),
        ]);

        // Update price
        $db = \Config\Database::connect();
        $price = $this->request->getPost('price');
        if ($price !== null && $price !== '') {
            $existing = $db->table('product_prices')->where('product_id', $id)->orderBy('id', 'DESC')->get()->getRow();
            if ($existing) {
                $db->table('product_prices')->where('id', $existing->id)->update([
                    'price' => $price,
                    'discount_price' => $this->request->getPost('discount_price') ?: null,
                ]);
            } else {
                $this->priceModel->insert([
                    'product_id' => $id,
                    'price' => $price,
                    'discount_price' => $this->request->getPost('discount_price') ?: null,
                    'currency' => 'IDR',
                ]);
            }
        }

        // Save new package ZIP file
        $file = $this->request->getFile('package_file');
        if ($file && $file->isValid()) {
            $this->storePackageFile($id, $file);
        }

        return redirect()->back()
            ->with('success', 'Product updated successfully.');
    }

    public function delete(int $id): RedirectResponse
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            return redirect()->to('/admin/products')
                ->with('error', 'Product not found.');
        }

        // Delete related data
        $db = \Config\Database::connect();
        $files = $db->table('product_files')->where('product_id', $id)->get()->getResult();
        foreach ($files as $f) {
            $path = WRITEPATH . $f->file_path;
            if (file_exists($path)) {
                @unlink($path);
            }
        }
        $db->table('product_files')->where('product_id', $id)->delete();
        $db->table('product_prices')->where('product_id', $id)->delete();
        $db->table('product_licenses')->where('product_id', $id)->delete();

        $this->productModel->delete($id, true);

        return redirect()->to('/admin/products')
            ->with('success', 'Product deleted successfully.');
    }

    // ===================== PACKAGE FILES (ZIP) =====================
    public function deleteFile(int $fileId): RedirectResponse
    {
        $file = $this->fileModel->find($fileId);
        if ($file) {
            $path = WRITEPATH . $file->file_path;
            if (file_exists($path)) {
                @unlink($path);
            }
            $this->fileModel->delete($fileId);
        }

        return redirect()->back()
            ->with('success', 'Package file deleted.');
    }

    // ===================== LICENSE / API / TOKEN =====================
    public function createLicense(int $productId): RedirectResponse
    {
        $product = $this->productModel->find($productId);
        if (!$product) {
            return redirect()->to('/admin/products')
                ->with('error', 'Product not found.');
        }

        $licenseType = $this->request->getPost('license_type');
        if (!in_array($licenseType, ['license', 'api_key', 'access_token'], true)) {
            return redirect()->back()
                ->with('error', 'Invalid license type.');
        }

        $db = \Config\Database::connect();
        $db->table('product_licenses')->insert([
            'uuid' => date('YmdHis') . substr(md5(uniqid('', true)), 0, 8),
            'product_id' => $productId,
            'license_key' => $this->generateLicenseKey($licenseType),
            'license_type' => $licenseType,
            'api_key' => $this->request->getPost('api_key') ?: null,
            'secret_key' => $this->request->getPost('secret_key') ?: null,
            'domain_limit' => $this->request->getPost('domain_limit') ?: 1,
            'max_devices' => $this->request->getPost('max_devices') ?: 1,
            'expires_at' => $this->request->getPost('expires_at') ?: null,
            'status' => $this->request->getPost('status') ?: 'active',
            'created_by' => session()->get('user_id'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()
            ->with('success', 'License generated successfully.');
    }

    public function deleteLicense(int $licenseId): RedirectResponse
    {
        $db = \Config\Database::connect();
        $db->table('product_licenses')->where('id', $licenseId)->delete();

        return redirect()->back()
            ->with('success', 'License deleted.');
    }

    private function generateLicenseKey(string $type): string
    {
        $prefix = match ($type) {
            'api_key' => 'API',
            'access_token' => 'TOK',
            default => 'LIC',
        };
        return $prefix . '-' . strtoupper(substr(md5(uniqid('', true) . mt_rand(1000, 9999)), 0, 8)) . '-' . strtoupper(substr(md5(uniqid('', true) . mt_rand(1000, 9999)), 0, 8)) . '-' . strtoupper(substr(md5(uniqid('', true) . mt_rand(1000, 9999)), 0, 8));
    }

    private function storePackageFile(int $productId, \CodeIgniter\HTTP\Files\UploadedFile $file): void
    {
        if (!in_array(strtolower($file->getExtension()), ['zip', 'rar', 'tar', 'gz', '7z'], true)) {
            return;
        }

        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads/products', $newName);

        $this->fileModel->insert([
            'product_id' => $productId,
            'file_name' => $file->getClientName(),
            'file_path' => 'uploads/products/' . $newName,
            'file_size' => $file->getSize(),
            'file_type' => $file->getClientMimeType() ?: 'application/zip',
            'version' => $this->request->getPost('file_version') ?: '1.0',
            'status' => 'active',
        ]);
    }
}