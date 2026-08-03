<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container text-center">
        <div class="alert alert-success">
            <h2>Thank you for your order!</h2>
            <p>Your order #<?= esc($order_id) ?> has been placed successfully.</p>
            <p>We will send you an invoice and payment instructions shortly.</p>
        </div>
        <a href="<?= site_url('client/dashboard') ?>" class="btn btn-primary">Go to Dashboard</a>
    </div>
</section>

<?= $this->endSection() ?>