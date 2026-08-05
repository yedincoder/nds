<?php

namespace App\Modules\FrontArea\Models;

use CodeIgniter\Model;

class ServiceCategoryModel extends Model
{
    protected $table = 'service_categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'uuid',
        'name',
        'slug',
        'description',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[150]',
        'slug' => 'required|min_length[2]|max_length[150]|is_unique[service_categories.slug,id,{id}]',
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

    public function getActive(): array
    {
        return $this->where('status', 'active')->findAll();
    }

    public function findBySlug(string $slug): ?object
    {
        return $this->where('slug', $slug)->first();
    }

    public function getTree(): array
    {
        return $this->orderBy('name', 'ASC')->findAll();
    }
}