<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3><?= esc($title ?? 'Page Form') ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/cms">CMS</a></li>
            <li class="breadcrumb-item"><a href="/admin/cms/pages">Pages</a></li>
            <li class="breadcrumb-item active"><?= !empty($pageData) ? 'Edit' : 'Create' ?></li>
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

<div class="card">
    <div class="card-header">
        <div class="card-title"><?= !empty($pageData) ? 'Edit Page' : 'Create Page' ?></div>
    </div>
    <div class="card-body">
        <?php $pageData = $pageData ?? new stdClass(); ?>
        <form method="post" action="<?= !empty($pageData->id) ? "/admin/cms/pages/{$pageData->id}/update" : "/admin/cms/pages/create" ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Title *</label>
                <input type="text" class="form-control" name="title" value="<?= esc($pageData->title ?? set_value('title')) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Slug *</label>
                <input type="text" class="form-control" name="slug" value="<?= esc($pageData->slug ?? set_value('slug')) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Content *</label>
                <textarea class="form-control ckeditor" name="content" rows="10" required><?= esc($pageData->content ?? set_value('content')) ?></textarea>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <select class="form-select" name="category_id">
                        <option value="">Select Category</option>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                            <option value="<?= esc($cat->id) ?>" <?= ($pageData->category_id ?? set_value('category_id')) == $cat->id ? 'selected' : '' ?>><?= esc($cat->name) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="draft" <?= ($pageData->status ?? set_value('status')) === 'draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="published" <?= ($pageData->status ?? set_value('status')) === 'published' ? 'selected' : '' ?>>Published</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Excerpt</label>
                <input type="text" class="form-control" name="excerpt" value="<?= esc($pageData->excerpt ?? set_value('excerpt')) ?>">
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Meta Title</label>
                    <input type="text" class="form-control" name="meta_title" value="<?= esc($pageData->meta_title ?? set_value('meta_title')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Meta Description</label>
                    <input type="text" class="form-control" name="meta_description" value="<?= esc($pageData->meta_description ?? set_value('meta_description')) ?>">
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i><?= !empty($pageData->id) ? 'Update' : 'Create' ?> Page</button>
                <a href="/admin/cms/pages" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.ckeditor').forEach(function(el) {
        ClassicEditor.create(el).catch(function(err) { console.error(err); });
    });
});
</script>
<?= $this->endSection() ?>