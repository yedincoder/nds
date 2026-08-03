<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3><?= isset($article) ? 'Edit Article' : 'Create Article' ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/cms/dashboard">CMS</a></li>
            <li class="breadcrumb-item"><a href="/admin/cms/articles">Articles</a></li>
            <li class="breadcrumb-item active"><?= isset($article) ? 'Edit' : 'Create' ?></li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= isset($article) ? '/admin/cms/articles/'.$article->id.'/update' : '/admin/cms/articles/create' ?>" method="POST">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="<?= esc($article->title ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" value="<?= esc($article->slug ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea name="content" id="article_content" class="form-control" rows="10" required><?= esc($article->content ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Excerpt</label>
                        <textarea name="excerpt" class="form-control" rows="3" required><?= esc($article->excerpt ?? '') ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Author</label>
                        <input type="text" name="author" class="form-control" value="<?= esc($article->author ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Published At</label>
                        <input type="datetime-local" name="published_at" class="form-control" value="<?= esc($article->published_at ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories ?? [] as $cat): ?>
                            <option value="<?= $cat->id ?>" <?= ($article->category_id ?? '') == $cat->id ? 'selected' : '' ?>><?= esc($cat->name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" <?= ($article->status ?? 'pending') == 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="approved" <?= ($article->status ?? '') == 'approved' ? 'selected' : '' ?>>Approved</option>
                            <option value="archived" <?= ($article->status ?? '') == 'archived' ? 'selected' : '' ?>>Archived</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="<?= esc($article->meta_title ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="3"><?= esc($article->meta_description ?? '') ?></textarea>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Save Article</button>
                <a href="/admin/cms/articles" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#article_content'), {
            toolbar: [
                'heading', '|', 'bold', 'italic', 'underline', '|',
                'alignment', '|', 'bulletedList', 'numberedList', '|',
                'outdent', 'indent', '|',
                'link', 'blockQuote', 'codeBlock', '|',
                'undo', 'redo'
            ],
        })
        .then(editor => {
            window.articleEditor = editor;
        })
        .catch(error => {
            console.error(error);
        });
</script>
<?= $this->endSection() ?>
