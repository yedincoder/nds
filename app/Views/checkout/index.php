<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <h1 class="mb-4">Checkout</h1>

        <div class="row">
            <div class="col-md-7">
                <div class="card mb-4">
                    <div class="card-header"><h5>Billing Information</h5></div>
                    <div class="card-body">
                        <form action="<?= site_url('checkout/process') ?>" method="POST">
                            <?= csrf_field() ?>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" name="billing_name" class="form-control" value="<?= old('billing_name') ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone *</label>
                                    <input type="tel" name="billing_phone" class="form-control" value="<?= old('billing_phone') ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" name="billing_email" class="form-control" value="<?= old('billing_email') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address *</label>
                                <textarea name="billing_address" class="form-control" rows="2" required><?= old('billing_address') ?></textarea>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">City *</label>
                                    <input type="text" name="billing_city" class="form-control" value="<?= old('billing_city') ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Province *</label>
                                    <input type="text" name="billing_province" class="form-control" value="<?= old('billing_province') ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Postal Code</label>
                                    <input type="text" name="billing_postal_code" class="form-control" value="<?= old('billing_postal_code') ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control" rows="3"><?= old('notes') ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header"><h5>Order Summary</h5></div>
                    <div class="card-body">
                        <?php if (!empty($items)): ?>
                            <?php foreach ($items as $item): ?>
                                <div class="d-flex justify-content-between mb-2">
                                    <span><?= esc($item->name) ?> x <?= $item->quantity ?></span>
                                    <span><?= format_price($item->subtotal) ?></span>
                                </div>
                            <?php endforeach; ?>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total</strong>
                                <strong><?= format_price($summary['total'] ?? 0) ?></strong>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>