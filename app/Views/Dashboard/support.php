<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Support Tickets</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Support</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Manage Support Tickets</h5>
        <a href="/admin/support/create" class="btn btn-primary btn-sm">New Ticket</a>
    </div>
    <div class="card-body">
        <?php if (!empty($tickets)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Ticket #</th>
                        <th>Customer</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tickets as $ticket): ?>
                    <tr>
                        <td><strong><?= esc($ticket->ticket_number ?? '#' . $ticket->id) ?></strong></td>
                        <td><?= esc($ticket->username ?? 'Guest') ?></td>
                        <td><?= esc($ticket->subject ?? '-') ?></td>
                        <td>
                            <?php
                            $statusClass = match($ticket->status ?? '') {
                                'open' => 'bg-warning text-dark',
                                'waiting_response' => 'bg-info',
                                'closed' => 'bg-secondary',
                                'resolved' => 'bg-success',
                                default => 'bg-secondary'
                            };
                            ?>
                            <span class="badge <?= $statusClass ?>"><?= esc(ucfirst($ticket->status ?? 'open')) ?></span>
                        </td>
                        <td><?= date('d M Y', strtotime($ticket->created_at ?? date('Y-m-d'))) ?></td>
                        <td>
                            <a href="/admin/support/ticket/<?= $ticket->id ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="text-center py-4">
            <i class="fas fa-headset fa-2x mb-2" style="color: var(--text-primary);"></i>
            <p>No tickets found.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>