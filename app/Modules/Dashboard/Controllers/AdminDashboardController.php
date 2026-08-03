<?php

namespace App\Modules\Dashboard\Controllers;

use App\Controllers\BaseController;

class AdminDashboardController extends BaseController
{
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
            'total_revenue'    => $db->table('transactions')->where('status', 'success')->sum('amount') ?? 0,
            'pending_orders'   => $db->table('orders')->where('status', 'pending')->orWhere('status', 'waiting_payment')->countAllResults(),
            'pending_invoices' => $db->table('invoices')->where('status', 'unpaid')->countAllResults(),
            'pending_tickets'  => $db->table('tickets')->whereIn('status', ['open', 'waiting_response'])->countAllResults(),
            'total_testimonials' => $db->table('testimonials')->where('status', 'approved')->countAllResults(),
            'total_payments'   => $db->table('transactions')->where('status', 'success')->countAllResults(),
        ];

        // Revenue last 6 months for chart
        $revenueChart = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-{$i} months"));
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
            ->leftJoin('order_items oi', 'oi.product_id = p.id')
            ->where('p.status', 'active')
            ->groupBy('p.id')
            ->orderBy('sold_count', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        // Recent activity logs
        $recentActivity = $db->table('activity_logs a')
            ->select('a.*, u.username')
            ->leftJoin('users u', 'u.id = a.user_id')
            ->orderBy('a.created_at', 'DESC')
            ->limit(8)
            ->get()
            ->getResult();

        $data = [
            'title'             => 'Admin Dashboard',
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

        return view('Dashboard/dashboard', $data);
    }

    public function customers()
    {
        $db = \Config\Database::connect();
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $customers = $db->table('user_profiles up')
            ->select('up.*, u.email, u.username, u.status, u.last_login_at, u.created_at')
            ->join('users u', 'u.id = up.user_id')
            ->orderBy('up.created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Customers',
            'customers' => $customers,
            'pager' => $db->table('user_profiles')->pager,
        ];

        return view('Dashboard/customers', $data);
    }

    public function products()
    {
        $db = \Config\Database::connect();
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $products = $db->table('products p')
            ->select('p.*, pc.name as category_name, pp.price, pp.discount_price')
            ->leftJoin('product_categories pc', 'pc.id = p.category_id')
            ->leftJoin('product_prices pp', 'pp.product_id = p.id')
            ->orderBy('p.created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Products',
            'products' => $products,
            'pager' => $db->table('products')->pager,
        ];

        return view('Dashboard/products', $data);
    }

    public function orders()
    {
        $db = \Config\Database::connect();
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $orders = $db->table('orders o')
            ->select('o.*, u.username, u.email')
            ->join('users u', 'u.id = o.user_id', 'left')
            ->orderBy('o.created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Orders',
            'orders' => $orders,
            'pager' => $db->table('orders')->pager,
        ];

        return view('Dashboard/orders', $data);
    }

    public function invoices()
    {
        $db = \Config\Database::connect();
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $invoices = $db->table('invoices i')
            ->select('i.*, u.username, o.order_number')
            ->leftJoin('users u', 'u.id = i.user_id')
            ->leftJoin('orders o', 'o.id = i.order_id')
            ->orderBy('i.created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Invoices',
            'invoices' => $invoices,
            'pager' => $db->table('invoices')->pager,
        ];

        return view('Dashboard/invoices', $data);
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

        $total = $db->table('transactions')->countAllResults();

        $data = [
            'title' => 'Payments',
            'payments' => $payments,
        ];

        return view('Dashboard/payments', $data);
    }

    public function services()
    {
        $db = \Config\Database::connect();
        $services = $db->table('services s')
            ->select('s.*, sc.name as category_name')
            ->leftJoin('service_categories sc', 'sc.id = s.category_id')
            ->orderBy('s.created_at', 'DESC')
            ->get()
            ->getResult();

        $data = [
            'title' => 'Services',
            'services' => $services,
        ];

        return view('Dashboard/services', $data);
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
            'portfolios' => $portfolios,
        ];

        return view('Dashboard/portfolio', $data);
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
            'stats' => [
                'total_revenue'      => $db->table('transactions')->where('status', 'success')->sum('amount') ?? 0,
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

        return view('Dashboard/reports', $data);
    }

    public function settings()
    {
        $data = [
            'title' => 'Settings',
        ];

        return view('Dashboard/settings', $data);
    }
}
