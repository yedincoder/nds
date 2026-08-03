<?php

namespace App\Modules\Order\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'uuid',
        'order_id',
        'product_id',
        'service_id',
        'name',
        'quantity',
        'price',
        'subtotal',
        'created_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';

    public function getByOrder(int $orderId)
    {
        return $this->where('order_id', $orderId)->findAll();
    }
}
