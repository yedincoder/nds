<?php

namespace App\Modules\FrontArea\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 'carts';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'uuid',
        'user_id',
        'session_id',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'status' => 'in_list[active,converted,abandoned,expired]',
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
        // Simple implementation dengan timestamp dan random number
        return date('YmdHis') . substr(md5(uniqid('', true) . mt_rand(100000, 999999)), 0, 8);
    }

    public function getByUser(int $userId): ?object
    {
        return $this->where('user_id', $userId)->where('status', 'active')->first();
    }

    public function getBySession(string $sessionId): ?object
    {
        return $this->where('session_id', $sessionId)->where('status', 'active')->first();
    }

    public function getActiveCart(?int $userId = null, ?string $sessionId = null): ?object
    {
        if ($userId) {
            return $this->where('user_id', $userId)->where('status', 'active')->first();
        } elseif ($sessionId) {
            return $this->where('session_id', $sessionId)->where('status', 'active')->first();
        }
        return null;
    }
}
