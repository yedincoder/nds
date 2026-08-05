<?php

namespace App\Modules\FrontArea\Services;

use App\Modules\FrontArea\Models\CartModel;
use App\Modules\FrontArea\Models\CartItemModel;

class CartService
{
    protected $cartModel;
    protected $cartItemModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->cartItemModel = new CartItemModel();
    }

    /**
     * Get cart for current user (wrapper for getOrCreateCart)
     */
    public function getCart(): array
    {
        $userId = session()->get('user_id');
        $sessionId = session_id();
        
        // Debug logging
        log_message('debug', 'CartService::getCart() - userId: ' . ($userId ?? 'null') . ', sessionId: ' . $sessionId);
        
        // Jika user belum login, gunakan session_id saja
        if (!$userId) {
            log_message('debug', 'CartService::getCart() - User not logged in, using session_id');
            return $this->getOrCreateCart(null, $sessionId);
        }
        
        $result = $this->getOrCreateCart($userId, $sessionId);
        
        // Debug logging
        if (isset($result['data']['items'])) {
            log_message('debug', 'CartService::getCart() - Items count: ' . count($result['data']['items']));
        }
        
        return $result;
    }

    /**
     * Add item to cart (wrapper for addItem)
     */
    public function addToCart(array $data): array
    {
        // Get or create cart
        $cartResult = $this->getCart();
        
        if (!$cartResult['success']) {
            return $cartResult;
        }
        
        $cart = $cartResult['data']['cart'];
        
        // Get product/service price if not provided
        if (!isset($data['price']) || $data['price'] == 0) {
            $db = \Config\Database::connect();
            
            if (!empty($data['product_id'])) {
                // Get price, tax_rate, discount_price from product_prices table
                $productPrice = $db->table('product_prices')
                    ->select('price, tax_rate, discount_price')
                    ->where('product_id', $data['product_id'])
                    ->orderBy('id', 'DESC')
                    ->limit(1)
                    ->get()
                    ->getRow();
                
                if ($productPrice) {
                    $data['price'] = $productPrice->price;
                    $data['tax_rate'] = $productPrice->tax_rate ?? 0;
                    
                    // Calculate discount
                    if (!empty($productPrice->discount_price) && $productPrice->discount_price < $productPrice->price) {
                        $data['discount_rate'] = (($productPrice->price - $productPrice->discount_price) / $productPrice->price) * 100;
                    } else {
                        $data['discount_rate'] = 0;
                    }
                } else {
                    $data['price'] = 0;
                    $data['tax_rate'] = 0;
                    $data['discount_rate'] = 0;
                }
            } elseif (!empty($data['service_id'])) {
                // Get price from service_prices table
                $servicePrice = $db->table('service_prices')
                    ->select('price, tax_rate, discount_price')
                    ->where('service_id', $data['service_id'])
                    ->orderBy('id', 'DESC')
                    ->limit(1)
                    ->get()
                    ->getRow();
                
                if ($servicePrice) {
                    $data['price'] = $servicePrice->price;
                    $data['tax_rate'] = $servicePrice->tax_rate ?? 0;
                    $data['discount_rate'] = 0;
                } else {
                    $data['price'] = 0;
                    $data['tax_rate'] = 0;
                    $data['discount_rate'] = 0;
                }
            }
        }
        
        return $this->addItem($cart->id, $data);
    }

    /**
     * Update cart item (wrapper for updateItem)
     */
    public function updateCartItem(int $itemId, int $quantity): array
    {
        return $this->updateItem($itemId, ['quantity' => $quantity]);
    }

    /**
     * Remove item from cart (wrapper for removeItem)
     */
    public function removeFromCart(string $itemId): array
    {
        return $this->removeItem((int) $itemId);
    }

    public function getOrCreateCart(?int $userId = null, ?string $sessionId = null): array
    {
        try {
            $cart = $this->cartModel->getActiveCart($userId, $sessionId);
            
            // Jika tidak ada cart aktif, cek apakah ada cart yang sudah dikonversi
            if (!$cart && $userId) {
                // Cari cart yang sudah dikonversi dan buat cart baru
                $oldCart = $this->cartModel->where('user_id', $userId)->orderBy('id', 'DESC')->first();
                if ($oldCart) {
                    // Buat cart baru untuk session ini
                    $cart = $this->cartModel->where('user_id', $userId)
                        ->where('status', 'active')
                        ->first();
                }
            }
            
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
            
            log_message('debug', 'CartService: No active cart found, creating new cart');

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
            log_message('debug', 'CartService::addItem() - cartId: ' . $cartId . ', productId: ' . ($data['product_id'] ?? 'null'));
            
            $cart = $this->cartModel->find($cartId);
            if (!$cart || $cart->status !== 'active') {
                return ['success' => false, 'message' => 'Cart not found or not active.'];
            }
            
            log_message('debug', 'CartService::addItem() - Cart status: ' . $cart->status);

            $existingItem = $this->cartItemModel->getItem($cartId, $data['product_id'] ?? null, $data['service_id'] ?? null);
            if ($existingItem) {
                // Update existing item
                $quantity = $existingItem->quantity + ($data['quantity'] ?? 1);
                $price = $data['price'] ?? $existingItem->price;
                $taxRate = $data['tax_rate'] ?? $existingItem->tax_rate ?? 0;
                $discountRate = $data['discount_rate'] ?? $existingItem->discount_rate ?? 0;
                
                $subtotal = $quantity * $price;
                $taxAmount = $subtotal * ($taxRate / 100);
                $discountAmount = $subtotal * ($discountRate / 100);

                $updateData = [
                    'quantity' => $quantity,
                    'price' => $price,
                    'tax_rate' => $taxRate,
                    'tax_amount' => $taxAmount,
                    'discount_rate' => $discountRate,
                    'discount_amount' => $discountAmount,
                    'subtotal' => $subtotal,
                ];
                $this->cartItemModel->update($existingItem->id, $updateData);

                return [
                    'success' => true,
                    'message' => 'Cart item updated successfully.',
                    'data' => $this->cartItemModel->find($existingItem->id)
                ];
            }

            // Create new cart item - Calculate tax and discount
            $quantity = $data['quantity'] ?? 1;
            $price = $data['price'] ?? 0;
            $taxRate = $data['tax_rate'] ?? 0;
            $discountRate = $data['discount_rate'] ?? 0;
            
            $subtotal = $quantity * $price;
            $taxAmount = $subtotal * ($taxRate / 100);
            $discountAmount = $subtotal * ($discountRate / 100);
            
            $itemData = [
                'uuid' => $this->generateUuidString(),
                'cart_id' => $cartId,
                'product_id' => $data['product_id'] ?? null,
                'service_id' => $data['service_id'] ?? null,
                'quantity' => $quantity,
                'price' => $price,
                'tax_rate' => $taxRate,
                'tax_amount' => $taxAmount,
                'discount_rate' => $discountRate,
                'discount_amount' => $discountAmount,
                'subtotal' => $subtotal,
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

    /**
     * Clear cart for current user (wrapper for original clearCart)
     */
    public function clearCart(): array
    {
        $cartResult = $this->getCart();
        
        if (!$cartResult['success']) {
            return $cartResult;
        }
        
        $cart = $cartResult['data']['cart'];
        
        // Call original clearCart dengan cartId
        return $this->clearCartById($cart->id);
    }

    /**
     * Clear cart by ID (original implementation)
     */
    public function clearCartById(int $cartId): array
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
        // Simple implementation dengan timestamp dan random number (Windows compatible)
        return date('YmdHis') . substr(md5(uniqid('', true) . mt_rand(100000, 999999)), 0, 8);
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