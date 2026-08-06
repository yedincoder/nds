<?= $this->extend('Layout/layout_frontarea') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="container">
        <h1>Blog</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Blog</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <?php if (!empty($articles)): ?>
                    <?php foreach ($articles as $article): ?>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge-category"><?= esc($article->category_name ?? 'Blog') ?></span>
                            </div>
                            <h2 class="card-title h5">
                                <a href="/article/<?= esc($article->slug ?? $article->id) ?>" style="color:var(--text-dark);text-decoration:none"><?= esc($article->title) ?></a>
                            </h2>
                            <p class="text-muted"><?= esc($article->excerpt ?? '') ?></p>
                            <small class="text-muted"><?= date('d M Y', strtotime($article->published_at ?? $article->created_at ?? 'now')) ?></small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-info">Belum ada artikel.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>