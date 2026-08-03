<?php

namespace App\Modules\Order\Controllers;

use App\Controllers\BaseController;
use App\Modules\Order\Services\OrderService;
use CodeIgniter\HTTP\ResponseInterface;

class OrderController extends BaseController
{
    protected OrderService $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    public function index()
    {
        $result = $this->orderService->getOrders();

        $data = [
            'title' => 'Orders',
            'orders' => $result['data']['orders'] ?? [],
        ];

        return view('Order/index', $data);
    }

    public function detail(string $uuid)
    {
        $result = $this->orderService->getOrderByUuid($uuid);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Order #' . $result['data']['order_number'],
            'order' => $result['data'],
        ];

        return view('Order/detail', $data);
    }

    public function cancel(string $uuid): ResponseInterface
    {
        $result = $this->orderService->cancelOrder($uuid);

        if ($result['success']) {
            return redirect()->back()
                ->with('success', $result['message']);
        }

        return redirect()->back()
            ->with('error', $result['message']);
    }
}