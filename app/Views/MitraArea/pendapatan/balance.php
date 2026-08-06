<?= $this->extend('Layout/layout_mitraarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Saldo</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/mitra/dashboard">Mitra</a></li>
            <li class="breadcrumb-item active">Saldo</li>
        </ol>
    </nav>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="kpi-icon" style="background:var(--primary-soft);color:var(--primary)"><i class="fas fa-wallet"></i></div>
            <h3>Rp <?= number_format($wallet->balance ?? 0, 0, ',', '.') ?></h3>
            <p>Saldo Tersedia</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="kpi-icon" style="background:rgba(245,158,11,.14);color:#b45309"><i class="fas fa-clock"></i></div>
            <h3>Rp <?= number_format($wallet->pending_balance ?? 0, 0, ',', '.') ?></h3>
            <p>Saldo Pending</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="kpi-icon" style="background:rgba(16,185,129,.12);color:#059669"><i class="fas fa-arrow-up"></i></div>
            <h3>Rp <?= number_format($wallet->total_withdrawn ?? 0, 0, ',', '.') ?></h3>
            <p>Total Penarikan</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Riwayat Transaksi</div>
    </div>
    <div class="card-body" style="padding:8px 16px">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Tipe</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transactions)): ?>
                        <?php foreach ($transactions as $i => $tx): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td>#<?= esc($tx->id) ?></td>
                                <td><span class="badge bg-info"><?= esc(ucfirst($tx->type ?? 'commission')) ?></span></td>
                                <td>Rp <?= number_format($tx->amount ?? 0, 0, ',', '.') ?></td>
                                <td>
                                    <?php $sc = match($tx->status ?? '') {
                                        'paid','completed' => 'bg-success',
                                        'pending' => 'bg-warning',
                                        'cancelled' => 'bg-danger',
                                        default => 'bg-secondary'
                                    }; ?>
                                    <span class="badge <?= $sc ?>"><?= esc(ucfirst($tx->status ?? 'pending')) ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($tx->created_at ?? '')) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center py-4">Belum ada transaksi</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>