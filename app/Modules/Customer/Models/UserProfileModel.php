<?php

namespace App\Modules\Customer\Models;

use CodeIgniter\Model;

class UserProfileModel extends Model
{
    protected $table = "user_profiles";
    protected $primaryKey = "id";
    protected $useAutoIncrement = true;
    protected $returnType = "object";
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        "uuid",
        "user_id",
        "full_name",
        "phone",
        "address",
        "city",
        "province",
        "company",
        "avatar",
        "created_at",
        "updated_at",
    ];

    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";

    protected $validationRules = [
        "user_id" => "required|integer|is_unique[user_profiles.user_id,id,{id}]",
        "full_name" => "required|min_length[2]|max_length[255]",
        "phone" => "max_length[30]",
    ];

    protected $beforeInsert = ["generateUuid"];
    protected $beforeUpdate = ["generateUuid"];

    protected function generateUuid(array $data): array
    {
        if (empty($data["data"]["uuid"])) {
            $data["data"]["uuid"] = $this->generateUuidString();
        }
        return $data;
    }

    protected function generateUuidString(): string
    {
        // Simple implementation dengan timestamp dan random number (Windows compatible)
        return date('YmdHis') . substr(md5(uniqid('', true) . mt_rand(100000, 999999)), 0, 8);
    }

    public function getByUserId(int $userId): ?object
    {
        return $this->where("user_id", $userId)->first();
    }

    public function updateOrCreate(int $userId, array $data): ?object
    {
        $existing = $this->getByUserId($userId);
        $data["uuid"] = $this->generateUuidString();
        $data["user_id"] = $userId;

        if ($existing) {
            $this->update($existing->id, $data);
            return $this->find($existing->id);
        } else {
            $id = $this->insert($data);
            return $this->find($id);
        }
    }
}