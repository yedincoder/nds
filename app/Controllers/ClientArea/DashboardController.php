<?php

namespace App\Controllers\ClientArea;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index(): ResponseInterface|string
    {
        $db = \Config\Database::connect();
        $userId = session('user_id');

        $stats = [
            'total_orders'      => $db->table('orders')->where('user_id', $userId)->countAllResults(),
            'pending_orders'    => $db->table('orders')->where('user_id', $userId)->where('status', 'waiting_payment')->countAllResults(),
            'unpaid_invoices'   => $db->table('invoices i')->join('orders o', 'o.id = i.order_id')->where('i.user_id', $userId)->where('i.status', 'unpaid')->countAllResults(),
            'available_downloads'=> $db->table('downloads d')->join('orders o', 'o.id = d.order_id')->where('d.user_id', $userId)->where('d.download_count < d.max_downloads')->where('(d.expires_at IS NULL OR d.expires_at > NOW())')->countAllResults(),
        ];

        $recentOrders = $db->table('orders')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        $recentInvoices = $db->table('invoices')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        $data = [
            'title'         => 'Dashboard',
            'page'          => 'client/dashboard',
            'stats'         => $stats,
            'recentOrders'  => $recentOrders,
            'recentInvoices'=> $recentInvoices,
        ];

        return view('client/dashboard', $data);
    }

    public function orders(): string
    {
        $db = \Config\Database::connect();
        $userId = session('user_id');

        $orders = $db->table('orders')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->paginate(15);

        $data = [
            'title'  => 'My Orders',
            'page'   => 'client/orders',
            'orders' => $orders,
            'pager'  => $db->table('orders')->pager,
        ];

        return view('client/orders', $data);
    }

    public function invoices(): string
    {
        $db = \Config\Database\connect();
        $userId = session('user_id');

        $invoices = $db->table('invoices')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->paginate(15);

        $data = [
            'title'    => 'My Invoices',
            'page'     => 'client/invoices',
            'invoices' => $invoices,
            'pager'    => $db->table('invoices')->pager,
        ];

        return view('client/invoices', $data);
    }

    public function downloads(): string
    {
        $db = \Config\Database\connect();
        $userId = session('user_id');

        $downloads = $db->table('downloads d')
            ->select('d.*, p.name as product_name, p.thumbnail, o.order_number')
            ->join('products p', 'p.id = d.product_id')
            ->join('orders o', 'o.id = d.order_id')
            ->where('d.user_id', $userId)
            ->orderBy('d.created_at', 'DESC')
            ->paginate(15);

        $data = [
            'title'      => 'My Downloads',
            'page'       => 'client/downloads',
            'downloads'  => $downloads,
            'pager'      => $db->table('downloads')->pager,
        ];

        return view('client/downloads', $data);
    }

    public function tickets(): string
    {
        return view('client/tickets', ['title' => 'Support Tickets', 'page' => 'client/tickets']);
    }

    public function profile(): string
    {
        return view('client/profile', ['title' => 'My Profile', 'page' => 'client/profile']);
    }
}