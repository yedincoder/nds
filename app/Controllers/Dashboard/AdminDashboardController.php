<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AdminDashboardController extends BaseController
{
    public function index(): ResponseInterface|string
    {
        $db = \Config\Database::connect();

        $stats = [
            'total_customers' => $db->table('users u')
                ->join('user_roles ur', 'ur.user_id = u.id')
                ->join('roles r', 'r.id = ur.role_id')
                ->where('r.slug', 'customer')
                ->countAllResults(),
            'total_orders'    => $db->table('orders')->countAllResults(),
            'total_revenue'   => $db->table('transactions')
                ->where('status', 'success')
                ->selectSum('amount', 'total')
                ->get()->getRow()->total ?? 0,
            'pending_invoices'=> $db->table('invoices')
                ->where('status', 'unpaid')
                ->countAllResults(),
            'pending_tickets' => $db->table('tickets')
                ->whereIn('status', ['open', 'waiting_response'])
                ->countAllResults(),
            'total_products'  => $db->table('products')
                ->where('status', 'active')
                ->countAllResults(),
        ];

        $recentOrders = $db->table('orders o')
            ->select('o.*, u.username, u.email')
            ->join('users u', 'u.id = o.user_id')
            ->orderBy('o.created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        $recentTickets = $db->table('tickets t')
            ->select('t.*, u.username')
            ->join('users u', 'u.id = t.user_id')
            ->orderBy('t.created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        $data = [
            'title'         => 'Admin Dashboard',
            'page'          => 'admin/dashboard',
            'stats'         => $stats,
            'recentOrders'  => $recentOrders,
            'recentTickets' => $recentTickets,
        ];

        return view('admin/dashboard', $data);
    }

    public function customers(): string
    {
        $db = \Config\Database::connect();

        $customers = $db->table('users u')
            ->select('u.*, up.full_name, r.name as role_name')
            ->join('user_profiles up', 'up.user_id = u.id', 'left')
            ->join('user_roles ur', 'ur.user_id = u.id', 'left')
            ->join('roles r', 'r.id = ur.role_id', 'left')
            ->orderBy('u.created_at', 'DESC')
            ->paginate(20);

        $data = [
            'title'    => 'Manage Customers',
            'page'     => 'admin/customers',
            'customers' => $customers,
            'pager'    => $db->table('users')->pager,
        ];

        return view('admin/customers', $data);
    }

    public function products(): string
    {
        return view('admin/products', ['title' => 'Manage Products', 'page' => 'admin/products']);
    }

    public function orders(): string
    {
        return view('admin/orders', ['title' => 'Manage Orders', 'page' => 'admin/orders']);
    }

    public function invoices(): string
    {
        return view('admin/invoices', ['title' => 'Manage Invoices', 'page' => 'admin/invoices']);
    }

    public function reports(): string
    {
        return view('admin/reports', ['title' => 'Reports', 'page' => 'admin/reports']);
    }

    public function settings(): string
    {
        return view('admin/settings', ['title' => 'System Settings', 'page' => 'admin/settings']);
    }

    public function payments(): string
    {
        $db = \Config\Database::connect();

        $payments = $db->table('transactions')
            ->select('t.*, u.username, u.email')
            ->join('users u', 'u.id = t.user_id', 'left')
            ->orderBy('t.created_at', 'DESC')
            ->paginate(15);

        $data = [
            'title'    => 'Payments (Midtrans)',
            'page'     => 'admin/payments',
            'payments' => $payments,
            'pager'    => $db->table('transactions')->pager,
        ];

        return view('admin/payments', $data);
    }
}