<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="mb-4"><?= esc($product->name) ?></h1>
                <img src="<?= esc($product->thumbnail ?? 'https://via.placeholder.com/800x400') ?>" class="img-fluid mb-4" alt="<?= esc($product->name) ?>">
                <div class="content">
                    <?= $product->description ?? '' ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-primary"><?= format_price($product->price ?? 0) ?></h4>
                        <?php if ($product->discount_price): ?>
                            <p class="text-muted"><del><?= format_price($product->price) ?></del></p>
                        <?php endif; ?>
                        <form action="<?= site_url('cart/add') ?>" method="POST">
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

<?= $this->endSection() ?>
