<?php

namespace App\Modules\FrontArea\Models;

use CodeIgniter\Model;

class PaymentMethodModel extends Model
{
    protected $table = 'payment_methods';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'uuid',
        'name',
        'code',
        'description',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]',
        'code' => 'required|min_length[2]|max_length[50]|is_unique[payment_methods.code,id,{id}]',
        'status' => 'in_list[active,inactive]',
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

    public function getActive(): array
    {
        return $this->where('status', 'active')->findAll();
    }

    public function findByCode(string $code): ?object
    {
        return $this->where('code', $code)->first();
    }
}