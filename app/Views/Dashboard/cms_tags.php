<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Manage Tags</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/cms/dashboard">CMS</a></li>
            <li class="breadcrumb-item active">Tags</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Tags</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addTag">Add Tag</button>
    </div>
    <div class="card-body">
        <?php if (!empty($tags)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Articles</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tags as $tag): ?>
                    <tr>
                        <td><?= esc($tag->name ?? '') ?></td>
                        <td><?= esc($tag->slug ?? '') ?></td>
                        <td><?= $tag->article_count ?? 0 ?></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p class="text-center">No tags found</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
