<?php

namespace App\Modules\CMS\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'uuid',
        'type',
        'parent_id',
        'name',
        'slug',
        'description',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'type' => 'required|max_length[30]',
        'name' => 'required|min_length[2]|max_length[150]',
        'slug' => 'required|min_length[2]|max_length[150]',
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

    public function getByType(string $type): array
    {
        return $this->where('type', $type)->orderBy('name', 'ASC')->findAll();
    }

    public function findBySlugAndType(string $slug, string $type): ?object
    {
        return $this->where('slug', $slug)
            ->where('type', $type)
            ->first();
    }

    public function getTree(string $type): array
    {
        return $this->where('type', $type)->orderBy('name', 'ASC')->findAll();
    }
}
