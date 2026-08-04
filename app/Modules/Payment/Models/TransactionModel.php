<?php

namespace App\Modules\Payment\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'uuid',
        'invoice_id',
        'payment_method',
        'payment_reference',
        'amount',
        'status',
        'paid_at',
        'created_at',
    ];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';

    protected $validationRules = [
        'invoice_id' => 'required|integer',
        'payment_method' => 'required|max_length[50]',
        'payment_reference' => 'max_length[100]',
        'amount' => 'required|decimal',
        'status' => 'in_list[pending,success,failed,cancelled,refunded]',
    ];

    protected $beforeInsert = ['generateUuid'];

    protected function generateUuid(array $data): array
    {
        if (empty($data['data']['uuid'])) {
            $data['data']['uuid'] = $this->generateUuidString();
        }
        return $data;
    }

    protected function generateUuidString(): string
    {
        return date('YmdHis') . substr(md5(uniqid('', true) . mt_rand(100000, 999999)), 0, 8);
    }

    public function getByInvoice(int $invoiceId): ?object
    {
        return $this->where('invoice_id', $invoiceId)->first();
    }

    public function getSuccessfulByInvoice(int $invoiceId): ?object
    {
        return $this->where('invoice_id', $invoiceId)
            ->where('status', 'success')
            ->first();
    }
}