<?php

namespace App\Modules\FrontArea\Controllers;

use App\Controllers\FrontBaseController;
use App\Modules\Product\Services\ProductService;
use CodeIgniter\HTTP\ResponseInterface;

class ProductsController extends FrontBaseController
{
    protected ProductService $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

    public function index()
    {
        $this->setActiveMenu('products');
        $this->setMeta([
            'title' => 'Produk - NgAppID',
            'description' => 'Produk digital berkualitas untuk kebutuhan bisnis Anda',
        ]);

        $db = \Config\Database::connect();
        $products = $db->table('products p')
            ->select('p.id, p.name, p.slug, p.short_description, p.description, p.thumbnail, pp.price, pp.discount_price, pc.name as category_name')
            ->join('product_prices pp', 'pp.product_id = p.id', 'left')
            ->join('product_categories pc', 'pc.id = p.category_id', 'left')
            ->where('p.status', 'active')
            ->orderBy('p.created_at', 'DESC')
            ->get()
            ->getResult();

        return $this->render('FrontArea/products/index', [
            'products' => $products,
        ]);
    }

    public function detail(string $slug)
    {
        $db = \Config\Database::connect();
        $product = $db->table('products p')
            ->select('p.*, pp.price, pp.discount_price, pc.name as category_name, pc.slug as category_slug')
            ->join('product_prices pp', 'pp.product_id = p.id', 'left')
            ->join('product_categories pc', 'pc.id = p.category_id', 'left')
            ->where('p.slug', $slug)
            ->where('p.status', 'active')
            ->get()
            ->getRow();

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->setActiveMenu('products');
        $this->setMeta([
            'title' => $product->name . ' - NgAppID',
            'description' => $product->short_description ?? '',
        ]);

        return $this->render('FrontArea/products/detail', [
            'product' => $product,
        ]);
    }

    public function category(string $slug)
    {
        $db = \Config\Database::connect();
        $category = $db->table('product_categories')
            ->where('slug', $slug)
            ->get()
            ->getRow();

        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $products = $db->table('products p')
            ->select('p.id, p.name, p.slug, p.short_description, p.thumbnail, pp.price, pp.discount_price')
            ->join('product_prices pp', 'pp.product_id = p.id', 'left')
            ->where('p.category_id', $category->id)
            ->where('p.status', 'active')
            ->orderBy('p.created_at', 'DESC')
            ->get()
            ->getResult();

        $this->setActiveMenu('products');
        $this->setMeta([
            'title' => $category->name . ' - NgAppID',
            'description' => $category->description ?? '',
        ]);

        return $this->render('FrontArea/products/index', [
            'products' => $products,
            'category' => $category,
        ]);
    }

    public function search()
    {
        $keyword = $this->request->getGet('q') ?? '';

        $db = \Config\Database::connect();
        $products = $db->table('products p')
            ->select('p.id, p.name, p.slug, p.short_description, p.thumbnail, pp.price')
            ->join('product_prices pp', 'pp.product_id = p.id', 'left')
            ->where('p.status', 'active')
            ->like('p.name', $keyword)
            ->orLike('p.short_description', $keyword)
            ->orderBy('p.created_at', 'DESC')
            ->get()
            ->getResult();

        $this->setActiveMenu('products');
        $this->setMeta([
            'title' => 'Cari Produk - NgAppID',
        ]);

        return $this->render('FrontArea/products/index', [
            'products' => $products,
            'keyword' => $keyword,
        ]);
    }
}