<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Billing</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item active">Billing</li>
        </ol>
    </nav>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:var(--primary-soft);color:var(--primary)"><i class="fas fa-file-invoice"></i></div>
                    <div class="kpi-label">Total Invoices</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['total'] ?? 0) ?></div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:rgba(16,185,129,.12);color:#059669"><i class="fas fa-check-circle"></i></div>
                    <div class="kpi-label">Paid</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['paid'] ?? 0) ?></div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:rgba(245,158,11,.14);color:#b45309"><i class="fas fa-hourglass-half"></i></div>
                    <div class="kpi-label">Unpaid</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['unpaid'] ?? 0) ?></div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:rgba(16,185,129,.12);color:#059669"><i class="fas fa-money-bill-wave"></i></div>
                    <div class="kpi-label">Revenue</div>
                </div>
            </div>
            <div class="kpi-value">Rp <?= number_format($stats['total_revenue'] ?? 0, 0, ',', '.') ?></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Manage Billing</div>
    </div>
    <div class="card-body" style="padding:8px 16px">
        <form method="get" class="row g-2 mb-3 align-items-end">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search invoice/customer..." value="<?= esc($search ?? '') ?>">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="" <?= empty($current_status) ? 'selected' : '' ?>>All Status</option>
                    <option value="paid" <?= ($current_status ?? '') === 'paid' ? 'selected' : '' ?>>Paid</option>
                    <option value="unpaid" <?= ($current_status ?? '') === 'unpaid' ? 'selected' : '' ?>>Unpaid</option>
                    <option value="expired" <?= ($current_status ?? '') === 'expired' ? 'selected' : '' ?>>Expired</option>
                    <option value="cancelled" <?= ($current_status ?? '') === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100"><i class="fas fa-search me-1"></i>Filter</button>
            </div>
            <div class="col-md-2">
                <a href="/admin/billing" class="btn btn-secondary w-100">Reset</a>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Invoice #</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($billings)): ?>
                        <?php foreach ($billings as $i => $billing): ?>
                            <tr>
                                <td><?= $i + 1 + (($pager->getCurrentPage() - 1) * $pager->getPerPage()) ?></td>
                                <td><strong><?= esc($billing->invoice_number ?? $billing->id) ?></strong></td>
                                <td><?= esc($billing->username ?? $billing->email ?? 'Guest') ?></td>
                                <td>Rp <?= number_format($billing->total ?? 0, 0, ',', '.') ?></td>
                                <td>
                                    <?php $sc = match($billing->status ?? 'unpaid') {
                                        'paid' => 'bg-success', 'unpaid' => 'bg-warning',
                                        'expired' => 'bg-danger', 'cancelled' => 'bg-secondary',
                                        default => 'bg-secondary'
                                    }; ?>
                                    <span class="badge <?= $sc ?>"><?= ucfirst($billing->status ?? 'unpaid') ?></span>
                                </td>
                                <td><?= !empty($billing->due_date) ? date('d M Y', strtotime($billing->due_date)) : '-' ?></td>
                                <td>
                                    <a href="/admin/billing/<?= esc($billing->uuid ?? $billing->id) ?>" class="btn btn-sm btn-outline-primary">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center py-4">No billing records found</td></tr>
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