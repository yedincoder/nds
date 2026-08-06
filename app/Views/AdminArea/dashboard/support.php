<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Support Tickets</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item active">Support</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Support Tickets</div>
        <a href="/admin/support/create" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i>New Ticket</a>
    </div>
    <div class="card-body" style="padding:8px 16px">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ticket Number</th>
                        <th>Subject</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($tickets)): ?>
                        <?php foreach ($tickets as $i => $ticket): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><strong><?= esc($ticket->ticket_number ?? '#' . $ticket->id) ?></strong></td>
                                <td><?= esc($ticket->subject ?? '-') ?></td>
                                <td><?= esc($ticket->username ?? 'Guest') ?></td>
                                <td>
                                    <?php $sc = match($ticket->status ?? 'open') {
                                        'closed','resolved' => 'bg-success', 'open' => 'bg-warning',
                                        'waiting_response' => 'bg-info', default => 'bg-secondary'
                                    }; ?>
                                    <span class="badge <?= $sc ?>"><?= ucfirst(str_replace('_', ' ', $ticket->status ?? 'open')) ?></span>
                                </td>
                                <td>
                                    <?php $pc = match($ticket->priority ?? 'normal') {
                                        'high' => 'bg-danger', 'low' => 'bg-info', default => 'bg-secondary'
                                    }; ?>
                                    <span class="badge <?= $pc ?>"><?= ucfirst($ticket->priority ?? 'normal') ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($ticket->created_at ?? '')) ?></td>
                                <td>
                                    <a href="/admin/support/ticket/<?= esc($ticket->id) ?>" class="btn btn-sm btn-outline-primary">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8" class="text-center py-4">Belum ada ticket</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>