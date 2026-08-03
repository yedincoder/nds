<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="container">
        <h1>Portfolio</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Portfolio</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Proyek Terbaru</h2>
            <p class="section-subtitle">Kami telah membantu berbagai klien membangun solusi digital terbaik</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="product-card h-100">
                    <div class="product-img">
                        <i class="fas fa-store"></i>
                    </div>
                    <div class="card-body">
                        <span class="badge bg-primary mb-2">E-Commerce</span>
                        <h5>Online Shop Platform</h5>
                        <p class="text-muted mb-3">Platform toko online untuk brand fashion lokal dengan integrasi pembayaran lengkap.</p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="product-card h-100">
                    <div class="product-img" style="background: linear-gradient(135deg, var(--accent), #9B59B6)">
                        <i class="fas fa-hospital"></i>
                    </div>
                    <div class="card-body">
                        <span class="badge bg-info mb-2">Healthcare</span>
                        <h5>Sistem Klinik Digital</h5>
                        <p class="text-muted mb-3">Aplikasi manajemen klinik dengan booking online dan rekam medis digital.</p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="product-card h-100">
                    <div class="product-img" style="background: linear-gradient(135deg, var(--success), #2ECC71)">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="card-body">
                        <span class="badge bg-success mb-2">Education</span>
                        <h5>Platform E-Learning</h5>
                        <p class="text-muted mb-3">Platform pembelajaran online dengan video streaming dan quiz interaktif.</p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="product-card h-100">
                    <div class="product-img" style="background: linear-gradient(135deg, var(--warning), var(--danger))">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="card-body">
                        <span class="badge bg-warning text-dark mb-2">Food & Beverage</span>
                        <h5>Restaurant Management</h5>
                        <p class="text-muted mb-3">Sistem manajemen restoran dengan pemesanan online dan delivery tracking.</p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="product-card h-100">
                    <div class="product-img" style="background: linear-gradient(135deg, #8E44AD, #3498DB)">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="card-body">
                        <span class="badge bg-secondary mb-2">Real Estate</span>
                        <h5>Property Listing Platform</h5>
                        <p class="text-muted mb-3">Platform listing properti dengan virtual tour dan kalkulator kredit.</p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="product-card h-100">
                    <div class="product-img" style="background: linear-gradient(135deg, var(--secondary), #34495E)">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="card-body">
                        <span class="badge bg-dark mb-2">Logistics</span>
                        <h5>Delivery Management</h5>
                        <p class="text-muted mb-3">Sistem manajemen pengiriman dengan real-time tracking dan route optimization.</p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
