<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'NgAppID') ?> - Digital Platform</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #1ABB9C;
            --primary-dark: #169F82;
            --secondary: #2A3F54;
            --accent: #3498DB;
            --dark: #172B3B;
            --light-bg: #F7F9FC;
            --text-muted: #6B7B8D;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; color: #333; }
        .navbar { background: var(--secondary); padding: 15px 0; transition: all 0.3s; }
        .navbar.scrolled { background: rgba(42,63,84,0.98); box-shadow: 0 2px 20px rgba(0,0,0,0.1); padding: 10px 0; }
        .navbar-brand { font-weight: 700; font-size: 22px; color: #fff !important; }
        .navbar-brand i { color: var(--primary); margin-right: 8px; }
        .navbar-nav .nav-link { color: rgba(255,255,255,0.8) !important; font-weight: 500; font-size: 14px; padding: 8px 16px !important; transition: 0.3s; }
        .navbar-nav .nav-link:hover { color: var(--primary) !important; }
        .navbar-nav .nav-link.active { color: var(--primary) !important; }
        .btn-nav { background: var(--primary); color: #fff !important; border-radius: 6px; padding: 8px 20px !important; margin-left: 10px; }
        .btn-nav:hover { background: var(--primary-dark); }
        .hero { background: linear-gradient(135deg, var(--secondary) 0%, var(--dark) 100%); color: #fff; padding: 120px 0 100px; position: relative; overflow: hidden; }
        .hero::before { content: ''; position: absolute; top: -50%; right: -20%; width: 600px; height: 600px; background: var(--primary); opacity: 0.1; border-radius: 50%; }
        .hero h1 { font-size: 48px; font-weight: 800; margin-bottom: 20px; }
        .hero h1 span { color: var(--primary); }
        .hero p { font-size: 18px; color: rgba(255,255,255,0.7); margin-bottom: 30px; max-width: 600px; }
        .btn-primary { background: var(--primary); border-color: var(--primary); font-weight: 600; padding: 12px 30px; border-radius: 6px; transition: 0.3s; }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); transform: translateY(-2px); }
        .btn-outline-light { border-color: rgba(255,255,255,0.3); color: #fff; font-weight: 600; padding: 12px 30px; border-radius: 6px; transition: 0.3s; }
        .btn-outline-light:hover { background: rgba(255,255,255,0.1); }
        .section-title { font-size: 32px; font-weight: 700; color: var(--secondary); margin-bottom: 15px; }
        .section-subtitle { color: var(--text-muted); font-size: 16px; margin-bottom: 50px; }
        .feature-card { background: #fff; border-radius: 12px; padding: 30px; text-align: center; transition: 0.3s; border: 1px solid #eef2f7; height: 100%; }
        .feature-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .feature-icon { width: 64px; height: 64px; border-radius: 16px; display: inline-flex; align-items: center; justify-content: center; font-size: 28px; margin-bottom: 20px; }
        .feature-card h5 { font-weight: 600; color: var(--secondary); margin-bottom: 12px; }
        .feature-card p { color: var(--text-muted); font-size: 14px; line-height: 1.7; }
        .product-card { background: #fff; border-radius: 12px; overflow: hidden; border: 1px solid #eef2f7; transition: 0.3s; height: 100%; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .product-img { height: 200px; background: linear-gradient(135deg, var(--primary), var(--accent)); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 48px; }
        .product-card .card-body { padding: 24px; }
        .product-card h5 { font-weight: 600; color: var(--secondary); }
        .product-card .price { font-size: 20px; font-weight: 700; color: var(--primary); }
        .cta-section { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: #fff; padding: 80px 0; }
        .footer { background: var(--secondary); color: rgba(255,255,255,0.7); padding: 60px 0 30px; }
        .footer h5 { color: #fff; font-weight: 600; margin-bottom: 20px; }
        .footer a { color: rgba(255,255,255,0.7); text-decoration: none; transition: 0.3s; }
        .footer a:hover { color: var(--primary); }
        .footer .social a { display: inline-flex; width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.1); align-items: center; justify-content: center; color: #fff; margin-right: 8px; transition: 0.3s; }
        .footer .social a:hover { background: var(--primary); }
        .page-header { background: linear-gradient(135deg, var(--secondary) 0%, var(--dark) 100%); color: #fff; padding: 80px 0 50px; }
        .breadcrumb-item a { color: var(--primary); text-decoration: none; }
        .breadcrumb-item.active { color: rgba(255,255,255,0.6); }
        .card { border: 1px solid #eef2f7; border-radius: 12px; transition: 0.3s; }
        .card:hover { box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="fas fa-cube"></i>NgAppID</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= ($page ?? '') === 'home' ? 'active' : '' ?>" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page ?? '') === 'about' ? 'active' : '' ?>" href="/about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page ?? '') === 'services' ? 'active' : '' ?>" href="/services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page ?? '') === 'products' ? 'active' : '' ?>" href="/products">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page ?? '') === 'blog' ? 'active' : '' ?>" href="/blog">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page ?? '') === 'contact' ? 'active' : '' ?>" href="/contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-nav" href="/auth/login">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?= $this->renderSection('content') ?>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5><i class="fas fa-cube me-2" style="color: var(--primary)"></i>NgAppID</h5>
                    <p>Platform digital modern untuk pengembangan aplikasi profesional, penjualan produk digital, dan layanan enterprise.</p>
                    <div class="social">
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Menu</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/">Home</a></li>
                        <li class="mb-2"><a href="/about">About</a></li>
                        <li class="mb-2"><a href="/services">Services</a></li>
                        <li class="mb-2"><a href="/products">Products</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Resources</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/blog">Blog</a></li>
                        <li class="mb-2"><a href="/portfolio">Portfolio</a></li>
                        <li class="mb-2"><a href="/contact">Contact</a></li>
                        <li class="mb-2"><a href="/auth/register">Register</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Contact</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-envelope me-2" style="color: var(--primary)"></i>info@ngappid.com</li>
                        <li class="mb-2"><i class="fas fa-phone me-2" style="color: var(--primary)"></i>+62 123 456 789</li>
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2" style="color: var(--primary)"></i>Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.1)">
            <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0">&copy; <?= date('Y') ?> NgAppID. All rights reserved.</p>
                <small>Powered by NgAppID Digital Platform</small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) { navbar.classList.add('scrolled'); }
            else { navbar.classList.remove('scrolled'); }
        });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
