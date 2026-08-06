<?php

namespace App\Modules\AdminArea\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductLicensesTables extends Migration
{
    public function up()
    {
        // product_licenses (License / API / Token management)
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'product_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'license_key' => ['type' => 'VARCHAR', 'constraint' => 100],
            'license_type' => ['type' => 'ENUM', 'constraint' => ['license','api_key','access_token'], 'default' => 'license'],
            'api_key' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'secret_key' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'domain_limit' => ['type' => 'INT', 'unsigned' => true, 'default' => 1],
            'max_devices' => ['type' => 'INT', 'unsigned' => true, 'default' => 1],
            'expires_at' => ['type' => 'DATETIME', 'null' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['active','inactive','expired','revoked'], 'default' => 'active'],
            'created_by' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addUniqueKey('license_key');
        $this->forge->addKey('product_id');
        $this->forge->addKey('status');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('product_licenses', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('product_licenses', true);
    }
}
