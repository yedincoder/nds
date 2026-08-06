<?php

namespace App\Modules\AdminArea\Controllers;

use App\Controllers\AdminBaseController;
use App\Modules\FrontArea\Models\ProductModel;
use App\Modules\FrontArea\Models\OrderModel;
use App\Modules\ClientArea\Models\UserProfileModel;
use App\Modules\FrontArea\Models\InvoiceModel;

class AdminDashboardController extends AdminBaseController
{
    protected ProductModel $productModel;
    protected OrderModel $orderModel;
    protected UserProfileModel $userProfileModel;
    protected InvoiceModel $invoiceModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->userProfileModel = new UserProfileModel();
        $this->invoiceModel = new InvoiceModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();

        // Stats
        $stats = [
            'total_customers'  => $db->table('users u')
                ->join('user_roles ur', 'ur.user_id = u.id')
                ->join('roles r', 'r.id = ur.role_id')
                ->where('r.slug', 'customer')
                ->countAllResults(),
            'total_products'   => $db->table('products')->where('status', 'active')->countAllResults(),
            'total_services'   => $db->table('services')->where('status', 'active')->countAllResults(),
            'total_portfolios' => $db->table('portfolios')->whereIn('status', ['published', 'featured'])->countAllResults(),
            'total_orders'     => $db->table('orders')->countAllResults(),
            'total_invoices'   => $db->table('invoices')->countAllResults(),
            'total_revenue'    => $db->table('transactions')->where('status', 'success')->selectSum('amount')->get()->getRow()->amount ?? 0,
            'pending_orders'   => $db->table('orders')->where('status', 'pending')->orWhere('status', 'waiting_payment')->countAllResults(),
            'pending_invoices' => $db->table('invoices')->where('status', 'unpaid')->countAllResults(),
            'pending_tickets'  => $db->table('tickets')->whereIn('status', ['open', 'waiting_response'])->countAllResults(),
            'total_testimonials' => $db->table('testimonials')->where('status', 'approved')->countAllResults(),
            'total_payments'   => $db->table('transactions')->where('status', 'success')->countAllResults(),
        ];

