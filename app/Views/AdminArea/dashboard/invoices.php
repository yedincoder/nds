<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Invoices</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item active">Invoices</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Manage Invoices</div>
    </div>
    <div class="card-body" style="padding:8px 16px">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Invoice Number</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($invoices)): ?>
                        <?php foreach ($invoices as $i => $invoice): ?>
                            <tr>
                                <td><?= $i + 1 + (($pager->getCurrentPage() - 1) * $pager->getPerPage()) ?></td>
                                <td><strong><?= esc($invoice->invoice_number ?? '#' . $invoice->id) ?></strong></td>
                                <td><?= esc($invoice->username ?? 'N/A') ?></td>
                                <td>Rp <?= number_format($invoice->total ?? 0, 0, ',', '.') ?></td>
                                <td>
                                    <?php $ic = match($invoice->status ?? 'draft') {
                                        'paid' => 'bg-success', 'unpaid' => 'bg-warning',
                                        'expired' => 'bg-danger', default => 'bg-secondary'
                                    }; ?>
                                    <span class="badge <?= $ic ?>"><?= ucfirst(esc($invoice->status ?? 'draft')) ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($invoice->created_at ?? '')) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center py-4">Belum ada invoice</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <?= $pager ? $pager->links() : '' ?>
    </div>
</div>

<?= $this->endSection() ?>
