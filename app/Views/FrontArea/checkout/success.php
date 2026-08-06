<?= $this->extend('Layout/layout_frontarea') ?>

<?= $this->section('content') ?>

<!-- 1. BAGIAN HEADER & BREADCRUMB (Sesuai Struktur) -->
<section class="page-header">
    <div class="container">
        <h1>Sukses</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Sukses</li>
            </ol>
        </nav>
    </div>
</section>

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
