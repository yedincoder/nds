<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Dashboard</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card" style="border-left-color: #1ABB9C;">
            <h3><?= number_format($stats['total_customers'] ?? 0) ?></h3>
            <p><i class="fas fa-users me-2"></i>Total Customers</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card" style="border-left-color: #3498DB;">
            <h3><?= number_format($stats['total_orders'] ?? 0) ?></h3>
            <p><i class="fas fa-shopping-cart me-2"></i>Total Orders</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card" style="border-left-color: #E74C3C;">
            <h3><?= isset($stats['total_revenue']) ? 'Rp ' . number_format($stats['total_revenue'], 0, ',', '.') : 'Rp 0' ?></h3>
            <p><i class="fas fa-money-bill me-2"></i>Total Revenue</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card" style="border-left-color: #F39C12;">
            <h3><?= number_format($stats['pending_orders'] ?? 0) ?></h3>
            <p><i class="fas fa-clock me-2"></i>Pending Orders</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="/admin/products" class="btn btn-primary me-2 mb-2">
                    <i class="fas fa-plus me-1"></i> Add Product
                </a>
                <a href="/admin/customers" class="btn btn-primary me-2 mb-2">
                    <i class="fas fa-user-plus me-1"></i> Add Customer
                </a>
                <a href="/admin/orders" class="btn btn-primary me-2 mb-2">
                    <i class="fas fa-file-invoice me-1"></i> New Order
                </a>
                <a href="/admin/reports" class="btn btn-primary mb-2">
                    <i class="fas fa-chart-line me-1"></i> View Reports
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders & Activity -->
<div class="row">
    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Orders</h5>
                <a href="/admin/orders" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_orders)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_orders as $order): ?>
                            <tr>
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
                                        default => 'bg-secondary'
                                    };
                                    ?>
                                    <span class="badge <?= $statusClass ?>"><?= ucfirst(esc($order->status ?? 'pending')) ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($order->created_at)) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x mb-3" style="color: var(--text-primary); opacity: 0.3;"></i>
                    <p class="mb-0">No recent orders</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-lg-5">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Statistics</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Orders Completed</span>
                        <span class="text-success"><?= $stats['total_orders'] ?? 0 ?></span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: 75%"></div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Pending Invoices</span>
                        <span class="text-warning"><?= $stats['unpaid_invoices'] ?? 0 ?></span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: 25%"></div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Total Products</span>
                        <span class="text-info"><?= $stats['total_products'] ?? 0 ?></span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-info" style="width: 60%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Customer Growth</span>
                        <span class="text-primary">+15%</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar" style="width: 85%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Auto-refresh every 30 seconds
    // setTimeout(() => location.reload(), 30000);
</script>
<?= $this->endSection() ?>