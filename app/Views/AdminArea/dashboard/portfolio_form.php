<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3><?= !empty($portfolio) ? 'Edit Portfolio' : 'Create Portfolio' ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item"><a href="/admin/portfolio">Portfolio</a></li>
            <li class="breadcrumb-item active"><?= !empty($portfolio) ? 'Edit' : 'Create' ?></li>
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

<?php $portfolio = $portfolio ?? new stdClass(); ?>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title"><?= !empty($portfolio) ? 'Edit Portfolio' : 'Create Portfolio' ?></div>
            </div>
            <div class="card-body">
                <form method="post" action="<?= !empty($portfolio->id) ? "/admin/portfolio/update/{$portfolio->id}" : "/admin/portfolio/create" ?>">
                    <?= csrf_field() ?>
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Title *</label>
                            <input type="text" class="form-control" name="title" value="<?= esc($portfolio->title ?? set_value('title')) ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status *</label>
                            <select class="form-select" name="status" required>
                                <option value="draft" <?= ($portfolio->status ?? set_value('status', 'draft')) === 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="published" <?= ($portfolio->status ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
                                <option value="featured" <?= ($portfolio->status ?? '') === 'featured' ? 'selected' : '' ?>>Featured</option>
                                <option value="archived" <?= ($portfolio->status ?? '') === 'archived' ? 'selected' : '' ?>>Archived</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Slug *</label>
                            <input type="text" class="form-control" name="slug" value="<?= esc($portfolio->slug ?? set_value('slug')) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Client</label>
                            <select class="form-select" name="client_id">
                                <option value="">Select Client</option>
                                <?php if (!empty($clients)): ?>
                                    <?php foreach ($clients as $cl): ?>
                                    <option value="<?= esc($cl->id) ?>" <?= ($portfolio->client_id ?? set_value('client_id')) == $cl->id ? 'selected' : '' ?>><?= esc($cl->name) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control ckeditor" name="description" rows="6"><?= esc($portfolio->description ?? set_value('description')) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea class="form-control ckeditor" name="content" rows="12"><?= esc($portfolio->content ?? set_value('content')) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Thumbnail URL</label>
                        <input type="text" class="form-control" name="thumbnail" value="<?= esc($portfolio->thumbnail ?? set_value('thumbnail')) ?>" placeholder="https://...">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">SEO Title</label>
                            <input type="text" class="form-control" name="seo_title" value="<?= esc($portfolio->seo_title ?? set_value('seo_title')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">SEO Description</label>
                            <input type="text" class="form-control" name="seo_description" value="<?= esc($portfolio->seo_description ?? set_value('seo_description')) ?>">
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i><?= !empty($portfolio->id) ? 'Update' : 'Create' ?> Portfolio</button>
                        <a href="/admin/portfolio" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
<script>
document.querySelectorAll('.ckeditor').forEach(function(el) {
    ClassicEditor.create(el).catch(function(err) { console.error(err); });
});
</script>
<?= $this->endSection() ?>
