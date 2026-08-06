<?= $this->extend('Layout/layout_frontarea') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <h1 class="mb-4"><?= esc($title) ?></h1>
        <p class="lead mb-5">Professional digital solutions for your business needs.</p>

        <div class="row">
            <?php if (!empty($services)): ?>
                <?php foreach ($services as $service): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="<?= esc($service->thumbnail ?? 'https://via.placeholder.com/400x300') ?>" class="card-img-top" alt="<?= esc($service->name) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($service->name) ?></h5>
                                <p class="card-text"><?= esc(substr($service->description ?? '', 0, 150)) ?>...</p>
                                <?php if ($service->price): ?>
                                    <p class="text-primary fw-bold">
                                        <?php if ($service->price_type === 'fixed'): ?>
                                            <?= format_price($service->price) ?>
                                        <?php else: ?>
                                            From <?= format_price($service->price) ?>
                                        <?php endif; ?>
                                    </p>
                                <?php endif; ?>
                                <a href="<?= site_url('services/' . $service->slug) ?>" class="btn btn-primary">Learn More</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">No services available.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

