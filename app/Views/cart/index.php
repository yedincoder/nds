<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <h1 class="mb-4">Shopping Cart</h1>

        <?php if (empty($items)): ?>
            <div class="alert alert-info">Your cart is empty.</div>
            <a href="<?= site_url('products') ?>" class="btn btn-primary">Browse Products</a>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product/Service</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= esc($item->name) ?></td>
                                <td><?= format_price($item->price) ?></td>
                                <td>
                                    <form action="<?= site_url('cart/update') ?>" method="POST" class="d-flex">
                                        <input type="hidden" name="item_id" value="<?= $item->id ?>">
                                        <input type="number" name="quantity" value="<?= $item->quantity ?>" class="form-control" style="width: 80px;">
                                        <button type="submit" class="btn btn-sm btn-outline-primary ms-2">Update</button>
                                    </form>
                                </td>
                                <td><?= format_price($item->subtotal) ?></td>
                                <td>
                                    <a href="<?= site_url('cart/remove/' . $item->id) ?>" class="btn btn-sm btn-outline-danger">Remove</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h5>Order Summary</h5>
                    <p>Subtotal: <?= format_price($summary['subtotal'] ?? 0) ?></p>
                    <p>Tax: <?= format_price($summary['tax'] ?? 0) ?></p>
                    <p>Discount: <?= format_price($summary['discount'] ?? 0) ?></p>
                    <h4>Total: <?= format_price($summary['total'] ?? 0) ?></h4>
                    <div class="d-flex gap-2 mt-3">
                        <a href="<?= site_url('products') ?>" class="btn btn-outline-secondary">Continue Shopping</a>
                        <a href="<?= site_url('checkout') ?>" class="btn btn-primary">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>