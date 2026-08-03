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
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card" style="border-left: 4px solid #E65C00;">
            <h3 style="color:#E65C00"><?= number_format($stats['total_customers'] ?? 0) ?></h3>
            <p><i class="fas fa-users me-2"></i>Customers</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card" style="border-left: 4px solid #3498DB;">
            <h3 style="color:#3498DB"><?= number_format($stats['total_orders'] ?? 0) ?></h3>
            <p><i class="fas fa-shopping-cart me-2"></i>Total Orders</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card" style="border-left: 4px solid #26B99A;">
            <h3 style="color:#26B99A">Rp <?= number_format($stats['total_revenue'] ?? 0, 0, ',', '.') ?></h3>
            <p><i class="fas fa-money-bill me-2"></i>Revenue</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card" style="border-left: 4px solid #F39C12;">
            <h3 style="color:#F39C12"><?= number_format($stats['pending_orders'] ?? 0) ?></h3>
            <p><i class="fas fa-clock me-2"></i>Pending Orders</p>
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card" style="border-left: 4px solid #8E44AD;">
            <h3 style="color:#8E44AD"><?= number_format($stats['total_products'] ?? 0) ?></h3>
            <p><i class="fas fa-box me-2"></i>Products</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card" style="border-left: 4px solid #E67E22;">
            <h3 style="color:#E67E22"><?= number_format($stats['total_services'] ?? 0) ?></h3>
            <p><i class="fas fa-cogs me-2"></i>Services</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card" style="border-left: 4px solid #E74C3C;">
            <h3 style="color:#E74C3C"><?= number_format($stats['pending_tickets'] ?? 0) ?></h3>
            <p><i class="fas fa-headset me-2"></i>Open Tickets</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card" style="border-left: 4px solid #1ABC9C;">
            <h3 style="color:#1ABC9C"><?= number_format($stats['total_testimonials'] ?? 0) ?></h3>
            <p><i class="fas fa-quote-left me-2"></i>Testimonials</p>
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
                <a href="/admin/products/create" class="btn btn-outline-primary me-2 mb-2"><i class="fas fa-plus me-1"></i> Product</a>
                <a href="/admin/services" class="btn btn-outline-primary me-2 mb-2"><i class="fas fa-cogs me-1"></i> Service</a>
                <a href="/admin/portfolio" class="btn btn-outline-primary me-2 mb-2"><i class="fas fa-briefcase me-1"></i> Portfolio</a>
                <a href="/admin/testimonials" class="btn btn-outline-primary me-2 mb-2"><i class="fas fa-quote-left me-1"></i> Testimonials</a>
                <a href="/admin/cms/pages/create" class="btn btn-outline-primary me-2 mb-2"><i class="fas fa-file-alt me-1"></i> Add Page</a>
                <a href="/admin/cms/articles/create" class="btn btn-outline-primary me-2 mb-2"><i class="fas fa-newspaper me-1"></i> Add Article</a>
                <a href="/admin/customers" class="btn btn-outline-primary me-2 mb-2"><i class="fas fa-users me-1"></i> Customers</a>
                <a href="/admin/reports" class="btn btn-outline-primary me-2 mb-2"><i class="fas fa-chart-line me-1"></i> Reports</a>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Chart & Order Status -->
<div class="row mb-4">
    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Revenue (6 Bulan Terakhir)</h5>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-5">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Order Status</h5>
            </div>
            <div class="card-body">
                <?php
                $orderColors = [
                    'completed' => '#26B99A', 'paid' => '#26B99A',
                    'processing' => '#3498DB', 'pending' => '#F39C12',
                    'waiting_payment' => '#E67E22', 'cancelled' => '#E74C3C',
                    'expired' => '#95A5A6',
                ];
                $orderLabels = [
                    'completed' => 'Completed', 'paid' => 'Paid',
                    'processing' => 'Processing', 'pending' => 'Pending',
                    'waiting_payment' => 'Waiting Payment', 'cancelled' => 'Cancelled',
                    'expired' => 'Expired',
                ];
                $totalOrders = array_sum($orderStatus) ?: 1;
                foreach ($orderStatus as $status => $count):
                    $pct = round(($count / $totalOrders) * 100);
                    $color = $orderColors[$status] ?? '#95A5A6';
                    $label = $orderLabels[$status] ?? ucfirst($status);
                ?>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span><?= $label ?></span>
                        <span style="color:<?= $color ?>"><?= $count ?> (<?= $pct ?>%)</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar" style="width:<?= $pct ?>%; background:<?= $color ?>"></div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php if (empty($orderStatus)): ?>
                <p class="text-muted text-center">No orders yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="row mb-4">
    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Orders</h5>
                <a href="/admin/orders" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if (!empty($recentOrders)): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr><th>Order #</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentOrders as $order): ?>
                            <tr>
                                <td><strong><?= esc($order->order_number ?? '#' . $order->id) ?></strong></td>
                                <td><?= esc($order->username ?? 'N/A') ?></td>
                                <td>Rp <?= number_format($order->total ?? 0, 0, ',', '.') ?></td>
                                <td>
                                    <?php $sc = match($order->status ?? '') {
                                        'paid','completed' => 'bg-success', 'pending' => 'bg-warning text-dark',
                                        'processing' => 'bg-info', 'cancelled' => 'bg-danger',
                                        default => 'bg-secondary'
                                    }; ?>
                                    <span class="badge <?= $sc ?>"><?= ucfirst(esc($order->status ?? 'pending')) ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($order->created_at)) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center py-4"><i class="fas fa-inbox fa-2x mb-2" style="color:#73879C;opacity:0.3;"></i><p class="mb-0">No recent orders</p></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Payments</h5>
                <a href="/admin/payments" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if (!empty($recentPayments)): ?>
                <?php foreach ($recentPayments as $pm): ?>
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <strong style="font-size:13px"><?= esc($pm->username ?? 'N/A') ?></strong>
                        <br><small class="text-muted">Rp <?= number_format($pm->amount ?? 0, 0, ',', '.') ?></small>
                    </div>
                    <?php $pmc = match($pm->status ?? '') {
                        'success' => 'bg-success', 'pending' => 'bg-warning text-dark',
                        'failed' => 'bg-danger', default => 'bg-secondary'
                    }; ?>
                    <span class="badge <?= $pmc ?>"><?= ucfirst($pm->status ?? '') ?></span>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p class="text-muted text-center">No payments yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Recent Invoices & Recent Tickets -->
