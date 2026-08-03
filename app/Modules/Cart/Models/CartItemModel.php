<?php

namespace App\Modules\Cart\Models;

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
        'subtotal',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'cart_id' => 'required|integer',
        'quantity' => 'required|integer|min[1]',
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
        foreach ($items as $item) {
            $subtotal += $item->subtotal;
        }
        return [
            'subtotal' => $subtotal,
            'tax' => $subtotal * 0.10, // 10% tax
            'total' => $subtotal * 1.10, // 10% tax
        ];
    }
}