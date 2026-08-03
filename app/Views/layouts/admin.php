<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'NgAppID Admin Dashboard') ?></title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 230px;
            --topbar-height: 60px;
            --primary-color: #2A3F54;
            --secondary-color: #1ABB9C;
            --accent-color: #3498DB;
            --danger-color: #E74C3C;
            --warning-color: #F39C12;
            --success-color: #26B99A;
            --info-color: #3498DB;
            --dark-color: #172B3B;
            --light-bg: #F7F7F7;
            --white-color: #FFFFFF;
            --border-color: #E5E5E5;
            --text-primary: #73879C;
            --text-dark: #2A3F54;
            --sidebar-dark: #2A3F54;
            --sidebar-light: #FFFFFF;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        [data-bs-theme="dark"] {
            --primary-color: #1F2937;
            --sidebar-dark: #111827;
            --light-bg: #1F2937;
            --white-color: #111827;
            --border-color: #374151;
            --text-primary: #9CA3AF;
            --text-dark: #F3F4F6;
            --sidebar-light: #1F2937;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: var(--text-primary);
            background-color: var(--light-bg);
            overflow-x: hidden;
            transition: var(--transition);
        }

        .nav_menu {
            background: var(--white-color);
            border-bottom: 1px solid var(--border-color);
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            z-index: 1000;
            display: flex;
            align-items: center;
            padding: 0 20px;
            transition: var(--transition);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .left_col {
            background: var(--sidebar-dark);
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: var(--sidebar-width);
            z-index: 1001;
            transition: var(--transition);
            overflow-y: auto;
            overflow-x: hidden;
        }

        .left_col::-webkit-scrollbar {
            width: 5px;
        }

        .left_col::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.05);
        }

        .left_col::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
        }

        .sidebar-header {
            padding: 20px 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .site_title {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--white-color);
            font-size: 18px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }

        .site_title i {
            font-size: 24px;
            color: var(--secondary-color);
        }

        .site_title:hover {
            color: var(--secondary-color);
        }

        .sidebar-menu {
            list-style: none;
            padding: 15px 0;
        }

        .sidebar-menu li {
            position: relative;
        }

        .sidebar-menu > li > a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: var(--transition);
            font-size: 13px;
            font-weight: 500;
        }

        .sidebar-menu > li > a i {
            font-size: 16px;
            width: 20px;
            text-align: center;
        }

        .sidebar-menu > li > a:hover,
        .sidebar-menu > li.active > a {
            background: rgba(255,255,255,0.05);
            color: var(--white-color);
            border-left: 3px solid var(--secondary-color);
            padding-left: 17px;
        }

        .sidebar-menu > li.active > a {
            background: linear-gradient(90deg, rgba(26,188,156,0.1) 0%, transparent 100%);
        }

        .sidebar-menu .menu-header {
            padding: 20px 20px 8px 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: rgba(255,255,255,0.35);
        }

        .sidebar-menu .menu-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
        }

        .sidebar-menu .menu-toggle i.fa-chevron-down {
            font-size: 11px;
            transition: transform 0.3s;
        }

        .sidebar-menu .menu-toggle.collapsed i.fa-chevron-down {
            transform: rotate(-90deg);
        }

        .sidebar-menu .submenu {
            list-style: none;
            padding: 0 0 5px 0;
            display: none;
        }

        .sidebar-menu .submenu.show {
            display: block;
        }

        .sidebar-menu .submenu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 9px 20px 9px 52px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            transition: var(--transition);
            font-size: 13px;
        }

        .sidebar-menu .submenu li a:hover,
        .sidebar-menu .submenu li.active a {
            background: rgba(255,255,255,0.03);
            color: var(--white-color);
        }

        .sidebar-menu .submenu li.active a {
            color: var(--secondary-color);
        }

        .sidebar-menu .submenu li.active a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--secondary-color);
        }

        .sidebar-menu .submenu li a::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
        }

        .sidebar-menu .submenu li.active a::before {
            background: var(--secondary-color);
        }

        .right_col {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            padding: 25px;
            min-height: calc(100vh - var(--topbar-height));
            transition: var(--transition);
        }

        .nav-toggle {
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 20px;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: var(--transition);
        }

        .nav-toggle:hover {
            background: var(--light-bg);
            color: var(--text-dark);
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-left: auto;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            color: var(--text-primary);
            text-decoration: none;
            border-radius: 6px;
            transition: var(--transition);
            font-size: 13px;
        }

        .nav-link:hover {
            background: var(--light-bg);
            color: var(--text-dark);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
        }

        .user-profile:hover {
            background: var(--light-bg);
        }

        .user-profile img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }

        .theme-toggle {
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 18px;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: var(--transition);
        }

        .theme-toggle:hover {
            background: var(--light-bg);
            color: var(--text-dark);
        }

        .page-title {
            margin-bottom: 25px;
        }

        .page-title h3 {
            font-size: 24px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .page-title .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
            font-size: 13px;
        }

        .breadcrumb-item a {
            color: var(--text-primary);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--secondary-color);
        }

        .card {
            background: var(--white-color);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            transition: var(--transition);
        }

        .card:hover {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .card-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            background: transparent;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .card-body {
            padding: 20px;
        }

        .stat-card {
            background: var(--white-color);
            border-radius: 8px;
            padding: 20px;
            border-left: 3px solid var(--secondary-color);
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .stat-card h3 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .stat-card p {
            color: var(--text-primary);
            font-size: 13px;
            margin: 0;
        }

        .table {
            color: var(--text-primary);
        }

        .table thead {
            background: var(--light-bg);
            color: var(--text-dark);
        }

        .table th {
            font-weight: 600;
            border-bottom: 2px solid var(--border-color);
        }

        .btn-primary {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
            color: white;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: #169f82;
            border-color: #169f82;
        }

        .dropdown-menu {
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        .dropdown-item {
            color: var(--text-primary);
            padding: 10px 16px;
            transition: var(--transition);
        }

        .dropdown-item:hover {
            background: var(--light-bg);
            color: var(--text-dark);
        }

        .badge {
            font-weight: 500;
            padding: 4px 10px;
        }

        .nav-settings .nav-link {
            color: var(--text-primary);
            padding: 12px 16px;
            border-left: 3px solid transparent;
            border-radius: 0;
            transition: var(--transition);
            font-size: 14px;
            font-weight: 500;
        }

        .nav-settings .nav-link:hover {
            background: var(--light-bg);
            color: var(--text-dark);
        }

        .nav-settings .nav-link.active {
            background: var(--light-bg);
            color: var(--secondary-color);
            border-left-color: var(--secondary-color);
        }

        .nav-settings .nav-link i {
            width: 20px;
            text-align: center;
        }

        .form-check-input:checked {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .form-select {
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 10px 14px;
            background-color: var(--white-color);
            color: var(--text-dark);
        }

        .form-select:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(26, 188, 156, 0.1);
        }

        .pagination .page-link {
            color: var(--text-primary);
            background: var(--white-color);
            border-color: var(--border-color);
            padding: 8px 14px;
        }

        .pagination .page-item.active .page-link {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
            color: white;
        }

        .table-hover tbody tr:hover {
            background: var(--light-bg);
        }

        .table-responsive {
            border-radius: 6px;
        }

        @media (max-width: 768px) {
            .left_col {
                transform: translateX(-100%);
            }

            .left_col.active {
                transform: translateX(0);
            }

            .nav_menu {
                left: 0;
            }

            .right_col {
                margin-left: 0;
            }
        }

        body.sidebar-mini .left_col {
            width: 70px;
        }

        body.sidebar-mini .nav_menu {
            left: 70px;
        }

        body.sidebar-mini .right_col {
            margin-left: 70px;
        }

        body.sidebar-mini .sidebar-menu > li > a span {
            display: none;
        }

        body.sidebar-mini .site_title span {
            display: none;
        }

        body.sidebar-mini .menu-header {
            display: none;
        }

        body.sidebar-mini .submenu {
            display: none !important;
        }

        body.sidebar-mini .menu-toggle {
            pointer-events: none;
        }

        body.sidebar-mini .menu-toggle i.fa-chevron-down {
            display: none;
        }
    </style>
</head>
<body>
    
    <!-- Left Sidebar -->
    <div class="left_col">
        <div class="sidebar-header">
            <a href="/admin/dashboard" class="site_title">
                <i class="fas fa-cube"></i>
                <span>NgAppID</span>
            </a>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-header">UTAMA</li>
            <li class="<?= uri_string() === 'admin/dashboard' ? 'active' : '' ?>">
                <a href="/admin/dashboard">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="menu-header">MANAJEMEN KONTEN</li>
            <li class="<?= strpos(uri_string(), 'admin/cms') === 0 ? 'active' : '' ?>">
                <a href="#submenu-cms" class="menu-toggle <?= strpos(uri_string(), 'admin/cms') === 0 ? '' : 'collapsed' ?>" data-bs-toggle="collapse" aria-expanded="<?= strpos(uri_string(), 'admin/cms') === 0 ? 'true' : 'false' ?>">
                    <span><i class="fas fa-newspaper me-2"></i>CMS</span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <ul class="submenu collapse <?= strpos(uri_string(), 'admin/cms') === 0 ? 'show' : '' ?>" id="submenu-cms">
                    <li class="<?= uri_string() === 'admin/cms/dashboard' ? 'active' : '' ?>">
                        <a href="/admin/cms/dashboard">Dashboard</a>
                    </li>
                    <li class="<?= uri_string() === 'admin/cms/pages' ? 'active' : '' ?>">
                        <a href="/admin/cms/pages">Pages</a>
                    </li>
                    <li class="<?= uri_string() === 'admin/cms/articles' ? 'active' : '' ?>">
                        <a href="/admin/cms/articles">Articles</a>
                    </li>
                    <li class="<?= uri_string() === 'admin/cms/categories' ? 'active' : '' ?>">
                        <a href="/admin/cms/categories">Categories</a>
                    </li>
                    <li class="<?= uri_string() === 'admin/cms/tags' ? 'active' : '' ?>">
                        <a href="/admin/cms/tags">Tags</a>
                    </li>
                </ul>
            </li>
            <li class="<?= uri_string() === 'admin/media' ? 'active' : '' ?>">
                <a href="/admin/media">
                    <i class="fas fa-images"></i>
                    <span>Media Manager</span>
                </a>
            </li>
            <li class="<?= uri_string() === 'admin/portfolio' ? 'active' : '' ?>">
                <a href="/admin/portfolio">
                    <i class="fas fa-briefcase"></i>
                    <span>Portfolio</span>
                </a>
            </li>

            <li class="menu-header">E-COMMERCE</li>
            <li class="<?= uri_string() === 'admin/products' ? 'active' : '' ?>">
                <a href="/admin/products">
                    <i class="fas fa-box"></i>
                    <span>Products</span>
                </a>
            </li>
            <li class="<?= uri_string() === 'admin/orders' ? 'active' : '' ?>">
                <a href="/admin/orders">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                </a>
            </li>
            <li class="<?= uri_string() === 'admin/invoices' ? 'active' : '' ?>">
                <a href="/admin/invoices">
                    <i class="fas fa-file-invoice"></i>
                    <span>Invoices</span>
                </a>
            </li>
            <li class="<?= strpos(uri_string(), 'admin/payments') === 0 ? 'active' : '' ?>">
                <a href="/admin/payments">
                    <i class="fas fa-credit-card"></i>
                    <span>Payments</span>
                </a>
            </li>

            <li class="menu-header">PELANGGAN</li>
            <li class="<?= uri_string() === 'admin/customers' ? 'active' : '' ?>">
                <a href="/admin/customers">
                    <i class="fas fa-users"></i>
                    <span>Customers</span>
                </a>
            </li>
            <li class="<?= uri_string() === 'admin/auth' ? 'active' : '' ?>">
                <a href="/admin/auth">
                    <i class="fas fa-users-cog"></i>
                    <span>Auth Users</span>
                </a>
            </li>

            <li class="menu-header">LAYANAN</li>
            <li class="<?= uri_string() === 'admin/services' ? 'active' : '' ?>">
                <a href="/admin/services">
                    <i class="fas fa-cogs"></i>
                    <span>Services</span>
                </a>
            </li>
            <li class="<?= uri_string() === 'admin/billing' ? 'active' : '' ?>">
                <a href="/admin/billing">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>Billing</span>
                </a>
            </li>
            <li class="<?= strpos(uri_string(), 'admin/testimonials') === 0 ? 'active' : '' ?>">
                <a href="/admin/testimonials">
                    <i class="fas fa-quote-left"></i>
                    <span>Testimonials</span>
                </a>
            </li>

            <li class="menu-header">DUKUNGAN</li>
            <li class="<?= strpos(uri_string(), 'admin/support') === 0 ? 'active' : '' ?>">
                <a href="/admin/support">
                    <i class="fas fa-headset"></i>
                    <span>Support Tickets</span>
                </a>
            </li>

            <li class="menu-header">LAPORAN & PENGATURAN</li>
            <li class="<?= uri_string() === 'admin/reports' ? 'active' : '' ?>">
                <a href="/admin/reports">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reports</span>
                </a>
            </li>
            <li class="<?= uri_string() === 'admin/settings' ? 'active' : '' ?>">
                <a href="/admin/settings">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Top Navigation -->
    <div class="nav_menu">
        <button class="nav-toggle" id="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>

        <nav class="navbar-nav">
            <button class="theme-toggle" id="theme-toggle" title="Toggle theme">
                <i class="fas fa-moon"></i>
            </button>

            <div class="dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-bell"></i>
                    <span class="badge bg-danger">3</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">New order received</a></li>
                    <li><a class="dropdown-item" href="#">Payment completed</a></li>
                    <li><a class="dropdown-item" href="#">New customer registered</a></li>
                </ul>
            </div>

            <div class="dropdown">
                <div class="user-profile dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode(session()->get('username') ?? 'Admin') ?>&background=1ABB9C&color=fff" alt="User">
                    <span><?= esc(session()->get('username') ?? 'Admin') ?></span>
                </div>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="/admin/profile"><i class="fas fa-user me-2"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="/admin/settings"><i class="fas fa-cog me-2"></i> Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="/auth/logout"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                </ul>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="right_col">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement;
        
        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        htmlElement.setAttribute('data-bs-theme', savedTheme);
        updateThemeIcon(savedTheme);
        
        themeToggle.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            htmlElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });
        
        function updateThemeIcon(theme) {
            const icon = themeToggle.querySelector('i');
            icon.className = theme === 'light' ? 'fas fa-moon' : 'fas fa-sun';
        }
        
        // Sidebar Toggle
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.querySelector('.left_col');
        
        menuToggle.addEventListener('click', () => {
            if (window.innerWidth > 768) {
                document.body.classList.toggle('sidebar-mini');
            } else {
                sidebar.classList.toggle('active');
            }
        });
        
        // Auto-detect system theme
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!localStorage.getItem('theme')) {
                const newTheme = e.matches ? 'dark' : 'light';
                htmlElement.setAttribute('data-bs-theme', newTheme);
                updateThemeIcon(newTheme);
            }
        });
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>