<?php

namespace App\Modules\FrontArea\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'uuid',
        'invoice_id',
        'user_id',
        'payment_method_id',
        'amount',
        'status',
        'paid_at',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'user_id' => 'required|integer',
        'invoice_id' => 'required|integer',
        'payment_method_id' => 'required|integer',
        'amount' => 'required|decimal',
        'status' => 'in_list[pending,processing,success,failed,expired,cancelled,refunded]',
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