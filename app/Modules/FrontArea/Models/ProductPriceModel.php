<?php

namespace App\Modules\FrontArea\Models;

use CodeIgniter\Model;

class ProductPriceModel extends Model
{
    protected $table = 'product_prices';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'uuid',
        'product_id',
        'price',
        'discount_price',
        'currency',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'product_id' => 'required|integer',
        'price' => 'required|decimal',
        'currency' => 'max_length[10]',
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
        // Simple implementation dengan timestamp dan random number (Windows compatible)
        return date('YmdHis') . substr(md5(uniqid('', true) . mt_rand(100000, 999999)), 0, 8);
    }

    public function getByProduct(int $productId): array
    {
        return $this->where('product_id', $productId)->findAll();
    }

    public function getActivePrice(int $productId): ?object
    {
        return $this->where('product_id', $productId)->first();
    }
}