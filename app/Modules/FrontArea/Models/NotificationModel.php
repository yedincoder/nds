<?php

namespace App\Modules\FrontArea\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'uuid',
        'user_id',
        'title',
        'message',
        'type',
        'status',
        'created_at',
    ];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';

    protected $validationRules = [
        'user_id' => 'required|integer',
        'title' => 'required|max_length[255]',
        'message' => 'required',
        'type' => 'max_length[50]',
        'status' => 'in_list[unread,read]',
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

    public function getByUser(int $userId, int $limit = 10, int $offset = 0): array
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit($limit, $offset)
            ->findAll();
    }

    public function getUnread(int $userId): array
    {
        return $this->where('user_id', $userId)
            ->where('status', 'unread')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function countUnread(int $userId): int
    {
        return $this->where('user_id', $userId)
            ->where('status', 'unread')
            ->countAllResults();
    }
}