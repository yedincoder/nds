<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3><?= isset($page) ? 'Edit Page' : 'Create Page' ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/cms/dashboard">CMS</a></li>
            <li class="breadcrumb-item"><a href="/admin/cms/pages">Pages</a></li>
            <li class="breadcrumb-item active"><?= isset($page) ? 'Edit' : 'Create' ?></li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= isset($page) ? '/admin/cms/pages/'.$page->id.'/update' : '/admin/cms/pages/create' ?>" method="POST">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="<?= esc($page->title ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" value="<?= esc($page->slug ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea name="content" id="page_content" class="form-control" rows="10" required><?= esc($page->content ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Excerpt</label>
                        <textarea name="excerpt" class="form-control" rows="3"><?= esc($page->excerpt ?? '') ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">Select Category</option>
                            <?php foreach ($categories ?? [] as $cat): ?>
                            <option value="<?= $cat->id ?>" <?= ($page->category_id ?? '') == $cat->id ? 'selected' : '' ?>><?= esc($cat->name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="draft" <?= ($page->status ?? 'draft') == 'draft' ? 'selected' : '' ?>>Draft</option>
                            <option value="published" <?= ($page->status ?? '') == 'published' ? 'selected' : '' ?>>Published</option>
                            <option value="archived" <?= ($page->status ?? '') == 'archived' ? 'selected' : '' ?>>Archived</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="<?= esc($page->meta_title ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="3"><?= esc($page->meta_description ?? '') ?></textarea>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Save Page</button>
                <a href="/admin/cms/pages" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#page_content'), {
            toolbar: [
                'heading', '|', 'bold', 'italic', 'underline', '|',
                'alignment', '|', 'bulletedList', 'numberedList', '|',
                'outdent', 'indent', '|',
                'link', 'blockQuote', 'codeBlock', '|',
                'undo', 'redo'
            ],
        })
        .then(editor => {
            window.pageEditor = editor;
        })
        .catch(error => {
            console.error(error);
        });
</script>
<?= $this->endSection() ?>
