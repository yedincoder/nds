<?= $this->extend('ClientArea/layout') ?>

<?= $this->section('content') ?>

<h3>Dashboard</h3>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <h3><?= $stats['orders'] ?? 0 ?></h3>
            <p><i class="fas fa-shopping-cart me-2"></i>Total Orders</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="border-left-color: #3498DB;">
            <h3><?= $stats['invoices'] ?? 0 ?></h3>
            <p><i class="fas fa-file-invoice me-2"></i>Total Invoices</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="border-left-color: #E74C3C;">
            <h3><?= $stats['tickets'] ?? 0 ?></h3>
            <p><i class="fas fa-headset me-2"></i>Support Tickets</p>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-xl-6 col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Recent Orders</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_orders)): ?>
                <table class="table table-hover">
                    <thead><tr><th>Order #</th><th>Total</th><th>Status</th><th>Date</th></tr></thead>
                    <tbody>
                    <?php foreach ($recent_orders as $order): ?>
                    <tr>
                        <td>#<?= esc($order->order_number ?? $order->id ?? '') ?></td>
                        <td>Rp <?= number_format($order->total ?? 0, 0, ',', '.') ?></td>
                        <td><span class="badge bg-info"><?= esc(ucfirst($order->status ?? '')) ?></span></td>
                        <td><?= date('d M Y', strtotime($order->created_at ?? '')) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p class="text-muted text-center py-3">No orders yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Unpaid Invoices</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($unpaid_invoices)): ?>
                <?php foreach ($unpaid_invoices as $inv): ?>
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <strong>#<?= esc($inv->invoice_number ?? $inv->id ?? '') ?></strong>
                        <br><small class="text-muted">Rp <?= number_format($inv->total ?? 0, 0, ',', '.') ?></small>
                    </div>
                    <a href="<?= site_url('payment/' . ($inv->invoice_number ?? $inv->id)) ?>" class="btn btn-sm btn-outline-primary">Pay Now</a>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p class="text-muted text-center py-3">No unpaid invoices</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
