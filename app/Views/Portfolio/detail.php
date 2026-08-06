<?= $this->extend('Layout/layout_frontarea') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="container">
        <h1><?= esc($portfolio->title ?? 'Portfolio') ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/portfolio">Portfolio</a></li>
                <li class="breadcrumb-item active"><?= esc($portfolio->title ?? '') ?></li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <?php if (!empty($portfolio->thumbnail)): ?>
                        <img src="<?= esc($portfolio->thumbnail) ?>" alt="<?= esc($portfolio->title ?? '') ?>" class="img-fluid rounded mb-4 w-100">
                        <?php endif; ?>
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge-category"><?= esc($portfolio->category_name ?? 'Portfolio') ?></span>
                        </div>
                        <h1 class="h3 mb-4"><?= esc($portfolio->title ?? '') ?></h1>
                        <?php if (!empty($portfolio->description)): ?>
                        <p class="lead text-muted"><?= esc($portfolio->description) ?></p>
                        <?php endif; ?>
                        <div class="portfolio-content">
                            <?= $portfolio->content ?? '' ?>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="/portfolio" class="btn btn-outline-primary"><i class="fas fa-arrow-left me-1"></i>Back to Portfolio</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>