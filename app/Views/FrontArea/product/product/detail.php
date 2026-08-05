<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<!-- 1. BAGIAN HEADER & BREADCRUMB (Sesuai Struktur) -->
<section class="page-header">
    <div class="container">
        <h1>Detail Produk</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/product">Products</a></li>
                <li class="breadcrumb-item active"><?= esc($product->name) ?></li>
            </ol>
        </nav>
    </div>
</section>

<!-- 2. BAGIAN MAIN CONTENT (Detail, Gambar, Harga) -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2 class="mb-4"><?= esc($product->name) ?></h2>
                <img src="<?= esc($product->thumbnail ?? 'https://via.placeholder.com/800x400') ?>" class="img-fluid mb-4" alt="<?= esc($product->name) ?>" style="width:100%; object-fit:cover;">
                <div class="content">
                    <?= $product->description ?? '' ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        
                        <!-- Logika Harga Sinkron -->
                        <div class="mb-4">
                            <?php if (!empty($product->discount_price) && $product->discount_price < $product->price): ?>
                                <span class="text-muted text-decoration-line-through d-block mb-1" style="font-size:14px;">Rp <?= number_format($product->price, 0, ',', '.') ?></span>
                                <h3 class="text-primary mb-0">Rp <?= number_format($product->discount_price, 0, ',', '.') ?></h3>
                            <?php else: ?>
                                <h3 class="text-primary mb-0">Rp <?= number_format($product->price ?? 0, 0, ',', '.') ?></h3>
                            <?php endif; ?>
                        </div>
                        
                        <form action="<?= site_url('cart/add') ?>" method="POST">
                            <?= csrf_field() ?>
                            <input type="hidden" name="product_id" value="<?= $product->id ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary btn-block w-100 mb-2">Add to Cart</button>
                        </form>
                        <button class="btn btn-outline-secondary btn-block w-100">Download Info</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. BAGIAN CTA (Sesuai Struktur) -->
<section class="cta-section">
    <div class="container text-center">
        <h2 class="text-white mb-3">Butuh Bantuan Kustomisasi?</h2>
        <p class="text-white mb-4" style="opacity: 0.9;">Kami bisa membantu menyesuaikan produk digital ini dengan kebutuhan spesifik Anda.</p>
        <a href="/contact" class="btn btn-cta">Konsultasi Sekarang</a>
    </div>
</section>

<?= $this->endSection() ?>