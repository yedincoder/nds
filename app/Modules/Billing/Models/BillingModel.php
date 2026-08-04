<?php

namespace App\Modules\Billing\Models;

use CodeIgniter\Model;

class BillingModel extends Model
{
    protected $table = 'billing';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'uuid',
        'user_id',
        'invoice_id',
        'transaction_id',
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
        'transaction_id' => 'required|max_length[100]',
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
        // Simple implementation dengan timestamp dan random number (Windows compatible)
        return date('YmdHis') . substr(md5(uniqid('', true) . mt_rand(100000, 999999)), 0, 8);
    }

    public function getByUser(int $userId, int $limit = 0, int $offset = 0): array
    {
        $query = $this->where('user_id', $userId);
        if ($limit > 0) {
            $query->limit($limit, $offset);
        }
        return $query->orderBy('created_at', 'DESC')->findAll();
    }

    public function getByInvoice(int $invoiceId): ?object
    {
        return $this->where('invoice_id', $invoiceId)->first();
    }

    public function getSuccessfulPayments(int $userId): array
    {
        return $this->where('user_id', $userId)
            ->where('status', 'success')
            ->orderBy('paid_at', 'DESC')
            ->findAll();
    }
}