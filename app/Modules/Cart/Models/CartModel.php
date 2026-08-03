<?php

namespace App\Modules\Cart\Models;

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