<?php

namespace App\Modules\Midtrans\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMidtransTables extends Migration
{
    public function up()
    {
        // midtrans_transactions
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'invoice_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'order_id' => ['type' => 'VARCHAR', 'constraint' => 100],
            'midtrans_order_id' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'transaction_id' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'transaction_status' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'payment_type' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'gross_amount' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'snap_token' => ['type' => 'TEXT', 'null' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['pending','success','failed','expired','cancelled','denied'], 'default' => 'pending'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addKey('order_id');
        $this->forge->addKey('midtrans_order_id');
        $this->forge->addKey('status');
        $this->forge->createTable('midtrans_transactions', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // midtrans_notifications
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'transaction_id' => ['type' => 'VARCHAR', 'constraint' => 100],
            'notification_payload' => ['type' => 'TEXT', 'null' => true],
            'signature_key' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 50],
            'processed' => ['type' => 'TINYINT', 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addKey('transaction_id');
        $this->forge->createTable('midtrans_notifications', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('midtrans_notifications', true);
        $this->forge->dropTable('midtrans_transactions', true);
    }
}