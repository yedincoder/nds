<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Payments</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item active">Payments</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Manage Payments</div>
    </div>
    <div class="card-body" style="padding:8px 16px">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($payments)): ?>
                        <?php foreach ($payments as $i => $payment): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($payment->invoice_number ?? $payment->invoice_id ?? '-') ?></td>
                                <td><?= esc($payment->username ?? $payment->email ?? 'Guest') ?></td>
                                <td>Rp <?= number_format($payment->amount ?? 0, 0, ',', '.') ?></td>
                                <td>
                                    <?php $sc = match($payment->status ?? 'pending') {
                                        'success' => 'bg-success', 'pending' => 'bg-warning',
                                        'failed' => 'bg-danger', default => 'bg-secondary'
                                    }; ?>
                                    <span class="badge <?= $sc ?>"><?= ucfirst($payment->status ?? 'pending') ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($payment->created_at ?? '')) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center py-4">Belum ada pembayaran</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <?= isset($pager) ? $pager->links() : '' ?>
    </div>
</div>

<?= $this->endSection() ?>