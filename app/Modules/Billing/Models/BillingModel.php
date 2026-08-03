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