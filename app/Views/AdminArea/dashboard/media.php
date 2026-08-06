<?php
/** @var \CodeIgniter\View\View $this */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #E65C00;
            --secondary: #1A1A2E;
            --light-bg: #FFFAF5;
            --text-dark: #2D2D2D;
            --card-border: #FFE8D6;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Inter, sans-serif; color: var(--text-dark); background: var(--light-bg); }
        .sidebar { width: 260px; background: var(--secondary); height: 100vh; position: fixed; top: 0; left: 0; z-index: 1000; transition: all 0.3s; }
        .sidebar.collapsed { width: 70px; }
        .sidebar-header { padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .brand-logo { width: 40px; height: 40px; background: var(--primary); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; margin: 0 auto 12px; }
        .brand-text { color: white; font-weight: 700; font-size: 1.1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar.collapsed .brand-text { display: none; }
        .nav-section { padding: 0 16px; margin-top: 20px; }
        .nav-label { font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,0.4); padding: 0 16px; margin-bottom: 8px; }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: rgba(255,255,255,0.7); text-decoration: none; border-radius: 8px; margin-bottom: 4px; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: rgba(230,92,0,0.15); color: var(--primary); }
        .nav-link i { width: 20px; text-align: center; font-size: 1.1rem; }
        .main-content { margin-left: 260px; padding: 30px; min-height: 100vh; }
        .card { border: 1px solid #eee; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .table th { background: #f8f9fa; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .media-item { cursor: pointer; }
        .media-item:hover { background: rgba(230,92,0,0.1); }
        .media-item img { max-width: 100%; max-height: 200px; border-radius: 8px; }
        .media-item .card-body { padding: 16px; }
        .media-item .card-title { font-weight: 600; margin-bottom: 5px; }
        .media-item .media-meta { color: var(--text-muted); font-size: 12px; }
        .btn-primary { background: #E65C00; border-color: #E65C00; }
        .btn-primary:hover { background: #C44900; border-color: #C44900; }
        .btn-outline-secondary { border-color: var(--secondary); }
        .btn-outline-secondary:hover { background: rgba(26,26,46,0.1); }
    </style>
</head>
<body data-active="media">
    <div class="shell d-flex">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="brand-logo"><i class="fas fa-cube"></i></div>
                <div class="brand-text">NgAppID Admin</div>
            </div>
            <nav class="nav-section">
                <div class="nav-label">Menu Utama</div>
                <a class="nav-link" href="/admin/dashboard"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
                <a class="nav-link" href="/admin/customers"><i class="fas fa-users"></i><span>Customers</span></a>
                <a class="nav-link" href="/admin/products"><i class="fas fa-box"></i><span>Products</span></a>
                <a class="nav-link" href="/admin/orders"><i class="fas fa-shopping-cart"></i><span>Orders</span></a>
                <a class="nav-link" href="/admin/invoices"><i class="fas fa-file-invoice"></i><span>Invoices</span></a>
                <a class="nav-link" href="/admin/reports"><i class="fas fa-chart-bar"></i><span>Reports</span></a>
                <a class="nav-link" href="/admin/settings"><i class="fas fa-cog"></i><span>Settings</span></a>
                <a class="nav-link" href="/admin/media"><i class="fas fa-images"></i><span>Media</span></a>
            </nav>
            <nav class="nav-section">
                <div class="nav-label">CMS</div>
                <a class="nav-link" href="/admin/cms"><i class="fas fa-tachometer-alt"></i><span>CMS Dashboard</span></a>
                <a class="nav-link" href="/admin/cms/pages"><i class="fas fa-file"></i><span>Pages</span></a>
                <a class="nav-link" href="/admin/cms/articles"><i class="fas fa-newspaper"></i><span>Articles</span></a>
            </nav>
            <nav class="nav-section">
                <div class="nav-label">Lainnya</div>
                <a class="nav-link" href="/admin/testimonial"><i class="fas fa-quote-left"></i><span>Testimonials</span></a>
                <a class="nav-link" href="/admin/support"><i class="fas fa-life-ring"></i><span>Support</span></a>
                <a class="nav-link" href="/auth/logout"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
            </nav>
        </aside>
        <div class="main-content">
            <header class="topbar">
                <button class="sidebar-toggle" data-sidebar-toggle><i class="fas fa-bars"></i></button>
                <div class="user-menu">
                    <div class="user-avatar">A</div>
                    <span class="text-dark">Admin</span>
                </div>
            </header>
            <main class="content" style="padding: 30px;">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Media Manager</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <button class="btn btn-primary mb-3">Upload Media</button>
                            <a href="/admin/media/upload" class="btn btn-outline-secondary">Upload</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Thumbnail</th>
                                        <th>Filename</th>
                                        <th>Type</th>
                                        <th>Size</th>
                                        <th>Uploaded</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($media)): ?>
                                        <?php foreach ($media as $i => $media): ?>
                                            <tr>
                                                <td><?= $i + 1 + (($pager->getCurrentPage() - 1) * $pager->getPerPage()) ?></td>
                                                <td>
                                                    <?php if ($media->path): ?>
                                                        <img src="<?= esc($media->path) ?>" alt="<?= esc($media->filename) ?>" class="media-item">
                                                    <?php else: ?>
                                                        <i class="fas fa-image"></i>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= esc($media->filename) ?></td>
                                                <td><?= esc($media->mime_type) ?></td>
                                                <td><?= number_format($media->size / 1024, 1) ?> KB</td>
                                                <td><?= esc($media->created_at) ?></td>
                                                <td>
                                                    <a href="/admin/media/detail/<?= esc($media->id) ?>" class="btn btn-sm btn-outline-primary">View</a>
                                                    <a href="/admin/media/delete/<?= esc($media->id) ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="6" class="text-center text-muted py-4">No media files found</td></tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
        });
    </script>
</body>
</html>
</path>