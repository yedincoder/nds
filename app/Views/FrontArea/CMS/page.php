<?= $this->extend('Layout/layout_frontarea') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="container">
        <h1>Blog</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/blog">Blog</a></li>
                <li class="breadcrumb-item active"><?= esc($article->title ?? 'Artikel') ?></li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <article>
                    <div class="text-center mb-4">
                        <?php if (!empty($article->category_name)): ?>
                        <span class="badge-category mb-3"><?= esc($article->category_name) ?></span>
                        <?php endif; ?>
                        <h1 class="mb-3"><?= esc($article->title ?? '') ?></h1>
                        <div class="text-muted mb-4">
                            <i class="far fa-calendar-alt me-1"></i><?= date('d M Y', strtotime($article->published_at ?? 'now')) ?>
                            <?php if (!empty($article->author_name)): ?>
                            <span class="mx-2">|</span>
                            <i class="far fa-user me-1"></i><?= esc($article->author_name) ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (!empty($article->thumbnail)): ?>
                    <img src="<?= esc($article->thumbnail) ?>" alt="<?= esc($article->title ?? '') ?>" class="img-fluid rounded mb-4" style="width:100%; object-fit:cover; max-height:400px;">
                    <?php endif; ?>

                    <div class="content">
                        <?= $article->content ?? $article->body ?? '' ?>
                    </div>

                    <div class="mt-5 pt-4 border-top">
                        <a href="/blog" class="btn btn-outline-primary"><i class="fas fa-arrow-left me-2"></i>Kembali ke Blog</a>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
