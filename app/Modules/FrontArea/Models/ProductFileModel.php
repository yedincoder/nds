<?php

namespace App\Modules\FrontArea\Models;

use CodeIgniter\Model;

class ProductFileModel extends Model
{
    protected $table = 'product_files';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'uuid',
        'product_id',
        'file_name',
        'file_path',
        'file_size',
        'file_type',
        'version',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'product_id' => 'required|integer',
        'file_name' => 'required|max_length[255]',
        'file_path' => 'required|max_length[255]',
        'file_type' => 'required|max_length[100]',
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
        // Simple implementation dengan timestamp dan random number (Windows compatible)
        return date('YmdHis') . substr(md5(uniqid('', true) . mt_rand(100000, 999999)), 0, 8);
    }

    public function getByProduct(int $productId): array
    {
        return $this->where('product_id', $productId)->where('status', 'active')->findAll();
    }

    public function getActiveFiles(int $productId): array
    {
        return $this->where('product_id', $productId)->where('status', 'active')->findAll();
    }
}