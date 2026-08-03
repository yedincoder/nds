<?= $this->extend('layouts/admin')?>

<?= $this->section('content')?>

<div class="page-title">
    <h3>CMS Dashboard</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">CMS Dashboard</li>
        </ol>
    </nav>
</div>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card" style="border-left-color: #1ABB9C;">
            <h3><?= number_format($stats['pages']?? 0)?></h3>
            <p><i class="fas fa-file-alt me-2"></i>Total Pages</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card" style="border-left-color: #3498DB;">
            <h3><?= number_format($stats['articles']?? 0)?></h3>
            <p><i class="fas fa-edit me-2"></i>Total Articles</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card" style="border-left-color: #E74C3E;">
            <h3><?= number_format($stats['categories']?? 0)?></h3>
            <p><i class="fas fa-folder me-2"></i>Categories</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card" style="border-left-color: #F39C12;">
            <h3><?= number_format($stats['tags']?? 0)?></h3>
            <p><i class="fas fa-tags me-2"></i>Tags</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">CMS Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="/admin/cms/pages" class="btn btn-primary me-2 mb-2">
                    <i class="fas fa-file-alt me-1"></i> Manage Pages
                </a>
                <a href="/admin/cms/articles" class="btn btn-primary me-2 mb-2">
                    <i class="fas fa-edit me-1"></i> Manage Articles
                </a>
                <a href="/admin/cms/categories" class="btn btn-primary me-2 mb-2">
                    <i class="fas fa-folder me-1"></i> Manage Categories
                </a>
                <a href="/admin/cms/tags" class="btn btn-primary mb-2">
                    <i class="fas fa-tags me-1"></i> Manage Tags
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Pages -->
<div class="row">
    <div class="col-xl-8 col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Pages</h5>
                <a href="/admin/cms/pages" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_pages)):?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_pages as $page):?>
                            <tr>
                                <td><?= esc($page->title?? '-')?></td>
                                <td><?= esc($page->slug?? '-')?></td>
                                <td>
                                    <?php
                                    $statusClass = match($page->status?? 'draft') {
                                        'draft' => 'bg-warning',
                                        'published' => 'bg-success',
                                        'archived' => 'bg-secondary',
                                        default => 'bg-secondary'
                                    };
                                    ?>
                                    <span class="badge <?= $statusClass?>"><?= esc(ucfirst($page->status?? 'draft'))?></span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="/admin/cms/pages/edit/<?= $page->id?>" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                        <form action="<?= site_url('/admin/cms/pages/delete/'. $page->id)?>" method="POST" style="display:inline">
                                            <input type="hidden" name="id" value="<?= $page->id?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <?php else:?>
                <div class="text-center py-4">
                    <i class="fas fa-file-alt fa-3x mb-3" style="color: var(--text-primary); opacity: 0.3;"></i>
                    <p class="mb-0">No pages yet</p>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Articles</h5>
                <a href="/admin/cms/articles" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_articles)):?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Published</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_articles as $article):?>
                            <tr>
                                <td><?= esc($article->title?? '-')?></td>
                                <td><?= esc($article->author?? '-')?></td>
                                <td><?= date('d M Y', strtotime($article->published_at?? date('Y-m-d')))?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="/admin/cms/articles/edit/<?= $article->id?>" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                        <form action="<?= site_url('/admin/cms/articles/delete/'.$article->id)?>" method="POST" style="display:inline">
                                            <input type="hidden" name="id" value="<?= $article->id?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <?php else:?>
                <div class="text-center py-4">
                    <i class="fas fa-edit fa-3x mb-3" style="color: var(--text-primary); opacity: 0.3;"></i>
                    <p class="mb-0">No articles yet</p>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection()?>

<?= $this->section('scripts')?>
<script>
// CMS-specific JavaScript
</script>
<?= $this->endSection()?>