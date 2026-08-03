<?php

namespace App\Modules\Cart\Services;

use App\Modules\Cart\Models\CartModel;
use App\Modules\Cart\Models\CartItemModel;

class CartService
{
    protected $cartModel;
    protected $cartItemModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->cartItemModel = new CartItemModel();
    }

    public function getOrCreateCart(?int $userId = null, ?string $sessionId = null): array
    {
        try {
            $cart = $this->cartModel->getActiveCart($userId, $sessionId);
            if ($cart) {
                $items = $this->cartItemModel->getCartItemsWithDetails($cart->id);
                $totals = $this->cartItemModel->calculateCartTotal($cart->id);

                return [
                    'success' => true,
                    'message' => 'Cart retrieved successfully.',
                    'data' => [
                        'cart' => $cart,
                        'items' => $items,
                        'totals' => $totals
                    ]
                ];
            }

            // Create new cart
            $cartData = [
                'uuid' => $this->generateUuidString(),
                'user_id' => $userId,
                'session_id' => $sessionId,
                'status' => 'active',
            ];
            $cartId = $this->cartModel->insert($cartData);

            return [
                'success' => true,
                'message' => 'Cart created successfully.',
                'data' => [
                    'cart' => $this->cartModel->find($cartId),
                    'items' => [],
                    'totals' => ['subtotal' => 0, 'tax' => 0, 'total' => 0]
                ]
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error getting/creating cart: ' . $e->getMessage()
            ];
        }
    }

    public function addItem(int $cartId, array $data): array
    {
        try {
            $cart = $this->cartModel->find($cartId);
            if (!$cart || $cart->status !== 'active') {
                return ['success' => false, 'message' => 'Cart not found or not active.'];
            }

            $existingItem = $this->cartItemModel->getItem($cartId, $data['product_id'] ?? null, $data['service_id'] ?? null);
            if ($existingItem) {
                // Update existing item
                $quantity = $existingItem->quantity + ($data['quantity'] ?? 1);
                $price = $data['price'] ?? $existingItem->price;
                $subtotal = $quantity * $price;

                $updateData = [
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ];
                $this->cartItemModel->update($existingItem->id, $updateData);

                return [
                    'success' => true,
                    'message' => 'Cart item updated successfully.',
                    'data' => $this->cartItemModel->find($existingItem->id)
                ];
            }

            // Create new cart item
            $itemData = [
                'uuid' => $this->generateUuidString(),
                'cart_id' => $cartId,
                'product_id' => $data['product_id'] ?? null,
                'service_id' => $data['service_id'] ?? null,
                'quantity' => $data['quantity'] ?? 1,
                'price' => $data['price'] ?? 0,
                'subtotal' => ($data['quantity'] ?? 1) * ($data['price'] ?? 0),
            ];
            $itemId = $this->cartItemModel->insert($itemData);

            $totals = $this->cartItemModel->calculateCartTotal($cartId);

            return [
                'success' => true,
                'message' => 'Cart item added successfully.',
                'data' => [
                    'item' => $this->cartItemModel->find($itemId),
                    'totals' => $totals
                ]
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error adding item to cart: ' . $e->getMessage()
            ];
        }
    }

    public function updateItem(int $itemId, array $data): array
    {
        try {
            $item = $this->cartItemModel->find($itemId);
            if (!$item) {
                return ['success' => false, 'message' => 'Cart item not found.'];
            }

            $updateData = [];
            if (isset($data['quantity'])) {
                $updateData['quantity'] = $data['quantity'];
                $updateData['subtotal'] = $data['quantity'] * ($item->price ?? 0);
            }
            if (isset($data['price'])) {
                $updateData['price'] = $data['price'];
                $updateData['subtotal'] = ($item->quantity ?? 1) * $data['price'];
            }

            if (empty($updateData)) {
                return ['success' => false, 'message' => 'No data to update.'];
            }

            $this->cartItemModel->update($itemId, $updateData);
            $totals = $this->cartItemModel->calculateCartTotal($item->cart_id);

            return [
                'success' => true,
                'message' => 'Cart item updated successfully.',
                'data' => [
                    'item' => $this->cartItemModel->find($itemId),
                    'totals' => $totals
                ]
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error updating cart item: ' . $e->getMessage()
            ];
        }
    }

    public function removeItem(int $itemId): array
    {
        try {
            $item = $this->cartItemModel->find($itemId);
            if (!$item) {
                return ['success' => false, 'message' => 'Cart item not found.'];
            }

            $cartId = $item->cart_id;
            $this->cartItemModel->delete($itemId);
            $totals = $this->cartItemModel->calculateCartTotal($cartId);

            return [
                'success' => true,
                'message' => 'Cart item removed successfully.',
                'data' => ['totals' => $totals]
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error removing cart item: ' . $e->getMessage()
            ];
        }
    }

    public function clearCart(int $cartId): array
    {
        try {
            $this->cartItemModel->where('cart_id', $cartId)->delete();

            return [
                'success' => true,
                'message' => 'Cart cleared successfully.',
                'data' => ['totals' => ['subtotal' => 0, 'tax' => 0, 'total' => 0]]
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error clearing cart: ' . $e->getMessage()
            ];
        }
    }

    public function convertCart(int $cartId, array $data): array
    {
        try {
            $cart = $this->cartModel->find($cartId);
            if (!$cart || $cart->status !== 'active') {
                return ['success' => false, 'message' => 'Cart not found or not active.'];
            }

            $db = \Config\Database::connect();
            $db->transBegin();

            try {
                // Update cart status
                $this->cartModel->update($cartId, ['status' => 'converted']);

                // Create order
                $orderData = [
                    'uuid' => $this->generateUuidString(),
                    'user_id' => $cart->user_id ?? null,
                    'order_number' => $this->generateOrderNumber(),
                    'status' => 'pending',
                    'payment_status' => 'pending',
                    'subtotal' => $data['subtotal'] ?? 0,
                    'discount' => $data['discount'] ?? 0,
                    'tax' => $data['tax'] ?? 0,
                    'total' => $data['total'] ?? 0,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $orderId = $db->table('orders')->insert($orderData);

                // Move cart items to order items
                $cartItems = $this->cartItemModel->getByCart($cartId);
                foreach ($cartItems as $cartItem) {
                    $orderItemData = [
                        'uuid' => $this->generateUuidString(),
                        'order_id' => $orderId,
                        'product_id' => $cartItem->product_id,
                        'service_id' => $cartItem->service_id,
                        'name' => $cartItem->product_id ? ($cartItem->product->name ?? 'Product') : ($cartItem->service_id ? ($cartItem->service->name ?? 'Service') : 'Item'),
                        'quantity' => $cartItem->quantity,
                        'price' => $cartItem->price,
                        'subtotal' => $cartItem->subtotal,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                    $db->table('order_items')->insert($orderItemData);
                }

                if ($db->transStatus() === false) {
                    $db->transRollback();
                    return ['success' => false, 'message' => 'Failed to convert cart to order.'];
                }

                $db->transCommit();

                return [
                    'success' => true,
                    'message' => 'Cart converted to order successfully.',
                    'data' => [
                        'order_id' => $orderId,
                        'cart_id' => $cartId
                    ]
                ];
            } catch (\Throwable $e) {
                $db->transRollback();
                throw $e;
            }
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error converting cart: ' . $e->getMessage()
            ];
        }
    }

    protected function generateUuidString(): string
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

    protected function generateOrderNumber(): string
    {
        $lastOrder = db_connect()->table('orders')
            ->select('order_number')
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();

        $counter = $lastOrder ? (int)substr($lastOrder->order_number, -6) + 1 : 1;

        return 'ORD-' . date('Ymd') . '-' . str_pad($counter, 6, '0', STR_PAD_LEFT);
    }
}