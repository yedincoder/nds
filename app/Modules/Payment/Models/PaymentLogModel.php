<?php

namespace App\Modules\Payment\Models;

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

    public function getByTransaction(int $transactionId): array
    {
        return $this->where('transaction_id', $transactionId)->findAll();
    }

    public function getRecentLogs(int $limit = 10): array
    {
        return $this->orderBy('created_at', 'DESC')->limit($limit)->findAll();
    }
}