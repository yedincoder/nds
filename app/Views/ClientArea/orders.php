<?= $this->extend('ClientArea/layout') ?>

<?= $this->section('content') ?>

<h3>My Orders</h3>

<div class="card">
    <div class="card-body">
        <?php if (!empty($orders)): ?>
        <table class="table table-hover">
            <thead>
                <tr><th>Order #</th><th>Total</th><th>Status</th><th>Date</th><th>Actions</th></tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td>#<?= esc($order->order_number ?? $order->id ?? '') ?></td>
                <td>Rp <?= number_format($order->total ?? 0, 0, ',', '.') ?></td>
                <td><span class="badge bg-info"><?= esc(ucfirst($order->status ?? '')) ?></span></td>
                <td><?= date('d M Y', strtotime($order->created_at ?? '')) ?></td>
                <td><a href="#" class="btn btn-sm btn-outline-primary">View</a></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="text-muted text-center py-5">No orders yet</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
