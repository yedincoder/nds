<?php

namespace App\Modules\Dashboard\Controllers;

use App\Controllers\BaseController;
use App\Modules\Product\Models\ProductModel;
use App\Modules\Order\Models\OrderModel;
use App\Modules\Customer\Models\UserProfileModel;
use App\Modules\Invoice\Models\InvoiceModel;

class AdminDashboardController extends BaseController
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
        $stats = [
            'total_products' => $this->productModel->countAllResults(),
            'total_orders' => $this->orderModel->countAllResults(),
            'total_customers' => $this->userProfileModel->countAllResults(),
            'total_revenue' => $this->invoiceModel->selectSum('total')->where('status', 'paid')->get()->getRow()->total ?? 0,
            'pending_orders' => $this->orderModel->where('status', 'pending')->countAllResults(),
            'unpaid_invoices' => $this->invoiceModel->where('status', 'unpaid')->countAllResults(),
        ];

        $data = [
            'title' => 'Admin Dashboard',
            'stats' => $stats,
            'recent_orders' => $this->orderModel->orderBy('created_at', 'DESC')->limit(10)->findAll(),
        ];

        return view('Dashboard/dashboard', $data);
    }

    public function customers()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $customers = $this->userProfileModel->join('users', 'users.id = user_profiles.user_id')
            ->select('user_profiles.*, users.email, users.status')
            ->orderBy('user_profiles.created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Customers',
            'customers' => $customers,
            'pager' => $this->userProfileModel->pager,
        ];

        return view('Dashboard/customers', $data);
    }

    public function products()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $data = [
            'title' => 'Products',
            'products' => $this->productModel->orderBy('created_at', 'DESC')->paginate($perPage),
            'pager' => $this->productModel->pager,
        ];

        return view('Dashboard/products', $data);
    }

    public function orders()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $data = [
            'title' => 'Orders',
            'orders' => $this->orderModel->orderBy('created_at', 'DESC')->paginate($perPage),
            'pager' => $this->orderModel->pager,
        ];

        return view('Dashboard/orders', $data);
    }

    public function invoices()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $data = [
            'title' => 'Invoices',
            'invoices' => $this->invoiceModel->orderBy('created_at', 'DESC')->paginate($perPage),
            'pager' => $this->invoiceModel->pager,
        ];

        return view('Dashboard/invoices', $data);
    }

    public function reports()
    {
        $data = [
            'title' => 'Reports',
            'stats' => [
            'total_revenue' => $this->invoiceModel->selectSum('total')->where('status', 'paid')->get()->getRow()->total ?? 0,
                'total_orders' => $this->orderModel->countAllResults(),
                'total_customers' => $this->userProfileModel->countAllResults(),
                'total_products' => $this->productModel->countAllResults(),
            ],
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

    public function payments(): string
    {
        $db = \Config\Database::connect();
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;
        $offset = ($page - 1) * $perPage;

        $payments = $db->table('transactions t')
            ->select('t.*, i.order_id, u.username, u.email')
            ->join('invoices i', 'i.id = t.invoice_id', 'left')
            ->join('users u', 'u.id = i.user_id', 'left')
            ->orderBy('t.created_at', 'DESC')
            ->limit($perPage, $offset)
            ->get()
            ->getResult();

        $total = $db->table('transactions')->countAllResults();

        return view('Dashboard/payments', $data);
    }
}
