<?= $this->extend('ClientArea/layout') ?>

<?= $this->section('content') ?>

<h3>My Orders</h3>

<div class="card">
    <div class="card-body">
        <?php if (!empty($orders)): ?>
        <table class="table table-hover">
            <thead>
                <tr><th>Order #</th><th>Items</th><th>Total</th><th>Status</th><th>Date</th><th>Actions</th></tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td>#<?= esc($order->order_number ?? $order->id ?? '') ?></td>
                <td>
                    <?php
                    $db = \Config\Database::connect();
                    $itemNames = $db->table('order_items')->select('name')->where('order_id', $order->id)->get()->getResult();
                    echo implode(', ', array_map(function($i) { return $i->name; }, array_slice($itemNames, 0, 2)));
                    if (count($itemNames) > 2) echo ' +' . (count($itemNames) - 2) . ' more';
                    ?>
                </td>
                <td>Rp <?= number_format($order->total ?? 0, 0, ',', '.') ?></td>
                <td><span class="badge bg-success"><?= esc(ucfirst($order->status ?? '')) ?></span></td>
                <td><?= date('d M Y', strtotime($order->created_at ?? '')) ?></td>
                <td>
                    <a href="<?= site_url('client/orders/' . ($order->uuid ?? $order->id)) ?>" class="btn btn-sm btn-outline-primary">View Detail</a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="text-muted text-center py-5">No completed orders yet</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
