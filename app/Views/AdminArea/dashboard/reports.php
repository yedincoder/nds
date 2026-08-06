<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Reports</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item active">Reports</li>
        </ol>
    </nav>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:var(--primary-soft);color:var(--primary)"><i class="fas fa-money-bill-wave"></i></div>
                    <div class="kpi-label">Revenue</div>
                </div>
            </div>
            <div class="kpi-value">Rp <?= number_format($stats['total_revenue'] ?? 0, 0, ',', '.') ?></div>
            <div class="kpi-subtext">Total pendapatan</div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:rgba(56,189,248,.12);color:#0284c7"><i class="fas fa-shopping-cart"></i></div>
                    <div class="kpi-label">Orders</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['total_orders'] ?? 0) ?></div>
            <div class="kpi-subtext">Total order</div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:var(--primary-soft);color:var(--primary)"><i class="fas fa-users"></i></div>
                    <div class="kpi-label">Customers</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['total_customers'] ?? 0) ?></div>
            <div class="kpi-subtext">Pelanggan terdaftar</div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:rgba(16,185,129,.12);color:#059669"><i class="fas fa-receipt"></i></div>
                    <div class="kpi-label">Transactions</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['total_transactions'] ?? 0) ?></div>
            <div class="kpi-subtext">Pembayaran sukses</div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Revenue (12 Bulan Terakhir)</div>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4 mb-4">
        <div class="stat-card">
            <h3><?= number_format($stats['total_products'] ?? 0) ?></h3>
            <p>Products</p>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="stat-card">
            <h3><?= number_format($stats['total_services'] ?? 0) ?></h3>
            <p>Services</p>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="stat-card">
            <h3>Rp <?= number_format(($stats['total_orders'] ?? 0) > 0 ? ($stats['total_revenue'] ?? 0) / $stats['total_orders'] : 0, 0, ',', '.') ?></h3>
            <p>Avg Order Value</p>
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