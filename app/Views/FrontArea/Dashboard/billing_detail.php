<?= $this->extend('Layout/layout_clientarea') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="container">
        <h1>Billing Detail</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/client/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/billing">Billing</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Invoice Detail</div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Bill To:</h6>
                        <p><?= esc($billing->username ?? 'Guest') ?></p>
                        <p><?= esc($billing->email ?? '') ?></p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h6>Invoice Details</h6>
                        <p>Invoice #: <?= esc($billing->invoice_number ?? $billing->id) ?></p>
                        <p>Date: <?= date('d M Y', strtotime($billing->created_at ?? '')) ?></p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr><th>Item</th><th>Qty</th><th>Price</th><th>Total</th></tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($billing->items)): ?>
                                    <?php foreach ($billing->items as $item): ?>
                                    <tr>
                                        <td><?= esc($item->description ?? $item->name ?? '-') ?></td>
                                        <td><?= esc($item->qty ?? 1) ?></td>
                                        <td>Rp <?= number_format($item->price ?? 0, 0, ',', '.') ?></td>
                                        <td>Rp <?= number_format($item->subtotal ?? ($item->price * $item->qty), 0, ',', '.') ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center py-3">Tidak ada item</td></tr>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                                    <td><strong>Rp <?= number_format($billing->total ?? 0, 0, ',', '.') ?></strong></td>
                                </tr>
                            </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>