        // Revenue last 6 months for chart
        $revenueChart = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthLabel = date('M Y', strtotime("-{$i} months"));
            $revenue = $db->table('transactions')
                ->selectSum('amount')
                ->where('status', 'success')
                ->where('DATE(created_at) >=', date('Y-m-01', strtotime("-{$i} months")))
                ->where('DATE(created_at) <=', date('Y-m-t', strtotime("-{$i} months")))
                ->get()
                ->getRow()->amount ?? 0;
            $revenueChart[] = ['month' => $monthLabel, 'revenue' => (float) $revenue];
        }

        // Order status breakdown
        $orderStatus = [];
        $orderStatusRaw = $db->table('orders')
            ->select('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->getResult();
        foreach ($orderStatusRaw as $row) {
            $orderStatus[$row->status] = (int) $row->count;
        }

        // Payment status breakdown
        $paymentStatus = [];
        $paymentStatusRaw = $db->table('transactions')
            ->select('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->getResult();
        foreach ($paymentStatusRaw as $row) {
            $paymentStatus[$row->status] = (int) $row->count;
        }

        // Recent orders (with user join)
        $recentOrders = $db->table('orders o')
            ->select('o.*, u.username, u.email')
            ->join('users u', 'u.id = o.user_id', 'left')
            ->orderBy('o.created_at', 'DESC')
            ->limit(8)
            ->get()
            ->getResult();

        // Recent invoices (with user join)
        $recentInvoices = $db->table('invoices i')
            ->select('i.*, u.username')
            ->join('users u', 'u.id = i.user_id', 'left')
            ->orderBy('i.created_at', 'DESC')
            ->limit(8)
            ->get()
            ->getResult();

        // Recent payments (with user join)
        $recentPayments = $db->table('transactions t')
            ->select('t.*, i.invoice_number, u.username')
            ->join('invoices i', 'i.id = t.invoice_id', 'left')
            ->join('users u', 'u.id = i.user_id', 'left')
            ->orderBy('t.created_at', 'DESC')
            ->limit(8)
            ->get()
            ->getResult();

        // Recent tickets
        $recentTickets = $db->table('tickets t')
            ->select('t.*, u.username')
            ->join('users u', 'u.id = t.user_id', 'left')
            ->orderBy('t.created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        // Recent testimonials
        $recentTestimonials = $db->table('testimonials')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        // Top products
        $topProducts = $db->table('products p')
            ->select('p.name, p.slug, COUNT(oi.id) as sold_count, p.status')
            ->join('order_items oi', 'oi.product_id = p.id', 'left')
            ->where('p.status', 'active')
            ->groupBy('p.id')
            ->orderBy('sold_count', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        // Recent activity logs
        $recentActivity = $db->table('activity_logs a')
            ->select('a.*, u.username')
            ->join('users u', 'u.id = a.user_id', 'left')
            ->orderBy('a.created_at', 'DESC')
            ->limit(8)
            ->get()
            ->getResult();

        $data = [
            'title'             => 'Admin Dashboard',
            'page'              => 'admin/dashboard',
            'stats'             => $stats,
            'revenueChart'      => $revenueChart,
            'orderStatus'       => $orderStatus,
            'paymentStatus'     => $paymentStatus,
            'recentOrders'      => $recentOrders,
            'recentInvoices'    => $recentInvoices,
            'recentPayments'    => $recentPayments,
            'recentTickets'     => $recentTickets,
            'recentTestimonials'=> $recentTestimonials,
            'topProducts'       => $topProducts,
            'recentActivity'    => $recentActivity,
        ];

        return view('AdminArea/dashboard/index', $data);
    }

    public function customers()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $customers = $this->userProfileModel->join('users', 'users.id = user_profiles.user_id')
            ->select('user_profiles.*, users.email, users.username, users.status')
            ->orderBy('user_profiles.created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Customers',
            'page'  => 'admin/customers',
            'customers' => $customers,
            'pager' => $this->userProfileModel->pager,
        ];

        return view('AdminArea/dashboard/customers', $data);
    }

    public function products()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $products = $this->productModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Products',
            'page'  => 'admin/products',
            'products' => $products,
            'pager' => $this->productModel->pager,
        ];

        return view('AdminArea/dashboard/products', $data);
    }

    public function orders()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $orders = $this->orderModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Orders',
            'page'  => 'admin/orders',
            'orders' => $orders,
            'pager' => $this->orderModel->pager,
        ];

        return view('AdminArea/dashboard/orders', $data);
    }

    public function invoices()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $invoices = $this->invoiceModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Invoices',
            'page'  => 'admin/invoices',
            'invoices' => $invoices,
            'pager' => $this->invoiceModel->pager,
        ];

        return view('AdminArea/dashboard/invoices', $data);
    }

    public function payments()
    {
        $db = \Config\Database::connect();
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;
        $offset = ($page - 1) * $perPage;

        $payments = $db->table('transactions t')
            ->select('t.*, i.invoice_number, u.username, u.email')
            ->join('invoices i', 'i.id = t.invoice_id', 'left')
            ->join('users u', 'u.id = i.user_id', 'left')
            ->orderBy('t.created_at', 'DESC')
            ->limit($perPage, $offset)
            ->get()
            ->getResult();

        $data = [
            'title' => 'Payments',
            'page'  => 'admin/payments',
            'payments' => $payments,
        ];

        return view('AdminArea/dashboard/payments', $data);
    }

    public function services()
    {
        $db = \Config\Database::connect();
        $services = $db->table('services s')
            ->select('s.*, sc.name as category_name')
            ->join('service_categories sc', 'sc.id = s.category_id', 'left')
            ->orderBy('s.created_at', 'DESC')
            ->get()
            ->getResult();

        $data = [
            'title' => 'Services',
            'page'  => 'admin/services',
            'services' => $services,
        ];

        return view('AdminArea/dashboard/services', $data);
    }

    public function portfolio()
    {
        $db = \Config\Database::connect();
        $portfolios = $db->table('portfolios')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResult();

        $data = [
            'title' => 'Portfolio',
            'page'  => 'admin/portfolio',
            'portfolios' => $portfolios,
        ];

        return view('AdminArea/dashboard/portfolio', $data);
    }

    public function reports()
    {
        $db = \Config\Database::connect();

        // Revenue last 12 months
        $revenueChart = [];
        for ($i = 11; $i >= 0; $i--) {
            $revenue = $db->table('transactions')
                ->selectSum('amount')
                ->where('status', 'success')
                ->where('DATE(created_at) >=', date('Y-m-01', strtotime("-{$i} months")))
                ->where('DATE(created_at) <=', date('Y-m-t', strtotime("-{$i} months")))
                ->get()
                ->getRow()->amount ?? 0;
            $revenueChart[] = ['month' => date('M Y', strtotime("-{$i} months")), 'revenue' => (float) $revenue];
        }

        $data = [
            'title' => 'Reports',
            'page'  => 'admin/reports',
            'stats' => [
                'total_revenue'      => $db->table('transactions')->where('status', 'success')->selectSum('amount')->get()->getRow()->amount ?? 0,
                'total_orders'       => $db->table('orders')->countAllResults(),
                'total_customers'    => $db->table('users')
                    ->join('user_roles ur', 'ur.user_id = users.id')
                    ->join('roles r', 'r.id = ur.role_id')
                    ->where('r.slug', 'customer')
                    ->countAllResults(),
                'total_products'     => $db->table('products')->countAllResults(),
                'total_services'     => $db->table('services')->countAllResults(),
                'total_transactions' => $db->table('transactions')->where('status', 'success')->countAllResults(),
            ],
            'revenueChart' => $revenueChart,
        ];

        return view('AdminArea/dashboard/reports', $data);
    }

    public function settings()
    {
        $data = [
            'title' => 'Settings',
            'page'  => 'admin/settings',
        ];

        return view('AdminArea/dashboard/settings', $data);
    }

    public function factoryReset()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/admin/settings')
                ->with('error', 'Invalid request.');
        }

        $password = $this->request->getPost('password');
        if (empty($password)) {
            return redirect()->to('/admin/settings')
                ->with('error', 'Password required to rebuild database.');
        }

        // Verify admin password
        $db = \Config\Database::connect();
        $user = $db->table('users')->where('id', session()->get('user_id'))->get()->getRow();
        if (!$user || !password_verify($password, $user->password_hash)) {
            return redirect()->to('/admin/settings')
                ->with('error', 'Password salah. Tidak bisa rebuild database.');
        }

        // Run fresh migrations (drop all + re-run)
        $migrate = \Config\Services::migrations();
        try {
            $migrate->setSilent(false);
            $migrate->latest();
        } catch (\Exception $e) {
            // Try rollback then latest
            try {
                $migrate->regress(0);
                $migrate->latest();
            } catch (\Throwable $th) {
                return redirect()->to('/admin/settings')
                    ->with('error', 'Database rebuild failed: ' . esc($th->getMessage()));
            }
        }

        // Log activity
        try {
            $db->table('activity_logs')->insert([
                'uuid' => date('YmdHis') . substr(md5(uniqid('', true)), 0, 8),
                'user_id' => session()->get('user_id'),
                'activity_type' => 'factory_reset',
                'description' => 'Database rebuilt (factory reset) by ' . ($user->username ?? 'admin'),
                'ip_address' => $this->request->getIPAddress(),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
            // ignore log failure
        }

        return redirect()->to('/admin/settings')
            ->with('success', 'Database berhasil di-rebuild (factory reset).');
    }
}
