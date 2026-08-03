<?php

require __DIR__ . '/vendor/autoload.php';

use CodeIgniter\Config\Database;

$db = Database::connect();

$hash = password_hash('admin123', PASSWORD_BCRYPT);

$result = $db->table('users')
    ->where('username', 'admin')
    ->update(['password_hash' => $hash]);

if ($result) {
    echo "✅ Password admin berhasil direset!\n";
    echo "Username: admin\n";
    echo "Password: admin123\n";
    echo "\nSekarang coba login di: http://localhost:8080/auth/login\n";
} else {
    echo "❌ Gagal mengupdate password\n";
}