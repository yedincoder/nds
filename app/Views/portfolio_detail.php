<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="container">
        <h1><?= esc($portfolio->title ?? 'Project Detail') ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/portfolio">Portfolio</a></li>
                <li class="breadcrumb-item active"><?= esc($portfolio->title ?? 'Project Detail') ?></li>
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
                        <?php if (!empty($portfolio->category_name)): ?>
                        <span class="badge-category mb-3"><?= esc($portfolio->category_name) ?></span>
                        <?php endif; ?>
                        <h1 class="mb-3"><?= esc($portfolio->title ?? '') ?></h1>
                        <div class="text-muted mb-4">
                            <i class="far fa-calendar-alt me-1"></i><?= date('d M Y', strtotime($portfolio->created_at ?? 'now')) ?>
                            <?php if (!empty($portfolio->client_name)): ?>
                            <span class="mx-2">|</span>
                            <i class="far fa-building me-1"></i><?= esc($portfolio->client_name) ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (!empty($portfolio->thumbnail)): ?>
                    <img src="<?= esc($portfolio->thumbnail) ?>" alt="<?= esc($portfolio->title ?? '') ?>" class="img-fluid rounded mb-4" style="width:100%; object-fit:cover; max-height:400px;">
                    <?php endif; ?>

                    <div class="content">
                        <?= $portfolio->content ?? $portfolio->description ?? '' ?>
                    </div>

                    <?php if (!empty($portfolio->client_name) || !empty($portfolio->category_name)): ?>
                    <div class="mt-5 pt-4 border-top">
                        <div class="row">
                            <?php if (!empty($portfolio->client_name)): ?>
                            <div class="col-md-6">
                                <strong>Client:</strong> <?= esc($portfolio->client_name) ?>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($portfolio->category_name)): ?>
                            <div class="col-md-6">
                                <strong>Kategori:</strong> <?= esc($portfolio->category_name) ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="mt-5 pt-4 border-top text-center">
                        <a href="/portfolio" class="btn btn-outline-primary"><i class="fas fa-arrow-left me-2"></i>Kembali ke Portfolio</a>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>