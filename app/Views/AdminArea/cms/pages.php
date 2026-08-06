<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Pages</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/cms">CMS</a></li>
            <li class="breadcrumb-item active">Pages</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Manage Pages</div>
        <a href="/admin/cms/pages/create" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i>Add Page</a>
    </div>
    <div class="card-body" style="padding:8px 16px">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pages)): ?>
                        <?php foreach ($pages as $i => $page): ?>
                            <tr>
                                <td><?= $i + 1 + (($pager->getCurrentPage() - 1) * $pager->getPerPage()) ?></td>
                                <td><strong><?= esc($page->title ?? '-') ?></strong></td>
                                <td><?= esc($page->slug ?? '-') ?></td>
                                <td>
                                    <?php $st = ($page->status ?? 'draft') === 'published' ? 'bg-success' : 'bg-secondary'; ?>
                                    <span class="badge <?= $st ?>"><?= ucfirst(esc($page->status ?? 'draft')) ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($page->created_at ?? '')) ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="/admin/cms/pages/<?= esc($page->id) ?>/edit" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                        <a href="/admin/cms/pages/<?= esc($page->id) ?>/delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this page?')"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center py-4">Belum ada halaman</td></tr>
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