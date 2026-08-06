<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Edit Tag</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/cms">CMS</a></li>
            <li class="breadcrumb-item"><a href="/admin/cms/tags">Tags</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<?php if (session()->getFlashdata('errors')): ?>
<div class="alert alert-danger">
    <ul class="mb-0">
        <?php foreach (session('errors') as $e): ?>
        <li><?= esc($e) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Edit Tag</div>
            </div>
            <div class="card-body">
                <form method="post" action="/admin/cms/tags/update/<?= esc($tag->id) ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Name *</label>
                        <input type="text" class="form-control" name="name" value="<?= esc($tag->name) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug *</label>
                        <input type="text" class="form-control" name="slug" value="<?= esc($tag->slug) ?>" required>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update Tag</button>
                        <a href="/admin/cms/tags" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>