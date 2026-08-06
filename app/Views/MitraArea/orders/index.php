<?= $this->extend('Layout/layout_mitraarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Pesanan</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/mitra/dashboard">Mitra</a></li>
            <li class="breadcrumb-item active">Pesanan</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Semua Pesanan</div>
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
                        <th>Status</th>
                        <th>Date</th>
                        <th>Komisi</th>
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
                                <td>
                                    <?php $sc = match($order->status ?? 'pending') {
                                        'paid','completed' => 'bg-success', 
                                        'pending','waiting_payment' => 'bg-warning',
                                        'cancelled','expired' => 'bg-danger',
                                        default => 'bg-secondary'
                                    }; ?>
                                    <span class="badge <?= $sc ?>"><?= ucfirst(str_replace('_', ' ', $order->status ?? 'pending')) ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($order->created_at ?? $order->order_created_at ?? '')) ?></td>
                                <td>Rp <?= number_format($order->commission ?? 0, 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center py-4">Belum ada pesanan</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>