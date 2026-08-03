<?= $this->extend('ClientArea/layout') ?>

<?= $this->section('content') ?>

<h3>My Downloads</h3>

<div class="card">
    <div class="card-body">
        <?php if (!empty($downloads)): ?>
        <table class="table table-hover">
            <thead><tr><th>Product</th><th>Order</th><th>Downloads Left</th><th>Expires</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach ($downloads as $dl): ?>
            <tr>
                <td><?= esc($dl->product_name ?? 'Product') ?></td>
                <td>#<?= esc($dl->order_number ?? '') ?></td>
                <td><?= ($dl->max_downloads ?? 0) - ($dl->download_count ?? 0) ?> / <?= $dl->max_downloads ?? 0 ?></td>
                <td><?= $dl->expires_at ? date('d M Y', strtotime($dl->expires_at)) : 'Never' ?></td>
                <td><a href="/client/download/<?= esc($dl->token ?? $dl->id) ?>" class="btn btn-sm btn-primary">Download</a></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="text-muted text-center py-5">No downloads available</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>