<?= $this->extend('Layout/layout_frontarea') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="mb-4"><?= esc($service->name) ?></h1>
                <div class="content">
                    <?= $service->description ?? '' ?>
                </div>

                <?php if (!empty($service->packages)): ?>
                    <h3 class="mt-5 mb-3">Packages</h3>
                    <div class="row">
                        <?php foreach ($service->packages as $package): ?>
                            <div class="col-md-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= esc($package->package_name) ?></h5>
                                        <p class="card-text"><?= esc($package->description) ?></p>
                                        <p class="text-primary fw-bold"><?= format_price($package->price) ?></p>
                                        <a href="<?= site_url('services/' . $service->slug . '/quote') ?>" class="btn btn-primary">Request Quote</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Get a Quote</h5>
                        <form action="<?= site_url('services/' . $service->slug . '/quote') ?>" method="POST">
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                            </div>
                            <div class="mb-3">
                                <input type="tel" name="phone" class="form-control" placeholder="Phone Number" required>
                            </div>
                            <div class="mb-3">
                                <textarea name="message" class="form-control" rows="4" placeholder="Your Message" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Send Quote Request</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

