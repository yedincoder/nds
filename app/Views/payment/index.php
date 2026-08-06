<?= $this->extend('Layout/layout_clientarea') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="container">
        <h1>Payment History</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Payment History</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <?php if (empty($payments)): ?>
            <div class="alert alert-info">Belum ada pembayaran.</div>
        <?php else: ?>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Method</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($payments as $payment): ?>
                                    <tr>
                                        <td><?= esc($payment->invoice_number ?? $payment->invoice_id ?? '-') ?></td>
                                        <td><?= esc($payment->payment_method ?? $payment->method ?? '-') ?></td>
                                        <td>Rp <?= number_format($payment->amount ?? 0, 0, ',', '.') ?></td>
                                        <td>
                                            <?php $st = match($payment->status ?? '') {
                                                'success','paid','settlement' => 'success',
                                                'pending' => 'warning',
                                                'failed','expire','cancel' => 'danger',
                                                default => 'secondary'
                                            }; ?>
                                            <span class="badge bg-<?= $st ?>"><?= ucfirst(str_replace('_', ' ', $payment->status ?? 'unknown')) ?></span>
                                        </td>
                                        <td><?= date('d M Y H:i', strtotime($payment->created_at ?? 'now')) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>

