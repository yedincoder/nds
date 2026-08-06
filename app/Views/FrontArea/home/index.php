<?= $this->extend('layout/layout_frontarea') ?>

<?= $this->section('content') ?>

<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1>Platform <span>Digital</span> Modern untuk Bisnis Anda</h1>
                <p>NgAppID adalah solusi lengkap untuk pengembangan aplikasi profesional, penjualan produk digital, sistem billing, dan dukungan pelanggan terintegrasi.</p>
                <div class="d-flex gap-3">
                    <a href="/products" class="btn btn-primary"><i class="fas fa-box me-1"></i>Lihat Produk</a>
                    <a href="/services" class="btn btn-outline-light"><i class="fas fa-cogs me-1"></i>Layanan Kami</a>
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
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-box"></i></div>
                    <h3><?= esc($stats['total_products'] ?? 0) ?>+</h3>
                    <p><i class="fas fa-box me-2"></i>Produk Digital</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="border-left-color: var(--info);">
                    <div class="stat-icon" style="background: rgba(52,152,219,0.1); color: var(--info);"><i class="fas fa-cogs"></i></div>
                    <h3><?= esc($stats['total_services'] ?? 0) ?>+</h3>
                    <p><i class="fas fa-cogs me-2"></i>Layanan Tersedia</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="border-left-color: var(--danger);">
                    <div class="stat-icon" style="background: rgba(231,76,60,0.1); color: var(--danger);"><i class="fas fa-briefcase"></i></div>
                    <h3><?= esc($stats['total_portfolios'] ?? 0) ?>+</h3>
                    <p><i class="fas fa-briefcase me-2"></i>Proyek Selesai</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="border-left-color: var(--warning);">
                    <div class="stat-icon" style="background: rgba(243,156,18,0.1); color: var(--warning);"><i class="fas fa-users"></i></div>
                    <h3><?= esc($stats['happy_clients'] ?? 0) ?>+</h3>
                    <p><i class="fas fa-users me-2"></i>Klien Puas</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5" style="background: var(--light-bg)">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Layanan Kami</h2>
            <p class="section-subtitle">Kami menyediakan berbagai layanan untuk memenuhi kebutuhan bisnis digital Anda</p>
        </div>
        <div class="row g-4">
            <?php foreach ($services as $idx => $service): ?>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card h-100">
                    <div class="feature-icon" style="background: rgba(<?= $idx === 0 ? '230,92,0,0.1' : ($idx === 1 ? '52,152,219,0.1' : '231,76,60,0.1') ?>); color: <?= $idx === 0 ? 'var(--primary)' : ($idx === 1 ? 'var(--info)' : 'var(--danger)') ?>;">
                        <i class="<?= $serviceIcons[$idx % count($serviceIcons)] ?? 'fas fa-cogs' ?>"></i>
                    </div>
                    <h5><?= esc($service->name) ?></h5>
                    <p class="small"><?= esc($service->description) ?></p>
                    <a href="/services" class="btn btn-sm btn-outline-primary mt-2">Selengkapnya</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-5" style="background: var(--light-bg)">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Produk Unggulan</h2>
            <p class="section-subtitle">Produk digital berkualitas untuk kebutuhan bisnis Anda</p>
        </div>
        <div class="row g-4">
            <?php $homeProducts = array_slice($products ?? [], 0, 3); ?>
            <?php foreach ($homeProducts as $product): ?>
            <div class="col-md-6 col-lg-4">
                <div class="product-card h-100">
                    <div class="product-img">
                        <?php if (!empty($product->thumbnail)): ?>
                        <img src="<?= esc($product->thumbnail) ?>" alt="<?= esc($product->name) ?>" style="width:100%;height:100%;object-fit:cover;">
                        <?php else: ?>
                        <i class="fas fa-box fa-4x"></i>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <h5><?= esc($product->name) ?></h5>
                        <p class="text-muted mb-3"><?= esc($product->short_description ?? '') ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price">Rp <?= number_format($product->price ?? 0, 0, ',', '.') ?></span>
                            <a href="/product/<?= esc($product->slug ?? $product->id) ?>" class="btn btn-sm btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="/products" class="btn btn-outline-primary">Lihat Semua Produk</a>
        </div>
    </div>
</section>

<section class="py-5" style="background: #fff">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Testimonial</h2>
            <p class="section-subtitle">Apa kata klien kami tentang layanan kami</p>
        </div>
        <div class="row g-4">
            <?php foreach ($testimonials as $idx => $t): ?>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="star">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star star <?= $i <= ($t->rating ?? 5) ? '' : 'text-muted' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <p style="font-style: italic; color: var(--text-muted); line-height: 1.7;">"<?= esc(substr($t->message, 0, 120)) ?>..."</p>
                    <div class="d-flex align-items-center mt-3">
                        <?php if (!empty($t->avatar)): ?>
                        <img src="<?= esc($t->avatar) ?>" class="rounded-circle me-2" width="40" height="40" alt="">
                        <?php else: ?>
                        <div class="rounded-circle me-2 d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:var(--orange-soft);color:var(--primary);font-weight:600;font-size:14px;">
                            <?= esc(strtoupper(substr($t->customer_name ?? '?', 0, 1))) ?>
                        </div>
                        <?php endif; ?>
                        <div>
                            <strong class="text-dark"><?= esc($t->customer_name ?? '') ?></strong>
                            <?php if (!empty($t->company)): ?><br><small class="text-muted"><?= esc($t->company) ?></small><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container text-center">
        <h2 class="text-white mb-3">Siap Memulai Proyek Anda?</h2>
        <p class="text-white mb-4" style="opacity: 0.9;">Konsultasikan kebutuhan digital bisnis PT. YEDIN DIGITAL MANDIRI dengan tim ahli kami.</p>
        <a href="/contact" class="btn btn-cta">Hubungi Kami Sekarang</a>
    </div>
</section>

<?= $this->endSection() ?>