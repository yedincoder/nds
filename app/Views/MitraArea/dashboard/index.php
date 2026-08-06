<?= $this->extend('Layout/layout_mitraarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Dashboard Mitra</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/mitra/dashboard">Mitra</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="kpi-icon" style="background:var(--primary-soft);color:var(--primary)"><i class="fas fa-shopping-bag"></i></div>
            <h3><?= number_format($stats['total_orders'] ?? 0) ?></h3>
            <p>Total Pesanan</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="kpi-icon" style="background:rgba(16,185,129,.12);color:#059669"><i class="fas fa-check-circle"></i></div>
            <h3><?= number_format($stats['success_orders'] ?? 0) ?></h3>
            <p>Pesanan Berhasil</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="kpi-icon" style="background:rgba(245,158,11,.14);color:#b45309"><i class="fas fa-times-circle"></i></div>
            <h3><?= number_format($stats['cancelled_orders'] ?? 0) ?></h3>
            <p>Dibatalkan</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="kpi-icon" style="background:rgba(16,185,129,.12);color:#059669"><i class="fas fa-money-bill-wave"></i></div>
            <h3>Rp <?= number_format($stats['total_commission'] ?? 0, 0, ',', '.') ?></h3>
            <p>Total Komisi</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="kpi-icon" style="background:rgba(245,158,11,.14);color:#b45309"><i class="fas fa-clock"></i></div>
            <h3>Rp <?= number_format($stats['pending_commission'] ?? 0, 0, ',', '.') ?></h3>
            <p>Komisi Pending</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="kpi-icon" style="background:var(--primary-soft);color:var(--primary)"><i class="fas fa-wallet"></i></div>
            <h3>Rp <?= number_format($stats['balance'] ?? 0, 0, ',', '.') ?></h3>
            <p>Saldo Tersedia</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-2 mb-4">
    <div class="col-6 col-md-3">
        <a href="/mitra/ecommerce/products" class="quick-action-card">
            <i class="fas fa-box"></i>
            <span>Produk</span>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="/mitra/ecommerce/orders" class="quick-action-card">
            <i class="fas fa-shopping-bag"></i>
            <span>Pesanan</span>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="/mitra/pendapatan/balance" class="quick-action-card">
            <i class="fas fa-wallet"></i>
            <span>Saldo</span>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="/mitra/akun/profile" class="quick-action-card">
            <i class="fas fa-user"></i>
            <span>Profil</span>
        </a>
    </div>
</div>

<!-- Recent Orders -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Pesanan Terbaru</div>
                <a href="/mitra/orders" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body" style="padding:8px 16px">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Komisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recentOrders)): ?>
                                <?php foreach ($recentOrders as $order): ?>
                                <tr>
                                    <td><strong>#<?= esc($order->order_number ?? '#' . $order->id) ?></strong></td>
                                    <td><?= esc($order->username ?? 'N/A') ?></td>
                                    <td>Rp <?= number_format($order->total ?? 0, 0, ',', '.') ?></td>
                                    <td>
                                        <?php $sc = match($order->status ?? '') {
                                            'paid','completed' => 'bg-success',
                                            'pending','waiting_payment' => 'bg-warning',
                                            'cancelled','expired' => 'bg-danger',
                                            default => 'bg-secondary'
                                        }; ?>
                                        <span class="badge <?= $sc ?>"><?= ucfirst(str_replace('_', ' ', $order->status ?? 'pending')) ?></span>
                                    </td>
                                    <td><?= date('d M Y', strtotime($order->created_at ?? $order->order_created_at ?? 'now')) ?></td>
                                    <td>Rp <?= number_format($order->commission ?? 0, 0, ',', '.') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center py-4">Belum ada pesanan</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Charts can be added here
});
</script>
<?= $this->endSection() ?>