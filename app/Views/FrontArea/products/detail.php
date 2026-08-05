<?= $this->extend('Layout/layout_frontarea') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="container">
        <h1>Detail Produk</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/products">Products</a></li>
                <li class="breadcrumb-item active"><?= esc($product->name) ?></li>
            </ol>
        </nav>
    </div>
</section>

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
                        <a href="/contact" class="btn btn-outline-secondary btn-block w-100">Tanya Produk Ini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>