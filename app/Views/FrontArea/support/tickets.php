<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <h1 class="mb-4">Support Tickets</h1>

        <div class="d-flex justify-content-between mb-4">
            <h2>My Tickets</h2>
            <a href="<?= site_url('support/ticket/create') ?>" class="btn btn-primary">Create New Ticket</a>
        </div>

        <?php if (empty($tickets)): ?>
            <div class="alert alert-info">No support tickets found.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Ticket #</th>
                            <th>Subject</th>
                            <th>Category</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tickets as $ticket): ?>
                            <tr>
                                <td><?= esc($ticket->ticket_number) ?></td>
                                <td><?= esc($ticket->subject) ?></td>
                                <td><?= esc($ticket->category_name ?? '-') ?></td>
                                <td>
                                    <span class="badge bg-<?= $ticket->priority === 'critical' ? 'danger' : ($ticket->priority === 'high' ? 'warning' : ($ticket->priority === 'medium' ? 'info' : 'success')) ?>">
                                        <?= esc(ucfirst($ticket->priority)) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $ticket->status === 'open' ? 'success' : ($ticket->status === 'in_progress' ? 'info' : 'secondary') ?>">
                                        <?= esc(ucfirst($ticket->status)) ?>
                                    </span>
                                </td>
                                <td><?= esc($ticket->created_at) ?></td>
                                <td>
                                    <a href="<?= site_url('support/ticket/' . $ticket->id) ?>" class="btn btn-sm btn-outline-primary">View</a>
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