<?php

namespace App\Modules\FrontArea\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBillingTables extends Migration
{
    public function up()
    {
        // invoices
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'user_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'order_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'invoice_number' => ['type' => 'VARCHAR', 'constraint' => 50],
            'status' => ['type' => 'ENUM', 'constraint' => ['draft','unpaid','paid','expired','cancelled','refunded'], 'default' => 'draft'],
            'subtotal' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'discount' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'tax' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'total' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'due_date' => ['type' => 'DATETIME', 'null' => true],
            'paid_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addUniqueKey('invoice_number');
        $this->forge->addKey('user_id');
        $this->forge->addKey('order_id');
        $this->forge->addKey('status');
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('invoices', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // invoice_items
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'invoice_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'product_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'service_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'description' => ['type' => 'VARCHAR', 'constraint' => 255],
            'quantity' => ['type' => 'INT', 'unsigned' => true, 'default' => 1],
            'price' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'subtotal' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addKey('invoice_id');
        $this->forge->addForeignKey('invoice_id', 'invoices', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('invoice_items', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // transactions
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'invoice_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'payment_method' => ['type' => 'VARCHAR', 'constraint' => 50],
            'payment_reference' => ['type' => 'VARCHAR', 'constraint' => 100],
            'amount' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'status' => ['type' => 'ENUM', 'constraint' => ['pending','success','failed','cancelled','refunded'], 'default' => 'pending'],
            'paid_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addKey('invoice_id');
        $this->forge->addKey('status');
        $this->forge->addForeignKey('invoice_id', 'invoices', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('transactions', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // payment_logs
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'transaction_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'gateway_response' => ['type' => 'TEXT', 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 50],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addKey('transaction_id');
        $this->forge->createTable('payment_logs', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('payment_logs', true);
        $this->forge->dropTable('transactions', true);
        $this->forge->dropTable('invoice_items', true);
        $this->forge->dropTable('invoices', true);
    }
}