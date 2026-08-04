<?php

namespace App\Modules\Service\Models;

use CodeIgniter\Model;

class ServicePackageModel extends Model
{
    protected $table = 'service_packages';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'uuid',
        'service_id',
        'package_name',
        'description',
        'price',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'service_id' => 'required|integer',
        'package_name' => 'required|min_length[2]|max_length[150]',
        'price' => 'required|decimal',
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

    public function getByService(int $serviceId): array
    {
        return $this->where('service_id', $serviceId)->findAll();
    }
}