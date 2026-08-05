<?php

namespace App\Modules\FrontArea\Models;

use CodeIgniter\Model;

class PaymentLogModel extends Model
{
    protected $table = 'payment_logs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'uuid',
        'transaction_id',
        'gateway_response',
        'status',
        'created_at',
    ];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';

    protected $validationRules = [
        'transaction_id' => 'required|integer',
        'status' => 'required|max_length[50]',
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

    public function getByTransaction(int $transactionId): array
    {
        return $this->where('transaction_id', $transactionId)->findAll();
    }

    public function getRecentLogs(int $limit = 10): array
    {
        return $this->orderBy('created_at', 'DESC')->limit($limit)->findAll();
    }
}