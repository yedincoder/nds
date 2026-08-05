<?= $this->extend('layouts/master') ?>

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
        <div class="text-center mb-4">
            <h1>INVOICE</h1>
            <p class="text-muted">#<?= esc($invoice->invoice_number) ?></p>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <h6>Bill To:</h6>
                <p><?= esc($invoice->billing_name ?? '') ?><br>
                <?= esc($invoice->billing_email ?? '') ?><br>
                <?= esc($invoice->billing_phone ?? '') ?></p>
            </div>
            <div class="col-md-6 text-md-end">
                <h6>Invoice Details</h6>
                <p>Invoice #: <?= esc($invoice->invoice_number) ?><br>
                Date: <?= esc($invoice->created_at) ?><br>
                Due Date: <?= esc($invoice->due_date ?? '-') ?></p>
            </div>
        </div>

        <table class="table table-bordered">
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
</section>

<?= $this->endSection() ?>