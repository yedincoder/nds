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
        .sidebar { width: 260px; background: #0F172A; height: 100vh; position: fixed; top: 0; left: 0; z-index: 1000; transition: all 0.3s; }
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
        .main-content { margin-left: 260px; padding: 30px; min-height: 100vh; }
        .topbar { background: white; border-bottom: 1px solid #eee; padding: 16px 32px; position: sticky; top: 0; z-index: 100; }
        .topbar .user-menu { display: flex; align-items: center; gap: 16px; }
        .user-avatar { width: 36px; height: 36px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; }
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .card { border: 1px solid #eee; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .table th { background: #f8f9fa; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .table td { border-bottom: 1px solid #eee; font-size: 13px; padding: 10px 12px; }
        .sidebar-toggle { display: none; }
        @media (max-width: 992px) { .sidebar { transform: translateX(-100%); } .sidebar.open { transform: translateX(0); } .main-content { margin-left: 0; } .sidebar-toggle { display: block; } }
    </style>
</head>
<body data-active="<?= esc($page ?? 'dashboard') ?>">
    <div class="shell">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="brand-logo"><i class="fas fa-handshake" style="font-size:1.5rem"></i></div>
                <div class="brand-text">Mitra NgAppID</div>
            </div>
            <nav class="nav-section">
                <div class="nav-label">Menu Utama</div>
                <a class="nav-link <?= ($page ?? '') === 'dashboard' ? 'active' : '' ?>" href="/mitra/dashboard">
                    <i class="fas fa-tachometer-alt" style="width:18px"></i><span>Dashboard</span>
                </a>
                <a class="nav-link <?= strpos($page ?? '', 'orders') === 0 ? 'active' : '' ?>" href="/mitra/orders">
                    <i class="fas fa-shopping-cart" style="width:18px"></i><span>Pesanan</span>
                </a>
                <a class="nav-link <?= strpos($page ?? '', 'payouts') === 0 ? 'active' : '' ?>" href="/mitra/payouts">
                    <i class="fas fa-money-bill-wave" style="width:18px"></i><span>Payouts</span>
                </a>
                <a class="nav-link <?= strpos($page ?? '', 'analytics') === 0 ? 'active' : '' ?>" href="/mitra/analytics">
                    <i class="fas fa-chart-line" style="width:18px"></i><span>Analytics</span>
                </a>
                <div class="nav-label">Akun</div>
                <a class="nav-link" href="/mitra/profile">
                    <i class="fas fa-user" style="width:18px"></i><span>Profil</span>
                </a>
                <a class="nav-link" href="/mitra/settings">
                    <i class="fas fa-cog" style="width:18px"></i><span>Pengaturan</span>
                </a>
            </nav>
        </aside>

        <div class="main-content">
            <header class="topbar">
                <button class="sidebar-toggle" data-sidebar-toggle><i class="fas fa-bars"></i></button>
                <div class="topbar-actions">
                    <button class="theme-toggle" id="themeToggle" title="Toggle theme">
                        <i class="fas fa-sun" style="font-size:16px"></i>
                    </button>
                    <div class="user-menu">
                        <div class="user-avatar"><?= esc(strtoupper(substr(session()->get('username') ?? 'M', 0, 1))) ?></div>
                        <span class="d-none d-md-inline"><?= esc(session()->get('username') ?? 'Mitra') ?></span>
                        <a href="/mitra/auth/logout" class="btn btn-sm btn-outline-danger ms-2"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </header>
            <main class="content" style="padding: 30px;">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.querySelector('[data-sidebar-toggle]');
            const sidebar = document.getElementById('sidebar');
            const body = document.body;
            toggle?.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                body.classList.toggle('sidebar-collapsed');
            });
        });
    </script>
</body>
</html>