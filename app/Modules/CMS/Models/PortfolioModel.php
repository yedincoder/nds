<?php

namespace App\Modules\CMS\Models;

use CodeIgniter\Model;

class PortfolioModel extends Model
{
    protected $table = 'portfolios';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'uuid',
        'client_id',
        'category_id',
        'title',
        'slug',
        'description',
        'content',
        'thumbnail',
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
        'title' => 'required|min_length[2]|max_length[255]',
        'slug' => 'required|min_length[2]|max_length[255]|is_unique[portfolios.slug,id,{id}]',
        'status' => 'in_list[draft,published,featured,archived]',
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

    public function getPublished(int $limit = 0, int $offset = 0): array
    {
        $query = $this->where('status', 'published')
            ->orWhere('status', 'featured');

        if ($limit > 0) {
            $query->limit($limit, $offset);
        }

        return $query->orderBy('created_at', 'DESC')->findAll();
    }

    public function getByCategory(int $categoryId, int $limit = 0, int $offset = 0): array
    {
        $query = $this->where('category_id', $categoryId)
            ->where('status', 'published')
            ->orWhere('status', 'featured');

        if ($limit > 0) {
            $query->limit($limit, $offset);
        }

        return $query->orderBy('created_at', 'DESC')->findAll();
    }

    public function getFeatured(int $limit = 6): array
    {
        return $this->where('status', 'featured')
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}
