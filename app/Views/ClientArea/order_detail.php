<?= $this->extend('ClientArea/layout') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-6">
                <h3>Order #<?= esc($order->order_number) ?></h3>
                <div class="d-flex gap-3 mt-2 flex-wrap">
                    <span class="badge bg-success"><?= esc(ucfirst($order->status)) ?></span>
                    <span class="badge bg-secondary"><?= date('d M Y', strtotime($order->created_at)) ?></span>
                    <span class="badge bg-info text-dark">Rp <?= number_format($order->total, 0, ',', '.') ?></span>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <a href="/client/orders" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Back to Orders</a>
            </div>
        </div>

        <?php if (!empty($items)): ?>
        <?php foreach ($items as $itemData): ?>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-box me-2"></i><?= esc($itemData['item']->name) ?>
                </h5>
                <span class="badge bg-secondary">Qty: <?= $itemData['item']->quantity ?></span>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <small class="text-muted">Harga: <strong>Rp <?= number_format($itemData['item']->price, 0, ',', '.') ?></strong></small>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <small class="text-muted">Subtotal: <strong>Rp <?= number_format($itemData['item']->subtotal, 0, ',', '.') ?></strong></small>
                    </div>
                </div>

                <?php if (!empty($itemData['product'])): ?>
                <div class="mb-3">
                    <span class="badge bg-info text-dark"><?= esc($itemData['product']->category_name ?? 'Digital Product') ?></span>
                    <?php if (!empty($itemData['product']->description)): ?>
                    <p class="text-muted mt-2 mb-0" style="font-size: 13px;"><?= esc(substr(strip_tags($itemData['product']->description), 0, 200)) ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($itemData['files'])): ?>
                <div class="mb-3">
                    <h6 class="text-muted mb-2"><i class="fas fa-download me-1"></i>Download Produk:</h6>
                    <?php foreach ($itemData['files'] as $file): ?>
                    <a href="<?= site_url('client/download/' . $file->uuid) ?>" class="btn btn-sm btn-outline-primary me-2 mb-2">
                        <i class="fas fa-file-download me-1"></i><?= esc($file->file_name) ?>
                        <?php if (!empty($file->file_size)): ?>
                        <small>(<?= round($file->file_size / 1024 / 1024, 2) ?> MB)</small>
                        <?php endif; ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="alert alert-info py-2 mb-0">
                    <small><i class="fas fa-info-circle me-1"></i>Produk digital - detail akses akan diberikan setelah pembelian selesai.</small>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <div class="card">
            <div class="card-body">
                <p class="text-muted text-center py-5">No items in this order</p>
            </div>
        </div>
        <?php endif; ?>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Order Summary</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-1">
                    <span>Subtotal</span>
                    <span>Rp <?= number_format($order->subtotal, 0, ',', '.') ?></span>
                </div>
                <?php if (($order->discount ?? 0) > 0): ?>
                <div class="d-flex justify-content-between mb-1">
                    <span>Diskon</span>
                    <span class="text-danger">-Rp <?= number_format($order->discount, 0, ',', '.') ?></span>
                </div>
                <?php endif; ?>
                <?php if (($order->tax ?? 0) > 0): ?>
                <div class="d-flex justify-content-between mb-1">
                    <span>Pajak</span>
                    <span>Rp <?= number_format($order->tax, 0, ',', '.') ?></span>
                </div>
                <?php endif; ?>
                <hr>
                <div class="d-flex justify-content-between">
                    <strong>Total</strong>
                    <strong class="text-primary">Rp <?= number_format($order->total, 0, ',', '.') ?></strong>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>