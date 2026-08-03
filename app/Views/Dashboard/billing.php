<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Billing</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Billing</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Billing Records</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($billings)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($billings as $billing): ?>
                    <tr>
                        <td><strong>#<?= esc($billing->id ?? '') ?></strong></td>
                        <td><?= esc($billing->username ?? 'N/A') ?></td>
                        <td><?= esc($billing->total ?? 0) ?></td>
                        <td><?= esc($billing->status ?? 'pending') ?></td>
                        <td><?= date('d M Y', strtotime($billing->created_at ?? date('Y-m-d'))) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-file-invoice-dollar fa-3x mb-3" style="color: var(--text-primary); opacity: 0.3;"></i>
            <p>No billing records found.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>