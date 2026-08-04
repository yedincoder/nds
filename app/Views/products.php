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
            <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
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
                        <?php if (!empty($product->category_name)): ?>
                        <span class="badge-category mb-2"><?= esc($product->category_name) ?></span>
                        <?php endif; ?>
                        <h5><?= esc($product->name) ?></h5>
                        <p class="text-muted mb-3"><?= esc($product->short_description ?? substr($product->description ?? '', 0, 120)) ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <?php if (!empty($product->discount_price) && $product->discount_price < $product->price): ?>
                                <span class="text-muted text-decoration-line-through me-2" style="font-size:14px;">Rp <?= number_format($product->price, 0, ',', '.') ?></span>
                                <span class="price">Rp <?= number_format($product->discount_price, 0, ',', '.') ?></span>
                                <?php else: ?>
                                <span class="price">Rp <?= number_format($product->price ?? 0, 0, ',', '.') ?></span>
                                <?php endif; ?>
                            </div>
                            <a href="<?= site_url('product/' . ($product->slug ?? $product->id)) ?>" class="btn btn-sm btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada produk yang tersedia.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container text-center">
        <h2 class="text-white mb-3">Butuh Produk Custom?</h2>
        <p class="text-white mb-4" style="opacity: 0.9;">Kami bisa membuat produk digital sesuai kebutuhan spesifik bisnis Anda.</p>
        <a href="/contact" class="btn btn-cta">Konsultasi Sekarang</a>
    </div>
</section>

<?= $this->endSection() ?>