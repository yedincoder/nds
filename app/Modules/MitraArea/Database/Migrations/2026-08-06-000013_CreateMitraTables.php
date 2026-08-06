<?php

namespace App\Modules\MitraArea\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMitraTables extends Migration
{
    public function up()
    {
        // mitra (partner profiles linked to users)
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'user_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'mitra_code' => ['type' => 'VARCHAR', 'constraint' => 30],
            'status' => ['type' => 'ENUM', 'constraint' => ['pending','active','suspended','inactive'], 'default' => 'pending'],
            'commission_rate' => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0.00],
            'referral_code' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addUniqueKey('mitra_code');
        $this->forge->addUniqueKey('referral_code');
        $this->forge->addKey('user_id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('mitra', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // mitra_orders (orders linked to a mitra/referral)
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'mitra_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'order_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'commission' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'status' => ['type' => 'ENUM', 'constraint' => ['pending','paid','cancelled'], 'default' => 'pending'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addKey('mitra_id');
        $this->forge->addKey('order_id');
        $this->forge->addForeignKey('mitra_id', 'mitra', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('mitra_orders', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // mitra_wallets (saldo balance)
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'mitra_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'balance' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'pending_balance' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'total_earned' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'total_withdrawn' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addKey('mitra_id');
        $this->forge->addForeignKey('mitra_id', 'mitra', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('mitra_wallets', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // mitra_withdrawals (penarikan saldo)
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'mitra_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'amount' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'bank_name' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'account_number' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'account_name' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['pending','approved','rejected','completed'], 'default' => 'pending'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addKey('mitra_id');
        $this->forge->addForeignKey('mitra_id', 'mitra', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('mitra_withdrawals', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('mitra_withdrawals', true);
        $this->forge->dropTable('mitra_wallets', true);
        $this->forge->dropTable('mitra_orders', true);
        $this->forge->dropTable('mitra', true);
    }
}
