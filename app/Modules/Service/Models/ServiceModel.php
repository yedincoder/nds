<?php

namespace App\Modules\Service\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'uuid',
        'category_id',
        'name',
        'slug',
        'description',
        'thumbnail',
        'price_type',
        'price',
        'status',
        'seo_title',
        'seo_description',
        'created_by',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[255]',
        'slug' => 'required|min_length[2]|max_length[255]|is_unique[services.slug,id,{id}]',
        'status' => 'in_list[draft,active,inactive,archived]',
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

    public function search(string $keyword, int $limit = 10): array
    {
        return $this->like('name', $keyword)
            ->orLike('description', $keyword)
            ->where('status', 'active')
            ->limit($limit)
            ->findAll();
    }

    public function getWithCategory(int $id): ?object
    {
        $service = $this->find($id);
        if ($service) {
            $db = \Config\Database::connect();
            $service->category = $db->table('service_categories')
                ->where('id', $service->category_id)
                ->get()
                ->getRow();
            $service->packages = $db->table('service_packages')
                ->where('service_id', $id)
                ->get()
                ->getResult();
        }
        return $service;
    }
}