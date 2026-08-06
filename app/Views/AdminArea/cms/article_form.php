<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3><?= esc($title ?? 'Article Form') ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/cms">CMS</a></li>
            <li class="breadcrumb-item"><a href="/admin/cms/articles">Articles</a></li>
            <li class="breadcrumb-item active"><?= !empty($article) ? 'Edit' : 'Create' ?></li>
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
        <div class="card-title"><?= !empty($article) ? 'Edit Article' : 'Create Article' ?></div>
    </div>
    <div class="card-body">
        <?php $article = $article ?? new stdClass(); ?>
        <form method="post" action="<?= !empty($article->id) ? "/admin/cms/articles/{$article->id}/update" : "/admin/cms/articles/create" ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Title *</label>
                <input type="text" class="form-control" name="title" value="<?= esc($article->title ?? set_value('title')) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Slug *</label>
                <input type="text" class="form-control" name="slug" value="<?= esc($article->slug ?? set_value('slug')) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Content *</label>
                <textarea class="form-control ckeditor" name="content" rows="10" required><?= esc($article->content ?? set_value('content')) ?></textarea>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label">Category *</label>
                    <select class="form-select" name="category_id" required>
                        <option value="">Select Category</option>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                            <option value="<?= esc($cat->id) ?>" <?= ($article->category_id ?? set_value('category_id')) == $cat->id ? 'selected' : '' ?>><?= esc($cat->name) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status *</label>
                    <select class="form-select" name="status" required>
                        <option value="pending" <?= ($article->status ?? set_value('status')) === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="approved" <?= ($article->status ?? set_value('status')) === 'approved' ? 'selected' : '' ?>>Approved</option>
                        <option value="archived" <?= ($article->status ?? set_value('status')) === 'archived' ? 'selected' : '' ?>>Archived</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Author *</label>
                    <input type="text" class="form-control" name="author" value="<?= esc($article->author ?? set_value('author')) ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Excerpt *</label>
                <input type="text" class="form-control" name="excerpt" value="<?= esc($article->excerpt ?? set_value('excerpt')) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Published At</label>
                <input type="date" class="form-control" name="published_at" value="<?= esc($article->published_at ?? set_value('published_at')) ?>">
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Meta Title</label>
                    <input type="text" class="form-control" name="meta_title" value="<?= esc($article->meta_title ?? set_value('meta_title')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Meta Description</label>
                    <input type="text" class="form-control" name="meta_description" value="<?= esc($article->meta_description ?? set_value('meta_description')) ?>">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Tags</label>
                <div>
                    <?php if (!empty($tags)): ?>
                        <?php foreach ($tags as $tag): ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="tags[]" value="<?= esc($tag->id) ?>" id="tag_<?= esc($tag->id) ?>">
                            <label class="form-check-label" for="tag_<?= esc($tag->id) ?>"><?= esc($tag->name) ?></label>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3"><?= !empty($article->id) ? 'Update' : 'Create' ?> Article</button>
            <a href="/admin/cms/articles" class="btn btn-secondary">Cancel</a>
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