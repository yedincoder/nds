<?php

namespace App\Modules\ClientArea\Controllers;

use App\Controllers\BaseController;
use App\Modules\ClientArea\Services\CustomerService;
use App\Modules\FrontArea\Services\OrderService;
use App\Modules\FrontArea\Services\InvoiceService;
use App\Modules\AdminArea\Services\SupportService;

class DashboardController extends BaseController
{
    protected CustomerService $customerService;
    protected OrderService $orderService;
    protected InvoiceService $invoiceService;
    protected SupportService $supportService;

    public function __construct()
    {
        $this->customerService = new CustomerService();
        $this->orderService = new OrderService();
        $this->invoiceService = new InvoiceService();
        $this->supportService = new SupportService();
    }

    public function index()
    {
        $userId = session()->get('user_id');

        $data = [
            'title' => 'Dashboard',
            'stats' => [
                'orders' => $this->orderService->countByUser($userId),
                'invoices' => $this->invoiceService->countByUser($userId),
                'tickets' => $this->supportService->countByUser($userId),
            ],
            'recent_orders' => $this->orderService->getRecentByUser($userId, 5)['data'] ?? [],
            'unpaid_invoices' => $this->invoiceService->getUnpaidByUser($userId)['data'] ?? [],
        ];

        return view('ClientArea/dashboard', $data);
    }

    public function orders()
    {
        $userId = session()->get('user_id');
        $result = $this->orderService->getOrdersByUser($userId);

        // Filter only paid/completed orders for My Orders
        $orders = array_filter($result['data']['orders'] ?? [], function($order) {
            return in_array($order->status ?? '', ['paid', 'completed']);
        });

        $data = [
            'title' => 'My Orders',
            'orders' => array_values($orders),
        ];

        return view('ClientArea/orders', $data);
    }

    public function invoices()
    {
        $userId = session()->get('user_id');
        $result = $this->invoiceService->getInvoicesByUser($userId);

        $data = [
            'title' => 'My Invoices',
            'invoices' => $result['data']['invoices'] ?? [],
        ];

        return view('ClientArea/invoices', $data);
    }

    public function downloads()
    {
        $userId = session()->get('user_id');
        $result = $this->customerService->getDownloads($userId);

        $data = [
            'title' => 'My Downloads',
            'downloads' => $result['data']['downloads'] ?? [],
        ];

        return view('ClientArea/downloads', $data);
    }

    public function tickets()
    {
        $userId = session()->get('user_id');
        $result = $this->supportService->getTicketsByUser($userId);

        $data = [
            'title' => 'Support Tickets',
            'tickets' => $result['data']['tickets'] ?? [],
        ];

        return view('ClientArea/tickets', $data);
    }

    public function profile()
    {
        $userId = session()->get('user_id');

        if ($this->request->getMethod() === 'post') {
            $result = $this->customerService->updateProfile($userId, [
                'full_name' => $this->request->getPost('full_name'),
                'phone' => $this->request->getPost('phone'),
                'address' => $this->request->getPost('address'),
                'city' => $this->request->getPost('city'),
                'province' => $this->request->getPost('province'),
                'postal_code' => $this->request->getPost('postal_code'),
            ]);

            if ($result['success']) {
                return redirect()->back()
                    ->with('success', $result['message']);
            }

            return redirect()->back()
                ->with('error', $result['message'])
                ->withInput();
        }

        $result = $this->customerService->getProfile($userId);

        $data = [
            'title' => 'Profile',
            'profile' => $result['data'] ?? null,
        ];

        return view('ClientArea/profile', $data);
    }
}
