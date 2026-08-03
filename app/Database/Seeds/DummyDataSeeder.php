<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    private $userId = 2;

    public function run()
    {
        $db = $this->db;
        $now = date('Y-m-d H:i:s');

        echo "=== Dummy Data Seeder ===\n\n";

        // Clean tables managed by this seeder (keep users, roles, user_profiles, user_roles)
        $tables = [
            'download_logs', 'downloads', 'notifications', 'ticket_messages', 'tickets',
            'midtrans_transactions', 'payment_logs', 'payments', 'payment_methods',
            'transactions', 'invoice_items', 'invoices', 'order_items', 'orders',
            'cart_items', 'carts', 'customer_addresses', 'login_attempts', 'activity_logs',
            'audit_logs', 'settings', 'service_packages', 'services', 'service_categories',
            'product_files', 'product_images', 'product_prices', 'products', 'product_categories',
            'pages', 'article_tags', 'articles', 'tags', 'categories',
        ];
        foreach ($tables as $t) {
            $db->query('SET FOREIGN_KEY_CHECKS = 0');
            $db->query("DELETE FROM {$t}");
            $db->query('SET FOREIGN_KEY_CHECKS = 1');
        }
        echo "[*] Cleaned " . count($tables) . " tables\n\n";

        // 1. product_categories
        $cat = $db->table('product_categories')->where('slug', 'digital-products')->get()->getRow();
        if (!$cat) {
            $db->table('product_categories')->insert([
                'uuid' => $this->uuid(), 'name' => 'Digital Products',
                'slug' => 'digital-products', 'description' => 'All digital product items',
                'status' => 'active', 'created_at' => $now, 'updated_at' => $now,
            ]);
            $catId = $db->insertID();
            echo "[+] product_categories (id={$catId})\n";
        } else {
            $catId = $cat->id;
            echo "[~] product_categories already exists (id={$catId})\n";
        }

        // 2. products
        $prod = $db->table('products')->where('slug', 'web-app-starter-pack')->get()->getRow();
        if (!$prod) {
            $db->table('products')->insert([
                'uuid' => $this->uuid(), 'category_id' => $catId,
                'name' => 'Web Application Starter Pack',
                'slug' => 'web-app-starter-pack',
                'description' => 'Complete starter pack for web applications with auth, dashboard, and API.',
                'short_description' => 'Starter pack untuk aplikasi web profesional.',
                'thumbnail' => '/images/products/web-starter.jpg',
                'status' => 'active', 'seo_title' => 'Web App Starter Pack',
                'seo_description' => 'Paket starter aplikasi web', 'created_by' => $this->userId,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            $prodId = $db->insertID();
            echo "[+] products (id={$prodId})\n";
        } else {
            $prodId = $prod->id;
            echo "[~] products already exists (id={$prodId})\n";
        }

        // 3. product_prices
        $db->table('product_prices')->insert([
            'uuid' => $this->uuid(), 'product_id' => $prodId,
            'price' => 2500000, 'discount_price' => 2000000,
            'currency' => 'IDR', 'created_at' => $now, 'updated_at' => $now,
        ]);
        echo "[+] product_prices\n";

        // 4. product_images
        $db->table('product_images')->insert([
            'uuid' => $this->uuid(), 'product_id' => $prodId,
            'image_path' => '/images/products/web-starter-1.jpg',
            'image_type' => 'gallery', 'position' => 1, 'created_at' => $now,
        ]);
        echo "[+] product_images\n";

        // 5. product_files
        $db->table('product_files')->insert([
            'uuid' => $this->uuid(), 'product_id' => $prodId,
            'file_name' => 'starter-pack-v1.zip',
            'file_path' => '/downloads/starter-pack-v1.zip',
            'file_size' => 5242880, 'file_type' => 'application/zip',
            'version' => '1.0', 'status' => 'active',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        echo "[+] product_files\n";

        // 6. service_categories
        $db->table('service_categories')->insert([
            'uuid' => $this->uuid(), 'name' => 'Web Development',
            'slug' => 'web-development', 'description' => 'Professional web development services',
            'status' => 'active', 'created_at' => $now, 'updated_at' => $now,
        ]);
        $svcCatId = $db->insertID();
        echo "[+] service_categories (id={$svcCatId})\n";

        // 7. services
        $db->table('services')->insert([
            'uuid' => $this->uuid(), 'category_id' => $svcCatId,
            'name' => 'Custom Web Application',
            'slug' => 'custom-web-application',
            'description' => 'Custom web application development tailored to your business needs.',
            'thumbnail' => '/images/services/web-dev.jpg',
            'price_type' => 'starting', 'price' => 15000000,
            'status' => 'active', 'seo_title' => 'Custom Web App Development',
            'seo_description' => 'Jasa pengembangan web aplikasi custom', 'created_by' => $this->userId,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $svcId = $db->insertID();
        echo "[+] services (id={$svcId})\n";

        // 8. service_packages
        $db->table('service_packages')->insert([
            'uuid' => $this->uuid(), 'service_id' => $svcId,
            'package_name' => 'Basic Package',
            'description' => '3 pages, basic auth, responsive design',
            'price' => 15000000, 'created_at' => $now, 'updated_at' => $now,
        ]);
        echo "[+] service_packages\n";

        // 9. carts
        $db->table('carts')->insert([
            'uuid' => $this->uuid(), 'user_id' => $this->userId,
            'session_id' => 'dummy-session-id-123', 'status' => 'active',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $cartId = $db->insertID();
        echo "[+] carts (id={$cartId})\n";

        // 10. cart_items
        $db->table('cart_items')->insert([
            'uuid' => $this->uuid(), 'cart_id' => $cartId,
            'product_id' => $prodId, 'quantity' => 1,
            'price' => 2000000, 'subtotal' => 2000000,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        echo "[+] cart_items\n";

        // 11. orders
        $db->table('orders')->insert([
            'uuid' => $this->uuid(), 'user_id' => $this->userId,
            'order_number' => 'ORD-2026-0001', 'status' => 'paid',
            'payment_status' => 'paid', 'subtotal' => 2000000,
            'discount' => 0, 'tax' => 220000, 'total' => 2220000,
            'notes' => 'Dummy order for testing',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $orderId = $db->insertID();
        echo "[+] orders (id={$orderId})\n";

        // 12. order_items
        $db->table('order_items')->insert([
            'uuid' => $this->uuid(), 'order_id' => $orderId,
            'product_id' => $prodId, 'name' => 'Web Application Starter Pack',
            'quantity' => 1, 'price' => 2000000, 'subtotal' => 2000000,
            'created_at' => $now,
        ]);
        echo "[+] order_items\n";

        // 13. invoices
        $db->table('invoices')->insert([
            'uuid' => $this->uuid(), 'user_id' => $this->userId,
            'order_id' => $orderId, 'invoice_number' => 'INV-2026-0001',
            'status' => 'paid', 'subtotal' => 2000000,
            'discount' => 0, 'tax' => 220000, 'total' => 2220000,
            'due_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
            'paid_at' => $now, 'created_at' => $now, 'updated_at' => $now,
        ]);
        $invoiceId = $db->insertID();
        echo "[+] invoices (id={$invoiceId})\n";

        // 14. invoice_items
        $db->table('invoice_items')->insert([
            'uuid' => $this->uuid(), 'invoice_id' => $invoiceId,
            'product_id' => $prodId,
            'description' => 'Web Application Starter Pack',
            'quantity' => 1, 'price' => 2000000, 'subtotal' => 2000000,
            'created_at' => $now,
        ]);
        echo "[+] invoice_items\n";

        // 15. transactions
        $db->table('transactions')->insert([
            'uuid' => $this->uuid(), 'invoice_id' => $invoiceId,
            'payment_method' => 'bank_transfer', 'payment_reference' => 'TRX-2026-0001',
            'amount' => 2220000, 'status' => 'success',
            'paid_at' => $now, 'created_at' => $now,
        ]);
        $txId = $db->insertID();
        echo "[+] transactions (id={$txId})\n";

        // 16. payment_methods
        $db->table('payment_methods')->insert([
            'uuid' => $this->uuid(), 'name' => 'Bank Transfer',
            'code' => 'bank_transfer',
            'description' => 'Transfer via bank',
            'status' => 'active', 'created_at' => $now, 'updated_at' => $now,
        ]);
        $pmId = $db->insertID();
        echo "[+] payment_methods (id={$pmId})\n";

        // 17. payments
        $db->table('payments')->insert([
            'uuid' => $this->uuid(), 'invoice_id' => $invoiceId,
            'user_id' => $this->userId, 'payment_method_id' => $pmId,
            'amount' => 2220000, 'status' => 'success',
            'paid_at' => $now, 'created_at' => $now, 'updated_at' => $now,
        ]);
        echo "[+] payments\n";

        // 18. payment_logs
        $db->table('payment_logs')->insert([
            'uuid' => $this->uuid(), 'transaction_id' => $txId,
            'gateway_response' => json_encode(['status' => 'capture', 'order_id' => 'TRX-2026-0001']),
            'status' => 'success', 'created_at' => $now,
        ]);
        echo "[+] payment_logs\n";

        // 19. midtrans_transactions
        $db->table('midtrans_transactions')->insert([
            'uuid' => $this->uuid(), 'invoice_id' => $invoiceId,
            'order_id' => 'ORD-2026-0001', 'midtrans_order_id' => 'MDTR-2026-0001',
            'transaction_id' => 'MDTR-2026-0001', 'transaction_status' => 'capture',
            'payment_type' => 'bank_transfer', 'gross_amount' => 2220000,
            'status' => 'success', 'created_at' => $now, 'updated_at' => $now,
        ]);
        echo "[+] midtrans_transactions\n";

        // 20. tickets
        $db->table('tickets')->insert([
            'uuid' => $this->uuid(), 'user_id' => $this->userId,
            'category_id' => 1, 'ticket_number' => 'TKT-2026-0001',
            'subject' => 'Dummy support ticket for testing',
            'priority' => 'medium', 'status' => 'open',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $ticketId = $db->insertID();
        echo "[+] tickets (id={$ticketId})\n";

        // 21. ticket_messages
        $db->table('ticket_messages')->insert([
            'uuid' => $this->uuid(), 'ticket_id' => $ticketId,
            'user_id' => $this->userId,
            'message' => 'This is a dummy support ticket message for testing purposes.',
            'created_at' => $now,
        ]);
        echo "[+] ticket_messages\n";

        // 22. notifications
        $db->table('notifications')->insert([
            'uuid' => $this->uuid(), 'user_id' => $this->userId,
            'title' => 'Order Confirmed',
            'message' => 'Your order ORD-2026-0001 has been confirmed.',
            'type' => 'system', 'status' => 'unread',
            'created_at' => $now,
        ]);
        echo "[+] notifications\n";

        // 23. downloads
        $db->table('downloads')->insert([
            'uuid' => $this->uuid(), 'user_id' => $this->userId,
            'product_id' => $prodId, 'order_id' => $orderId,
            'download_token' => bin2hex(random_bytes(32)),
            'download_count' => 0, 'max_downloads' => 5,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
            'created_at' => $now,
        ]);
        $dlId = $db->insertID();
        echo "[+] downloads (id={$dlId})\n";

        // 24. download_logs
        $db->table('download_logs')->insert([
            'download_id' => $dlId, 'file_id' => 1,
            'ip_address' => '127.0.0.1', 'user_agent' => 'Mozilla/5.0',
            'downloaded_at' => $now,
        ]);
        echo "[+] download_logs\n";

        // 25. user_profiles
        $existing = $db->table('user_profiles')->where('user_id', $this->userId)->get()->getRow();
        if (!$existing) {
            $db->table('user_profiles')->insert([
                'uuid' => $this->uuid(), 'user_id' => $this->userId,
                'full_name' => 'John Doe', 'phone' => '081234567890',
                'address' => 'Jl. Sudirman No. 123', 'city' => 'Jakarta',
                'province' => 'DKI Jakarta', 'postal_code' => '12190',
                'created_at' => $now, 'updated_at' => $now,
            ]);
            echo "[+] user_profiles\n";
        } else {
            echo "[~] user_profiles already exists, skipped\n";
        }

        // 26. customer_addresses
        $db->table('customer_addresses')->insert([
            'uuid' => $this->uuid(), 'user_id' => $this->userId,
            'name' => 'John Doe', 'phone' => '081234567890',
            'address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
            'city' => 'Jakarta', 'province' => 'DKI Jakarta',
            'is_default' => 1, 'created_at' => $now,
        ]);
        echo "[+] customer_addresses\n";

        // 27. user_roles (customer)
        $existing = $db->table('user_roles')->where('user_id', $this->userId)->get()->getRow();
        if (!$existing) {
            $customerRole = $db->table('roles')->where('slug', 'customer')->get()->getRow();
            if ($customerRole) {
                $db->table('user_roles')->insert([
                    'user_id' => $this->userId, 'role_id' => $customerRole->id,
                    'created_at' => $now,
                ]);
                echo "[+] user_roles (customer)\n";
            }
        } else {
            echo "[~] user_roles already exists, skipped\n";
        }

        // 28. login_attempts
        $db->table('login_attempts')->insert([
            'user_id' => $this->userId, 'email' => 'customer@ngappid.id',
            'ip_address' => '127.0.0.1', 'status' => 'success',
            'created_at' => $now,
        ]);
        echo "[+] login_attempts\n";

        // 29. activity_logs
        $db->table('activity_logs')->insert([
            'uuid' => $this->uuid(), 'user_id' => $this->userId,
            'activity_type' => 'login', 'description' => 'User logged in',
            'ip_address' => '127.0.0.1', 'user_agent' => 'Mozilla/5.0',
            'created_at' => $now,
        ]);
        echo "[+] activity_logs\n";

        // 30. audit_logs
        $db->table('audit_logs')->insert([
            'uuid' => $this->uuid(), 'user_id' => $this->userId,
            'action' => 'create', 'module' => 'orders',
            'description' => 'User created order ORD-2026-0001',
            'ip_address' => '127.0.0.1', 'user_agent' => 'Mozilla/5.0',
            'created_at' => $now,
        ]);
        echo "[+] audit_logs\n";

        // 31. settings
        $db->table('settings')->insert([
            'uuid' => $this->uuid(), 'group' => 'general',
            'key' => 'site_name', 'value' => 'NgAppID',
            'type' => 'string', 'description' => 'Site name',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        echo "[+] settings\n";

        // 32. pages
        $db->table('pages')->insert([
            'uuid' => $this->uuid(), 'title' => 'About NgAppID',
            'slug' => 'about-ngappid',
            'content' => '<p>NgAppID adalah platform digital modern untuk bisnis Anda.</p>',
            'status' => 'published', 'created_at' => $now, 'updated_at' => $now,
        ]);
        echo "[+] pages\n";

        // 33. categories
        $db->table('categories')->insert([
            'uuid' => $this->uuid(), 'name' => 'Blog',
            'slug' => 'blog', 'description' => 'Blog articles category',
            'type' => 'article', 'created_at' => $now, 'updated_at' => $now,
        ]);
        $artCatId = $db->insertID();
        echo "[+] categories (id={$artCatId})\n";

        // 34. tags
        $db->table('tags')->insert([
            'uuid' => $this->uuid(), 'name' => 'Tutorial',
            'slug' => 'tutorial',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        echo "[+] tags\n";

        // 35. articles
        $db->table('articles')->insert([
            'uuid' => $this->uuid(), 'category_id' => $artCatId,
            'author_id' => $this->userId,
            'title' => 'Getting Started with NgAppID',
            'slug' => 'getting-started-ngappid',
            'content' => '<p>Panduan memulai menggunakan platform NgAppID.</p>',
            'excerpt' => 'Panduan singkat memulai NgAppID',
            'status' => 'published',
            'published_at' => $now,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        echo "[+] articles\n";

        echo "\n=== Selesai: 1 dummy per tabel user/customer related ===\n";
    }

    private function uuid(): string
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
