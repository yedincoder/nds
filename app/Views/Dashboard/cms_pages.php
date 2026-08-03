<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Manage Pages</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/cms/dashboard">CMS</a></li>
            <li class="breadcrumb-item active">Pages</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Pages</h5>
        <a href="/admin/cms/pages/create" class="btn btn-primary btn-sm">Add Page</a>
    </div>
    <div class="card-body">
        <?php if (!empty($pages)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pages as $page): ?>
                    <tr>
                        <td><?= esc($page->title ?? '') ?></td>
                        <td><?= esc($page->slug ?? '') ?></td>
                        <td><span class="badge bg-info"><?= esc($page->status ?? 'draft') ?></span></td>
                        <td><?= date('d M Y', strtotime($page->created_at ?? date('Y-m-d'))) ?></td>
                        <td>
                            <a href="/admin/cms/pages/<?= $page->id ?>/edit" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <a href="/admin/cms/pages/<?= $page->id ?>/delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p class="text-center">No pages found</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
