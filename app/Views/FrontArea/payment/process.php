<?= $this->extend('Layout/layout_clientarea') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="container">
        <h1>Payment</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/payment">Payment</a></li>
                <li class="breadcrumb-item active">Process</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i><?= esc($error) ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Payment for Invoice <?= esc($invoice->invoice_number ?? '') ?></div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Invoice Detail</h5>
                        <p><strong>Invoice #:</strong> <?= esc($invoice->invoice_number ?? '') ?></p>
                        <p><strong>Total:</strong> Rp <?= number_format($invoice->total ?? 0, 0, ',', '.') ?></p>
                        <p><strong>Status:</strong> 
                            <?php $st = match($invoice->status ?? 'unpaid') {
                                'paid' => 'bg-success', 'unpaid' => 'warning',
                                'expired' => 'danger', default => 'secondary'
                            }; ?>
                            <span class="badge bg-<?= $st ?>"><?= ucfirst($invoice->status ?? 'unpaid') ?></span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h5>Payment Methods</h5>
                        <?php if (!empty($paymentMethods)): ?>
                            <form method="post" action="/payment/invoice/<?= esc($invoice->uuid ?? $invoice->id) ?>">
                                <div class="mb-3">
                                    <label class="form-label">Pilih Metode Pembayaran</label>
                                    <select name="payment_method_id" class="form-select" required>
                                        <option value="">Pilih metode...</option>
                                        <?php foreach ($paymentMethods as $pm): ?>
                                            <option value="<?= esc($pm->id) ?>"><?= esc($pm->name) ?> (<?= esc($pm->type) ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-credit-card me-1"></i>Bayar Sekarang</button>
                            </form>
                        <?php else: ?>
                            <div class="alert alert-warning">Belum ada metode pembayaran tersedia.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>