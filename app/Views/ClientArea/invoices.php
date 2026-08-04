<?= $this->extend('ClientArea/layout') ?>

<?= $this->section('content') ?>

<h3>My Invoices</h3>

<div class="card">
    <div class="card-body">
        <?php if (!empty($invoices)): ?>
        <table class="table table-hover">
            <thead><tr><th>Invoice #</th><th>Total</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach ($invoices as $inv): ?>
            <tr>
                <td>#<?= esc($inv->invoice_number ?? $inv->id ?? '') ?></td>
                <td>Rp <?= number_format($inv->total ?? 0, 0, ',', '.') ?></td>
                <td><span class="badge bg-<?= $inv->status === 'paid' ? 'success' : 'warning text-dark' ?>"><?= esc(ucfirst($inv->status ?? '')) ?></span></td>
                <td><?= date('d M Y', strtotime($inv->created_at ?? '')) ?></td>
                <td>
                    <?php if ($inv->status !== 'paid'): ?>
    <a href="<?= site_url('payment/' . ($inv->invoice_number ?? $inv->id)) ?>" class="btn btn-sm btn-primary">Pay Now</a>
<?php endif; ?>
<a href="<?= site_url('invoice/' . ($inv->invoice_number ?? $inv->id)) ?>" class="btn btn-sm btn-outline-secondary">View</a>
<a href="<?= site_url('invoice/download/' . ($inv->invoice_number ?? $inv->id)) ?>" class="btn btn-sm btn-outline-danger">PDF</a>
                    
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="text-muted text-center py-5">No invoices yet</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>