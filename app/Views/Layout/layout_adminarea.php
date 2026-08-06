<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'NgAppID Admin') ?></title>
    <script>(function(){try{var t=localStorage.getItem("dash26-theme"),e=window.matchMedia("(prefers-color-scheme: dark)").matches;document.documentElement.setAttribute("data-theme",t||(e?"dark":"light"))}catch(t){document.documentElement.setAttribute("data-theme","light")}})();</script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="/assets/adminator/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        /* Bootstrap-like minimal helpers for content components */
        .row { display: flex; flex-wrap: wrap; margin: 0 -10px; }
        .col-xl-3, .col-md-6, .col-lg-4, .col-md-4, .col-md-3, .col-lg-5, .col-lg-7 { padding: 0 10px; }
        .col-xl-3 { flex: 0 0 25%; max-width: 25%; }
        .col-xl-4 { flex: 0 0 33.333%; max-width: 33.333%; }
        .col-xl-7 { flex: 0 0 58.333%; max-width: 58.333%; }
        .col-xl-8 { flex: 0 0 66.667%; max-width: 66.667%; }
        .col-xl-5 { flex: 0 0 41.667%; max-width: 41.667%; }
        .col-xl-12 { flex: 0 0 100%; max-width: 100%; }
        .col-lg-6 { flex: 0 0 50%; max-width: 50%; }
        .col-lg-7 { flex: 0 0 58.333%; max-width: 58.333%; }
        .col-lg-5 { flex: 0 0 41.667%; max-width: 41.667%; }
        .col-lg-4 { flex: 0 0 33.333%; max-width: 33.333%; }
        .col-md-6 { flex: 0 0 50%; max-width: 50%; }
        .col-md-4 { flex: 0 0 33.333%; max-width: 33.333%; }
        .col-md-3 { flex: 0 0 25%; max-width: 25%; }
        .col-md-2 { flex: 0 0 16.667%; max-width: 16.667%; }
        .col-md-8 { flex: 0 0 66.667%; max-width: 66.667%; }
        .col-md-10 { flex: 0 0 83.333%; max-width: 83.333%; }
        .col-md-5 { flex: 0 0 41.667%; max-width: 41.667%; }
        .col-md-7 { flex: 0 0 58.333%; max-width: 58.333%; }
        .col-md-12 { flex: 0 0 100%; max-width: 100%; }
        .col-12, .col { flex: 0 0 100%; max-width: 100%; }
        .d-flex { display: flex; }
        .justify-content-between { justify-content: space-between; }
        .justify-content-end { justify-content: flex-end; }
        .align-items-center { align-items: center; }
        .flex-wrap { flex-wrap: wrap; }
        .mb-4 { margin-bottom: 24px; }
        .mb-3 { margin-bottom: 16px; }
        .mb-2 { margin-bottom: 8px; }
        .mb-1 { margin-bottom: 4px; }
        .mb-0 { margin-bottom: 0; }
        .mt-3 { margin-top: 16px; }
        .mt-4 { margin-top: 24px; }
        .mt-2 { margin-top: 8px; }
        .me-1 { margin-right: 4px; }
        .me-2 { margin-right: 8px; }
        .me-3 { margin-right: 16px; }
        .ms-auto { margin-left: auto; }
        .ms-2 { margin-left: 8px; }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .text-muted { color: var(--t-muted); }
        .text-primary { color: var(--primary); }
        .text-success { color: #059669; }
        .text-danger { color: #dc2626; }
        .text-warning { color: #d97706; }
        .text-white { color: #fff; }
        .text-dark { color: var(--t-base); }
        .text-decoration-line-through { text-decoration: line-through; }
        .fw-bold { font-weight: 700; }
        .fw-semibold { font-weight: 600; }
        .small { font-size: 13px; }
        .text-truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .text-nowrap { white-space: nowrap; }
        .py-2 { padding: 8px 0; }
        .py-3 { padding: 16px 0; }
        .py-4 { padding: 24px 0; }
        .py-5 { padding: 48px 0; }
        .px-2 { padding: 0 8px; }
        .p-2 { padding: 8px; }
        .p-4 { padding: 24px; }
        .border-bottom { border-bottom: 1px solid var(--border-soft); }
        .w-100 { width: 100%; }
        .h-100 { height: 100%; }
        .rounded-circle { border-radius: 50%; }
        .float-end { float: right; }
        .position-relative { position: relative; }
        .gap-3 { gap: 16px; }
        .gap-2 { gap: 8px; }
        .gap-1 { gap: 4px; }
        .btn-group { display: inline-flex; gap: 4px; }
        .list-unstyled { list-style: none; padding: 0; margin: 0; }
        .d-block { display: block; }
        .img-fluid { max-width: 100%; height: auto; }

        .btn { align-items: center; border-radius: 8px; display: inline-flex; font-size: 13px; font-weight: 500; gap: 6px; justify-content: center; line-height: 1.2; padding: 8px 14px; transition: background-color .18s ease, color .18s ease, box-shadow .18s ease, border-color .18s ease; text-decoration: none; border: 1px solid transparent; cursor: pointer; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); color: #fff; }
        .btn-secondary { background: var(--bg-muted); color: var(--t-base); }
        .btn-secondary:hover { background: var(--bg-hover); }
        .btn-outline-primary { background: transparent; border-color: var(--primary); color: var(--primary); }
        .btn-outline-primary:hover { background: var(--primary); color: #fff; }
        .btn-outline-secondary { background: transparent; border-color: var(--border); color: var(--t-base); }
        .btn-outline-secondary:hover, .btn-outline-secondary.active { background: var(--bg-muted); }
        .btn-outline-info { background: transparent; border-color: #38bdf8; color: #0284c7; }
        .btn-outline-danger { background: transparent; border-color: #f87171; color: #dc2626; }
        .btn-outline-danger:hover { background: #dc2626; color: #fff; }
        .btn-outline-warning { background: transparent; border-color: #fbbf24; color: #d97706; }
        .btn-outline-warning:hover { background: #d97706; color: #fff; }
        .btn-outline-success { background: transparent; border-color: #34d399; color: #059669; }
        .btn-sm { font-size: 12px; padding: 5px 10px; border-radius: 6px; }
        .btn-lg { font-size: 15px; padding: 12px 20px; }
        .btn-light { background: #fff; color: var(--primary); }

        .badge { border-radius: 6px; display: inline-block; font-size: 11px; font-weight: 600; line-height: 1; padding: 5px 10px; }
        .bg-success { background: rgba(16,185,129,.12); color: #059669; }
        .bg-info { background: rgba(56,189,248,.12); color: #0284c7; }
        .bg-warning { background: rgba(245,158,11,.14); color: #b45309; }
        .bg-danger { background: rgba(239,68,68,.12); color: #dc2626; }
        .bg-secondary { background: var(--bg-muted); color: var(--t-muted); }
        .text-dark.bg-warning { color: #78350f; }

        .form-control, .form-select { background: var(--bg-card); border: 1px solid var(--border); border-radius: 8px; color: var(--t-base); font-size: 13px; padding: 9px 12px; width: 100%; }
        .form-control:focus, .form-select:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-ring); }
        .form-label { color: var(--t-base); display: block; font-size: 13px; font-weight: 500; margin-bottom: 6px; }
        .form-check-input { accent-color: var(--primary); }
        .form-check-label { font-size: 13px; }
        .form-text { color: var(--t-muted); font-size: 12px; }

        .table { border-collapse: collapse; width: 100%; }
        .table th { border-bottom: 2px solid var(--border); color: var(--t-light); font-size: 11px; font-weight: 600; letter-spacing: .05em; padding: 10px 12px; text-align: left; text-transform: uppercase; }
        .table td { border-bottom: 1px solid var(--border-soft); color: var(--t-base); font-size: 13px; padding: 10px 12px; }
        .table-hover tbody tr:hover { background: var(--bg-hover); }
        .table-responsive { overflow-x: auto; }

        .card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; margin-bottom: 20px; }
        .card-header { align-items: center; border-bottom: 1px solid var(--border-soft); display: flex; justify-content: space-between; padding: 14px 18px; }
        .card-title { color: var(--t-base); font-size: 14px; font-weight: 600; margin: 0; }
        .card-body { padding: 18px; }
        .card-footer { border-top: 1px solid var(--border-soft); padding: 12px 18px; }

        .stat-card { background: var(--bg-card); border: 1px solid var(--border); border-left: 4px solid var(--primary); border-radius: 10px; padding: 18px 20px; margin-bottom: 20px; }
        .stat-card h3 { color: var(--primary); font-size: 24px; font-weight: 700; margin: 0 0 4px; }
        .stat-card p { color: var(--t-muted); font-size: 13px; margin: 0; }

        .alert { border-radius: 8px; font-size: 13px; margin-bottom: 16px; padding: 12px 16px; }
        .alert-success { background: rgba(16,185,129,.1); border: 1px solid rgba(16,185,129,.3); color: #059669; }
        .alert-danger { background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.3); color: #dc2626; }
        .alert-warning { background: rgba(245,158,11,.1); border: 1px solid rgba(245,158,11,.3); color: #b45309; }

        .pagination { display: flex; gap: 4px; list-style: none; margin: 16px 0 0; padding: 0; justify-content: flex-end; }
        .pagination .page-link { border: 1px solid var(--border); border-radius: 6px; color: var(--t-base); display: inline-flex; font-size: 13px; padding: 6px 10px; text-decoration: none; }
        .pagination .page-item.active .page-link { background: var(--primary); border-color: var(--primary); color: #fff; }
        .pagination .page-item.disabled .page-link { color: var(--t-light); pointer-events: none; }

        .progress { background: var(--bg-muted); border-radius: 6px; height: 8px; overflow: hidden; }
        .progress-bar { background: var(--primary); height: 100%; }

        .dropdown-menu { background: var(--bg-card); border: 1px solid var(--border); border-radius: 8px; box-shadow: 0 8px 24px rgba(0,0,0,.08); display: none; list-style: none; min-width: 180px; padding: 6px; position: absolute; z-index: 100; }
        .dropdown-item { border-radius: 6px; color: var(--t-base); display: block; font-size: 13px; padding: 8px 12px; text-decoration: none; }
        .dropdown-item:hover { background: var(--bg-hover); }
        .dropdown-divider { border-top: 1px solid var(--border-soft); margin: 6px 0; }
        .dropdown.show .dropdown-menu { display: block; }
        .dropdown-menu-end { right: 0; }
        .position-absolute { position: absolute; }
        .position-relative { position: relative; }

        .modal { display: none; position: fixed; inset: 0; z-index: 1000; background: rgba(15,23,42,.5); align-items: center; justify-content: center; }
        .modal.show { display: flex; }
        .modal-dialog { background: var(--bg-card); border-radius: 12px; max-width: 500px; width: 90%; }
        .modal-header { border-bottom: 1px solid var(--border-soft); padding: 16px 20px; }
        .modal-title { font-size: 16px; font-weight: 600; margin: 0; }
        .modal-body { padding: 20px; }
        .modal-footer { border-top: 1px solid var(--border-soft); display: flex; gap: 8px; justify-content: flex-end; padding: 14px 20px; }
        .btn-close { background: none; border: none; color: var(--t-muted); cursor: pointer; font-size: 18px; line-height: 1; padding: 4px; }

        .page-title { margin-bottom: 24px; }
        .page-title h3 { color: var(--t-base); font-size: 22px; font-weight: 700; margin: 0 0 4px; }
        .breadcrumb { color: var(--t-muted); font-size: 13px; list-style: none; margin: 0; padding: 0; }
        .breadcrumb-item { display: inline; }
        .breadcrumb-item + .breadcrumb-item::before { color: var(--t-light); content: "/"; padding: 0 6px; }
        .breadcrumb-item a { color: var(--primary); text-decoration: none; }
        .breadcrumb-item.active { color: var(--t-muted); }

        @media (max-width: 992px) {
            .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-7, .col-xl-8 { flex: 0 0 100%; max-width: 100%; }
            .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7 { flex: 0 0 100%; max-width: 100%; }
            .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-10 { flex: 0 0 100%; max-width: 100%; }
        }
        @media (max-width: 768px) {
            .col-md-6, .col-md-4, .col-md-3 { flex: 0 0 100%; max-width: 100%; }
        }
        .theme-toggle, .hamburger { align-items:center; background:transparent; border:none; border-radius:8px; color:var(--t-muted); cursor:pointer; display:inline-flex; height:36px; justify-content:center; transition:background .16s; width:36px; }
        .theme-toggle:hover, .hamburger:hover { background:var(--bg-hover); color:var(--t-base); }
        .hamburger { display:inline-flex; }
        .d-topbar { display:flex; }
        .crumbs { display:flex; }
        .topbar-actions { display:flex; }
        .nav-item-group.is-open .nav-submenu { max-height: 260px; }
        .nav-submenu a { border-radius:6px; color:var(--t-muted); display:block; font-size:13px; padding:7px 12px; text-decoration:none; }
        .nav-submenu a:hover { background:var(--bg-hover); color:var(--t-base); }
        .nav-submenu a.is-active { color:var(--primary); font-weight:500; }
        .workspace-avatar { align-items:center; border-radius:8px; display:inline-flex; font-size:12px; font-weight:600; height:30px; justify-content:center; width:30px; }
        .workspace-text { line-height:1.25; }
        .workspace-name { color:var(--t-base); font-size:13px; font-weight:600; }
        .workspace-role { color:var(--t-light); font-size:11px; }
        .brand-text { line-height:1.25; }
        .brand-name { color:var(--t-base); font-size:15px; font-weight:700; }
        .brand-tag { color:var(--t-light); font-size:11px; }
        .nav-link.is-active { background:var(--primary-soft); color:var(--primary); }
        .nav-link.is-active i { color:var(--primary); }
        @media (max-width: 992px) {
            .d-sidebar { position:fixed; left:0; top:0; z-index:100; transform:translateX(-100%); transition:transform .25s ease; }
            .shell.sidebar-open .d-sidebar, body.sidebar-open .d-sidebar { transform:translateX(0); }
        }
        .sidebar-footer a { color:var(--t-muted); text-decoration:none; }
        .kpi-identity { align-items:center; display:flex; gap:10px; }
        .kpi-subtext { color:var(--t-muted); font-size:12px; }
        .kpi-card .kpi-value { font-size:28px; }
        .kpi-card:hover { border-color:var(--primary); transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,.08); }
    </style>
</head>
<body data-active="<?= esc($page ?? 'dashboard') ?>" data-crumbs="Admin | <?= esc($title ?? 'Dashboard') ?>">

<div class="shell">
    <aside class="d-sidebar">
        <div class="brand">
            <div class="brand-logo"><i class="fas fa-cube fa-lg" style="color:var(--primary)"></i></div>
            <div class="brand-text">
                <div class="brand-name">NgAppID</div>
                <div class="brand-tag">Digital Platform</div>
            </div>
        </div>

        <nav class="nav-section">
            <div class="nav-label">Utama</div>
            <a class="nav-link <?= ($page ?? '') === 'admin/dashboard' ? 'is-active' : '' ?>" href="/admin/dashboard">
                <i class="fas fa-home" style="width:18px"></i><span>Dashboard</span>
            </a>
        </nav>

        <nav class="nav-section">
            <div class="nav-label">Konten</div>
            <div class="nav-item-group <?= strpos($page ?? '', 'admin/cms') === 0 ? 'is-open' : '' ?>">
                <a class="nav-link" href="javascript:void(0)" data-nav-toggle>
                    <i class="fas fa-newspaper" style="width:18px"></i><span>CMS</span>
                    <i class="fas fa-chevron-right chev"></i>
                </a>
                <div class="nav-submenu">
                    <a href="/admin/cms/dashboard">Dashboard</a>
                    <a href="/admin/cms/pages">Pages</a>
                    <a href="/admin/cms/articles">Articles</a>
                    <a href="/admin/cms/categories">Categories</a>
                    <a href="/admin/cms/tags">Tags</a>
                </div>
            </div>
            <a class="nav-link <?= ($page ?? '') === 'admin/media' ? 'is-active' : '' ?>" href="/admin/media">
                <i class="fas fa-images" style="width:18px"></i><span>Media</span>
            </a>
            <a class="nav-link <?= ($page ?? '') === 'admin/portfolio' ? 'is-active' : '' ?>" href="/admin/portfolio">
                <i class="fas fa-briefcase" style="width:18px"></i><span>Portfolio</span>
            </a>
            <a class="nav-link <?= ($page ?? '') === 'admin/testimonials' ? 'is-active' : '' ?>" href="/admin/testimonials">
                <i class="fas fa-quote-left" style="width:18px"></i><span>Testimonials</span>
            </a>
        </nav>

        <nav class="nav-section">
            <div class="nav-label">E-Commerce</div>
            <a class="nav-link <?= ($page ?? '') === 'admin/products' ? 'is-active' : '' ?>" href="/admin/products">
                <i class="fas fa-box" style="width:18px"></i><span>Products</span>
            </a>
            <a class="nav-link <?= ($page ?? '') === 'admin/orders' ? 'is-active' : '' ?>" href="/admin/orders">
                <i class="fas fa-shopping-cart" style="width:18px"></i><span>Orders</span>
            </a>
            <a class="nav-link <?= ($page ?? '') === 'admin/invoices' ? 'is-active' : '' ?>" href="/admin/invoices">
                <i class="fas fa-file-invoice" style="width:18px"></i><span>Invoices</span>
            </a>
            <a class="nav-link <?= ($page ?? '') === 'admin/payments' ? 'is-active' : '' ?>" href="/admin/payments">
                <i class="fas fa-credit-card" style="width:18px"></i><span>Payments</span>
            </a>
        </nav>

        <nav class="nav-section">
            <div class="nav-label">Pelanggan</div>
            <a class="nav-link <?= ($page ?? '') === 'admin/customers' ? 'is-active' : '' ?>" href="/admin/customers">
                <i class="fas fa-users" style="width:18px"></i><span>Customers</span>
            </a>
            <a class="nav-link <?= ($page ?? '') === 'admin/auth' ? 'is-active' : '' ?>" href="/admin/auth">
                <i class="fas fa-user-cog" style="width:18px"></i><span>Auth Users</span>
            </a>
        </nav>

        <nav class="nav-section">
            <div class="nav-label">Layanan</div>
            <a class="nav-link <?= ($page ?? '') === 'admin/services' ? 'is-active' : '' ?>" href="/admin/services">
                <i class="fas fa-cogs" style="width:18px"></i><span>Services</span>
            </a>
            <a class="nav-link <?= ($page ?? '') === 'admin/billing' ? 'is-active' : '' ?>" href="/admin/billing">
                <i class="fas fa-file-invoice-dollar" style="width:18px"></i><span>Billing</span>
            </a>
            <a class="nav-link <?= ($page ?? '') === 'admin/support' ? 'is-active' : '' ?>" href="/admin/support">
                <i class="fas fa-headset" style="width:18px"></i><span>Support</span>
            </a>
        </nav>

        <nav class="nav-section">
            <div class="nav-label">Sistem</div>
            <a class="nav-link <?= ($page ?? '') === 'admin/reports' ? 'is-active' : '' ?>" href="/admin/reports">
                <i class="fas fa-chart-bar" style="width:18px"></i><span>Reports</span>
            </a>
            <a class="nav-link <?= ($page ?? '') === 'admin/settings' ? 'is-active' : '' ?>" href="/admin/settings">
                <i class="fas fa-cog" style="width:18px"></i><span>Settings</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="workspace">
                <div class="workspace-avatar" style="background:var(--primary);color:#fff"><?= esc(strtoupper(substr(session()->get('username') ?? 'A', 0, 1))) ?></div>
                <div class="workspace-text">
                    <div class="workspace-name"><?= esc(session()->get('username') ?? 'Admin') ?></div>
                    <div class="workspace-role">Administrator</div>
                </div>
                <a href="/auth/logout" title="Logout" style="color:var(--t-muted);text-decoration:none"><i class="fas fa-sign-out-alt"></i></a>
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
                <button class="cmd" data-palette-open>
                    <i class="fas fa-search"></i>
                    <span>Search...</span>
                    <kbd class="kbd">Ctrl K</kbd>
                </button>
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
            <?php if (!empty(session()->getFlashdata('errors')) && is_array(session()->getFlashdata('errors'))): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $e): ?>
                    <li><?= esc($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
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
    document.querySelectorAll('[data-palette-open]').forEach(function(p) {
        p.addEventListener('click', function() {
            var input = document.querySelector('.content input[type="search"], .content input[type="text"]');
            if (input) input.focus();
        });
    });
})();
</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
