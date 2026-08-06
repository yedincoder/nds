<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>CMS Dashboard</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item active">CMS</li>
        </ol>
    </nav>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:var(--primary-soft);color:var(--primary)"><i class="fas fa-file-alt"></i></div>
                    <div class="kpi-label">Pages</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['pages'] ?? 0) ?></div>
            <div class="kpi-subtext">Total halaman</div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:var(--primary-soft);color:var(--primary)"><i class="fas fa-newspaper"></i></div>
                    <div class="kpi-label">Articles</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['articles'] ?? 0) ?></div>
            <div class="kpi-subtext">Total artikel</div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:var(--primary-soft);color:var(--primary)"><i class="fas fa-folder"></i></div>
                    <div class="kpi-label">Categories</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['categories'] ?? 0) ?></div>
            <div class="kpi-subtext">Total kategori</div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:var(--primary-soft);color:var(--primary)"><i class="fas fa-tags"></i></div>
                    <div class="kpi-label">Tags</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['tags'] ?? 0) ?></div>
            <div class="kpi-subtext">Total tag</div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Recent Pages</div>
                <a href="/admin/cms/pages" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body" style="padding:8px 16px">
                <?php if (!empty($recent_pages)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr><th>Title</th><th>Status</th><th>Date</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_pages as $pg): ?>
                            <tr>
                                <td><strong><?= esc($pg->title ?? '-') ?></strong></td>
                                <td>
                                    <?php $pc = ($pg->status ?? 'draft') === 'published' ? 'bg-success' : 'bg-secondary'; ?>
                                    <span class="badge <?= $pc ?>"><?= ucfirst(esc($pg->status ?? 'draft')) ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($pg->created_at ?? '')) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted text-center py-3">Belum ada halaman</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Recent Articles</div>
                <a href="/admin/cms/articles" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body" style="padding:8px 16px">
                <?php if (!empty($recent_articles)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr><th>Title</th><th>Status</th><th>Date</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_articles as $art): ?>
                            <tr>
                                <td><strong><?= esc($art->title ?? '-') ?></strong></td>
                                <td>
                                    <?php $ac = match($art->status ?? 'pending') {
                                        'approved' => 'bg-success', 'pending' => 'bg-warning', default => 'bg-secondary'
                                    }; ?>
                                    <span class="badge <?= $ac ?>"><?= ucfirst(esc($art->status ?? 'pending')) ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($art->created_at ?? '')) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted text-center py-3">Belum ada artikel</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>