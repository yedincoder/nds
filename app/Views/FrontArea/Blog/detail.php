<?= $this->extend('Layout/layout_frontarea') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="container">
        <h1><?= esc($article->title ?? 'Article') ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/blog">Blog</a></li>
                <li class="breadcrumb-item active"><?= esc($article->title ?? '') ?></li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge-category"><?= esc($article->category_name ?? 'Blog') ?></span>
                            <small class="text-muted ms-auto"><?= date('d M Y', strtotime($article->published_at ?? $article->created_at ?? 'now')) ?></small>
                        </div>
                        <h1 class="h3 mb-4"><?= esc($article->title ?? '') ?></h1>
                        <?php if (!empty($article->thumbnail)): ?>
                        <img src="<?= esc($article->thumbnail) ?>" alt="<?= esc($article->title ?? '') ?>" class="img-fluid rounded mb-4 w-100">
                        <?php endif; ?>
                        <div class="article-content">
                            <?= $article->content ?? '' ?>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="/blog" class="btn btn-outline-primary"><i class="fas fa-arrow-left me-1"></i>Back to Blog</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>