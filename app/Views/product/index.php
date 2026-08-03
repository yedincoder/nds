<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <h1 class="mb-4"><?= esc($title) ?></h1>

        <div class="row">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="<?= esc($product->thumbnail ?? 'https://via.placeholder.com/300x200') ?>" class="card-img-top" alt="<?= esc($product->name) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($product->name) ?></h5>
                                <p class="card-text"><?= esc($product->short_description ?? '') ?></p>
                                <a href="<?= site_url('products/' . $product->slug) ?>" class="btn btn-primary">View Details</a>
                                <a href="<?= site_url('cart/add') ?>" class="btn btn-outline-success" data-product-id="<?= $product->id ?>">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">No products found.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
