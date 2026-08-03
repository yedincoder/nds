<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'My Account') ?> - NgAppID</title>
    <script>(function(){try{var t=localStorage.getItem("dash26-theme"),e=window.matchMedia("(prefers-color-scheme: dark)").matches;document.documentElement.setAttribute("data-theme",t||(e?"dark":"light"))}catch(t){document.documentElement.setAttribute("data-theme","light")}})();</script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="/assets/adminator/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        .row { display: flex; flex-wrap: wrap; margin: 0 -10px; }
        .col-md-6, .col-lg-4, .col-md-4, .col-md-3 { padding: 0 10px; }
        .col-md-6 { flex: 0 0 50%; max-width: 50%; }
        .col-md-4 { flex: 0 0 33.333%; max-width: 33.333%; }
        .col-md-3 { flex: 0 0 25%; max-width: 25%; }
        .d-flex { display: flex; }
        .justify-content-between { justify-content: space-between; }
        .align-items-center { align-items: center; }
        .mb-4 { margin-bottom: 24px; }
        .mb-3 { margin-bottom: 16px; }
        .mb-2 { margin-bottom: 8px; }
        .mb-0 { margin-bottom: 0; }
        .mt-3 { margin-top: 16px; }
        .me-2 { margin-right: 8px; }
        .text-muted { color: var(--t-muted); }
        .text-dark { color: var(--t-base); }
        .text-success { color: #059669; }
        .card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; margin-bottom: 20px; }
        .card-header { align-items: center; border-bottom: 1px solid var(--border-soft); display: flex; justify-content: space-between; padding: 14px 18px; }
        .card-title { color: var(--t-base); font-size: 14px; font-weight: 600; margin: 0; }
        .card-body { padding: 18px; }
        .table { border-collapse: collapse; width: 100%; }
        .table th { border-bottom: 2px solid var(--border); color: var(--t-light); font-size: 11px; font-weight: 600; letter-spacing: .05em; padding: 10px 12px; text-align: left; text-transform: uppercase; }
        .table td { border-bottom: 1px solid var(--border-soft); color: var(--t-base); font-size: 13px; padding: 10px 12px; }
        .form-control, .form-select { background: var(--bg-card); border: 1px solid var(--border); border-radius: 8px; color: var(--t-base); font-size: 13px; padding: 9px 12px; width: 100%; }
        .form-control:focus, .form-select:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-ring); }
        .form-label { color: var(--t-base); display: block; font-size: 13px; font-weight: 500; margin-bottom: 6px; }
        .btn { align-items: center; border-radius: 8px; display: inline-flex; font-size: 13px; font-weight: 500; gap: 6px; justify-content: center; padding: 8px 14px; border: 1px solid transparent; cursor: pointer; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-secondary { background: var(--bg-muted); color: var(--t-base); }
        .btn-outline-primary { background: transparent; border-color: var(--primary); color: var(--primary); }
        .stat-card { background: var(--bg-card); border: 1px solid var(--border); border-left: 4px solid var(--primary); border-radius: 10px; padding: 18px 20px; margin-bottom: 20px; }
        .stat-card h3 { color: var(--primary); font-size: 24px; font-weight: 700; margin: 0 0 4px; }
        .stat-card p { color: var(--t-muted); font-size: 13px; margin: 0; }
        .alert { border-radius: 8px; font-size: 13px; margin-bottom: 16px; padding: 12px 16px; }
        .alert-success { background: rgba(16,185,129,.1); border: 1px solid rgba(16,185,129,.3); color: #059669; }
        .alert-danger { background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.3); color: #dc2626; }
        .page-title { margin-bottom: 24px; }
        .page-title h3 { color: var(--t-base); font-size: 22px; font-weight: 700; margin: 0 0 4px; }
        .breadcrumb { color: var(--t-muted); font-size: 13px; list-style: none; margin: 0; padding: 0; }
        .breadcrumb-item { display: inline; }
        .breadcrumb-item + .breadcrumb-item::before { color: var(--t-light); content: "/"; padding: 0 6px; }
        .breadcrumb-item a { color: var(--primary); text-decoration: none; }
        .text-center { text-align: center; }
        .mb-0 { margin-bottom: 0; }
        .mt-3 { margin-top: 16px; }
        .form-check-input { accent-color: var(--primary); }
        .form-check-label { font-size: 13px; }
        .rounded-circle { border-radius: 50%; }
        @media (max-width: 768px) { .col-md-6, .col-md-4, .col-md-3 { flex: 0 0 100%; max-width: 100%; } }
    </style>
</head>
<body data-active="<?= esc($page ?? 'dashboard') ?>" data-crumbs="Client | <?= esc($title ?? 'Dashboard') ?>">

<div class="shell">
    <aside class="d-sidebar">
        <div class="brand">
            <div class="brand-logo"><i class="fas fa-cube fa-lg" style="color:var(--primary)"></i></div>
            <div class="brand-text">
                <div class="brand-name">NgAppID</div>
                <div class="brand-tag">My Account</div>
            </div>
        </div>

        <nav class="nav-section">
            <div class="nav-label">Menu</div>
            <a class="nav-link <?= ($page ?? '') === 'client/dashboard' ? 'is-active' : '' ?>" href="/client/dashboard">
                <i class="fas fa-home" style="width:18px"></i><span>Dashboard</span>
            </a>
            <a class="nav-link <?= strpos($page ?? '', 'client/orders') === 0 ? 'is-active' : '' ?>" href="/client/orders">
                <i class="fas fa-shopping-cart" style="width:18px"></i><span>My Orders</span>
            </a>
            <a class="nav-link <?= strpos($page ?? '', 'client/invoices') === 0 ? 'is-active' : '' ?>" href="/client/invoices">
                <i class="fas fa-file-invoice" style="width:18px"></i><span>My Invoices</span>
            </a>
            <a class="nav-link <?= strpos($page ?? '', 'client/downloads') === 0 ? 'is-active' : '' ?>" href="/client/downloads">
                <i class="fas fa-download" style="width:18px"></i><span>Downloads</span>
            </a>
            <a class="nav-link <?= strpos($page ?? '', 'client/tickets') === 0 ? 'is-active' : '' ?>" href="/client/tickets">
                <i class="fas fa-headset" style="width:18px"></i><span>Support</span>
            </a>
        </nav>

        <nav class="nav-section">
            <div class="nav-label">Akun</div>
            <a class="nav-link <?= strpos($page ?? '', 'client/profile') === 0 ? 'is-active' : '' ?>" href="/client/profile">
                <i class="fas fa-user" style="width:18px"></i><span>Profile</span>
            </a>
            <a class="nav-link" href="/auth/logout">
                <i class="fas fa-sign-out-alt" style="width:18px"></i><span>Logout</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="workspace">
                <div class="workspace-avatar" style="background:var(--primary);color:#fff"><?= esc(strtoupper(substr(session()->get('username') ?? 'U', 0, 1))) ?></div>
                <div class="workspace-text">
                    <div class="workspace-name"><?= esc(session()->get('username') ?? 'User') ?></div>
                    <div class="workspace-role">Customer</div>
                </div>
            </div>
        </div>
    </aside>

    <div class="main">
        <header class="d-topbar">
            <div class="crumbs">
                <button class="hamburger" data-drawer-open aria-label="Open navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="current"><?= esc($title ?? 'Dashboard') ?></span>
            </div>
            <div class="topbar-actions">
                <button class="theme-toggle" id="themeToggle" title="Toggle theme">
                    <i class="fas fa-sun" style="font-size:16px"></i>
                </button>
            </div>
        </header>

        <main class="content">
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
(function() {
    var toggle = document.getElementById('themeToggle');
    if (toggle) {
        toggle.addEventListener('click', function() {
            var html = document.documentElement;
            var next = html.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
            html.setAttribute('data-theme', next);
            localStorage.setItem('dash26-theme', next);
        });
    }
    var hamburger = document.querySelector('[data-drawer-open]');
    if (hamburger) {
        hamburger.addEventListener('click', function() {
            document.body.classList.toggle('sidebar-open');
        });
    }
    document.querySelectorAll('[data-nav-toggle]').forEach(function(t) {
        t.addEventListener('click', function() {
            this.closest('.nav-item-group').classList.toggle('is-open');
        });
    });
})();
</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
