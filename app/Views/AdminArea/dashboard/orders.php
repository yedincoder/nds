<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Orders</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item active">Orders</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Manage Orders</div>
    </div>
    <div class="card-body" style="padding:8px 16px">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $i => $order): ?>
                            <tr>
                                <td><?= $i + 1 + (($pager->getCurrentPage() - 1) * $pager->getPerPage()) ?></td>
                                <td><strong>#<?= esc($order->id) ?></strong></td>
                                <td><?= esc($order->username ?? $order->email ?? 'Guest') ?></td>
                                <td>Rp <?= number_format($order->total ?? 0, 0, ',', '.') ?></td>
                                <td>
                                    <?php $sc = match($order->status ?? 'pending') {
                                        'paid','completed' => 'bg-success', 'pending' => 'bg-warning',
                                        'processing' => 'bg-info', 'cancelled' => 'bg-danger',
                                        default => 'bg-secondary'
                                    }; ?>
                                    <span class="badge <?= $sc ?>"><?= ucfirst(esc($order->status ?? 'pending')) ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($order->created_at ?? '')) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center py-4">Belum ada order</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <?= $pager ? $pager->links() : '' ?>
    </div>
</div>

<?= $this->endSection() ?>
