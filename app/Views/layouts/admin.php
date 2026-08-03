<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'NgAppID Admin Dashboard') ?></title>
    <link rel="icon" href="/images/favicon.svg" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="/assets/gentelella/assets/main-v4-DDS6x4g-.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
</head>
<body data-shell="admin" data-page="<?= esc($page ?? 'dashboard') ?>" data-breadcrumb="<?= esc($breadcrumb ?? 'Home > Dashboard') ?>">

<a class="skip-link" href="#main-content">Skip to main content</a>

<aside class="sidebar" aria-label="Primary navigation">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="fas fa-cube"></i></div>
        <div class="brand-name">NgAppID</div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-group">
            <div class="nav-label">Utama</div>
            <a class="nav-link <?= ($page ?? '') === 'admin/dashboard' ? 'active' : '' ?>" href="/admin/dashboard">
                <i class="fas fa-home"></i>
                <span class="nav-text">Dashboard</span>
            </a>
        </div>

        <div class="nav-group">
            <div class="nav-label">Konten</div>
            <div class="nav-tree <?= strpos($page ?? '', 'admin/cms') === 0 ? 'open has-active' : '' ?>">
                <button type="button" class="nav-link nav-toggle" aria-expanded="<?= strpos($page ?? '', 'admin/cms') === 0 ? 'true' : 'false' ?>">
                    <i class="fas fa-newspaper"></i>
                    <span class="nav-text">CMS</span>
                    <i class="fas fa-chevron-right nav-chev"></i>
                </button>
                <div class="nav-sub"><div class="nav-sub-inner">
                    <a class="nav-sublink <?= ($page ?? '') === 'admin/cms/dashboard' ? 'active' : '' ?>" href="/admin/cms/dashboard">Dashboard</a>
                    <a class="nav-sublink <?= ($page ?? '') === 'admin/cms/pages' ? 'active' : '' ?>" href="/admin/cms/pages">Pages</a>
                    <a class="nav-sublink <?= ($page ?? '') === 'admin/cms/articles' ? 'active' : '' ?>" href="/admin/cms/articles">Articles</a>
                    <a class="nav-sublink <?= ($page ?? '') === 'admin/cms/categories' ? 'active' : '' ?>" href="/admin/cms/categories">Categories</a>
                    <a class="nav-sublink <?= ($page ?? '') === 'admin/cms/tags' ? 'active' : '' ?>" href="/admin/cms/tags">Tags</a>
                </div></div>
            </div>
            <a class="nav-link <?= ($page ?? '') === 'admin/media' ? 'active' : '' ?>" href="/admin/media">
                <i class="fas fa-images"></i>
                <span class="nav-text">Media Manager</span>
            </a>
            <a class="nav-link <?= ($page ?? '') === 'admin/portfolio' ? 'active' : '' ?>" href="/admin/portfolio">
                <i class="fas fa-briefcase"></i>
                <span class="nav-text">Portfolio</span>
            </a>
            <a class="nav-link <?= ($page ?? '') === 'admin/testimonials' ? 'active' : '' ?>" href="/admin/testimonials">
                <i class="fas fa-quote-left"></i>
                <span class="nav-text">Testimonials</span>
            </a>
        </div>

        <div class="nav-group">
            <div class="nav-label">E-Commerce</div>
            <a class="nav-link <?= ($page ?? '') === 'admin/products' ? 'active' : '' ?>" href="/admin/products">
                <i class="fas fa-box"></i>
                <span class="nav-text">Products</span>
            </a>
            <a class="nav-link <?= ($page ?? '') === 'admin/orders' ? 'active' : '' ?>" href="/admin/orders">
                <i class="fas fa-shopping-cart"></i>
                <span class="nav-text">Orders</span>
            </a>
            <a class="nav-link <?= ($page ?? '') === 'admin/invoices' ? 'active' : '' ?>" href="/admin/invoices">
                <i class="fas fa-file-invoice"></i>
                <span class="nav-text">Invoices</span>
            </a>
            <a class="nav-link <?= ($page ?? '') === 'admin/payments' ? 'active' : '' ?>" href="/admin/payments">
                <i class="fas fa-credit-card"></i>
                <span class="nav-text">Payments</span>
            </a>
        </div>

        <div class="nav-group">
            <div class="nav-label">Pelanggan</div>
            <a class="nav-link <?= ($page ?? '') === 'admin/customers' ? 'active' : '' ?>" href="/admin/customers">
                <i class="fas fa-users"></i>
                <span class="nav-text">Customers</span>
            </a>
            <a class="nav-link <?= ($page ?? '') === 'admin/auth' ? 'active' : '' ?>" href="/admin/auth">
                <i class="fas fa-user-cog"></i>
                <span class="nav-text">Auth Users</span>
            </a>
        </div>

        <div class="nav-group">
            <div class="nav-label">Layanan</div>
            <a class="nav-link <?= ($page ?? '') === 'admin/services' ? 'active' : '' ?>" href="/admin/services">
                <i class="fas fa-cogs"></i>
                <span class="nav-text">Services</span>
            </a>
            <a class="nav-link <?= ($page ?? '') === 'admin/billing' ? 'active' : '' ?>" href="/admin/billing">
                <i class="fas fa-file-invoice-dollar"></i>
                <span class="nav-text">Billing</span>
            </a>
            <a class="nav-link <?= ($page ?? '') === 'admin/support' ? 'active' : '' ?>" href="/admin/support">
                <i class="fas fa-headset"></i>
                <span class="nav-text">Support</span>
            </a>
        </div>

        <div class="nav-group">
            <div class="nav-label">Sistem</div>
            <a class="nav-link <?= ($page ?? '') === 'admin/reports' ? 'active' : '' ?>" href="/admin/reports">
                <i class="fas fa-chart-bar"></i>
                <span class="nav-text">Reports</span>
            </a>
            <a class="nav-link <?= ($page ?? '') === 'admin/settings' ? 'active' : '' ?>" href="/admin/settings">
                <i class="fas fa-cog"></i>
                <span class="nav-text">Settings</span>
            </a>
        </div>
    </nav>
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="avatar"><?= esc(strtoupper(substr(session()->get('username') ?? 'A', 0, 1))) ?><span class="online"></span></div>
            <div class="sidebar-user-info">
                <div class="name"><?= esc(session()->get('username') ?? 'Admin') ?></div>
                <div class="role">Administrator</div>
            </div>
            <a class="more-btn" href="/auth/logout" aria-label="Logout" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>
