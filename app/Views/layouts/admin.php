<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'NgAppID Admin') ?></title>
    <script>(function(){try{var t=localStorage.getItem("dash26-theme"),e=window.matchMedia("(prefers-color-scheme: dark)").matches;document.documentElement.setAttribute("data-theme",t||(e?"dark":"light"))}catch(t){document.documentElement.setAttribute("data-theme","light")}})();</script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="/assets/adminator/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
</head>
<body data-active="<?= esc($page ?? 'dashboard') ?>" data-crumbs="Admin | <?= esc($title ?? 'Dashboard') ?>">

<div class="shell">
    <aside class="d-sidebar">
        <div class="brand">
            <div class="brand-logo"><i class="fas fa-cube"></i></div>
            <div class="brand-text">
                <div class="brand-name">NgAppID</div>
                <div class="brand-tagline">Digital Platform</div>
            </div>
        </div>
        <nav class="nav-menu">
            <div class="nav-section">
                <div class="nav-label">Utama</div>
                <a class="nav-link <?= ($page ?? '') === 'admin/dashboard' ? 'is-active' : '' ?>" href="/admin/dashboard">
                    <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="nav-section">
                <div class="nav-label">Konten</div>
                <div class="nav-item-group <?= strpos($page ?? '', 'admin/cms') === 0 ? 'is-open' : '' ?>">
                    <a class="nav-link" href="javascript:void(0)" data-nav-toggle>
                        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        <span>CMS</span>
                        <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m9 18 6-6-6-6"/></svg>
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
                    <svg viewBox="0 0 24 24"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/><circle cx="12" cy="13" r="4"/></svg>
                    <span>Media Manager</span>
                </a>
                <a class="nav-link <?= ($page ?? '') === 'admin/portfolio' ? 'is-active' : '' ?>" href="/admin/portfolio">
                    <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
                    <span>Portfolio</span>
                </a>
                <a class="nav-link <?= ($page ?? '') === 'admin/testimonials' ? 'is-active' : '' ?>" href="/admin/testimonials">
                    <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                    <span>Testimonials</span>
                </a>
            </div>
            <div class="nav-section">
                <div class="nav-label">E-Commerce</div>
                <a class="nav-link <?= ($page ?? '') === 'admin/products' ? 'is-active' : '' ?>" href="/admin/products">
                    <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                    <span>Products</span>
                </a>
                <a class="nav-link <?= ($page ?? '') === 'admin/orders' ? 'is-active' : '' ?>" href="/admin/orders">
                    <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><path d="M6 2h12"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
                    <span>Orders</span>
                </a>
                <a class="nav-link <?= ($page ?? '') === 'admin/invoices' ? 'is-active' : '' ?>" href="/admin/invoices">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    <span>Invoices</span>
                </a>
                <a class="nav-link <?= ($page ?? '') === 'admin/payments' ? 'is-active' : '' ?>" href="/admin/payments">
                    <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    <span>Payments</span>
                </a>
            </div>
            <div class="nav-section">
                <div class="nav-label">Pelanggan</div>
                <a class="nav-link <?= ($page ?? '') === 'admin/customers' ? 'is-active' : '' ?>" href="/admin/customers">
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    <span>Customers</span>
                </a>
                <a class="nav-link <?= ($page ?? '') === 'admin/auth' ? 'is-active' : '' ?>" href="/admin/auth">
                    <svg viewBox="0 0 24 24"><path d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07"/></svg>
                    <span>Auth Users</span>
                </a>
            </div>
            <div class="nav-section">
                <div class="nav-label">Layanan</div>
                <a class="nav-link <?= ($page ?? '') === 'admin/services' ? 'is-active' : '' ?>" href="/admin/services">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1 1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001.51 1 1.65 1.65 0 001.82-.33"/></svg>
                    <span>Services</span>
                </a>
                <a class="nav-link <?= ($page ?? '') === 'admin/billing' ? 'is-active' : '' ?>" href="/admin/billing">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span>Billing</span>
                </a>
                <a class="nav-link <?= ($page ?? '') === 'admin/support' ? 'is-active' : '' ?>" href="/admin/support">
                    <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                    <span>Support</span>
                </a>
            </div>
            <div class="nav-section">
                <div class="nav-label">Sistem</div>
                <a class="nav-link <?= ($page ?? '') === 'admin/reports' ? 'is-active' : '' ?>" href="/admin/reports">
                    <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    <span>Reports</span>
                </a>
                <a class="nav-link <?= ($page ?? '') === 'admin/settings' ? 'is-active' : '' ?>" href="/admin/settings">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1 1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001.51 1 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1 1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001.51 1 1.65 1.65 0 001.82-.33"/></svg>
                    <span>Settings</span>
                </a>
            </div>
        </nav>
        <div class="sidebar-footer">
            <a class="sidebar-logout" href="/auth/logout">
                <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <div class="main">
        <header class="topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle" type="button" aria-label="Toggle sidebar">
                    <svg viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <div class="topbar-crumbs" id="topbarCrumbs"><?= esc($breadcrumb ?? 'Admin > Dashboard') ?></div>
            </div>
            <div class="topbar-right">
                <button class="theme-toggle" type="button" title="Toggle theme" id="themeToggle">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
                </button>
                <a class="topbar-user" href="/admin/settings" title="Profile">
                    <span class="topbar-avatar"><?= esc(strtoupper(substr(session()->get('username') ?? 'A', 0, 1))) ?></span>
                    <span class="topbar-user-name"><?= esc(session()->get('username') ?? 'Admin') ?></span>
                </a>
            </div>
        </header>

        <main class="content">
            <?php if (session()->getFlashdata('success')): ?>
            <div class="flash-success" style="padding:12px 16px;border-radius:8px;margin-bottom:20px;background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);color:#059669;">
                <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
            </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
            <div class="flash-error" style="padding:12px 16px;border-radius:8px;margin-bottom:20px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#dc2626;">
                <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
            </div>
            <?php endif; ?>
            <?php if (!empty(session()->getFlashdata('errors')) && is_array(session()->getFlashdata('errors'))): ?>
            <div class="flash-error" style="padding:12px 16px;border-radius:8px;margin-bottom:20px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#dc2626;">
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

<script src="/assets/adminator/vendors.js"></script>
<script src="/assets/adminator/2026.js"></script>
<script>
// Sidebar toggle
document.querySelector('.sidebar-toggle')?.addEventListener('click', function() {
    document.querySelector('.d-sidebar').classList.toggle('is-collapsed');
});
// Theme toggle
document.getElementById('themeToggle')?.addEventListener('click', function() {
    const html = document.documentElement;
    const current = html.getAttribute('data-theme');
    const next = current === 'light' ? 'dark' : 'light';
    html.setAttribute('data-theme', next);
    localStorage.setItem('dash26-theme', next);
});
</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
