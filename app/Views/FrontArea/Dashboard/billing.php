<?= $this->extend('Layout/layout_clientarea') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="container">
        <h1>Billing</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Billing</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <?php if (empty($billings)): ?>
            <div class="alert alert-info">Belum ada tagihan.</div>
        <?php else: ?>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($billings as $billing): ?>
                                    <tr>
                                        <td><?= esc($billing->invoice_number ?? $billing->id) ?></td>
                                        <td><?= esc($billing->username ?? 'Guest') ?></td>
                                        <td>Rp <?= number_format($billing->total ?? 0, 0, ',', '.') ?></td>
                                        <td>
                                            <?php $st = match($billing->status ?? 'unpaid') {
                                                'paid' => 'success', 'unpaid' => 'warning',
                                                'expired' => 'danger', 'cancelled' => 'secondary',
                                                default => 'secondary'
                                            }; ?>
                                            <span class="badge bg-<?= $st ?>"><?= ucfirst($billing->status ?? 'unpaid') ?></span>
                                        </td>
                                        <td><?= date('d M Y', strtotime($billing->created_at ?? 'now')) ?></td>
                                        <td>
                                            <a href="/billing/<?= esc($billing->uuid ?? $billing->id) ?>" class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
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