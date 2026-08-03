<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        $this->seedRoles();
        $this->seedPermissions();
        $this->seedPaymentMethods();
        $this->seedSettings();
    }

    private function seedRoles()
    {
        $data = [
            [
                'uuid' => $this->generateUuid(),
                'name' => 'Super Administrator',
                'slug' => 'super-administrator',
                'description' => 'Full system access',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'Administrator',
                'slug' => 'administrator',
                'description' => 'Admin access',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'Customer',
                'slug' => 'customer',
                'description' => 'Regular customer',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'Guest',
                'slug' => 'guest',
                'description' => 'Guest user',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('roles')->insertBatch($data);
    }

    private function seedPermissions()
    {
        $data = [
            ['name' => 'users.read', 'description' => 'View users'],
            ['name' => 'users.create', 'description' => 'Create users'],
            ['name' => 'users.update', 'description' => 'Update users'],
            ['name' => 'users.delete', 'description' => 'Delete users'],
            ['name' => 'products.read', 'description' => 'View products'],
            ['name' => 'products.create', 'description' => 'Create products'],
            ['name' => 'products.update', 'description' => 'Update products'],
            ['name' => 'products.delete', 'description' => 'Delete products'],
            ['name' => 'orders.read', 'description' => 'View orders'],
            ['name' => 'orders.create', 'description' => 'Create orders'],
            ['name' => 'orders.update', 'description' => 'Update orders'],
            ['name' => 'invoices.read', 'description' => 'View invoices'],
            ['name' => 'invoices.create', 'description' => 'Create invoices'],
            ['name' => 'payments.read', 'description' => 'View payments'],
            ['name' => 'reports.read', 'description' => 'View reports'],
            ['name' => 'settings.update', 'description' => 'Update settings'],
        ];

        foreach ($data as &$row) {
            $row['uuid'] = $this->generateUuid();
            $row['created_at'] = date('Y-m-d H:i:s');
        }

        $this->db->table('permissions')->insertBatch($data);
    }

    private function seedPaymentMethods()
    {
        $data = [
            [
                'uuid' => $this->generateUuid(),
                'name' => 'Credit Card',
                'code' => 'credit_card',
                'description' => 'Payment via credit card (Visa, Mastercard)',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'Bank Transfer',
                'code' => 'bank_transfer',
                'description' => 'Direct bank transfer',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'E-Wallet',
                'code' => 'ewallet',
                'description' => 'Payment via digital wallet',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('payment_methods')->insertBatch($data);
    }

    private function seedSettings()
    {
        $data = [
            [
                'uuid' => $this->generateUuid(),
                'group' => 'general',
                'key' => 'app_name',
                'value' => 'NgAppID Digital Platform',
                'type' => 'string',
                'description' => 'Application name',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'group' => 'general',
                'key' => 'app_description',
                'value' => 'Professional Digital Platform',
                'type' => 'string',
                'description' => 'Application description',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'group' => 'general',
                'key' => 'app_url',
                'value' => 'https://example.com',
                'type' => 'string',
                'description' => 'Application URL',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'group' => 'email',
                'key' => 'from_email',
                'value' => 'noreply@example.com',
                'type' => 'string',
                'description' => 'From email address',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('settings')->insertBatch($data);
    }

    private function generateUuid()
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
}
