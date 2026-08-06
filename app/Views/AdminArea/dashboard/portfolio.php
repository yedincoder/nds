<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Portfolio</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item active">Portfolio</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Manage Portfolio</div>
    </div>
    <div class="card-body" style="padding:8px 16px">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Project</th>
                        <th>Status</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($portfolios)): ?>
                        <?php foreach ($portfolios as $i => $portfolio): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><strong><?= esc($portfolio->title ?? $portfolio->name ?? '-') ?></strong></td>
                                <td>
                                    <?php $st = match($portfolio->status ?? 'draft') {
                                        'published','featured' => 'bg-success', default => 'bg-secondary'
                                    }; ?>
                                    <span class="badge <?= $st ?>"><?= ucfirst(esc($portfolio->status ?? 'draft')) ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($portfolio->created_at ?? '')) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center py-4">Belum ada portfolio</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>