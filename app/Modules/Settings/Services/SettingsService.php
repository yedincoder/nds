<?php

namespace App\Modules\Settings\Services;

use App\Modules\Settings\Models\SettingModel;

class SettingsService
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    public function get(string $group, string $key): ?object
    {
        return $this->settingModel->getByKey($group, $key);
    }

    public function set(string $group, string $key, $value, string $type = "string"): array
    {
        try {
            $data = [
                "group" => $group,
                "key" => $key,
                "value" => $value,
                "type" => $type,
            ];

            $setting = $this->settingModel->getByKey($group, $key);
            if ($setting) {
                $data["uuid"] = $this->generateUuidString();
                $this->settingModel->update($setting->id, $data);
                $message = "Setting updated successfully.";
            } else {
                $data["uuid"] = $this->generateUuidString();
                $this->settingModel->insert($data);
                $message = "Setting created successfully.";
            }

            return [
                "success" => true,
                "message" => $message,
                "data" => $this->settingModel->getByKey($group, $key)
            ];
        } catch (\Throwable $e) {
            return [
                "success" => false,
                "message" => "Error setting value: " . $e->getMessage()
            ];
        }
    }

    public function update(int $id, array $data): array
    {
        try {
            $setting = $this->settingModel->find($id);
            if (!$setting) {
                return ["success" => false, "message" => "Setting not found."];
            }

            $data["uuid"] = $this->generateUuidString();
            $this->settingModel->update($id, $data);

            return [
                "success" => true,
                "message" => "Setting updated successfully.",
                "data" => $this->settingModel->find($id)
            ];
        } catch (\Throwable $e) {
            return [
                "success" => false,
                "message" => "Error updating setting: " . $e->getMessage()
            ];
        }
    }

    public function delete(int $id): array
    {
        try {
            $setting = $this->settingModel->find($id);
            if (!$setting) {
                return ["success" => false, "message" => "Setting not found."];
            }

            $this->settingModel->delete($id);

            return ["success" => true, "message" => "Setting deleted successfully."];
        } catch (\Throwable $e) {
            return [
                "success" => false,
                "message" => "Error deleting setting: " . $e->getMessage()
            ];
        }
    }

    public function getByGroup(string $group): array
    {
        try {
            $settings = $this->settingModel->getByGroup($group);
            return [
                "success" => true,
                "message" => "Settings retrieved successfully.",
                "data" => $settings
            ];
        } catch (\Throwable $e) {
            return [
                "success" => false,
                "message" => "Error retrieving settings: " . $e->getMessage()
            ];
        }
    }

    public function getAllGrouped(): array
    {
        try {
            $settings = $this->settingModel->getAllGrouped();
            return [
                "success" => true,
                "message" => "All settings retrieved successfully.",
                "data" => $settings
            ];
        } catch (\Throwable $e) {
            return [
                "success" => false,
                "message" => "Error retrieving settings: " . $e->getMessage()
            ];
        }
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
}