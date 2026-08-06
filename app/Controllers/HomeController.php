<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Modules\FrontArea\Models\TransactionModel;
use App\Modules\FrontArea\Models\PaymentMethodModel;

class HomeController extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();
        $now = date('Y-m-d H:i:s');

        // Stats
        $stats = [
            'total_products'  => $db->table('products')->where('status', 'active')->countAllResults(),
            'total_services'  => $db->table('services')->where('status', 'active')->countAllResults(),
            'total_portfolios'=> $db->table('portfolios')->whereIn('status', ['published','featured'])->countAllResults(),
            'happy_clients'   => $db->table('users')
                ->join('user_roles ur', 'ur.user_id = users.id')
                ->join('roles r', 'r.id = ur.role_id')
                ->where('r.slug', 'customer')
                ->where('users.status', 'active')
                ->countAllResults(),
            'support_tickets' => $db->table('tickets')->countAllResults(),
            'uptime'          => '99.9',
        ];

        // Services (limit 3)
        $services = $db->table('services s')
            ->select('s.name, s.slug, s.description, s.thumbnail, s.price, s.price_type')
            ->join('service_categories sc', 'sc.id = s.category_id', 'left')
            ->where('s.status', 'active')
            ->orderBy('s.created_at', 'DESC')
            ->limit(3)
            ->get()
            ->getResult();

        // Products (limit 3)
        $products = $db->table('products p')
            ->select('p.name, p.slug, p.short_description, p.thumbnail, pp.price, pp.discount_price')
            ->join('product_prices pp', 'pp.product_id = p.id', 'left')
            ->where('p.status', 'active')
            ->orderBy('p.created_at', 'DESC')
            ->limit(3)
            ->get()
            ->getResult();

        // Testimonials (approved only, limit 3)
        $testimonials = $db->table('testimonials')
            ->where('status', 'approved')
            ->orderBy('featured', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->limit(3)
            ->get()
            ->getResult();

        // Services icons map
        $serviceIcons = ['fas fa-code', 'fas fa-mobile-alt', 'fas fa-cloud', 'fas fa-shopping-cart', 'fas fa-shield-alt', 'fas fa-headset', 'fas fa-database', 'fas fa-chart-line'];
        $serviceColors = ['primary', 'info', 'danger', 'warning', 'primary', 'info', 'danger', 'warning'];

        $data = [
            'title'  => 'NgAppID - Digital Platform',
            'page'   => 'home',
            'stats'  => $stats,
            'services' => $services,
            'products' => $products,
            'testimonials' => $testimonials,
            'serviceIcons' => $serviceIcons,
            'serviceColors' => $serviceColors,
        ];

        return view('FrontArea/home/index', $data);
    }

    public function about(): string
    {
        $db = \Config\Database::connect();

        $stats = [
            'total_products'  => $db->table('products')->where('status', 'active')->countAllResults(),
            'total_services'  => $db->table('services')->where('status', 'active')->countAllResults(),
            'total_portfolios'=> $db->table('portfolios')->whereIn('status', ['published','featured'])->countAllResults(),
            'total_articles'  => $db->table('articles')->where('status', 'published')->countAllResults(),
        ];

        return view('FrontArea/about', ['title' => 'About Us', 'page' => 'about', 'stats' => $stats]);
    }

    public function services(): string
    {
        $db = \Config\Database::connect();

        $services = $db->table('services s')
            ->select('s.name, s.slug, s.description, s.thumbnail, s.price, s.price_type, sc.name as category_name')
            ->join('service_categories sc', 'sc.id = s.category_id', 'left')
            ->where('s.status', 'active')
            ->orderBy('s.created_at', 'DESC')
            ->get()
            ->getResult();

        return view('FrontArea/services', ['title' => 'Our Services', 'page' => 'services', 'services' => $services]);
    }

    public function products(): string
    {
        $db = \Config\Database::connect();

        $products = $db->table('products p')
            ->select('p.name, p.slug, p.short_description, p.description, p.thumbnail, pp.price, pp.discount_price, pc.name as category_name')
            ->join('product_prices pp', 'pp.product_id = p.id', 'left')
            ->join('product_categories pc', 'pc.id = p.category_id', 'left')
            ->where('p.status', 'active')
            ->orderBy('p.created_at', 'DESC')
            ->get()
            ->getResult();

        return view('FrontArea/products', ['title' => 'Our Products', 'page' => 'products', 'products' => $products]);
    }

    public function portfolio(): string
    {
        $db = \Config\Database::connect();

        $portfolios = $db->table('portfolios')
            ->where('status', 'published')
            ->orWhere('status', 'featured')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResult();

        return view('FrontArea/portfolio', ['title' => 'Our Portfolio', 'page' => 'portfolio', 'portfolios' => $portfolios]);
    }

    public function portfolioDetail(string $slug): string
    {
        $db = \Config\Database::connect();

        $portfolio = $db->table('portfolios p')
            ->select('p.*, c.name as client_name')
            ->join('clients c', 'c.id = p.client_id', 'left')
            ->where('p.slug', $slug)
            ->whereIn('p.status', ['published', 'featured'])
            ->get()
            ->getRow();

        if (!$portfolio) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('FrontArea/portfolio_detail', [
            'title' => $portfolio->title ?? 'Portfolio',
            'page' => 'portfolio',
            'portfolio' => $portfolio,
        ]);
    }

    public function blog(): string
    {
        $db = \Config\Database::connect();

        $articles = $db->table('articles a')
            ->select('a.id, a.title, a.slug, a.excerpt, a.thumbnail, a.published_at, c.name as category_name, a.author_id')
            ->join('categories c', 'c.id = a.category_id', 'left')
            ->where('a.status', 'published')
            ->orderBy('a.published_at', 'DESC')
            ->get()
            ->getResult();

        $categories = $db->table('categories')
            ->where('type', 'article')
            ->orderBy('name', 'ASC')
            ->get()
            ->getResult();

        return view('FrontArea/blog', ['title' => 'Blog', 'page' => 'blog', 'articles' => $articles, 'categories' => $categories]);
    }

    public function contact(): string
    {
        return view('FrontArea/contact', ['title' => 'Contact Us', 'page' => 'contact']);
    }

    public function contactStore()
    {
        $validation = $this->validate([
            'name'    => 'required|min_length[3]|max_length[150]',
            'email'   => 'required|valid_email|max_length[150]',
            'subject' => 'required|min_length[3]|max_length[255]',
            'message' => 'required|min_length[10]',
        ]);

        if (!$validation) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $db = \Config\Database::connect();

        $inserted = $db->table('contact_messages')->insert([
            'uuid'       => $this->generateUuid(),
            'name'       => $this->request->getPost('name'),
            'email'      => $this->request->getPost('email'),
            'subject'    => $this->request->getPost('subject'),
            'message'    => $this->request->getPost('message'),
            'status'     => 'new',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if (!$inserted) {
            return redirect()->back()
                ->with('error', 'Gagal mengirim pesan. Silakan coba lagi.')
                ->withInput();
        }

        return redirect()->to('contact')
            ->with('success', 'Pesan berhasil dikirim. Kami akan segera menghubungi Anda.');
    }

    protected function generateUuid(): string
    {
        // Simple implementation dengan timestamp dan random number (Windows compatible)
        return date('YmdHis') . substr(md5(uniqid('', true) . mt_rand(100000, 999999)), 0, 8);
    }
}
