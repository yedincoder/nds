<?php

namespace App\Modules\Customer\Models;

use CodeIgniter\Model;

class CustomerAddressModel extends Model
{
    protected $table = "customer_addresses";
    protected $primaryKey = "id";
    protected $useAutoIncrement = true;
    protected $returnType = "object";
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        "uuid",
        "user_id",
        "name",
        "phone",
        "address",
        "city",
        "province",
        "is_default",
        "created_at",
    ];

    protected $useTimestamps = false;
    protected $createdField = "created_at";

    protected $validationRules = [
        "user_id" => "required|integer",
        "name" => "required|min_length[2]|max_length[150]",
        "phone" => "required|max_length[30]",
        "address" => "required",
        "city" => "required|max_length[100]",
        "province" => "required|max_length[100]",
        "is_default" => "in_list[0,1]",
    ];

    protected $beforeInsert = ["generateUuid"];

    protected function generateUuid(array $data): array
    {
        if (empty($data["data"]["uuid"])) {
            $data["data"]["uuid"] = $this->generateUuidString();
        }
        return $data;
    }

    protected function generateUuidString(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return sprintf("%02x%02x%02x%02x-%02x%02x-%02x%02x-%02x%02x-%02x%02x%02x%02x%02x%02x",
            $data[0], $data[1], $data[2], $data[3],
            $data[4], $data[5], $data[6], $data[7],
            $data[8], $data[9], $data[10], $data[11],
            $data[12], $data[13], $data[14], $data[15]
        );
    }

    public function getByUser(int $userId): array
    {
        return $this->where("user_id", $userId)->findAll();
    }

    public function getDefault(int $userId): ?object
    {
        return $this->where("user_id", $userId)->where("is_default", 1)->first();
    }

    public function setDefault(int $addressId, int $userId): void
    {
        // Reset all user addresses to non-default
        $this->where("user_id", $userId)->update(["is_default" => 0]);
        // Set chosen address as default
        $this->where("id", $addressId)->where("user_id", $userId)->update(["is_default" => 1]);
    }
}