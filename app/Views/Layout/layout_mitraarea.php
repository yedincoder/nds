<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Mitra Area') ?> - Mitra NgAppID</title>
    <script>(function(){try{var t=localStorage.getItem("dash26-theme"),e=window.matchMedia("(prefers-color-scheme: dark)").matches;document.documentElement.setAttribute("data-theme",t||(e?"dark":"light"))}catch(t){document.documentElement.setAttribute("data-theme","light")}})();</script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #10B981;
            --primary-dark: #059669;
            --primary-light: #34D399;
            --primary-soft: rgba(16,185,129,.1);
            --secondary: #1E293B;
            --secondary-light: #334155;
            --accent: #F59E0B;
            --dark: #0F172A;
            --light-bg: #F8FAFC;
            --text-muted: #94A3B8;
            --text-dark: #1E293B;
            --card-border: #E2E8F0;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; color: var(--text-dark); background: var(--light-bg); }
        .sidebar { width: 260px; background: #0F172A; height: 100vh; position: fixed; top: 0; left: 0; z-index: 1000; transition: all 0.3s; overflow-y: auto; }
        .sidebar.collapsed { width: 70px; }
        .sidebar-header { padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .brand-logo { width: 40px; height: 40px; background: var(--primary); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; margin: 0 auto 12px; }
        .brand-text { color: white; font-weight: 700; font-size: 1.1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar.collapsed .brand-text { display: none; }
        .nav-section { padding: 0 16px; margin-top: 20px; }
        .nav-label { font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,0.4); padding: 0 16px; margin-bottom: 8px; }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: rgba(255,255,255,0.7); text-decoration: none; border-radius: 8px; margin-bottom: 4px; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: rgba(16,185,129,0.15); color: var(--primary); }
        .nav-link i { width: 20px; text-align: center; font-size: 1.1rem; }
        .nav-item-group.is-open .nav-submenu { max-height: 300px; }
        .nav-submenu { max-height: 0; overflow: hidden; transition: max-height .25s ease; }
        .nav-submenu a { border-radius: 6px; color: rgba(255,255,255,0.6); display: block; font-size: 13px; padding: 7px 12px 7px 48px; text-decoration: none; }
        .nav-submenu a:hover, .nav-submenu a.is-active { color: var(--primary); }
        .main-content { margin-left: 260px; padding: 30px; min-height: 100vh; }
        .topbar { background: white; border-bottom: 1px solid #eee; padding: 16px 32px; position: sticky; top: 0; z-index: 100; display: flex; justify-content: space-between; align-items: center; }
        .topbar .user-menu { display: flex; align-items: center; gap: 16px; }
        .user-avatar { width: 36px; height: 36px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; }
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .card { border: 1px solid #eee; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .card-header { border-bottom: 1px solid #eee; }
        .card-title { font-weight: 600; font-size: 15px; }
        .table th { background: #f8f9fa; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .table td { border-bottom: 1px solid #eee; font-size: 13px; padding: 10px 12px; }
        .stat-card { background: #fff; border: 1px solid var(--card-border); border-radius: 12px; padding: 24px; position: relative; }
        .stat-card .kpi-icon { width: 48px; height: 48px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 12px; }
        .stat-card h3 { font-size: 24px; font-weight: 700; margin: 0 0 4px; }
        .stat-card p { color: var(--text-muted); font-size: 13px; margin: 0; }
        .badge { font-weight: 600; }
        .alert { border-radius: 8px; }
        .page-title { margin-bottom: 24px; }
        .page-title h3 { font-weight: 700; margin: 0 0 4px; }
        .breadcrumb { font-size: 13px; margin: 0; }
        .breadcrumb-item a { color: var(--primary); text-decoration: none; }
        .form-control, .form-select { border-radius: 8px; }
        .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(16,185,129,.15); }
        .sidebar-toggle { display: none; }
        @media (max-width: 992px) { .sidebar { transform: translateX(-100%); } .sidebar.open { transform: translateX(0); } .main-content { margin-left: 0; } .sidebar-toggle { display: block; } }
    </style>
</head>
<body data-active="<?= esc($page ?? 'dashboard') ?>">
    <div class="shell">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="brand-logo"><i class="fas fa-handshake"></i></div>
                <div class="brand-text">Mitra NgAppID</div>
            </div>

            <nav class="nav-section">
                <div class="nav-label">Menu</div>
                <a class="nav-link <?= ($page ?? '') === 'mitra/dashboard' ? 'active' : '' ?>" href="/mitra/dashboard">
                    <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
                </a>
            </nav>

            <nav class="nav-section">
                <div class="nav-label">E-Commerce</div>
                <a class="nav-link <?= strpos($page ?? '', 'mitra/products') === 0 ? 'active' : '' ?>" href="/mitra/ecommerce/products">
                    <i class="fas fa-box"></i><span>Products</span>
                </a>
                <a class="nav-link <?= strpos($page ?? '', 'mitra/ecommerce/orders') === 0 ? 'active' : '' ?>" href="/mitra/ecommerce/orders">
                    <i class="fas fa-shopping-bag"></i><span>Orders</span>
                </a>
            </nav>

            <nav class="nav-section">
                <div class="nav-label">Pesanan</div>
                <a class="nav-link <?= ($page ?? '') === 'mitra/orders' ? 'active' : '' ?>" href="/mitra/orders">
                    <i class="fas fa-list"></i><span>Semua</span>
                </a>
                <a class="nav-link <?= strpos($page ?? '', 'mitra/orders/success') === 0 ? 'active' : '' ?>" href="/mitra/orders/success">
                    <i class="fas fa-check-circle"></i><span>Berhasil</span>
                </a>
                <a class="nav-link <?= strpos($page ?? '', 'mitra/orders/cancelled') === 0 ? 'active' : '' ?>" href="/mitra/orders/cancelled">
                    <i class="fas fa-times-circle"></i><span>Dibatalkan</span>
                </a>
            </nav>

            <nav class="nav-section">
                <div class="nav-label">Pendapatan</div>
                <a class="nav-link <?= ($page ?? '') === 'mitra/balance' ? 'active' : '' ?>" href="/mitra/pendapatan/balance">
                    <i class="fas fa-wallet"></i><span>Saldo</span>
                </a>
                <a class="nav-link <?= ($page ?? '') === 'mitra/withdrawals' ? 'active' : '' ?>" href="/mitra/pendapatan/withdrawals">
                    <i class="fas fa-money-bill-wave"></i><span>Penarikan</span>
                </a>
            </nav>

            <nav class="nav-section">
                <div class="nav-label">Akun</div>
                <a class="nav-link <?= ($page ?? '') === 'mitra/profile' ? 'active' : '' ?>" href="/mitra/akun/profile">
                    <i class="fas fa-user"></i><span>Profil Mitra</span>
                </a>
                <a class="nav-link" href="/mitra/akun/logout">
                    <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                </a>
            </nav>

            <div class="sidebar-footer" style="padding:16px;border-top:1px solid rgba(255,255,255,0.1);margin-top:20px">
                <div class="d-flex align-items-center gap-2">
                    <div class="user-avatar"><?= esc(strtoupper(substr(session()->get('username') ?? 'M', 0, 1))) ?></div>
                    <div>
                        <div class="text-white fw-bold" style="font-size:13px"><?= esc(session()->get('username') ?? 'Mitra') ?></div>
                        <div class="text-muted" style="font-size:11px">Partner</div>
                    </div>
                </div>
            </div>
        </aside>

        <div class="main-content">
            <header class="topbar">
                <button class="sidebar-toggle" data-sidebar-toggle><i class="fas fa-bars"></i></button>
                <span class="fw-semibold"><?= esc($title ?? 'Mitra Dashboard') ?></span>
                <div class="topbar-actions d-flex align-items-center gap-3">
                    <button class="theme-toggle" id="themeToggle" title="Toggle theme">
                        <i class="fas fa-sun"></i>
                    </button>
                    <div class="user-menu">
                        <div class="user-avatar"><?= esc(strtoupper(substr(session()->get('username') ?? 'M', 0, 1))) ?></div>
                        <span class="d-none d-md-inline"><?= esc(session()->get('username') ?? 'Mitra') ?></span>
                        <a href="/mitra/akun/logout" class="btn btn-sm btn-outline-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </header>
            <main class="content" style="padding: 30px;">
                <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.querySelector('[data-sidebar-toggle]');
            const sidebar = document.getElementById('sidebar');
            toggle?.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                document.body.classList.toggle('sidebar-collapsed');
            });
            document.querySelectorAll('[data-nav-toggle]').forEach(function(t) {
                t.addEventListener('click', function() {
                    this.closest('.nav-item-group').classList.toggle('is-open');
                });
            });
        });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
