<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="container">
        <h1><?= esc($title ?? 'Articles') ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/blog">Blog</a></li>
                <li class="breadcrumb-item active"><?= esc($title ?? 'Articles') ?></li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title"><?= esc($title ?? 'Artikel') ?></h2>
            <p class="section-subtitle">Wawasan, tips, dan update teknologi terbaru dari tim kami</p>
        </div>
        <div class="row g-4">
            <?php if (!empty($articles)): ?>
            <?php foreach ($articles as $article): ?>
            <div class="col-md-6 col-lg-4">
                <div class="product-card h-100">
                    <div class="product-img">
                        <?php if (!empty($article->thumbnail)): ?>
                        <img src="<?= esc($article->thumbnail) ?>" alt="<?= esc($article->title) ?>" style="width:100%;height:100%;object-fit:cover;">
                        <?php else: ?>
                        <i class="fas fa-newspaper fa-4x"></i>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <?php if (!empty($article->category_name)): ?>
                            <span class="badge-category"><?= esc($article->category_name) ?></span>
                            <?php endif; ?>
                            <small class="text-muted"><?= date('d M Y', strtotime($article->published_at ?? '')) ?></small>
                        </div>
                        <h5><?= esc($article->title) ?></h5>
                        <p class="text-muted mb-3"><?= esc(substr($article->excerpt ?? '', 0, 100)) ?></p>
                        <a href="/article/<?= esc($article->slug) ?>" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada artikel pada kategori ini.</p>
                <a href="/blog" class="btn btn-primary mt-2">Kembali ke Blog</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
