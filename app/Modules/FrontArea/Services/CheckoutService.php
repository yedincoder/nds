<?php

namespace App\Modules\FrontArea\Services;

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
            ->select('o.*, u.email as user_email, up.full_name as user_name')
            ->join('users u', 'u.id = o.user_id', 'left')
            ->join('user_profiles up', 'up.user_id = u.id', 'left')
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
        $builder->select('o.*, u.email as user_email, up.full_name as user_name');
        $builder->join('users u', 'u.id = o.user_id', 'left');
        $builder->join('user_profiles up', 'up.user_id = u.id', 'left');

        if (!empty($filters['status'])) {
            $builder->where('o.status', $filters['status']);
        }

        if (!empty($filters['payment_status'])) {
            $builder->where('o.payment_status', $filters['payment_status']);
        }

        if (!empty($filters['search'])) {
            $builder->groupStart();
            $builder->like('o.order_number', $filters['search']);
            $builder->orLike('up.full_name', $filters['search']);
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

    public function processCheckout(array $data): array
    {
        $this->db->transBegin();

        try {
            $userId = session()->get('user_id');
            if (!$userId) {
                return [
                    'success' => false,
                    'message' => 'User not authenticated.'
                ];
            }

            // Get cart items
            $cart = $this->db->table('carts')
                ->where('user_id', $userId)
                ->where('status', 'active')
                ->get()
                ->getRow();

            if (!$cart) {
                return [
                    'success' => false,
                    'message' => 'Cart not found.'
                ];
            }

            $cartItems = $this->db->table('cart_items')
                ->select('cart_items.*, products.name as product_name, services.name as service_name')
                ->join('products', 'products.id = cart_items.product_id', 'left')
                ->join('services', 'services.id = cart_items.service_id', 'left')
                ->where('cart_id', $cart->id)
                ->get()
                ->getResult();

            if (empty($cartItems)) {
                return [
                    'success' => false,
                    'message' => 'Cart is empty.'
                ];
            }

            // Prepare order items
            $orderItems = [];
            $subtotal = 0;
            
            foreach ($cartItems as $item) {
                $itemName = $item->product_name ?? $item->service_name ?? 'Item';
                $itemSubtotal = $item->quantity * $item->price;
                
                $orderItems[] = [
                    'product_id' => $item->product_id,
                    'service_id' => $item->service_id,
                    'name' => $itemName,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $itemSubtotal
                ];
                
                $subtotal += $itemSubtotal;
            }

            // Create order
            $orderId = $this->createOrder($userId, $orderItems, $data, [
                'subtotal' => $subtotal,
                'discount' => 0,
                'tax' => 0,
                'total' => $subtotal
            ]);

            if (!$orderId) {
                return [
                    'success' => false,
                    'message' => 'Failed to create order.'
                ];
            }

            // Create invoice
            $billingService = new \App\Modules\FrontArea\Services\BillingService();
            
            $invoiceId = $billingService->createInvoice($orderId, $userId, [
                'subtotal' => $subtotal,
                'discount' => 0,
                'tax' => 0,
                'total' => $subtotal,
                'status' => 'unpaid',
                'items' => $orderItems
            ]);

            if (!$invoiceId) {
                $this->db->transRollback();
                return [
                    'success' => false,
                    'message' => 'Failed to create invoice.'
                ];
            }

            // Update cart status
            $this->db->table('carts')
                ->where('id', $cart->id)
                ->update(['status' => 'converted']);

            $invoice = $this->db->table('invoices')->where('id', $invoiceId)->get()->getRow();

            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                return [
                    'success' => false,
                    'message' => 'Checkout process failed.'
                ];
            }

            $this->db->transCommit();

            return [
                'success' => true,
                'message' => 'Checkout completed successfully.',
                'data' => [
                    'order_id' => $orderId,
                    'invoice_id' => $invoiceId,
                    'invoice_uuid' => $invoice->uuid ?? null,
                    'invoice_number' => $invoice->invoice_number ?? null,
                    'order_number' => $this->getOrder($orderId)->order_number ?? ''
                ]
            ];

        } catch (\Throwable $e) {
            $this->db->transRollback();
            log_message('error', 'Checkout error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'An error occurred during checkout. Please try again.'
            ];
        }
    }

    protected function generateOrderNumber(): string
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }

    protected function generateUuid(): string
    {
        // Generate UUID v4 dengan uniqid dan mt_rand untuk Windows compatibility
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}
