<?php

namespace App\Modules\FrontArea\Models;

use CodeIgniter\Model;

class CartItemModel extends Model
{
    protected $table = 'cart_items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'uuid',
        'cart_id',
        'product_id',
        'service_id',
        'quantity',
        'price',
        'tax_rate',
        'tax_amount',
        'discount_rate',
        'discount_amount',
        'subtotal',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'cart_id' => 'required|integer',
        'quantity' => 'required|integer|greater_than_equal_to[1]',
        'price' => 'required|decimal',
        'subtotal' => 'required|decimal',
    ];

    protected $beforeInsert = ['generateUuid'];
    protected $beforeUpdate = ['generateUuid'];

    protected function generateUuid(array $data): array
    {
        if (empty($data['data']['uuid'])) {
            $data['data']['uuid'] = $this->generateUuidString();
        }
        return $data;
    }

    protected function generateUuidString(): string
    {
        // Simple implementation dengan timestamp dan random number
        return date('YmdHis') . substr(md5(uniqid('', true) . mt_rand(100000, 999999)), 0, 8);
    }

    public function getByCart(int $cartId): array
    {
        return $this->where('cart_id', $cartId)->findAll();
    }

    public function getItem(int $cartId, ?int $productId = null, ?int $serviceId = null): ?object
    {
        $query = $this->where('cart_id', $cartId);
        if ($productId) {
            $query->where('product_id', $productId);
        } elseif ($serviceId) {
            $query->where('service_id', $serviceId);
        }
        return $query->first();
    }

    public function getCartItemsWithDetails(int $cartId): array
    {
        $items = $this->where('cart_id', $cartId)->findAll();
        
        // Debug: Log if no items found
        if (empty($items)) {
            log_message('debug', 'CartService: No items found for cart_id=' . $cartId);
            return [];
        }
        
        foreach ($items as $item) {
            if ($item->product_id) {
                $db = \Config\Database::connect();
                $item->product = $db->table('products')
                    ->select('id, name, thumbnail, slug')
                    ->where('id', $item->product_id)
                    ->get()
                    ->getRow();
            } elseif ($item->service_id) {
                $db = \Config\Database::connect();
                $item->service = $db->table('services')
                    ->select('id, name, thumbnail, slug')
                    ->where('id', $item->service_id)
                    ->get()
                    ->getRow();
            }
        }
        return $items;
    }

    public function calculateCartTotal(int $cartId): array
    {
        $items = $this->where('cart_id', $cartId)->findAll();
        $subtotal = 0;
        $totalTax = 0;
        $totalDiscount = 0;
        
        foreach ($items as $item) {
            $subtotal += $item->subtotal;
            $totalTax += $item->tax_amount ?? 0;
            $totalDiscount += $item->discount_amount ?? 0;
        }
        
        return [
            'subtotal' => $subtotal,
            'tax' => $totalTax,
            'discount' => $totalDiscount,
            'total' => $subtotal + $totalTax - $totalDiscount,
        ];
    }
}