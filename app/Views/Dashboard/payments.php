<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Payments (Midtrans)</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Payments</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Payment Transactions</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($payments)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Invoice #</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment): ?>
                    <tr>
                        <td><strong>#<?= esc($payment->id ?? '') ?></strong></td>
                        <td><?= esc($payment->username ?? 'N/A') ?></td>
                        <td><?= esc($payment->invoice_id ?? '-') ?></td>
                        <td>Rp <?= number_format($payment->amount ?? 0, 0, ',', '.') ?></td>
                        <td><span class="badge bg-success"><?= esc($payment->status ?? 'pending') ?></span></td>
                        <td><?= date('d M Y', strtotime($payment->created_at ?? date('Y-m-d'))) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-credit-card fa-3x mb-3" style="color: var(--text-primary); opacity: 0.3;"></i>
            <h5>No Payment Transactions Yet</h5>
            <p class="text-muted">Payment transactions will appear here when customers make a purchase.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>