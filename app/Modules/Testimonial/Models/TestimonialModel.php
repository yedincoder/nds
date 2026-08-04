<?php

namespace App\Modules\Testimonial\Models;

use CodeIgniter\Model;

class TestimonialModel extends Model
{
    protected $table = 'testimonials';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'uuid',
        'user_id',
        'customer_name',
        'customer_email',
        'company',
        'position',
        'title',
        'message',
        'rating',
        'avatar',
        'status',
        'featured',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'customer_name' => 'required|min_length[2]|max_length[150]',
        'message' => 'required|min_length[10]',
        'rating' => 'permit_empty|in_list[1,2,3,4,5]',
        'status' => 'permit_empty|in_list[pending,approved,rejected]',
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

    public function getApproved(int $limit = 10): array
    {
        return $this->where('status', 'approved')
            ->orderBy('featured', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function getFeatured(int $limit = 5): array
    {
        return $this->where('status', 'approved')
            ->where('featured', 1)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function countByStatus(string $status): int
    {
        return $this->where('status', $status)->countAllResults();
    }
}
