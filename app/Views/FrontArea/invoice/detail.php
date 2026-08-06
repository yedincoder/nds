<?= $this->extend('Layout/layout_clientarea') ?>

<?= $this->section('content') ?>

<!-- 1. BAGIAN HEADER & BREADCRUMB (Sesuai Struktur) -->
<section class="page-header">
    <div class="container">
        <h1>Invoice</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Invoice</li>
            </ol>
        </nav>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Invoice #<?= esc($invoice->invoice_number) ?></h1>
                    <span class="badge bg-<?= $invoice->status === 'paid' ? 'success' : 'warning' ?> fs-6">
                        <?= esc(ucfirst($invoice->status)) ?>
                    </span>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Bill To:</h6>
                                <p><?= esc($invoice->billing_name ?? '') ?></p>
                                <p><?= esc($invoice->billing_email ?? '') ?></p>
                                <p><?= esc($invoice->billing_phone ?? '') ?></p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <h6>Invoice Details</h6>
                                <p>Invoice #: <?= esc($invoice->invoice_number) ?></p>
                                <p>Date: <?= esc($invoice->created_at) ?></p>
                                <p>Due Date: <?= esc($invoice->due_date ?? '-') ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($invoice->items)): ?>
                                    <?php foreach ($invoice->items as $item): ?>
                                        <tr>
                                            <td><?= esc($item->description) ?></td>
                                            <td><?= $item->quantity ?></td>
                                            <td><?= format_price($item->price) ?></td>
                                            <td><?= format_price($item->subtotal) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end">Subtotal</td>
                                    <td><?= format_price($invoice->subtotal) ?></td>
                                </tr>
                                <?php if ($invoice->discount > 0): ?>
                                    <tr>
                                        <td colspan="3" class="text-end">Discount</td>
                                        <td>-<?= format_price($invoice->discount) ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($invoice->tax > 0): ?>
                                    <tr>
                                        <td colspan="3" class="text-end">Tax</td>
                                        <td><?= format_price($invoice->tax) ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total</td>
                                    <td class="fw-bold"><?= format_price($invoice->total) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="<?= site_url('invoice/' . $invoice->uuid) ?>" class="btn btn-outline-secondary">Back</a>
                    <a href="<?= site_url('invoice/download/' . $invoice->uuid) ?>" class="btn btn-primary">Download PDF</a>
                    <a href="<?= site_url('invoice/print/' . $invoice->uuid) ?>" class="btn btn-outline-primary">Print</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
