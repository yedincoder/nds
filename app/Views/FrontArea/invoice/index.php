<?= $this->extend('Layout/layout_clientarea') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <h1 class="mb-4">My Invoices</h1>

        <?php if (empty($invoices)): ?>
            <div class="alert alert-info">No invoices found.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Invoice Number</th>
                            <th>Order</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($invoices as $invoice): ?>
                            <tr>
                                <td><?= esc($invoice->invoice_number) ?></td>
                                <td><?= esc($invoice->order_id) ?></td>
                                <td><?= format_price($invoice->total) ?></td>
                                <td>
                                    <span class="badge bg-<?= $invoice->status === 'paid' ? 'success' : ($invoice->status === 'unpaid' ? 'warning' : 'secondary') ?>">
                                        <?= esc(ucfirst($invoice->status)) ?>
                                    </span>
                                </td>
                                <td><?= esc($invoice->created_at) ?></td>
                                <td>
                                    <a href="<?= site_url('invoice/' . $invoice->uuid) ?>" class="btn btn-sm btn-outline-primary">View</a>
                                    <?php if ($invoice->status === 'paid'): ?>
                                        <a href="<?= site_url('invoice/download/' . $invoice->uuid) ?>" class="btn btn-sm btn-outline-success">Download</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>
