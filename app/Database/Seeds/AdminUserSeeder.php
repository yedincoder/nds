<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        $uuid = $this->generateUuid();
        
        $userData = [
            'uuid' => $uuid,
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password_hash' => password_hash('admin123', PASSWORD_BCRYPT),
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('users')->insert($userData);
        $userId = $this->db->insertID();

        // Get administrator role
        $adminRole = $this->db->table('roles')
            ->where('slug', 'administrator')
            ->get()
            ->getRow();

        if ($adminRole) {
            $this->db->table('user_roles')->insert([
                'user_id' => $userId,
                'role_id' => $adminRole->id,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // Get super-administrator role
        $superRole = $this->db->table('roles')
            ->where('slug', 'super-administrator')
            ->get()
            ->getRow();

        if ($superRole) {
            $this->db->table('user_roles')->insert([
                'user_id' => $userId,
                'role_id' => $superRole->id,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // Create user profile
        $this->db->table('user_profiles')->insert([
            'uuid' => $this->generateUuid(),
            'user_id' => $userId,
            'full_name' => 'System Administrator',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        echo "Admin user created successfully!\n";
        echo "Email: admin@example.com\n";
        echo "Password: admin123\n";
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
