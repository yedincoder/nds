<?php

namespace App\Modules\FrontArea\Services;

use App\Modules\FrontArea\Models\OrderModel;
use App\Modules\FrontArea\Models\OrderItemModel;

class OrderService
{
    protected OrderModel $orderModel;
    protected OrderItemModel $orderItemModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
    }

    public function getOrders(array $filters = []): array
    {
        $userId = session()->get('user_id');
        $orders = $this->orderModel->getOrdersByUser($userId);

        return [
            'success' => true,
            'message' => 'Orders retrieved successfully.',
            'data' => ['orders' => $orders],
        ];
    }

    public function getOrderByUuid(string $uuid): array
    {
        $order = $this->orderModel->getOrderByUuid($uuid);

        if (!$order) {
            return [
                'success' => false,
                'message' => 'Order not found.',
            ];
        }

        $items = $this->orderItemModel->getByOrder($order->id);

        return [
            'success' => true,
            'message' => 'Order retrieved successfully.',
            'data' => [
                'order' => $order,
                'items' => $items,
            ],
        ];
    }

    public function cancelOrder(string $uuid): array
    {
        $order = $this->orderModel->getOrderByUuid($uuid);

        if (!$order) {
            return [
                'success' => false,
                'message' => 'Order not found.',
            ];
        }

        if (!in_array($order->status, ['pending', 'waiting_payment'])) {
            return [
                'success' => false,
                'message' => 'Order cannot be cancelled.',
            ];
        }

        $this->orderModel->update($order->id, ['status' => 'cancelled']);

        return [
            'success' => true,
            'message' => 'Order cancelled successfully.',
        ];
    }

    public function countByUser(int $userId): int
    {
        return $this->orderModel->countByUser($userId);
    }

    public function getRecentByUser(int $userId, int $limit = 5): array
    {
        $orders = $this->orderModel->getRecentByUser($userId, $limit);

        return [
            'success' => true,
            'data' => $orders,
        ];
    }

    public function getOrdersByUser(int $userId): array
    {
        $orders = $this->orderModel->getOrdersByUser($userId);

        return [
            'success' => true,
            'message' => 'Orders retrieved successfully.',
            'data' => ['orders' => $orders],
        ];
    }
}
