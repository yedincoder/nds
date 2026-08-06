<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Articles</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/cms">CMS</a></li>
            <li class="breadcrumb-item active">Articles</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Manage Articles</div>
        <a href="/admin/cms/articles/create" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i>Add Article</a>
    </div>
    <div class="card-body" style="padding:8px 16px">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($articles)): ?>
                        <?php foreach ($articles as $i => $article): ?>
                            <tr>
                                <td><?= $i + 1 + (($pager->getCurrentPage() - 1) * $pager->getPerPage()) ?></td>
                                <td><strong><?= esc($article->title ?? '-') ?></strong></td>
                                <td><?= esc($article->category_name ?? '-') ?></td>
                                <td>
                                    <?php $sc = match($article->status ?? 'pending') {
                                        'approved' => 'bg-success', 'pending' => 'bg-warning', default => 'bg-secondary'
                                    }; ?>
                                    <span class="badge <?= $sc ?>"><?= ucfirst(esc($article->status ?? 'pending')) ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($article->created_at ?? '')) ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="/admin/cms/articles/<?= esc($article->id) ?>/edit" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                        <a href="/admin/cms/articles/<?= esc($article->id) ?>/delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this article?')"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center py-4">Belum ada artikel</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <?= $pager ? $pager->links() : '' ?>
    </div>
</div>

<?= $this->endSection() ?>