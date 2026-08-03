<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1>Platform <span>Digital</span> Modern untuk Bisnis Anda</h1>
                <p>NgAppID adalah solusi lengkap untuk pengembangan aplikasi profesional, penjualan produk digital, sistem billing, dan dukungan pelanggan terintegrasi.</p>
                <div class="d-flex gap-3">
                    <a href="/products" class="btn btn-primary">Lihat Produk</a>
                    <a href="/about" class="btn btn-outline-light">Pelajari Lebih Lanjut</a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-cube fa-10x" style="color: var(--primary); opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</section>

<section class="py-5" style="margin-top: -30px; position: relative; z-index: 1;">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card text-center p-4" style="border-top: 3px solid var(--primary)">
                    <h3 class="fw-bold" style="color: var(--primary)">100+</h3>
                    <p class="text-muted mb-0">Produk Digital</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-4" style="border-top: 3px solid var(--accent)">
                    <h3 class="fw-bold" style="color: var(--accent)">500+</h3>
                    <p class="text-muted mb-0">Klien Puas</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-4" style="border-top: 3px solid var(--success)">
                    <h3 class="fw-bold" style="color: var(--success)">24/7</h3>
                    <p class="text-muted mb-0">Dukungan Teknis</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-4" style="border-top: 3px solid var(--danger)">
                    <h3 class="fw-bold" style="color: var(--danger)">99.9%</h3>
                    <p class="text-muted mb-0">Uptime Server</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5" style="background: var(--light-bg)">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Layanan Kami</h2>
            <p class="section-subtitle">Solusi digital lengkap untuk kebutuhan bisnis Anda</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background: rgba(26,187,156,0.1); color: var(--primary)">
                        <i class="fas fa-code"></i>
                    </div>
                    <h5>Web Development</h5>
                    <p>Pengembangan aplikasi web profesional dengan teknologi terkini dan arsitektur modern.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background: rgba(52,152,219,0.1); color: var(--accent)">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h5>Mobile Apps</h5>
                    <p>Pembuatan aplikasi mobile untuk Android dan iOS dengan performa optimal.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background: rgba(231,76,60,0.1); color: var(--danger)">
                        <i class="fas fa-cloud"></i>
                    </div>
                    <h5>Cloud Solutions</h5>
                    <p>Infrastruktur cloud yang scalable dan aman untuk menjalankan aplikasi Anda.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background: rgba(243,156,18,0.1); color: var(--warning)">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h5>E-Commerce</h5>
                    <p>Platform e-commerce lengkap dengan integrasi pembayaran dan manajemen produk.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background: rgba(26,187,156,0.1); color: var(--primary)">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5>Security Audit</h5>
                    <p>Audit keamanan aplikasi untuk memastikan perlindungan data yang optimal.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background: rgba(52,152,219,0.1); color: var(--accent)">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h5>24/7 Support</h5>
                    <p>Dukungan teknis profesional yang siap membantu Anda kapan saja.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Produk Unggulan</h2>
            <p class="section-subtitle">Produk digital berkualitas untuk kebutuhan Anda</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="product-card">
                    <div class="product-img">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <div class="card-body">
                        <h5>Web Application Starter</h5>
                        <p class="text-muted mb-3">Template aplikasi web lengkap dengan autentikasi dan dashboard.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price">Rp 2.500.000</span>
                            <a href="/products" class="btn btn-sm btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="product-card">
                    <div class="product-img" style="background: linear-gradient(135deg, var(--accent), #9B59B6)">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div class="card-body">
                        <h5>Mobile App Framework</h5>
                        <p class="text-muted mb-3">Framework hybrid untuk aplikasi Android dan iOS.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price">Rp 3.500.000</span>
                            <a href="/products" class="btn btn-sm btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="product-card">
                    <div class="product-img" style="background: linear-gradient(135deg, var(--warning), var(--danger))">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <div class="card-body">
                        <h5>E-Commerce Suite</h5>
                        <p class="text-muted mb-3">Paket lengkap untuk membangun toko online profesional.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price">Rp 5.000.000</span>
                            <a href="/products" class="btn btn-sm btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="/products" class="btn btn-outline-primary">Lihat Semua Produk</a>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container text-center">
        <h2 class="text-white mb-3">Siap Memulai Proyek Anda?</h2>
        <p class="text-white mb-4" style="opacity: 0.9">Konsultasikan kebutuhan digital bisnis Anda dengan tim ahli kami.</p>
        <a href="/contact" class="btn btn-light btn-lg">Hubungi Kami Sekarang</a>
    </div>
</section>

<?= $this->endSection() ?>
