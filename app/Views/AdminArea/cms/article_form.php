<?php
/** @var \CodeIgniter\View\View $this */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Form') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary: #E65C00; --secondary: #1A1A2E; --light-bg: #FFFAF5; --text-dark: #2D2D2D; }
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
        .form-label { font-weight: 600; }
        .form-control, .form-select { border: 1px solid #ced4da; border-radius: 8px; }
        .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 0.25rem rgba(230,92,0,0.25); }
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: #C44900; border-color: #C44900; }
        .error-msg { color: #dc3545; font-size: 13px; }
    </style>
</head>
<body data-active="cms">
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
                <a class="nav-link active" href="/admin/cms/articles"><i class="fas fa-newspaper"></i><span>Articles</span></a>
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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="section-title mb-0"><?= esc($title) ?></h1>
                    <a href="/admin/cms/articles" class="btn btn-outline-secondary">Back</a>
                </div>
                <?php if (session()->has('errors')): ?>
                    <div class="alert alert-danger">
                        <?php foreach (session('errors') as $error): ?>
                            <div class="error-msg"><?= esc($error) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="<?= esc($article->id ?? '') ? "/admin/cms/articles/{$article->id}/update" : "/admin/cms/articles/create" ?>">
                            <div class="mb-3">
                                <label class="form-label">Title *</label>
                                <input type="text" class="form-control" name="title" value="<?= esc($article->title ?? set_value('title')) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Slug *</label>
                                <input type="text" class="form-control" name="slug" value="<?= esc($article->slug ?? set_value('slug')) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Content *</label>
                                <textarea class="form-control" name="content" rows="10" required><?= esc($article->content ?? set_value('content')) ?></textarea>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Category *</label>
                                        <select class="form-select" name="category_id" required>
                                            <option value="">Select Category</option>
                                            <?php if (!empty($categories)): ?>
                                                <?php foreach ($categories as $cat): ?>
                                                    <option value="<?= esc($cat->id) ?>" <?= ($article->category_id ?? set_value('category_id')) == $cat->id ? 'selected' : '' ?>><?= esc($cat->name) ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Status *</label>
                                        <select class="form-select" name="status" required>
                                            <option value="pending" <?= ($article->status ?? set_value('status')) === 'pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="approved" <?= ($article->status ?? set_value('status')) === 'approved' ? 'selected' : '' ?>>Approved</option>
                                            <option value="archived" <?= ($article->status ?? set_value('status')) === 'archived' ? 'selected' : '' ?>>Archived</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Author *</label>
                                        <input type="text" class="form-control" name="author" value="<?= esc($article->author ?? set_value('author')) ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Excerpt *</label>
                                <input type="text" class="form-control" name="excerpt" value="<?= esc($article->excerpt ?? set_value('excerpt')) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Published At</label>
                                <input type="date" class="form-control" name="published_at" value="<?= esc($article->published_at ?? set_value('published_at')) ?>">
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Meta Title</label>
                                        <input type="text" class="form-control" name="meta_title" value="<?= esc($article->meta_title ?? set_value('meta_title')) ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Meta Description</label>
                                        <input type="text" class="form-control" name="meta_description" value="<?= esc($article->meta_description ?? set_value('meta_description')) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tags</label>
                                <div>
                                    <?php if (!empty($tags)): ?>
                                        <?php foreach ($tags as $tag): ?>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="tags[]" value="<?= esc($tag->id) ?>" id="tag_<?= esc($tag->id) ?>">
                                                <label class="form-check-label" for="tag_<?= esc($tag->id) ?>"><?= esc($tag->name) ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3"><?= esc($article->id ?? '') ? 'Update' : 'Create' ?> Article</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggle = document.querySelector("[data-sidebar-toggle]");
            const sidebar = document.getElementById("sidebar");
            toggle?.addEventListener("click", function() {
                sidebar.classList.toggle("collapsed");
                document.body.classList.toggle("sidebar-collapsed");
            });
        });
    </script>
</body>
</html>
</path>