<div class="row mb-4">
    <div class="col-xl-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Invoices</h5>
                <a href="/admin/invoices" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if (!empty($recentInvoices)): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr><th>Invoice #</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentInvoices as $inv): ?>
                            <tr>
                                <td><strong><?= esc($inv->invoice_number ?? '#' . $inv->id) ?></strong></td>
                                <td><?= esc($inv->username ?? 'N/A') ?></td>
                                <td>Rp <?= number_format($inv->total ?? 0, 0, ',', '.') ?></td>
                                <td>
                                    <?php $ic = match($inv->status ?? '') {
                                        'paid' => 'bg-success', 'unpaid' => 'bg-warning text-dark',
                                        'expired' => 'bg-danger', default => 'bg-secondary'
                                    }; ?>
                                    <span class="badge <?= $ic ?>"><?= ucfirst($inv->status ?? 'draft') ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($inv->created_at ?? '')) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted text-center">No invoices yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Tickets</h5>
                <a href="/admin/support" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if (!empty($recentTickets)): ?>
                <?php foreach ($recentTickets as $tk): ?>
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <strong style="font-size:13px"><?= esc($tk->subject ?? '') ?></strong>
                        <br><small class="text-muted"><?= esc($tk->username ?? '') ?> · <?= date('d M Y', strtotime($tk->created_at ?? '')) ?></small>
                    </div>
                    <?php $tkc = match($tk->status ?? '') {
                        'open' => 'bg-warning text-dark', 'waiting_response' => 'bg-info',
                        'resolved' => 'bg-success', 'closed' => 'bg-secondary',
                        default => 'bg-secondary'
                    }; ?>
                    <span class="badge <?= $tkc ?>"><?= ucfirst(str_replace('_', ' ', $tk->status ?? '')) ?></span>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p class="text-muted text-center">No tickets yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Recent Testimonials & Top Products -->
<div class="row mb-4">
    <div class="col-xl-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Testimonials</h5>
                <a href="/admin/testimonials" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if (!empty($recentTestimonials)): ?>
                <?php foreach ($recentTestimonials as $tm): ?>
                <div class="py-2 border-bottom">
                    <div class="d-flex align-items-center mb-1">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star" style="font-size:11px; color:<?= $i <= ($tm->rating ?? 5) ? '#F39C12' : '#ddd' ?>"></i>
                        <?php endfor; ?>
                        <span class="ms-2 fw-bold" style="font-size:13px"><?= esc($tm->customer_name ?? '') ?></span>
                        <?php $tmc = match($tm->status ?? '') {
                            'approved' => 'bg-success', 'rejected' => 'bg-danger', default => 'bg-warning text-dark'
                        }; ?>
                        <span class="badge <?= $tmc ?> ms-2" style="font-size:10px"><?= ucfirst($tm->status ?? '') ?></span>
                    </div>
                    <p class="mb-0 text-muted" style="font-size:12px; line-height:1.5"><?= esc(substr($tm->message ?? '', 0, 80)) ?>...</p>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p class="text-muted text-center">No testimonials yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Top Products</h5>
                <a href="/admin/products" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if (!empty($topProducts)): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr><th>Product</th><th>Sold</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($topProducts as $tp): ?>
                            <tr>
                                <td><strong><?= esc($tp->name ?? '') ?></strong></td>
                                <td><?= $tp->sold_count ?? 0 ?> orders</td>
                                <td>
                                    <?php $tpsc = match($tp->status ?? '') {
                                        'active' => 'bg-success', default => 'bg-secondary'
                                    }; ?>
                                    <span class="badge <?= $tpsc ?>"><?= ucfirst($tp->status ?? '') ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted text-center">No products yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Activity</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recentActivity)): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr><th>User</th><th>Action</th><th>Description</th><th>Time</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentActivity as $act): ?>
                            <tr>
                                <td><?= esc($act->username ?? 'System') ?></td>
                                <td><span class="badge bg-info"><?= esc($act->activity_type ?? '') ?></span></td>
                                <td><?= esc(substr($act->description ?? '', 0, 50)) ?></td>
                                <td class="text-nowrap"><?= date('d M H:i', strtotime($act->created_at ?? '')) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted text-center">No activity yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
const revenueData = <?= json_encode($revenueChart ?? []) ?>;
const labels = revenueData.map(d => d.month);
const values = revenueData.map(d => d.revenue);

new Chart(document.getElementById('revenueChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Revenue (Rp)',
            data: values,
            backgroundColor: 'rgba(230, 92, 0, 0.7)',
            borderColor: '#E65C00',
            borderWidth: 1,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => 'Rp ' + ctx.raw.toLocaleString('id-ID')
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: v => 'Rp ' + v.toLocaleString('id-ID')
                },
                grid: { color: 'rgba(0,0,0,0.05)' }
            },
            x: { grid: { display: false } }
        }
    }
});
</script>
<?= $this->endSection() ?>
