<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Manage Articles</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/cms/dashboard">CMS</a></li>
            <li class="breadcrumb-item active">Articles</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Articles</h5>
        <a href="/admin/cms/articles/create" class="btn btn-primary btn-sm">Add Article</a>
    </div>
    <div class="card-body">
        <?php if (!empty($articles)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $article): ?>
                    <tr>
                        <td><?= esc($article->title ?? '') ?></td>
                        <td><?= esc($article->author ?? '') ?></td>
                        <td><span class="badge bg-success"><?= esc($article->status ?? 'pending') ?></span></td>
                        <td><?= date('d M Y', strtotime($article->published_at ?? date('Y-m-d'))) ?></td>
                        <td>
                            <a href="/admin/cms/articles/<?= $article->id ?>/edit" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <a href="/admin/cms/articles/<?= $article->id ?>/delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p class="text-center">No articles found</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
