<?= $this->extend('Layout/layout_frontarea') ?>

<?= $this->section('content') ?>

<!-- 1. BAGIAN HEADER & BREADCRUMB (Sesuai Struktur) -->
<section class="page-header">
    <div class="container">
        <h1>Payment</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Payment</li>
            </ol>
        </nav>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <?php if (isset($error) && !empty($error)): ?>
        <div class="alert alert-danger mb-4">
            <strong>Error:</strong> <?= esc($error) ?>
        </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger mb-4">
            <strong>Error:</strong> <?= esc(session()->getFlashdata('error')) ?>
        </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success mb-4">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
        <?php endif; ?>

        <h1 class="mb-4">Payment - Invoice #<?= esc($invoice->invoice_number) ?></h1>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Invoice Total: <span class="text-primary"><?= format_price($invoice->total) ?></span></h5>
                        <p class="text-muted">Due: <?= esc($invoice->due_date ?? 'Upon receipt') ?></p>
                    </div>
                </div>

                <form action="<?= site_url('payment/' . $invoice->invoice_number) ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="card mb-4">
                        <div class="card-header"><h5>Select Payment Method</h5></div>
                        <div class="card-body">
                            <?php if (!empty($paymentMethods)): ?>
                                <?php foreach ($paymentMethods as $method): ?>
                                    <div class="form-check mb-3">
                                        <input type="radio" name="payment_method_id" value="<?= $method->id ?>" class="form-check-input" id="method_<?= $method->id ?>" required>
                                        <label class="form-check-label" for="method_<?= $method->id ?>">
                                            <strong><?= esc($method->name) ?></strong><br>
                                            <small class="text-muted"><?= esc($method->description) ?></small>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="alert alert-warning">No payment methods available.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Proceed to Payment</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>