</aside>

<header class="topbar">
    <div class="topbar-left">
        <button class="sidebar-toggle" type="button" aria-label="Open menu" aria-controls="sidebar" aria-expanded="false">
            <i class="fas fa-bars"></i>
        </button>
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <span class="current" aria-current="page"><?= esc($breadcrumb ?? 'Home') ?></span>
        </nav>
    </div>
    <div class="search-box">
        <i class="fas fa-search s-icon"></i>
        <input type="text" placeholder="Search pages or run a command..." aria-label="Search">
    </div>
    <div class="topbar-right">
        <button class="tb-btn theme-toggle" type="button" title="Toggle theme" aria-label="Toggle theme" aria-pressed="false">
            <i class="fas fa-sun theme-icon-light"></i>
            <i class="fas fa-moon theme-icon-dark"></i>
        </button>
        <a class="tb-avatar" href="/auth/logout" title="Logout">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </div>
</header>

<main id="main-content" tabindex="-1" class="main">
    <div class="page-wrapper">
        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
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
    </div>
</main>

<script type="module" crossorigin src="/assets/gentelella/js/rolldown-runtime-DEgBLETi.js"></script>
<script type="module" crossorigin src="/assets/gentelella/js/menus-BVcs0GJR.js"></script>
<script type="module" crossorigin src="/assets/gentelella/js/modal-MTuCfURV.js"></script>
<script type="module" crossorigin src="/assets/gentelella/js/main-v4-BFwmMcfm.js"></script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
