<?php

namespace App\Modules\Product\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
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
        'short_description',
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
        'name' => 'required|min_length[2]|max_length[255]',
        'slug' => 'required|min_length[2]|max_length[255]|is_unique[products.slug,id,{id}]',
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

    public function getByCategory(int $categoryId, int $limit = 0, int $offset = 0): array
    {
        $query = $this->where('category_id', $categoryId)->where('status', 'active');
        if ($limit > 0) {
            $query->limit($limit, $offset);
        }
        return $query->findAll();
    }

    public function search(string $keyword, int $limit = 10): array
    {
        return $this->like('name', $keyword)
            ->orLike('description', $keyword)
            ->where('status', 'active')
            ->limit($limit)
            ->findAll();
    }

    public function getWithPricing(int $id): ?object
    {
        $product = $this->find($id);
        if ($product) {
            $db = \Config\Database::connect();
            $product->pricing = $db->table('product_prices')
                ->where('product_id', $id)
                ->get()
                ->getResult();
            $product->images = $db->table('product_images')
                ->where('product_id', $id)
                ->orderBy('position', 'ASC')
                ->get()
                ->getResult();
            $product->files = $db->table('product_files')
                ->where('product_id', $id)
                ->where('status', 'active')
                ->get()
                ->getResult();
        }
        return $product;
    }
}