<?= $this->extend('Layout/layout_frontarea') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="container">
        <h1>Portfolio</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Portfolio</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <?php if (!empty($portfolios)): ?>
                <?php foreach ($portfolios as $portfolio): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <?php if (!empty($portfolio->thumbnail)): ?>
                            <img src="<?= esc($portfolio->thumbnail) ?>" class="card-img-top" alt="<?= esc($portfolio->title ?? '') ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($portfolio->title ?? '') ?></h5>
                            <p class="card-text text-muted small"><?= esc($portfolio->description ?? '') ?></p>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="/portfolio/<?= esc($portfolio->slug ?? $portfolio->id) ?>" class="btn btn-primary w-100">View Detail</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info text-center">Belum ada portfolio.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>