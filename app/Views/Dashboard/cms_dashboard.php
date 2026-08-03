<?= $this->extend('layouts/admin')?>

<?= $this->section('content')?>

<div class="page-title">
    <h3>CMS Dashboard</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">CMS</li>
        </ol>
    </nav>
</div>

<!-- Statistics - 1 row x 4 columns -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:var(--primary-soft);color:var(--primary)"><i class="fas fa-file-alt"></i></div>
                    <div class="kpi-label">Total Pages</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['pages'] ?? 0) ?></div>
            <div class="kpi-subtext">Halaman website</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:rgba(56,189,248,.12);color:#0284c7"><i class="fas fa-edit"></i></div>
                    <div class="kpi-label">Total Articles</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['articles'] ?? 0) ?></div>
            <div class="kpi-subtext">Artikel & tutorial</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:rgba(239,68,68,.12);color:#dc2626"><i class="fas fa-folder"></i></div>
                    <div class="kpi-label">Categories</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['categories'] ?? 0) ?></div>
            <div class="kpi-subtext">Kategori konten</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:rgba(245,158,11,.14);color:#b45309"><i class="fas fa-tags"></i></div>
                    <div class="kpi-label">Tags</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['tags'] ?? 0) ?></div>
            <div class="kpi-subtext">Label konten</div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">CMS Quick Actions</div>
            </div>
            <div class="card-body">
                <a href="/admin/cms/pages" class="btn btn-primary me-2 mb-2"><i class="fas fa-file-alt me-1"></i> Manage Pages</a>
                <a href="/admin/cms/articles" class="btn btn-outline-primary me-2 mb-2"><i class="fas fa-edit me-1"></i> Manage Articles</a>
                <a href="/admin/cms/categories" class="btn btn-outline-primary me-2 mb-2"><i class="fas fa-folder me-1"></i> Categories</a>
                <a href="/admin/cms/tags" class="btn btn-outline-primary mb-2"><i class="fas fa-tags me-1"></i> Tags</a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Pages & Articles -->
<div class="row">
    <div class="col-xl-8 col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Recent Pages</div>
                <a href="/admin/cms/pages" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body" style="padding:8px 16px">
                <?php if (!empty($recent_pages)):?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_pages as $page):?>
                            <tr>
                                <td><strong><?= esc($page->title ?? '-') ?></strong></td>
                                <td><?= esc($page->slug ?? '-') ?></td>
                                <td>
                                    <?php
                                    $statusClass = match($page->status ?? 'draft') {
                                        'draft' => 'bg-secondary',
                                        'published' => 'bg-success',
                                        'archived' => 'bg-warning',
                                        default => 'bg-secondary'
                                    };
                                    ?>
                                    <span class="badge <?= $statusClass ?>"><?= esc(ucfirst($page->status ?? 'draft')) ?></span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="/admin/cms/pages/<?= $page->id ?>/edit" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                        <a href="/admin/cms/pages/<?= $page->id ?>/delete" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <?php else:?>
                <div class="text-center py-4">
                    <i class="fas fa-file-alt fa-2x mb-2" style="color:var(--t-muted);opacity:.3"></i>
                    <p class="mb-0 text-muted">Belum ada halaman</p>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Recent Articles</div>
                <a href="/admin/cms/articles" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_articles)):?>
                <?php foreach ($recent_articles as $article):?>
                <div class="py-2 border-bottom">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <strong style="font-size:13px"><?= esc($article->title ?? '-') ?></strong>
                        <?php
                        $aClass = match($article->status ?? 'pending') {
                            'published' => 'bg-success',
                            'pending' => 'bg-warning',
                            'archived' => 'bg-secondary',
                            default => 'bg-secondary'
                        };
                        ?>
                        <span class="badge <?= $aClass ?>"><?= esc(ucfirst($article->status ?? 'pending')) ?></span>
                    </div>
                    <small class="text-muted"><?= esc($article->author ?? '') ?> · <?= date('d M Y', strtotime($article->published_at ?? $article->created_at ?? date('Y-m-d'))) ?></small>
                </div>
                <?php endforeach;?>
                <?php else:?>
                <div class="text-center py-4">
                    <i class="fas fa-edit fa-2x mb-2" style="color:var(--t-muted);opacity:.3"></i>
                    <p class="mb-0 text-muted">Belum ada artikel</p>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection()?>
