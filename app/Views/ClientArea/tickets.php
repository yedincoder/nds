<?= $this->extend('ClientArea/layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Support Tickets</h3>
    <a href="/support/ticket/create" class="btn btn-primary">New Ticket</a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (!empty($tickets)): ?>
        <table class="table table-hover">
            <thead><tr><th>Ticket #</th><th>Subject</th><th>Status</th><th>Priority</th><th>Date</th></tr></thead>
            <tbody>
            <?php foreach ($tickets as $ticket): ?>
            <tr>
                <td>#<?= esc($ticket->ticket_number ?? $ticket->id ?? '') ?></td>
                <td><?= esc($ticket->subject ?? '') ?></td>
                <td><span class="badge bg-info"><?= esc(ucfirst($ticket->status ?? '')) ?></span></td>
                <td><span class="badge bg-warning text-dark"><?= esc(ucfirst($ticket->priority ?? '')) ?></span></td>
                <td><?= date('d M Y', strtotime($ticket->created_at ?? '')) ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="text-muted text-center py-5">No tickets yet</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>