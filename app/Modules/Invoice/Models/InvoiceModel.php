<?php

namespace App\Modules\Invoice\Models;

use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table = 'invoices';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'uuid',
        'user_id',
        'order_id',
        'invoice_number',
        'status',
        'subtotal',
        'discount',
        'tax',
        'total',
        'due_date',
        'paid_at',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getInvoicesByUser(int $userId)
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function getInvoiceByUuid(string $uuid)
    {
        return $this->where('uuid', $uuid)->first();
    }

    public function getInvoiceByNumber(string $invoiceNumber)
    {
        return $this->where('invoice_number', $invoiceNumber)->first();
    }

    public function countByUser(int $userId): int
    {
        return $this->where('user_id', $userId)->countAllResults();
    }

    public function getUnpaidByUser(int $userId)
    {
        return $this->where('user_id', $userId)
            ->where('status', 'unpaid')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }
}
