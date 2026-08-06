<?= $this->extend('Layout/layout_mitraarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Pesanan Dibatalkan</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/mitra/dashboard">Mitra</a></li>
            <li class="breadcrumb-item"><a href="/mitra/orders">Pesanan</a></li>
            <li class="breadcrumb-item active">Dibatalkan</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Pesanan Dibatalkan</div>
    </div>
    <div class="card-body" style="padding:8px 16px">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $i => $order): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><strong>#<?= esc($order->order_number ?? '#' . $order->id) ?></strong></td>
                                <td><?= esc($order->username ?? 'N/A') ?></td>
                                <td>Rp <?= number_format($order->total ?? 0, 0, ',', '.') ?></td>
                                <td><?= date('d M Y', strtotime($order->created_at ?? $order->order_created_at ?? '')) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center py-4">Belum ada pesanan dibatalkan</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>