<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Tags</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/cms">CMS</a></li>
            <li class="breadcrumb-item active">Tags</li>
        </ol>
    </nav>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Add Tag</div>
            </div>
            <div class="card-body">
                <form method="post" action="/admin/cms/tags/create">
                    <div class="mb-3">
                        <label class="form-label">Name *</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" class="form-control" name="slug">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Add Tag</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Manage Tags</div>
            </div>
            <div class="card-body" style="padding:8px 16px">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr><th>#</th><th>Name</th><th>Slug</th><th>Description</th><th>Actions</th></tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($tags)): ?>
                                <?php foreach ($tags as $i => $tag): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><strong><?= esc($tag->name) ?></strong></td>
                                    <td><?= esc($tag->slug) ?></td>
                                    <td><?= esc($tag->description ?? '-') ?></td>
                                    <td>
                                        <a href="/admin/cms/tags/<?= esc($tag->id) ?>/delete" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center py-4">Belum ada tag</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>