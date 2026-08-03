<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTestimonialsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'user_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'customer_name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'customer_email' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'company' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'position' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'message' => ['type' => 'TEXT'],
            'rating' => ['type' => 'TINYINT', 'unsigned' => true, 'default' => 5],
            'avatar' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected'], 'default' => 'pending'],
            'featured' => ['type' => 'TINYINT', 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addKey('user_id');
        $this->forge->addKey('status');
        $this->forge->addKey('rating');
        $this->forge->createTable('testimonials', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('testimonials', true);
    }
}
