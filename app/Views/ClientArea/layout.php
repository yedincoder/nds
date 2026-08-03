<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'My Account') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f6f9; }
        .sidebar { min-height: 100vh; background: #2A3F54; color: #fff; padding-top: 0; }
        .sidebar a { color: rgba(255,255,255,0.7); text-decoration: none; padding: 12px 20px; display: block; font-size: 14px; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.1); color: #fff; border-left: 3px solid #1ABB9C; padding-left: 17px; }
        .sidebar .logo { padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar .logo a { font-size: 18px; font-weight: 600; color: #fff; }
        .sidebar .logo a i { color: #1ABB9C; margin-right: 10px; }
        .content { padding: 30px; }
        .stat-card { background: #fff; border-radius: 8px; padding: 20px; border-left: 4px solid #1ABB9C; margin-bottom: 20px; }
        .stat-card h3 { font-size: 28px; font-weight: 700; margin: 0; }
        .stat-card p { color: #666; margin: 0; font-size: 14px; }
        .card { border: none; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .table th { background: #f8f9fa; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar">
                <div class="logo">
                    <a href="/client/dashboard"><i class="fas fa-cube"></i> My Account</a>
                </div>
                <div class="mt-3">
                    <a href="/client/dashboard" class="<?= uri_string() == 'client/dashboard' ? 'active' : '' ?>">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a href="/client/orders" class="<?= uri_string() == 'client/orders' ? 'active' : '' ?>">
                        <i class="fas fa-shopping-cart me-2"></i> My Orders
                    </a>
                    <a href="/client/invoices" class="<?= uri_string() == 'client/invoices' ? 'active' : '' ?>">
                        <i class="fas fa-file-invoice me-2"></i> My Invoices
                    </a>
                    <a href="/client/downloads" class="<?= uri_string() == 'client/downloads' ? 'active' : '' ?>">
                        <i class="fas fa-download me-2"></i> Downloads
                    </a>
                    <a href="/client/tickets" class="<?= uri_string() == 'client/tickets' ? 'active' : '' ?>">
                        <i class="fas fa-headset me-2"></i> Support Tickets
                    </a>
                    <a href="/client/profile" class="<?= uri_string() == 'client/profile' ? 'active' : '' ?>">
                        <i class="fas fa-user me-2"></i> Profile
                    </a>
                    <a href="/auth/logout" class="mt-3">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </div>
            </div>
            <div class="col-md-10 content">
                <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
