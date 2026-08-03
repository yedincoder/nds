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