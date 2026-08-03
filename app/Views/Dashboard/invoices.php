<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Invoices</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Invoices</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Manage Invoices</h5>
        <button class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i> Create Invoice</button>
    </div>
    <div class="card-body">
        <?php if (!empty($invoices)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoices as $invoice): ?>
                    <tr>
                        <td><strong><?= esc($invoice->invoice_number ?? '#' . $invoice->id) ?></strong></td>
                        <td><?= esc($invoice->user_name ?? $invoice->username ?? 'N/A') ?></td>
                        <td>Rp <?= number_format($invoice->total ?? 0, 0, ',', '.') ?></td>
                        <td>
                            <?php
                            $statusClass = match($invoice->status ?? '') {
                                'paid' => 'bg-success',
                                'unpaid' => 'bg-warning text-dark',
                                'overdue', 'expired' => 'bg-danger',
                                'draft' => 'bg-secondary',
                                'refunded' => 'bg-info',
                                default => 'bg-secondary'
                            };
                            ?>
                            <span class="badge <?= $statusClass ?>"><?= ucfirst(esc($invoice->status ?? 'draft')) ?></span>
                        </td>
                        <td><?= isset($invoice->due_date) ? date('d M Y', strtotime($invoice->due_date)) : '-' ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="#" class="btn btn-sm btn-outline-info" title="View"><i class="fas fa-eye"></i></a>
                                <a href="#" class="btn btn-sm btn-outline-primary" title="Print"><i class="fas fa-print"></i></a>
                                <a href="#" class="btn btn-sm btn-outline-success" title="Download"><i class="fas fa-download"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <?php if (isset($pager)): ?>
        <div class="d-flex justify-content-end mt-3">
            <?= $pager->links() ?>
        </div>
        <?php endif; ?>
        
        <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-file-invoice fa-3x mb-3" style="color: var(--text-primary); opacity: 0.3;"></i>
            <h5>No Invoices Yet</h5>
            <p class="text-muted">Invoices will appear here when orders are created.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>