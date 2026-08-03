<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Orders</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Orders</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Manage Orders</h5>
        <div class="btn-group">
            <button class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
            <button class="btn btn-sm btn-outline-secondary" data-filter="pending">Pending</button>
            <button class="btn btn-sm btn-outline-secondary" data-filter="completed">Completed</button>
            <button class="btn btn-sm btn-outline-secondary" data-filter="cancelled">Cancelled</button>
        </div>
    </div>
    <div class="card-body">
        <?php if (!empty($orders)): ?>
        <div class="table-responsive">
            <table class="table table-hover" id="ordersTable">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr data-status="<?= esc($order->status ?? '') ?>">
                        <td><strong><?= esc($order->order_number ?? '#' . $order->id) ?></strong></td>
                        <td><?= esc($order->username ?? $order->customer_name ?? 'N/A') ?></td>
                        <td>Rp <?= number_format($order->total ?? 0, 0, ',', '.') ?></td>
                        <td>
                            <?php
                            $statusClass = match($order->status ?? '') {
                                'paid', 'completed' => 'bg-success',
                                'pending' => 'bg-warning text-dark',
                                'processing' => 'bg-info',
                                'cancelled' => 'bg-danger',
                                'expired' => 'bg-secondary',
                                default => 'bg-secondary'
                            };
                            ?>
                            <span class="badge <?= $statusClass ?>"><?= ucfirst(esc($order->status ?? 'pending')) ?></span>
                        </td>
                        <td>
                            <?php
                            $payStatus = $order->payment_status ?? 'unpaid';
                            $payClass = $payStatus === 'paid' ? 'text-success' : ($payStatus === 'pending' ? 'text-warning' : 'text-danger');
                            ?>
                            <span class="<?= $payClass ?>"><i class="fas fa-circle me-1" style="font-size: 8px;"></i><?= ucfirst($payStatus) ?></span>
                        </td>
                        <td><?= date('d M Y H:i', strtotime($order->created_at ?? date('Y-m-d H:i:s'))) ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="#" class="btn btn-sm btn-outline-info" title="View"><i class="fas fa-eye"></i></a>
                                <a href="#" class="btn btn-sm btn-outline-primary" title="Invoice"><i class="fas fa-file-invoice"></i></a>
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
            <i class="fas fa-shopping-cart fa-3x mb-3" style="color: var(--text-primary); opacity: 0.3;"></i>
            <h5>No Orders Yet</h5>
            <p class="text-muted">Orders will appear here when customers make a purchase.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Order filter
    document.querySelectorAll('[data-filter]').forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.dataset.filter;
            
            // Toggle active state
            document.querySelectorAll('[data-filter]').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Filter rows
            document.querySelectorAll('#ordersTable tbody tr').forEach(row => {
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