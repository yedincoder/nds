<?php

namespace App\Modules\Checkout\Services;

class CheckoutService
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function createOrder(int $userId, array $items, array $addressData, array $orderData = []): ?int
    {
        $this->db->transBegin();

        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item['subtotal'];
        }

        $discount = $orderData['discount'] ?? 0;
        $tax      = $orderData['tax'] ?? 0;
        $total    = $subtotal - $discount + $tax;

        $orderNumber = $this->generateOrderNumber();

        $this->db->table('orders')->insert([
            'uuid'           => $this->generateUuid(),
            'user_id'        => $userId,
            'order_number'   => $orderNumber,
            'status'         => 'pending',
            'payment_status' => 'pending',
            'subtotal'       => $subtotal,
            'discount'       => $discount,
            'tax'            => $tax,
            'total'          => $total,
            'notes'          => $orderData['notes'] ?? null,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ]);

        $orderId = $this->db->insertID();

        if (!$orderId) {
            $this->db->transRollback();
            return null;
        }

        foreach ($items as $item) {
            $this->db->table('order_items')->insert([
                'uuid'       => $this->generateUuid(),
                'order_id'   => $orderId,
                'product_id' => $item['product_id'] ?? null,
                'service_id' => $item['service_id'] ?? null,
                'name'       => $item['name'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
                'subtotal'   => $item['subtotal'],
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        if (!empty($addressData)) {
            $this->db->table('customer_addresses')->insert([
                'uuid'    => $this->generateUuid(),
                'user_id' => $userId,
                'name'    => $addressData['name'] ?? '',
                'phone'   => $addressData['phone'] ?? '',
                'address' => $addressData['address'] ?? '',
                'city'    => $addressData['city'] ?? '',
                'province'=> $addressData['province'] ?? '',
                'is_default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $this->db->transComplete();

        return $this->db->transStatus() ? $orderId : null;
    }

    public function getOrder(int $orderId): ?object
    {
        return $this->db->table('orders o')
            ->select('o.*, u.full_name as user_name, u.email as user_email')
            ->join('users u', 'u.id = o.user_id', 'left')
            ->where('o.id', $orderId)
            ->get()
            ->getRow();
    }

    public function getOrderByNumber(string $orderNumber): ?object
    {
        return $this->db->table('orders')
            ->where('order_number', $orderNumber)
            ->get()
            ->getRow();
    }

    public function getOrderItems(int $orderId): array
    {
        return $this->db->table('order_items')
            ->where('order_id', $orderId)
            ->orderBy('created_at', 'ASC')
            ->get()
            ->getResult();
    }

    public function getUserOrders(int $userId, int $perPage = 10, int $page = 1): array
    {
        $builder = $this->db->table('orders');
        $builder->where('user_id', $userId);
        $total = $builder->countAllResults(false);

        $orders = $builder->orderBy('created_at', 'DESC')
            ->limit($perPage, ($page - 1) * $perPage)
            ->get()
            ->getResult();

        return [
            'orders'    => $orders,
            'total'     => $total,
            'perPage'   => $perPage,
            'page'      => $page,
            'totalPages'=> (int) ceil($total / $perPage),
        ];
    }

    public function cancelOrder(int $orderId, int $userId): bool
    {
        $order = $this->db->table('orders')
            ->where('id', $orderId)
            ->where('user_id', $userId)
            ->get()
            ->getRow();

        if (!$order || !in_array($order->status, ['pending', 'waiting_payment'], true)) {
            return false;
        }

        return $this->db->table('orders')
            ->where('id', $orderId)
            ->update([
                'status'         => 'cancelled',
                'payment_status' => 'cancelled',
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);
    }

    public function updateOrderStatus(int $orderId, string $status): bool
    {
        return $this->db->table('orders')
            ->where('id', $orderId)
            ->update([
                'status'     => $status,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
    }

    public function updatePaymentStatus(int $orderId, string $status): bool
    {
        return $this->db->table('orders')
            ->where('id', $orderId)
            ->update([
                'payment_status' => $status,
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);
    }

    public function getAllOrders(array $filters = [], int $perPage = 20, int $page = 1): array
    {
        $builder = $this->db->table('orders o');
        $builder->select('o.*, u.full_name as user_name, u.email as user_email');
        $builder->join('users u', 'u.id = o.user_id', 'left');

        if (!empty($filters['status'])) {
            $builder->where('o.status', $filters['status']);
        }

        if (!empty($filters['payment_status'])) {
            $builder->where('o.payment_status', $filters['payment_status']);
        }

        if (!empty($filters['search'])) {
            $builder->groupStart();
            $builder->like('o.order_number', $filters['search']);
            $builder->orLike('u.full_name', $filters['search']);
            $builder->groupEnd();
        }

        $total = $builder->countAllResults(false);
        $orders = $builder->orderBy('o.created_at', 'DESC')
            ->limit($perPage, ($page - 1) * $perPage)
            ->get()
            ->getResult();

        return [
            'orders'    => $orders,
            'total'     => $total,
            'perPage'   => $perPage,
            'page'      => $page,
            'totalPages'=> (int) ceil($total / $perPage),
        ];
    }

    public function getOrderStats(): array
    {
        return [
            'total_orders'       => $this->db->table('orders')->countAllResults(),
            'pending_orders'     => $this->db->table('orders')->where('status', 'pending')->countAllResults(),
            'completed_orders'   => $this->db->table('orders')->where('status', 'completed')->countAllResults(),
            'cancelled_orders'   => $this->db->table('orders')->where('status', 'cancelled')->countAllResults(),
            'total_revenue'      => $this->db->table('orders')->where('status', 'completed')->selectSum('total')->get()->getRow()->total ?? 0,
        ];
    }

    protected function generateOrderNumber(): string
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }

    protected function generateUuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return sprintf('%02x%02x%02x%02x-%02x%02x-%02x%02x-%02x%02x-%02x%02x%02x%02x%02x%02x',
            $data[0], $data[1], $data[2], $data[3],
            $data[4], $data[5], $data[6], $data[7],
            $data[8], $data[9], $data[10], $data[11],
            $data[12], $data[13], $data[14], $data[15]
        );
    }
}
