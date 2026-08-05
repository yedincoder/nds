<?php

namespace App\Modules\FrontArea\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'uuid',
        'user_id',
        'order_number',
        'status',
        'payment_status',
        'subtotal',
        'discount',
        'tax',
        'total',
        'notes',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'user_id' => 'required|integer',
        'order_number' => 'required|max_length[50]|is_unique[orders.order_number,id,{id}]',
        'status' => 'required|in_list[pending,waiting_payment,paid,processing,completed,cancelled,expired]',
    ];

    public function getOrdersByUser(int $userId)
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function getOrderByUuid(string $uuid)
    {
        return $this->where('uuid', $uuid)->first();
    }

    public function getOrderByNumber(string $orderNumber)
    {
        return $this->where('order_number', $orderNumber)->first();
    }

    public function countByUser(int $userId): int
    {
        return $this->where('user_id', $userId)->countAllResults();
    }

    public function getRecentByUser(int $userId, int $limit = 5)
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}
