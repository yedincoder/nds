<?= $this->extend('Layout/layout_frontarea') ?>

<?= $this->section('content') ?>

<!-- 1. BAGIAN HEADER & BREADCRUMB (Sesuai Struktur) -->
<section class="page-header">
    <div class="container">
        <h1>Payment</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Payment</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h1 class="mb-4">Payment History</h1>

        <?php if (empty($payments)): ?>
            <div class="alert alert-info">No payment history found.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payments as $payment): ?>
                            <tr>
                                <td><?= esc($payment->invoice_number ?? $payment->invoice_id) ?></td>
                                <td><?= format_price($payment->amount) ?></td>
                                <td><?= esc($payment->payment_method_name ?? '-') ?></td>
                                <td>
                                    <span class="badge bg-<?= $payment->status === 'success' ? 'success' : ($payment->status === 'failed' ? 'danger' : 'warning') ?>">
                                        <?= esc(ucfirst($payment->status)) ?>
                                    </span>
                                </td>
                                <td><?= esc($payment->paid_at ?? $payment->created_at) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>