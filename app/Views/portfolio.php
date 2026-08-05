<?= $this->extend('layouts/master') ?>

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
        <div class="text-center mb-5">
            <h2 class="section-title">Proyek Terbaru</h2>
            <p class="section-subtitle">Kami telah membantu berbagai klien membangun solusi digital terbaik</p>
        </div>
        <div class="row g-4">
            <?php if (!empty($portfolios)): ?>
            <?php foreach ($portfolios as $idx => $pf): ?>
            <div class="col-md-6 col-lg-4">
                <div class="portfolio-card">
                    <div class="portfolio-img">
                        <?php if (!empty($pf->thumbnail)): ?>
                        <img src="<?= esc($pf->thumbnail) ?>" alt="<?= esc($pf->title) ?>" style="width:100%;height:100%;object-fit:cover;">
                        <?php else: ?>
                        <i class="fas fa-briefcase fa-4x"></i>
                        <?php endif; ?>
                    </div>
                    <div class="card-body p-4">
                        <h5 style="font-weight:600;color:var(--secondary);"><?= esc($pf->title) ?></h5>
                        <p class="text-muted mb-3" style="font-size:14px;"><?= esc(substr($pf->description ?? '', 0, 100)) ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><?= date('d M Y', strtotime($pf->created_at ?? date('Y-m-d'))) ?></small>
                            <a href="/portfolio/<?= esc($pf->slug) ?>" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada proyek yang ditampilkan.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>