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
            'pages', 'article_tags', 'articles', 'tags', 'categories', 'testimonials', 'portfolios',
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

        // 2. products (3 dummies)
        $productList = [
            ['name' => 'Web Application Starter Pack', 'slug' => 'web-app-starter-pack', 'price' => 2500000, 'discount' => 2000000, 'short' => 'Starter pack untuk aplikasi web profesional.', 'desc' => 'Complete starter pack for web applications with auth, dashboard, and API.', 'img' => '/images/products/web-starter.jpg'],
            ['name' => 'Mobile App Framework', 'slug' => 'mobile-app-framework', 'price' => 3500000, 'discount' => 3000000, 'short' => 'Framework hybrid untuk aplikasi Android dan iOS.', 'desc' => 'Hybrid mobile app framework with single codebase for Android and iOS, including push notifications and offline support.', 'img' => '/images/products/mobile-framework.jpg'],
            ['name' => 'E-Commerce Suite', 'slug' => 'ecommerce-suite', 'price' => 5000000, 'discount' => 4500000, 'short' => 'Paket lengkap untuk membangun toko online.', 'desc' => 'Complete e-commerce package with product management, cart, checkout, payment gateway integration, and admin dashboard.', 'img' => '/images/products/ecommerce-suite.jpg'],
        ];

        $productIds = [];
        foreach ($productList as $i => $p) {
            $db->table('products')->insert([
                'uuid' => $this->uuid(), 'category_id' => $catId,
                'name' => $p['name'], 'slug' => $p['slug'],
                'description' => $p['desc'],
                'short_description' => $p['short'],
                'thumbnail' => $p['img'],
                'status' => 'active', 'seo_title' => $p['name'],
                'seo_description' => $p['short'], 'created_by' => $this->userId,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            $pid = $db->insertID();
            $productIds[] = $pid;

            // product_prices
            $db->table('product_prices')->insert([
                'uuid' => $this->uuid(), 'product_id' => $pid,
                'price' => $p['price'], 'discount_price' => $p['discount'],
                'currency' => 'IDR', 'created_at' => $now, 'updated_at' => $now,
            ]);

            // product_images
            $db->table('product_images')->insert([
                'uuid' => $this->uuid(), 'product_id' => $pid,
                'image_path' => str_replace('.jpg', '-1.jpg', $p['img']),
                'image_type' => 'gallery', 'position' => 1, 'created_at' => $now,
            ]);

            // product_files
            $db->table('product_files')->insert([
                'uuid' => $this->uuid(), 'product_id' => $pid,
                'file_name' => str_replace('-', '-', $p['slug']) . '-v1.zip',
                'file_path' => '/downloads/' . $p['slug'] . '-v1.zip',
                'file_size' => 5242880 + ($i * 1048576), 'file_type' => 'application/zip',
                'version' => '1.0', 'status' => 'active',
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }
        $prodId = $productIds[0];
        echo "[+] products (3 dummies)\n";
        echo "[+] product_prices / product_images / product_files (3x)\n";

        // 6. service_categories
        $db->table('service_categories')->insert([
            'uuid' => $this->uuid(), 'name' => 'Web Development',
            'slug' => 'web-development', 'description' => 'Professional web development services',
            'status' => 'active', 'created_at' => $now, 'updated_at' => $now,
        ]);
        $svcCatId = $db->insertID();
        echo "[+] service_categories (id={$svcCatId})\n";

        // 7. services (3 dummies)
        $serviceList = [
            ['name' => 'Custom Web Application', 'slug' => 'custom-web-application', 'desc' => 'Custom web application development tailored to your business needs.', 'price' => 15000000, 'img' => '/images/services/web-dev.jpg'],
            ['name' => 'Mobile App Development', 'slug' => 'mobile-app-development', 'desc' => 'Professional mobile app development for Android and iOS platforms.', 'price' => 25000000, 'img' => '/images/services/mobile-dev.jpg'],
            ['name' => 'Cloud & DevOps Setup', 'slug' => 'cloud-devops-setup', 'desc' => 'Complete cloud infrastructure setup, CI/CD pipeline, and deployment automation.', 'price' => 10000000, 'img' => '/images/services/cloud-devops.jpg'],
        ];

        $svcIds = [];
        foreach ($serviceList as $p) {
            $db->table('services')->insert([
                'uuid' => $this->uuid(), 'category_id' => $svcCatId,
                'name' => $p['name'], 'slug' => $p['slug'],
                'description' => $p['desc'],
                'thumbnail' => $p['img'],
                'price_type' => 'starting', 'price' => $p['price'],
                'status' => 'active', 'seo_title' => $p['name'],
                'seo_description' => $p['desc'], 'created_by' => $this->userId,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            $sid = $db->insertID();
            $svcIds[] = $sid;

            // service_packages
            $db->table('service_packages')->insert([
                'uuid' => $this->uuid(), 'service_id' => $sid,
                'package_name' => 'Basic Package',
                'description' => 'Starter package with core features',
                'price' => $p['price'], 'created_at' => $now, 'updated_at' => $now,
            ]);
        }
        $svcId = $svcIds[0];
        echo "[+] services (3 dummies)\n";
        echo "[+] service_packages (3x)\n";

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

        // 32. pages (5 dummies)
        $pagesData = [
            ['title' => 'Tentang Kami', 'slug' => 'tentang-kami', 'content' => '<h2>Tentang NgAppID</h2><p>NgAppID adalah platform digital modern yang menyediakan layanan pengembangan perangkat lunak, penjualan produk digital, sistem billing pelanggan, serta layanan support terintegrasi.</p><p>Visi kami adalah menjadi platform digital terdepan di Indonesia dengan teknologi terkini dan arsitektur yang bersih.</p>'],
            ['title' => 'Team', 'slug' => 'team', 'content' => '<h2>Tim Kami</h2><p>Tim NgAppID terdiri dari para ahli di bidang pengembangan perangkat lunak, desain UI/UX, arsitektur sistem, dan jaminan kualitas.</p><ul><li>Project Manager</li><li>Full Stack Developer</li><li>UI/UX Designer</li><li>Quality Assurance</li></ul>'],
            ['title' => 'Cara Pesan', 'slug' => 'cara-pesan', 'content' => '<h2>Cara Memesan</h2><p>Berikut langkah-langkah cara memesan produk atau layanan kami:</p><ol><li>Pilih produk atau layanan yang diinginkan</li><li>Tambahkan ke keranjang belanja</li><li>Lakukan checkout dan isi data Anda</li><li>Pilih metode pembayaran</li><li>Selesaikan pembayaran</li><li>Download produk atau mulai pengerjaan</li></ol>'],
            ['title' => 'Pembayaran (Terms of Payment)', 'slug' => 'pembayaran', 'content' => '<h2>Ketentuan Pembayaran</h2><p>Kami menerima berbagai metode pembayaran untuk kenyamanan Anda:</p><ul><li>Transfer Bank (BCA, Mandiri, BNI, BRI)</li><li>E-Wallet (GoPay, OVO, DANA, ShopeePay)</li><li>Virtual Account</li><li>QRIS</li></ul><p>Pembayaran dilakukan melalui gateway Midtrans yang aman dan terpercaya.</p>'],
            ['title' => 'Kebijakan & Ketentuan', 'slug' => 'kebijakan-ketentuan', 'content' => '<h2>Kebijakan & Ketentuan</h2><p>Dengan menggunakan layanan NgAppID, Anda setuju dengan kebijakan dan ketentuan berikut:</p><ul><li>Produk digital bersifat non-refundable setelah diunduh</li><li>Layanan pengembangan mengikuti kontrak yang disepakati</li><li>Data pelanggan dijaga kerahasiaannya</li><li>Dukungan teknis tersedia 24/7</li></ul>'],
        ];
        foreach ($pagesData as $pg) {
            $db->table('pages')->insert(array_merge($pg, [
                'uuid' => $this->uuid(),
                'status' => 'published',
                'created_at' => $now, 'updated_at' => $now,
            ]));
        }
        echo "[+] pages (5 dummies)\n";

        // 33. categories (Blog + Tutorial)
        $catDefs = [
            ['name' => 'Blog', 'slug' => 'blog', 'desc' => 'Artikel dan berita terkait NgAppID'],
            ['name' => 'Tutorial', 'slug' => 'tutorial', 'desc' => 'Panduan dan tutorial pengembangan'],
        ];
        $catIds = [];
        foreach ($catDefs as $cd) {
            $db->table('categories')->insert([
                'uuid' => $this->uuid(), 'name' => $cd['name'],
                'slug' => $cd['slug'], 'description' => $cd['desc'],
                'type' => 'article', 'created_at' => $now, 'updated_at' => $now,
            ]);
            $catIds[$cd['slug']] = $db->insertID();
        }
        $blogCatId = $catIds['blog'];
        $tutorialCatId = $catIds['tutorial'];
        echo "[+] categories (Blog id={$blogCatId}, Tutorial id={$tutorialCatId})\n";

        // 34. tags
        $tagDefs = ['Tutorial', 'News', 'Tips', 'Development'];
        $tagIds = [];
        foreach ($tagDefs as $tg) {
            $db->table('tags')->insert([
                'uuid' => $this->uuid(), 'name' => $tg,
                'slug' => strtolower($tg),
                'created_at' => $now, 'updated_at' => $now,
            ]);
            $tagIds[strtolower($tg)] = $db->insertID();
        }
        echo "[+] tags (4 dummies)\n";

        // 35. articles (3 Blog + 3 Tutorial)
        $articlesData = [
            // Blog category
            ['cat' => $blogCatId, 'title' => 'NgAppID Meluncurkan Fitur Baru untuk Client Area', 'slug' => 'fitur-baru-client-area', 'content' => '<p>NgAppID dengan bangga mengumumkan peluncuran fitur baru pada Client Area, termasuk dashboard yang lebih informatif dan manajemen download yang lebih baik.</p>', 'excerpt' => 'Fitur baru Client Area telah diluncurkan.', 'tag' => 'news'],
            ['cat' => $blogCatId, 'title' => 'Tips Meningkatkan Keamanan Aplikasi Web', 'slug' => 'tips-keamanan-aplikasi-web', 'content' => '<p>Keamanan adalah hal terpenting dalam aplikasi web. Berikut tips untuk meningkatkan keamanan aplikasi Anda.</p><p>1. Gunakan HTTPS. 2. Validasi input. 3. Sanitasi output. 4. Kelola session dengan aman.</p>', 'excerpt' => 'Tips keamanan penting untuk aplikasi web.', 'tag' => 'tips'],
            ['cat' => $blogCatId, 'title' => 'Update Platform dan Peningkatan Performa', 'slug' => 'update-platform-performa', 'content' => '<p>Kami telah melakukan update besar pada platform untuk meningkatkan performa dan stabilitas sistem.</p>', 'excerpt' => 'Peningkatan performa platform terbaru.', 'tag' => 'news'],
            // Tutorial category
            ['cat' => $tutorialCatId, 'title' => 'Tutorial: Membuat Website Pertama dengan CodeIgniter 4', 'slug' => 'tutorial-website-codeigniter4', 'content' => '<p>Dalam tutorial ini, Anda akan belajar membuat website pertama menggunakan CodeIgniter 4.</p><p>Langkah 1: Instalasi. Langkah 2: Konfigurasi. Langkah 3: Membuat Controller dan View.</p>', 'excerpt' => 'Panduan lengkap membuat website dengan CI4.', 'tag' => 'tutorial'],
            ['cat' => $tutorialCatId, 'title' => 'Tutorial: Integrasi Midtrans Payment Gateway', 'slug' => 'tutorial-integrasi-midtrans', 'content' => '<p>Pelajari cara mengintegrasikan Midtrans sebagai payment gateway di aplikasi Anda.</p><p>Midtrans menyediakan berbagai metode pembayaran seperti transfer bank, e-wallet, dan virtual account.</p>', 'excerpt' => 'Integrasi pembayaran Midtrans step by step.', 'tag' => 'development'],
            ['cat' => $tutorialCatId, 'title' => 'Tutorial: Membuat REST API dengan CodeIgniter', 'slug' => 'tutorial-rest-api-codeigniter', 'content' => '<p>Belajar membuat REST API menggunakan CodeIgniter 4 dengan baik dan benar.</p><p>Kita akan membuat API untuk manajemen produk lengkap dengan autentikasi.</p>', 'excerpt' => 'Panduan membangun REST API dengan CI4.', 'tag' => 'development'],
        ];

        $artIds = [];
        foreach ($articlesData as $ar) {
            $db->table('articles')->insert([
                'uuid' => $this->uuid(), 'category_id' => $ar['cat'],
                'author_id' => $this->userId,
                'title' => $ar['title'], 'slug' => $ar['slug'],
                'content' => $ar['content'], 'excerpt' => $ar['excerpt'],
                'status' => 'published',
                'published_at' => $now,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            $aid = $db->insertID();
            $artIds[] = $aid;

            // article_tags
            $db->table('article_tags')->insert([
                'article_id' => $aid,
                'tag_id' => $tagIds[$ar['tag']] ?? $tagIds['tutorial'],
            ]);
        }
        echo "[+] articles (6 dummies: 3 Blog + 3 Tutorial)\n";
        echo "[+] article_tags (6x)\n";

        // 36. testimonials
        $dummyTestimonials = [
            ['customer_name' => 'Ahmad Rizky', 'company' => 'PT Teknologi Nusantara', 'position' => 'CTO', 'title' => 'Platform Terbaik untuk Startup', 'message' => 'NgAppID membantu kami membangun MVP dalam 2 minggu. Fitur yang disediakan lengkap dan mudah dikustomisasi. Highly recommended!', 'rating' => 5, 'status' => 'approved', 'featured' => 1],
            ['customer_name' => 'Siti Nurhaliza', 'company' => 'CV Digital Kreatif', 'position' => 'CEO', 'title' => 'Solusi E-Commerce yang Lengkap', 'message' => 'Integrasi payment gateway dengan Midtrans sangat mulus. Invoice dan billing system juga sudah ready to use. Sangat puas!', 'rating' => 5, 'status' => 'approved', 'featured' => 1],
            ['customer_name' => 'Budi Santoso', 'company' => 'Freelance Developer', 'position' => 'Full Stack Developer', 'title' => 'Code Base yang Bersih', 'message' => 'Arsitektur codebase-nya clean dan mengikuti best practice. Membantu saya belajar structure project yang baik untuk production.', 'rating' => 4, 'status' => 'approved', 'featured' => 0],
            ['customer_name' => 'Diana Putri', 'company' => 'Online Store ID', 'position' => 'Founder', 'title' => 'Support Team yang Responsif', 'message' => 'Tim support NgAppID sangat responsif dan membantu. Ketika kami ada issue di production, mereka langsung merespon dan menyelesaikan.', 'rating' => 5, 'status' => 'approved', 'featured' => 1],
            ['customer_name' => 'Rudi Hartono', 'company' => 'Tech Startup XYZ', 'position' => 'Product Manager', 'title' => 'Fitur Client Area yang Bagus', 'message' => 'Client area untuk customer management, invoice, dan download produk sangat memudahkan workflow kami. Customer juga senang karena semua terintegrasi.', 'rating' => 4, 'status' => 'pending', 'featured' => 0],
        ];

        foreach ($dummyTestimonials as $t) {
            $db->table('testimonials')->insert(array_merge($t, [
                'uuid' => $this->uuid(),
                'user_id' => $this->userId,
                'customer_email' => strtolower(str_replace(' ', '.', $t['customer_name'])) . '@email.com',
                'created_at' => $now, 'updated_at' => $now,
            ]));
        }
        echo "[+] testimonials (5 dummies)\n";

        // Portfolios (3 dummy)
        $portfolioData = [
            ['title' => 'E-Commerce Platform untuk Fashion Brand', 'slug' => 'ecommerce-fashion-brand', 'description' => 'Platform e-commerce lengkap untuk brand fashion lokal', 'content' => '<p>Platform e-commerce lengkap dengan fitur manajemen produk, keranjang belanja, checkout, dan integrasi payment gateway.</p>', 'thumbnail' => '/images/portfolio/ecommerce-fashion.jpg', 'status' => 'published'],
            ['title' => 'Sistem Klinik Digital', 'slug' => 'sistem-klinik-digital', 'description' => 'Aplikasi manajemen klinik dengan booking online', 'content' => '<p>Aplikasi manajemen klinik dengan fitur booking online, rekam medis digital, dan antrian digital.</p>', 'thumbnail' => '/images/portfolio/klinik-digital.jpg', 'status' => 'published'],
            ['title' => 'Platform E-Learning', 'slug' => 'platform-e-learning', 'description' => 'Platform pembelajaran online dengan video streaming', 'content' => '<p>Platform pembelajaran online dengan video streaming, quiz interaktif, dan sertifikat.</p>', 'thumbnail' => '/images/portfolio/e-learning.jpg', 'status' => 'published'],
        ];
        foreach ($portfolioData as $i => $p) {
            $slug = $p['slug'] . '-' . $i;
            $db->table('portfolios')->insert([
                'uuid' => $this->uuid(),
                'client_id' => 1, 'category_id' => 1,
                'title' => $p['title'], 'slug' => $slug,
                'description' => $p['description'], 'content' => $p['content'],
                'thumbnail' => $p['thumbnail'], 'status' => 'published',
                'created_by' => $this->userId,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }
        echo "[+] portfolios (3 dummies)\n";

        echo "\n=== Selesai: Semua dummy data berhasil dimasukkan ===\n";
    }

    private function uuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return sprintf('%02x%02x%02x%02x-%02x%02x-%02x%02x-%02x%02x-%02x%02x%02x%02x%02x%02x',
            ord($data[0]), ord($data[1]), ord($data[2]), ord($data[3]),
            ord($data[4]), ord($data[5]), ord($data[6]), ord($data[7]),
            ord($data[8]), ord($data[9]), ord($data[10]), ord($data[11]),
            ord($data[12]), ord($data[13]), ord($data[14]), ord($data[15])
        );
    }
}
