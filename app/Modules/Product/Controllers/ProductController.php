<?php

namespace App\Modules\Product\Controllers;

use App\Controllers\BaseController;
use App\Modules\Product\Services\ProductService;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends BaseController
{
    protected ProductService $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

    public function index()
    {
        $perPage = 12;
        $page = $this->request->getGet('page') ?? 1;
        $category = $this->request->getGet('category');
        $search = $this->request->getGet('search');

        $result = $this->productService->getProducts([
            'page' => $page,
            'perPage' => $perPage,
            'category' => $category,
            'search' => $search,
            'status' => 'active'
        ]);

        $data = [
            'title' => 'Products',
            'products' => $result['data']['products'] ?? [],
            'pager' => $result['data']['pager'] ?? null,
            'categories' => $this->productService->getCategories()['data'] ?? [],
        ];

        return view('product/index', $data);
    }

    public function detail(string $slug)
    {
        // Tangkap data yang ternyata langsung berupa object
        $product = $this->productService->getProductBySlug($slug);

        // Cek kalau datanya kosong/tidak ditemukan di database
        if (empty($product)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'   => $product->name,
            'product' => $product,
        ];

        return view('product/detail', $data);
    }

    public function category(string $slug)
    {
        $perPage = 12;
        $page = $this->request->getGet('page') ?? 1;

        $result = $this->productService->getProductsByCategory($slug, [
            'page' => $page,
            'perPage' => $perPage,
        ]);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => $result['data']['category']->name ?? 'Products',
            'products' => $result['data']['products'] ?? [],
            'pager' => $result['data']['pager'] ?? null,
            'category' => $result['data']['category'] ?? null,
        ];

        return view('product/index', $data);
    }

    public function search()
    {
        $keyword = $this->request->getGet('q');
        $perPage = 12;
        $page = $this->request->getGet('page') ?? 1;

        $result = $this->productService->searchProducts($keyword, [
            'page' => $page,
            'perPage' => $perPage,
        ]);

        $data = [
            'title' => 'Search: ' . $keyword,
            'products' => $result['data']['products'] ?? [],
            'pager' => $result['data']['pager'] ?? null,
            'keyword' => $keyword,
        ];

        return view('product/index', $data);
    }
}
