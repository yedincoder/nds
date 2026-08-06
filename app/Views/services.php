<?= $this->extend('Layout/layout_frontarea') ?>

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
            <?php if (!empty($services)): ?>
            <?php foreach ($services as $idx => $service): ?>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card h-100">
                    <div class="feature-icon">
                        <?php if (!empty($service->thumbnail)): ?>
                        <img src="<?= esc($service->thumbnail) ?>" alt="<?= esc($service->name) ?>" style="width:64px;height:64px;border-radius:16px;object-fit:cover;">
                        <?php else: ?>
                        <i class="fas fa-cogs"></i>
                        <?php endif; ?>
                    </div>
                    <h5><?= esc($service->name) ?></h5>
                    <p><?= esc($service->description) ?></p>
                    <div class="mt-3">
                        <span class="price" style="font-size:16px;color:var(--primary);font-weight:700;">
                            <?php if (!empty($service->price)): ?>
                                Mulai dari Rp <?= number_format($service->price, 0, ',', '.') ?>
                            <?php else: ?>
                                Custom
                            <?php endif; ?>
                        </span>
                    </div>
                    <a href="/contact" class="btn btn-sm btn-primary mt-3">Konsultasi Gratis</a>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada layanan yang tersedia.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="py-5" style="background: var(--orange-soft)">
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
                <div class="feature-icon" style="width: 120px; height: 120px; font-size: 50px; background: #fff; color: var(--primary);">
                    <i class="fas fa-handshake"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container text-center">
        <h2 class="text-white mb-3">Butuh Konsultasi?</h2>
        <p class="text-white mb-4" style="opacity: 0.9;">Hubungi kami untuk mendiskusikan kebutuhan project Anda.</p>
        <a href="/contact" class="btn btn-cta">Hubungi Kami</a>
    </div>
</section>

<?= $this->endSection() ?>