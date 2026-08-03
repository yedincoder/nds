<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'My Account') ?> - NgAppID</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="/assets/gentelella/assets/main-v4-DDS6x4g-.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <script>(function(){try{var t=localStorage.getItem('theme');var d=window.matchMedia('(prefers-color-scheme: dark)').matches;var theme=t||(d?'dark':'light');document.documentElement.setAttribute('data-theme',theme);}catch(e){}})();</script>
</head>
<body data-shell="admin" data-page="client">

<aside class="sidebar" aria-label="Primary navigation">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="fas fa-cube"></i></div>
        <div class="brand-name">NgAppID</div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-group">
            <div class="nav-label">Menu</div>
            <a class="nav-link <?= ($page ?? '') === 'client/dashboard' ? 'active' : '' ?>" href="/client/dashboard">
                <i class="fas fa-home"></i>
                <span class="nav-text">Dashboard</span>
            </a>
            <a class="nav-link <?= strpos($page ?? '', 'client/orders') === 0 ? 'active' : '' ?>" href="/client/orders">
                <i class="fas fa-shopping-cart"></i>
                <span class="nav-text">My Orders</span>
            </a>
            <a class="nav-link <?= strpos($page ?? '', 'client/invoices') === 0 ? 'active' : '' ?>" href="/client/invoices">
                <i class="fas fa-file-invoice"></i>
                <span class="nav-text">My Invoices</span>
            </a>
            <a class="nav-link <?= strpos($page ?? '', 'client/downloads') === 0 ? 'active' : '' ?>" href="/client/downloads">
                <i class="fas fa-download"></i>
                <span class="nav-text">Downloads</span>
            </a>
            <a class="nav-link <?= strpos($page ?? '', 'client/tickets') === 0 ? 'active' : '' ?>" href="/client/tickets">
                <i class="fas fa-headset"></i>
                <span class="nav-text">Support Tickets</span>
            </a>
        </div>
        <div class="nav-group">
            <div class="nav-label">Akun</div>
            <a class="nav-link <?= strpos($page ?? '', 'client/profile') === 0 ? 'active' : '' ?>" href="/client/profile">
                <i class="fas fa-user"></i>
                <span class="nav-text">Profile</span>
            </a>
            <a class="nav-link" href="/auth/logout">
                <i class="fas fa-sign-out-alt"></i>
                <span class="nav-text">Logout</span>
            </a>
        </div>
    </nav>
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="avatar"><?= esc(strtoupper(substr(session()->get('username') ?? 'U', 0, 1))) ?><span class="online"></span></div>
            <div class="sidebar-user-info">
                <div class="name"><?= esc(session()->get('username') ?? 'User') ?></div>
                <div class="role">Customer</div>
            </div>
        </div>
    </div>
</aside>

<header class="topbar">
    <div class="topbar-left">
        <button class="sidebar-toggle" type="button" aria-label="Open menu">
            <i class="fas fa-bars"></i>
        </button>
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <span class="current" aria-current="page"><?= esc($breadcrumb ?? 'My Account') ?></span>
        </nav>
    </div>
    <div class="topbar-right">
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
