<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="container">
        <h1>Produk Kami</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Products</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Produk Digital Berkualitas</h2>
            <p class="section-subtitle">Temukan produk digital yang sesuai dengan kebutuhan bisnis Anda</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="product-card h-100">
                    <div class="product-img">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <div class="card-body">
                        <h5>Web Application Starter</h5>
                        <p class="text-muted mb-3">Template aplikasi web lengkap dengan autentikasi, dashboard admin, dan API.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price">Rp 2.500.000</span>
                            <a href="/contact" class="btn btn-sm btn-primary">Beli Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="product-card h-100">
                    <div class="product-img" style="background: linear-gradient(135deg, var(--accent), #9B59B6)">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div class="card-body">
                        <h5>Mobile App Framework</h5>
                        <p class="text-muted mb-3">Framework hybrid untuk aplikasi Android dan iOS dengan satu codebase.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price">Rp 3.500.000</span>
                            <a href="/contact" class="btn btn-sm btn-primary">Beli Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="product-card h-100">
                    <div class="product-img" style="background: linear-gradient(135deg, var(--warning), var(--danger))">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <div class="card-body">
                        <h5>E-Commerce Suite</h5>
                        <p class="text-muted mb-3">Paket lengkap untuk membangun toko online dengan payment gateway.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price">Rp 5.000.000</span>
                            <a href="/contact" class="btn btn-sm btn-primary">Beli Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="product-card h-100">
                    <div class="product-img" style="background: linear-gradient(135deg, var(--success), #2ECC71)">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="card-body">
                        <h5>Analytics Dashboard</h5>
                        <p class="text-muted mb-3">Dashboard analitik real-time dengan visualisasi data interaktif.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price">Rp 4.000.000</span>
                            <a href="/contact" class="btn btn-sm btn-primary">Beli Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="product-card h-100">
                    <div class="product-img" style="background: linear-gradient(135deg, #8E44AD, #3498DB)">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div class="card-body">
                        <h5>Chat & Support System</h5>
                        <p class="text-muted mb-3">Sistem live chat dan support ticket untuk customer service.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price">Rp 3.000.000</span>
                            <a href="/contact" class="btn btn-sm btn-primary">Beli Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="product-card h-100">
                    <div class="product-img" style="background: linear-gradient(135deg, var(--secondary), #34495E)">
                        <i class="fas fa-server"></i>
                    </div>
                    <div class="card-body">
                        <h5>Server Management Panel</h5>
                        <p class="text-muted mb-3">Panel manajemen server dengan monitoring dan deployment otomatis.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price">Rp 6.000.000</span>
                            <a href="/contact" class="btn btn-sm btn-primary">Beli Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container text-center">
        <h2 class="text-white mb-3">Butuh Produk Custom?</h2>
        <p class="text-white mb-4" style="opacity: 0.9">Kami bisa membuat produk digital sesuai kebutuhan spesifik bisnis Anda.</p>
        <a href="/contact" class="btn btn-light btn-lg">Konsultasi Sekarang</a>
    </div>
</section>

<?= $this->endSection() ?>
