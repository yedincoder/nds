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