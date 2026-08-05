<?php

namespace App\Modules\FrontArea\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCMSTables extends Migration
{
    public function up()
    {
        // pages
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'title' => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 255],
            'content' => ['type' => 'LONGTEXT', 'null' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['draft','published','archived'], 'default' => 'draft'],
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
        $this->forge->createTable('pages', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // categories (shared for articles/blog)
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'type' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'article'],
            'parent_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 150],
            'description' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addKey(['type', 'slug']);
        $this->forge->createTable('categories', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // articles
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'category_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'author_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 255],
            'content' => ['type' => 'LONGTEXT', 'null' => true],
            'excerpt' => ['type' => 'TEXT', 'null' => true],
            'thumbnail' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['draft','review','published','archived'], 'default' => 'draft'],
            'seo_title' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'seo_description' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'published_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey('category_id');
        $this->forge->addKey('author_id');
        $this->forge->addKey('status');
        $this->forge->addKey('published_at');
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('author_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('articles', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // tags
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('tags', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // article_tags
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'article_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'tag_id' => ['type' => 'BIGINT', 'unsigned' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('article_id');
        $this->forge->addKey('tag_id');
        $this->forge->addUniqueKey(['article_id', 'tag_id'], 'article_tag_unique');
        $this->forge->addForeignKey('article_id', 'articles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tag_id', 'tags', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('article_tags', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // media
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'file_name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'file_path' => ['type' => 'VARCHAR', 'constraint' => 255],
            'file_type' => ['type' => 'VARCHAR', 'constraint' => 100],
            'file_size' => ['type' => 'BIGINT', 'unsigned' => true, 'default' => 0],
            'mime_type' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'uploaded_by' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addKey('uploaded_by');
        $this->forge->addKey('file_type');
        $this->forge->addForeignKey('uploaded_by', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('media', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // menus
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'location' => ['type' => 'VARCHAR', 'constraint' => 50],
            'status' => ['type' => 'ENUM', 'constraint' => ['active','inactive'], 'default' => 'active'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->createTable('menus', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // menu_items
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid' => ['type' => 'CHAR', 'constraint' => 36],
            'menu_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'parent_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'label' => ['type' => 'VARCHAR', 'constraint' => 150],
            'url' => ['type' => 'VARCHAR', 'constraint' => 255],
            'target' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => '_self'],
            'sort_order' => ['type' => 'INT', 'default' => 0],
            'status' => ['type' => 'ENUM', 'constraint' => ['active','inactive'], 'default' => 'active'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addKey('menu_id');
        $this->forge->addForeignKey('menu_id', 'menus', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('menu_items', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('menu_items', true);
        $this->forge->dropTable('menus', true);
        $this->forge->dropTable('media', true);
        $this->forge->dropTable('article_tags', true);
        $this->forge->dropTable('tags', true);
        $this->forge->dropTable('articles', true);
        $this->forge->dropTable('categories', true);
        $this->forge->dropTable('pages', true);
    }
}