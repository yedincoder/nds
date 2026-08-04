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
        // Simple implementation dengan timestamp dan random number (Windows compatible)
        return date('YmdHis') . substr(md5(uniqid('', true) . mt_rand(100000, 999999)), 0, 8);
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