<?php

namespace App\Modules\FrontArea\Models;

use CodeIgniter\Model;

class ProductImageModel extends Model
{
    protected $table = 'product_images';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'uuid',
        'product_id',
        'image_path',
        'image_type',
        'position',
        'created_at',
    ];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';

    protected $validationRules = [
        'product_id' => 'required|integer',
        'image_path' => 'required|max_length[255]',
        'image_type' => 'max_length[30]',
    ];

    protected $beforeInsert = ['generateUuid'];

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
        return $this->where('product_id', $productId)->orderBy('position', 'ASC')->findAll();
    }

    public function getGalleryImages(int $productId): array
    {
        return $this->where('product_id', $productId)
            ->where('image_type', 'gallery')
            ->orderBy('position', 'ASC')
            ->findAll();
    }
}