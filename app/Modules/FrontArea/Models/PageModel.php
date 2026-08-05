<?php

namespace App\Modules\FrontArea\Models;

use CodeIgniter\Model;

class PageModel extends Model
{
    protected $table = 'pages';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'uuid',
        'title',
        'slug',
        'content',
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
        'id' => 'permit_empty',
        'title' => 'required|min_length[2]|max_length[255]',
        'slug' => 'required|min_length[2]|max_length[255]|is_unique[pages.slug,id,{id}]',
        'status' => 'in_list[draft,published,archived]',
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

    public function findBySlug(string $slug): ?object
    {
        return $this->where('slug', $slug)->first();
    }

    public function getPublished(): array
    {
        return $this->where('status', 'published')->findAll();
    }

    public function search(string $keyword, int $limit = 10): array
    {
        return $this->like('title', $keyword)
            ->orLike('content', $keyword)
            ->where('status', 'published')
            ->limit($limit)
            ->findAll();
    }
}
