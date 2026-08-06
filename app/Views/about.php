<<?= $this->extend('Layout/layout_frontarea') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="container">
        <h1>About Us</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">About Us</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="section-title">Tentang NgAppID</h2>
                <p>NgAppID adalah platform digital modern yang didedikasikan untuk menyediakan solusi perangkat lunak enterprise-grade untuk bisnis modern.</p>
                <p>Visi kami adalah menjadi platform digital terdepan yang menyediakan layanan pengembangan software, penjualan produk digital, sistem billing pelanggan, serta layanan support yang terintegrasi dalam satu platform modern, aman, scalable, dan mudah dikembangkan.</p>
                <p>Tim kami terdiri dari para ahli di bidang pengembangan perangkat lunak, desain UI/UX, arsitektur sistem, dan jaminan kualitas untuk memastikan setiap solusi yang kami sediakan memenuhi standar tertinggi.</p>
            </div>
            <div class="col-lg-6 text-center">
                <div class="feature-icon" style="width: 120px; height: 120px; font-size: 50px; background: var(--orange-soft); color: var(--primary);">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5" style="background: var(--orange-soft)">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Nilai-Nilai Kami</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background: rgba(230,92,0,0.1); color: var(--primary)"><i class="fas fa-award"></i></div>
                    <h5>Professional</h5>
                    <p>Kualitas dan standar tertinggi dalam setiap deliverable yang kami hasilkan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background: rgba(52,152,219,0.1); color: var(--info)"><i class="fas fa-bolt"></i></div>
                    <h5>Fast</h5>
                    <p>Pengembangan cepat tanpa mengorbankan kualitas hasil akhir.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background: rgba(231,76,60,0.1); color: var(--danger)"><i class="fas fa-shield-alt"></i></div>
                    <h5>Secure</h5>
                    <p>Keamanan yang kuat untuk data dan transaksi pelanggan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background: rgba(243,156,18,0.1); color: var(--warning)"><i class="fas fa-lightbulb"></i></div>
                    <h5>Modern</h5>
                    <p>Teknologi terkini dan arsitektur yang bersih untuk solusi masa depan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background: rgba(230,92,0,0.1); color: var(--primary)"><i class="fas fa-arrows-alt"></i></div>
                    <h5>Scalable</h5>
                    <p>Siap berkembang seiring pertumbuhan bisnis Anda.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background: rgba(52,152,219,0.1); color: var(--info)"><i class="fas fa-cogs"></i></div>
                    <h5>Maintainable</h5>
                    <p>Kode yang mudah dipelihara dan dikembangkan oleh tim manapun.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container text-center">
        <h2 class="section-title">Statistik Kami</h2>
        <div class="row g-4 mt-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-box"></i></div>
                    <h3><?= esc($stats['total_products'] ?? 0) ?>+</h3>
                    <p>Produk Digital</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(52,152,219,0.1); color: var(--info);"><i class="fas fa-cogs"></i></div>
                    <h3><?= esc($stats['total_services'] ?? 0) ?>+</h3>
                    <p>Layanan</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(26,188,156,0.1); color: var(--primary);"><i class="fas fa-briefcase"></i></div>
                    <h3><?= esc($stats['total_portfolios'] ?? 0) ?>+</h3>
                    <p>Proyek Selesai</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(231,76,60,0.1); color: var(--danger);"><i class="fas fa-newspaper"></i></div>
                    <h3><?= esc($stats['total_articles'] ?? 0) ?>+</h3>
                    <p>Artikel & Tutorial</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5" style="background: var(--orange-soft)">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="section-title">Mitra Teknologi Kami</h2>
                <p>Kami menggunakan teknologi terbaik untuk membangun solusi yang handal dan scalable.</p></            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-code fa-8x" style="color: var(--primary); opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>