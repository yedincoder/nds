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

<!-- Stats Cards - 1 row x 4 columns -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:var(--primary-soft);color:var(--primary)"><i class="fas fa-users"></i></div>
                    <div class="kpi-label">Customers</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['total_customers'] ?? 0) ?></div>
            <div class="kpi-subtext">Total pelanggan terdaftar</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:rgba(56,189,248,.12);color:#0284c7"><i class="fas fa-shopping-cart"></i></div>
                    <div class="kpi-label">Orders</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['total_orders'] ?? 0) ?></div>
            <div class="kpi-subtext"><?= $stats['pending_orders'] ?? 0 ?> pending</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:rgba(16,185,129,.12);color:#059669"><i class="fas fa-money-bill-wave"></i></div>
                    <div class="kpi-label">Revenue</div>
                </div>
            </div>
            <div class="kpi-value">Rp <?= number_format($stats['total_revenue'] ?? 0, 0, ',', '.') ?></div>
            <div class="kpi-subtext"><?= $stats['total_payments'] ?? 0 ?> pembayaran sukses</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:rgba(245,158,11,.14);color:#b45309"><i class="fas fa-clock"></i></div>
                    <div class="kpi-label">Pending Orders</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['pending_orders'] ?? 0) ?></div>
            <div class="kpi-subtext"><?= $stats['pending_invoices'] ?? 0 ?> invoice belum bayar</div>
        </div>
    </div>
</div>

<!-- Stats Cards - row 2 -->
<div class="row mb-4">    
    <div class="col-xl-3 col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:var(--primary-soft);color:var(--primary)"><i class="fas fa-box"></i></div>
                    <div class="kpi-label">Products</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['total_products'] ?? 0) ?></div>
            <div class="kpi-subtext">Produk aktif</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:var(--primary-soft);color:var(--primary)"><i class="fas fa-cogs"></i></div>
                    <div class="kpi-label">Services</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['total_services'] ?? 0) ?></div>
            <div class="kpi-subtext">Layanan aktif</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:rgba(239,68,68,.12);color:#dc2626"><i class="fas fa-headset"></i></div>
                    <div class="kpi-label">Open Tickets</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['pending_tickets'] ?? 0) ?></div>
            <div class="kpi-subtext">Ticket belum selesai</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:var(--primary-soft);color:var(--primary)"><i class="fas fa-quote-left"></i></div>
                    <div class="kpi-label">Testimonials</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['total_testimonials'] ?? 0) ?></div>
            <div class="kpi-subtext">Testimoni disetujui</div>
        </div>
    </div>
</div>

<!-- Revenue Chart & Order Status -->
<div class="row mb-4">
    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Revenue (6 Bulan Terakhir)</div>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-5">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Order Status</div>
            </div>
            <div class="card-body">
                <?php
                $orderColors = [
                    'completed' => '#059669', 'paid' => '#059669',
                    'processing' => '#0284c7', 'pending' => '#d97706',
                    'waiting_payment' => '#ea580c', 'cancelled' => '#dc2626',
                    'expired' => '#64748b',
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
                    $color = $orderColors[$status] ?? '#64748b';
                    $label = $orderLabels[$status] ?? ucfirst($status);
                ?>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span style="color:var(--t-base);font-size:13px"><?= $label ?></span>
                        <span style="color:<?= $color ?>;font-size:13px"><?= $count ?> (<?= $pct ?>%)</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width:<?= $pct ?>%; background:<?= $color ?>"></div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php if (empty($orderStatus)): ?>
                <p class="text-muted text-center">Belum ada order</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders & Payments -->
<div class="row mb-4">
    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Recent Orders</div>
                <a href="/admin/orders" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body" style="padding:8px 16px">
                <?php if (!empty($recentOrders)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
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
                                        'paid','completed' => 'bg-success', 'pending' => 'bg-warning',
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
                <div class="text-center py-4"><p class="mb-0">Belum ada order</p></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Recent Payments</div>
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
                        'success' => 'bg-success', 'pending' => 'bg-warning',
                        'failed' => 'bg-danger', default => 'bg-secondary'
                    }; ?>
                    <span class="badge <?= $pmc ?>"><?= ucfirst($pm->status ?? '') ?></span>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p class="text-muted text-center">Belum ada pembayaran</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Recent Invoices & Tickets -->
<div class="row mb-4">
    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Recent Invoices</div>
                <a href="/admin/invoices" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body" style="padding:8px 16px">
                <?php if (!empty($recentInvoices)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
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
                                        'paid' => 'bg-success', 'unpaid' => 'bg-warning',
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
                <p class="text-muted text-center">Belum ada invoice</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-5">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Recent Tickets</div>
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
                        'open' => 'bg-warning', 'waiting_response' => 'bg-info',
                        'resolved' => 'bg-success', 'closed' => 'bg-secondary',
                        default => 'bg-secondary'
                    }; ?>
                    <span class="badge <?= $tkc ?>"><?= ucfirst(str_replace('_', ' ', $tk->status ?? '')) ?></span>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p class="text-muted text-center">Belum ada ticket</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Testimonials & Top Products & Recent Activity -->
<div class="row mb-4">
    <div class="col-xl-4 col-lg-5">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Recent Testimonials</div>
                <a href="/admin/testimonials" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if (!empty($recentTestimonials)): ?>
                <?php foreach ($recentTestimonials as $tm): ?>
                <div class="py-2 border-bottom">
                    <div class="d-flex align-items-center mb-1">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star" style="font-size:11px; color:<?= $i <= ($tm->rating ?? 5) ? '#f59e0b' : '#e2e8f0' ?>"></i>
                        <?php endfor; ?>
                        <span class="ms-2 fw-bold" style="font-size:13px"><?= esc($tm->customer_name ?? '') ?></span>
                        <?php $tmc = match($tm->status ?? '') {
                            'approved' => 'bg-success', 'rejected' => 'bg-danger', default => 'bg-warning'
                        }; ?>
                        <span class="badge <?= $tmc ?> ms-2" style="font-size:10px"><?= ucfirst($tm->status ?? '') ?></span>
                    </div>
                    <p class="mb-0 text-muted" style="font-size:12px; line-height:1.5"><?= esc(substr($tm->message ?? '', 0, 80)) ?>...</p>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p class="text-muted text-center">Belum ada testimoni</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-7">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Top Products</div>
                <a href="/admin/products" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body" style="padding:8px 16px">
                <?php if (!empty($topProducts)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
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
                <p class="text-muted text-center">Belum ada produk</p>
                <?php endif; ?>
            </div>
        </div>
        
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Recent Activity</div>
            </div>
            <div class="card-body" style="padding:8px 16px">
                <?php if (!empty($recentActivity)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
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
                <p class="text-muted text-center">Belum ada aktivitas</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
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
                callbacks: { label: ctx => 'Rp ' + ctx.raw.toLocaleString('id-ID') }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') },
                grid: { color: 'rgba(0,0,0,0.05)' }
            },
            x: { grid: { display: false } }
        }
    }
});
</script>
<?= $this->endSection() ?>
