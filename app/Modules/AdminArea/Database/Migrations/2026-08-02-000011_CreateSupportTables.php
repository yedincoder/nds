<?php

namespace App\Modules\AdminArea\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSupportTables extends Migration
{
    public function up()
    {
        // ticket_categories
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'description' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['active','inactive'], 'default' => 'active'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->createTable('ticket_categories', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // tickets
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'user_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'category_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'assigned_to' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'ticket_number' => ['type' => 'VARCHAR', 'constraint' => 50],
            'subject' => ['type' => 'VARCHAR', 'constraint' => 255],
            'priority' => ['type' => 'ENUM', 'constraint' => ['low','medium','high','critical'], 'default' => 'medium'],
            'status' => ['type' => 'ENUM', 'constraint' => ['open','waiting_response','in_progress','resolved','closed'], 'default' => 'open'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addUniqueKey('ticket_number');
        $this->forge->addKey('user_id');
        $this->forge->addKey('status');
        $this->forge->addKey('priority');
        $this->forge->createTable('tickets', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // ticket_messages
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'ticket_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'user_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'message' => ['type' => 'TEXT'],
            'attachment' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addKey('ticket_id');
        $this->forge->addForeignKey('ticket_id', 'tickets', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ticket_messages', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // ticket_histories
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'ticket_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'old_status' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'new_status' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'description' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_by' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('ticket_id');
        $this->forge->createTable('ticket_histories', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // notifications
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'user_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 255],
            'message' => ['type' => 'TEXT'],
            'type' => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'system'],
            'status' => ['type' => 'ENUM', 'constraint' => ['unread','read'], 'default' => 'unread'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addKey('user_id');
        $this->forge->addKey('status');
        $this->forge->createTable('notifications', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // downloads
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'user_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'product_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'order_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'download_token' => ['type' => 'VARCHAR', 'constraint' => 64],
            'download_count' => ['type' => 'INT', 'unsigned' => true, 'default' => 0],
            'max_downloads' => ['type' => 'INT', 'unsigned' => true, 'default' => 5],
            'expires_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addUniqueKey('download_token');
        $this->forge->addKey('user_id');
        $this->forge->createTable('downloads', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // download_logs
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'download_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'file_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'user_agent' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'downloaded_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('download_id');
        $this->forge->createTable('download_logs', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // activity_logs
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'user_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'activity_type' => ['type' => 'VARCHAR', 'constraint' => 50],
            'description' => ['type' => 'TEXT', 'null' => true],
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'user_agent' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addKey('user_id');
        $this->forge->addKey('activity_type');
        $this->forge->addKey('created_at');
        $this->forge->createTable('activity_logs', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // portfolio
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'client_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'category_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 255],
            'description' => ['type' => 'TEXT', 'null' => true],
            'content' => ['type' => 'LONGTEXT', 'null' => true],
            'thumbnail' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['draft','published','featured','archived'], 'default' => 'draft'],
            'seo_title' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'seo_description' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_by' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey('status');
        $this->forge->createTable('portfolios', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // clients
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'logo' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'description' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->createTable('clients', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('clients', true);
        $this->forge->dropTable('portfolios', true);
        $this->forge->dropTable('activity_logs', true);
        $this->forge->dropTable('download_logs', true);
        $this->forge->dropTable('downloads', true);
        $this->forge->dropTable('notifications', true);
        $this->forge->dropTable('ticket_histories', true);
        $this->forge->dropTable('ticket_messages', true);
        $this->forge->dropTable('tickets', true);
        $this->forge->dropTable('ticket_categories', true);
    }
}