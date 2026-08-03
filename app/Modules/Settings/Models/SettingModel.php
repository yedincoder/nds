<?php

namespace App\Modules\Settings\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = "settings";
    protected $primaryKey = "id";
    protected $useAutoIncrement = true;
    protected $returnType = "object";
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        "uuid",
        "group",
        "key",
        "value",
        "type",
        "description",
        "created_at",
        "updated_at",
    ];

    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";

    protected $validationRules = [
        "group" => "required|max_length[50]",
        "key" => "required|max_length[100]",
        "value" => "max_length[65535]",
        "type" => "max_length[20]",
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

    public function getByKey(string $group, string $key): ?object
    {
        return $this->where("group", $group)->where("key", $key)->first();
    }

    public function getAllGrouped(): array
    {
        $settings = $this->findAll();
        $grouped = [];
        foreach ($settings as $setting) {
            $grouped[$setting->group][$setting->key] = $this->castValue($setting->value, $setting->type);
        }
        return $grouped;
    }

    public function getByGroup(string $group): array
    {
        $result = [];
        $settings = $this->where("group", $group)->findAll();
        foreach ($settings as $setting) {
            $result[$setting->key] = $this->castValue($setting->value, $setting->type);
        }
        return $result;
    }

    protected function castValue($value, string $type)
    {
        switch ($type) {
            case "boolean":
                return (bool)$value;
            case "integer":
                return (int)$value;
            case "decimal":
            case "float":
                return (float)$value;
            case "array":
            case "json":
                return json_decode($value, true);
            default:
                return $value;
        }
    }
}