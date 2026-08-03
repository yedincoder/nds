<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="container">
        <h1>Layanan Kami</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Services</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Solusi Digital Lengkap</h2>
            <p class="section-subtitle">Kami menyediakan berbagai layanan untuk memenuhi kebutuhan bisnis digital Anda</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="feature-card h-100">
                    <div class="feature-icon" style="background: rgba(26,187,156,0.1); color: var(--primary)">
                        <i class="fas fa-code"></i>
                    </div>
                    <h5>Web Development</h5>
                    <p>Pengembangan aplikasi web profesional menggunakan framework modern seperti CodeIgniter, Laravel, React, dan Vue.js.</p>
                    <a href="/contact" class="btn btn-outline-primary btn-sm">Konsultasi Gratis</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card h-100">
                    <div class="feature-icon" style="background: rgba(52,152,219,0.1); color: var(--accent)">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h5>Mobile Development</h5>
                    <p>Pembuatan aplikasi mobile native dan hybrid untuk Android dan iOS dengan performa optimal.</p>
                    <a href="/contact" class="btn btn-outline-primary btn-sm">Konsultasi Gratis</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card h-100">
                    <div class="feature-icon" style="background: rgba(231,76,60,0.1); color: var(--danger)">
                        <i class="fas fa-cloud"></i>
                    </div>
                    <h5>Cloud Solutions</h5>
                    <p>Infrastruktur cloud yang scalable dengan deployment otomatis dan monitoring 24/7.</p>
                    <a href="/contact" class="btn btn-outline-primary btn-sm">Konsultasi Gratis</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card h-100">
                    <div class="feature-icon" style="background: rgba(243,156,18,0.1); color: var(--warning)">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h5>E-Commerce Development</h5>
                    <p>Platform toko online lengkap dengan manajemen produk, keranjang belanja, dan integrasi pembayaran.</p>
                    <a href="/contact" class="btn btn-outline-primary btn-sm">Konsultasi Gratis</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card h-100">
                    <div class="feature-icon" style="background: rgba(26,187,156,0.1); color: var(--primary)">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5>Security Audit</h5>
                    <p>Audit keamanan aplikasi web dan mobile untuk memastikan perlindungan data yang optimal.</p>
                    <a href="/contact" class="btn btn-outline-primary btn-sm">Konsultasi Gratis</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card h-100">
                    <div class="feature-icon" style="background: rgba(52,152,219,0.1); color: var(--accent)">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h5>IT Consulting</h5>
                    <p>Konsultasi teknologi informasi untuk membantu bisnis Anda mengadopsi solusi digital yang tepat.</p>
                    <a href="/contact" class="btn btn-outline-primary btn-sm">Konsultasi Gratis</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5" style="background: var(--light-bg)">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="section-title">Mengapa Memilih Kami?</h2>
                <div class="d-flex align-items-start mb-3">
                    <i class="fas fa-check-circle me-3 mt-1" style="color: var(--primary); font-size: 20px;"></i>
                    <div>
                        <h6 class="fw-bold">Tim Ahli Berpengalaman</h6>
                        <p class="text-muted mb-0">Didukung oleh developer senior dengan pengalaman 5+ tahun di industri.</p>
                    </div>
                </div>
                <div class="d-flex align-items-start mb-3">
                    <i class="fas fa-check-circle me-3 mt-1" style="color: var(--primary); font-size: 20px;"></i>
                    <div>
                        <h6 class="fw-bold">Metodologi Agile</h6>
                        <p class="text-muted mb-0">Proses pengembangan transparan dengan sprint mingguan dan demo berkala.</p>
                    </div>
                </div>
                <div class="d-flex align-items-start mb-3">
                    <i class="fas fa-check-circle me-3 mt-1" style="color: var(--primary); font-size: 20px;"></i>
                    <div>
                        <h6 class="fw-bold">Support 24/7</h6>
                        <p class="text-muted mb-0">Tim support siap membantu Anda kapan saja setelah project selesai.</p>
                    </div>
                </div>
                <div class="d-flex align-items-start">
                    <i class="fas fa-check-circle me-3 mt-1" style="color: var(--primary); font-size: 20px;"></i>
                    <div>
                        <h6 class="fw-bold">Garansi & Maintenance</h6>
                        <p class="text-muted mb-0">Garansi bug selama 6 bulan dan maintenance berkala sesuai paket.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-handshake fa-8x" style="color: var(--primary); opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container text-center">
        <h2 class="text-white mb-3">Butuh Konsultasi?</h2>
        <p class="text-white mb-4" style="opacity: 0.9">Hubungi kami untuk mendiskusikan kebutuhan project Anda.</p>
        <a href="/contact" class="btn btn-light btn-lg">Hubungi Kami</a>
    </div>
</section>

<?= $this->endSection() ?>
