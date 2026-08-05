<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Reports</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Reports</li>
        </ol>
    </nav>
</div>

<!-- Stats Overview -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-3 mb-3">
        <div class="stat-card" style="border-left-color: #1ABB9C;">
            <h3><?= number_format($stats['total_revenue'] ?? 0) ?></h3>
            <p><i class="fas fa-chart-line me-2"></i>Total Revenue</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3 mb-3">
        <div class="stat-card" style="border-left-color: #3498DB;">
            <h3><?= number_format($stats['total_orders'] ?? 0) ?></h3>
            <p><i class="fas fa-shopping-cart me-2"></i>Total Orders</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3 mb-3">
        <div class="stat-card" style="border-left-color: #E74C3C;">
            <h3><?= number_format($stats['total_customers'] ?? 0) ?></h3>
            <p><i class="fas fa-users me-2"></i>Total Customers</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3 mb-3">
        <div class="stat-card" style="border-left-color: #F39C12;">
            <h3><?= number_format($stats['total_products'] ?? 0) ?></h3>
            <p><i class="fas fa-box me-2"></i>Total Products</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Revenue Overview</h5>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-lg-5">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Order Status Distribution</h5>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Revenue',
                data: [12000000, 19000000, 3000000, 5000000, 2000000, 3000000, 4000000, 5000000, 6000000, 7000000, 8000000, 9000000],
                borderColor: '#1ABB9C',
                backgroundColor: 'rgba(26, 188, 156, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                        }
                    }
                }
            }
        }
    });

    // Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'Pending', 'Processing', 'Cancelled'],
            datasets: [{
                data: [45, 25, 20, 10],
                backgroundColor: ['#1ABB9C', '#F39C12', '#3498DB', '#E74C3C']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
<?= $this->endSection() ?>