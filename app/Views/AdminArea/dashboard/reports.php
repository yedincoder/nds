<?php
/** @var \CodeIgniter\View\View $this */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #E65C00;
            --secondary: #1A1A2E;
            --light-bg: #FFFAF5;
            --text-dark: #2D2D2D;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Inter, sans-serif; color: var(--text-dark); background: var(--light-bg); }
        .sidebar { width: 260px; background: var(--secondary); height: 100vh; position: fixed; top: 0; left: 0; z-index: 1000; transition: all 0.3s; }
        .sidebar.collapsed { width: 70px; }
        .sidebar-header { padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .brand-logo { width: 40px; height: 40px; background: var(--primary); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; margin: 0 auto 12px; }
        .brand-text { color: white; font-weight: 700; font-size: 1.1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar.collapsed .brand-text { display: none; }
        .nav-section { padding: 0 16px; margin-top: 20px; }
        .nav-label { font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,0.4); padding: 0 16px; margin-bottom: 8px; }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: rgba(255,255,255,0.7); text-decoration: none; border-radius: 8px; margin-bottom: 4px; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: rgba(230,92,0,0.15); color: var(--primary); }
        .nav-link i { width: 20px; text-align: center; font-size: 1.1rem; }
        .main-content { margin-left: 260px; padding: 30px; min-height: 100vh; }
        .topbar { background: white; border-bottom: 1px solid #eee; padding: 16px 32px; position: sticky; top: 0; z-index: 100; }
        .topbar .user-menu { display: flex; align-items: center; gap: 16px; }
        .user-avatar { width: 36px; height: 36px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; }
        .card { border: 1px solid #eee; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .stat-card { background: #fff; border-radius: 12px; padding: 25px; border: 1px solid #FFE8D6; text-align: center; transition: 0.3s; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.08); }
        .stat-card .stat-icon { width: 60px; height: 60px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 15px; background: #FFF0E6; color: #E65C00; }
        .stat-card h3 { font-size: 28px; font-weight: 700; color: #1A1A2E; margin-bottom: 5px; }
        .stat-card p { color: #6B7B8D; font-size: 13px; margin: 0; }
        .chart-bar { height: 30px; background: var(--primary); border-radius: 4px; display: flex; align-items: flex-end; justify-content: center; color: #fff; font-size: 10px; font-weight: 600; }
        .chart-row { display: flex; align-items: flex-end; gap: 8px; margin-bottom: 8px; }
        .chart-label { font-size: 11px; color: var(--text-muted); min-width: 80px; }
        .chart-value { font-size: 12px; font-weight: 600; color: var(--text-dark); }
    </style>
</head>
<body data-active="reports">
    <div class="shell d-flex">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="brand-logo"><i class="fas fa-cube"></i></div>
                <div class="brand-text">NgAppID Admin</div>
            </div>
            <nav class="nav-section">
                <div class="nav-label">Menu Utama</div>
                <a class="nav-link" href="/admin/dashboard"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
                <a class="nav-link" href="/admin/customers"><i class="fas fa-users"></i><span>Customers</span></a>
                <a class="nav-link" href="/admin/products"><i class="fas fa-box"></i><span>Products</span></a>
                <a class="nav-link" href="/admin/orders"><i class="fas fa-shopping-cart"></i><span>Orders</span></a>
                <a class="nav-link" href="/admin/invoices"><i class="fas fa-file-invoice"></i><span>Invoices</span></a>
                <a class="nav-link active" href="/admin/reports"><i class="fas fa-chart-bar"></i><span>Reports</span></a>
                <a class="nav-link" href="/admin/settings"><i class="fas fa-cog"></i><span>Settings</span></a>
                <a class="nav-link" href="/admin/media"><i class="fas fa-images"></i><span>Media</span></a>
            </nav>
            <nav class="nav-section">
                <div class="nav-label">CMS</div>
                <a class="nav-link" href="/admin/cms"><i class="fas fa-tachometer-alt"></i><span>CMS Dashboard</span></a>
                <a class="nav-link" href="/admin/cms/pages"><i class="fas fa-file"></i><span>Pages</span></a>
                <a class="nav-link" href="/admin/cms/articles"><i class="fas fa-newspaper"></i><span>Articles</span></a>
            </nav>
            <nav class="nav-section">
                <div class="nav-label">Lainnya</div>
                <a class="nav-link" href="/admin/testimonial"><i class="fas fa-quote-left"></i><span>Testimonials</span></a>
                <a class="nav-link" href="/admin/support"><i class="fas fa-life-ring"></i><span>Support</span></a>
                <a class="nav-link" href="/auth/logout"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
            </nav>
        </aside>
        <div class="main-content">
            <header class="topbar">
                <button class="sidebar-toggle" data-sidebar-toggle><i class="fas fa-bars"></i></button>
                <div class="user-menu">
                    <div class="user-avatar">A</div>
                    <span class="text-dark">Admin</span>
                </div>
            </header>
            <main class="content" style="padding: 30px;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="section-title mb-0">Reports</h1>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon"><i class="fas fa-money-bill"></i></div>
                            <h3>Rp <?= number_format($stats['total_revenue'] ?? 0) ?></h3>
                            <p>Total Revenue</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
                            <h3><?= number_format($stats['total_orders'] ?? 0) ?></h3>
                            <p>Total Orders</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon"><i class="fas fa-users"></i></div>
                            <h3><?= number_format($stats['total_customers'] ?? 0) ?></h3>
                            <p>Total Customers</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon"><i class="fas fa-receipt"></i></div>
                            <h3><?= number_format($stats['total_transactions'] ?? 0) ?></h3>
                            <p>Transactions</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">Revenue - Last 12 Months</h5>
                            </div>
                            <div class="card-body">
                                <?php foreach ($revenueChart as $chart): ?>
                                    <div class="chart-row">
                                        <div class="chart-label"><?= esc($chart['month']) ?></div>
                                        <div class="chart-value">Rp <?= number_format($chart['revenue']) ?></div>
                                        <div class="chart-bar" style="width: <?= min(100, $chart['revenue'] ? 40 : 0) ?>px;">&nbsp;</div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">Summary</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><strong>Products:</strong> <?= number_format($stats['total_products'] ?? 0) ?></li>
                                    <li class="mb-2"><strong>Services:</strong> <?= number_format($stats['total_services'] ?? 0) ?></li>
                                    <li class="mb-2"><strong>Portfolios:</strong> <?= number_format($stats['total_portfolios'] ?? 0) ?></li>
                                    <li class="mb-2"><strong>Avg Order Value:</strong> Rp <?= $stats['total_orders'] > 0 ? number_format(($stats['total_revenue'] ?? 0) / $stats['total_orders']) : '0' ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggle = document.querySelector("[data-sidebar-toggle]");
            const sidebar = document.getElementById("sidebar");
            toggle?.addEventListener("click", function() {
                sidebar.classList.toggle("collapsed");
                document.body.classList.toggle("sidebar-collapsed");
            });
        });
    </script>
</body>
</html>
</path>