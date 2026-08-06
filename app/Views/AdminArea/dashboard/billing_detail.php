<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3><?= esc($billing->invoice_number ?? '') ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item"><a href="/admin/billing">Billing</a></li>
            <li class="breadcrumb-item active"><?= esc($billing->invoice_number ?? '') ?></li>
        </ol>
    </nav>
</div>

<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Invoice Detail</div>
                <?php $sc = match($billing->status ?? 'unpaid') {
                    'paid' => 'bg-success', 'unpaid' => 'bg-warning',
                    'expired' => 'bg-danger', 'cancelled' => 'bg-secondary',
                    default => 'bg-secondary'
                }; ?>
                <span class="badge <?= $sc ?>"><?= ucfirst($billing->status ?? 'unpaid') ?></span>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Customer</p>
                        <p class="mb-0 fw-bold"><?= esc($billing->username ?? 'N/A') ?></p>
                        <p class="mb-0 small text-muted"><?= esc($billing->email ?? '') ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Issued / Due</p>
                        <p class="mb-0"><?= date('d M Y', strtotime($billing->created_at ?? '')) ?> / <?= !empty($billing->due_date) ? date('d M Y', strtotime($billing->due_date)) : '-' ?></p>
                    </div>
                </div>

                <h5 style="font-size:14px;font-weight:600;margin:16px 0">Items</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr><th>Item</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($items)): ?>
                                <?php foreach ($items as $item): ?>
                                <tr>
                                    <td><?= esc($item->description ?? $item->name ?? '-') ?></td>
                                    <td><?= esc($item->qty ?? $item->quantity ?? 1) ?></td>
                                    <td>Rp <?= number_format($item->price ?? $item->unit_price ?? 0, 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format($item->subtotal ?? $item->total ?? (($item->price ?? 0) * ($item->qty ?? 1)), 0, ',', '.') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center py-3">No items</td></tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total</strong></td>
                                <td><strong>Rp <?= number_format($billing->total ?? 0, 0, ',', '.') ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Payments</div>
            </div>
            <div class="card-body">
                <?php if (!empty($payments)): ?>
                    <?php foreach ($payments as $pm): ?>
                    <div class="py-2 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong style="font-size:13px">Rp <?= number_format($pm->amount ?? 0, 0, ',', '.') ?></strong>
                                <br><small class="text-muted"><?= date('d M Y H:i', strtotime($pm->created_at ?? '')) ?></small>
                            </div>
                            <?php $pc = match($pm->status ?? '') {
                                'success' => 'bg-success', 'pending' => 'bg-warning',
                                'failed' => 'bg-danger', default => 'bg-secondary'
                            }; ?>
                            <span class="badge <?= $pc ?>"><?= ucfirst($pm->status ?? '') ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center">Belum ada pembayaran</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>