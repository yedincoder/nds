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