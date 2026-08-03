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
