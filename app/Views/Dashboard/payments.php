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
        <div class="btn-group">
            <button class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
            <button class="btn btn-sm btn-outline-secondary" data-filter="success">Success</button>
            <button class="btn btn-sm btn-outline-secondary" data-filter="pending">Pending</button>
            <button class="btn btn-sm btn-outline-secondary" data-filter="failed">Failed</button>
        </div>
    </div>
    <div class="card-body">
        <?php if (!empty($payments)): ?>
        <div class="table-responsive">
            <table class="table table-hover" id="paymentsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Invoice #</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Reference</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment): ?>
                    <tr data-status="<?= esc($payment->status ?? '') ?>">
                        <td><strong>#<?= esc($payment->id ?? '') ?></strong></td>
                        <td><?= esc($payment->username ?? 'Guest') ?></td>
                        <td><?= esc($payment->invoice_id ?? '-') ?></td>
                        <td>Rp <?= number_format($payment->amount ?? 0, 0, ',', '.') ?></td>
                        <td><?= esc(ucfirst($payment->payment_method ?? 'N/A')) ?></td>
                        <td>
                            <?php
                            $statusClass = match(strtolower($payment->status ?? '')) {
                                'success', 'paid' => 'bg-success',
                                'pending' => 'bg-warning text-dark',
                                'failed' => 'bg-danger',
                                'cancelled' => 'bg-secondary',
                                'refunded' => 'bg-info',
                                default => 'bg-secondary'
                            };
                            ?>
                            <span class="badge <?= $statusClass ?>"><?= esc(ucfirst($payment->status ?? 'pending')) ?></span>
                        </td>
                        <td><?= esc($payment->payment_reference ?? '-') ?></td>
                        <td><?= date('d M Y H:i', strtotime($payment->created_at ?? date('Y-m-d H:i:s'))) ?></td>
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
            <i class="fas fa-credit-card fa-3x mb-3" style="color: var(--text-primary); opacity: 0.3;"></i>
            <h5>No Payment Transactions Yet</h5>
            <p class="text-muted">Payment transactions will appear here when customers make a purchase.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Payment filter
    document.querySelectorAll('[data-filter]').forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.dataset.filter;
            
            // Toggle active state
            document.querySelectorAll('[data-filter]').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Filter rows
            document.querySelectorAll('#paymentsTable tbody tr').forEach(row => {
                if (filter === 'all' || row.dataset.status === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>