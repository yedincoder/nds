<?php

namespace App\Modules\Customer\Services;

use App\Modules\Customer\Models\CustomerAddressModel;
use App\Modules\Customer\Models\UserProfileModel;
use App\Modules\Authentication\Models\UserModel;

class CustomerService
{
    protected $userModel;
    protected $profileModel;
    protected $addressModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->profileModel = new UserProfileModel();
        $this->addressModel = new CustomerAddressModel();
    }

    public function getProfile(int $userId): array
    {
        try {
            $user = $this->userModel->find($userId);
            if (!$user) {
                return ['success' => false, 'message' => 'User not found.'];
            }

            $profile = $this->profileModel->getByUserId($userId);
            $addresses = $this->addressModel->getByUser($userId);

            return [
                'success' => true,
                'message' => 'Profile retrieved successfully.',
                'data' => [
                    'user' => $user,
                    'profile' => $profile,
                    'addresses' => $addresses
                ]
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error retrieving profile: ' . $e->getMessage()
            ];
        }
    }

    public function updateProfile(int $userId, array $data): array
    {
        try {
            $user = $this->userModel->find($userId);
            if (!$user) {
                return ['success' => false, 'message' => 'User not found.'];
            }

            $db = \Config\Database::connect();
            $db->transBegin();

            try {
                // Update user
                $userData = [];
                if (!empty($data["username"])) {
                    $userData["username"] = $data["username"];
                }
                if (!empty($data["email"])) {
                    $userData["email"] = $data["email"];
                }
                if (!empty($data["password"])) {
                    $userData["password"] = $data["password"];
                }

                if (!empty($userData)) {
                    $this->userModel->update($userId, $userData);
                }

                // Update or create profile
                $profileData = [
                    "full_name" => $data["full_name"] ?? null,
                    "phone" => $data["phone"] ?? null,
                    "address" => $data["address"] ?? null,
                    "city" => $data["city"] ?? null,
                    "province" => $data["province"] ?? null,
                    "company" => $data["company"] ?? null,
                    "avatar" => $data["avatar"] ?? null,
                ];
                $this->profileModel->updateOrCreate($userId, $profileData);

                if ($db->transStatus() === false) {
                    $db->transRollback();
                    return ['success' => false, 'message' => 'Failed to update profile.'];
                }

                $db->transCommit();

                return [
                    'success' => true,
                    'message' => 'Profile updated successfully.',
                    'data' => $this->getProfile($userId)["data"]
                ];
            } catch (\Throwable $e) {
                $db->transRollback();
                throw $e;
            }
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error updating profile: ' . $e->getMessage()
            ];
        }
    }

    public function addAddress(int $userId, array $data): array
    {
        try {
            $user = $this->userModel->find($userId);
            if (!$user) {
                return ['success' => false, 'message' => 'User not found.'];
            }

            $addressData = [
                "uuid" => $this->generateUuidString(),
                "user_id" => $userId,
                "name" => $data["name"],
                "phone" => $data["phone"],
                "address" => $data["address"],
                "city" => $data["city"],
                "province" => $data["province"],
                "is_default" => $data["is_default"] ?? 0,
                "created_at" => date("Y-m-d H:i:s"),
            ];

            if ($data["is_default"]) {
                $this->addressModel->setDefault(0, $userId);
            }

            $addressId = $this->addressModel->insert($addressData);
            if (!$addressId) {
                return ['success' => false, 'message' => 'Failed to add address.'];
            }

            return [
                'success' => true,
                'message' => 'Address added successfully.',
                'data' => $this->addressModel->find($addressId)
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error adding address: ' . $e->getMessage()
            ];
        }
    }

    public function updateAddress(int $addressId, array $data): array
    {
        try {
            $address = $this->addressModel->find($addressId);
            if (!$address) {
                return ['success' => false, 'message' => 'Address not found.'];
            }

            $data["uuid"] = $this->generateUuidString();

            if ($data["is_default"] ?? false) {
                $this->addressModel->setDefault($addressId, $address->user_id);
            }

            $this->addressModel->update($addressId, $data);

            return [
                'success' => true,
                'message' => 'Address updated successfully.',
                'data' => $this->addressModel->find($addressId)
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error updating address: ' . $e->getMessage()
            ];
        }
    }

    public function deleteAddress(int $addressId): array
    {
        try {
            $address = $this->addressModel->find($addressId);
            if (!$address) {
                return ['success' => false, 'message' => 'Address not found.'];
            }

            $this->addressModel->delete($addressId);

            return [
                'success' => true,
                'message' => 'Address deleted successfully.'
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error deleting address: ' . $e->getMessage()
            ];
        }
    }

    public function getDefaultAddress(int $userId): ?object
    {
        return $this->addressModel->getDefault($userId);
    }

    public function getDownloads(int $userId): array
    {
        $db = \Config\Database::connect();
        $downloads = $db->table('downloads d')
            ->select('d.*, p.name as product_name, p.thumbnail, o.order_number')
            ->join('products p', 'p.id = d.product_id', 'left')
            ->join('orders o', 'o.id = d.order_id', 'left')
            ->where('d.user_id', $userId)
            ->orderBy('d.created_at', 'DESC')
            ->get()
            ->getResult();

        return [
            'success' => true,
            'data' => ['downloads' => $downloads],
        ];
    }

    public function getAddresses(int $userId): array
    {
        $addresses = $this->addressModel->getByUser($userId);

        return [
            'success' => true,
            'data' => ['addresses' => $addresses],
        ];
    }

    public function changePassword(int $userId, array $data): array
    {
        try {
            $user = $this->userModel->find($userId);
            if (!$user) {
                return ['success' => false, 'message' => 'User not found.'];
            }

            if (!password_verify($data['current_password'], $user->password_hash)) {
                return ['success' => false, 'message' => 'Current password is incorrect.'];
            }

            $this->userModel->update($userId, [
                'password_hash' => password_hash($data['new_password'], PASSWORD_BCRYPT),
            ]);

            return ['success' => true, 'message' => 'Password changed successfully.'];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => 'Error changing password: ' . $e->getMessage()];
        }
    }

    public function downloadFile(int $userId, string $token): array
    {
        $db = \Config\Database::connect();
        $download = $db->table('downloads')
            ->where('download_token', $token)
            ->where('user_id', $userId)
            ->get()
            ->getRow();

        if (!$download) {
            return ['success' => false, 'message' => 'Download not found.'];
        }

        // Check download limit
        if (($download->download_count ?? 0) >= ($download->max_downloads ?? 0)) {
            return ['success' => false, 'message' => 'Download limit reached.'];
        }

        // Check expiry
        if (!empty($download->expires_at) && strtotime($download->expires_at) < time()) {
            return ['success' => false, 'message' => 'Download has expired.'];
        }

        // Get file from product_files table
        $file = $db->table('product_files')
            ->where('product_id', $download->product_id)
            ->where('status', 'active')
            ->orderBy('id', 'ASC')
            ->limit(1)
            ->get()
            ->getRow();

        if (!$file) {
            return ['success' => false, 'message' => 'File not found for this product.'];
        }

        // File path: check public/downloads or writable/uploads
        $publicPath = FCPATH . ltrim($file->file_path, '/');
        $writablePath = WRITEPATH . 'uploads/' . ltrim($file->file_path, '/');

        if (file_exists($publicPath)) {
            $filePath = $publicPath;
        } elseif (file_exists($writablePath)) {
            $filePath = $writablePath;
        } else {
            return ['success' => false, 'message' => 'File not found on server.'];
        }

        // Increment download count
        $db->table('downloads')
            ->where('id', $download->id)
            ->update(['download_count' => ($download->download_count ?? 0) + 1]);

        return [
            'success' => true,
            'data' => [
                'file' => $file,
                'file_path' => $filePath,
            ],
        ];
    }

    protected function generateUuidString(): string
    {
        // Simple implementation dengan timestamp dan random number (Windows compatible)
        return date('YmdHis') . substr(md5(uniqid('', true) . mt_rand(100000, 999999)), 0, 8);
    }
}