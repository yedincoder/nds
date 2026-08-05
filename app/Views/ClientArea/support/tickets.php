<?= $this->extend('ClientArea/layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0"><i class="fas fa-headset me-2"></i>Support Tickets</h3>
    <a href="/client/support/ticket/create" class="btn btn-primary"><i class="fas fa-plus me-1"></i>New Ticket</a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (!empty($tickets)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Ticket #</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Date</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($tickets as $ticket): ?>
                    <tr>
                        <td>#<?= esc($ticket->ticket_number ?? $ticket->id ?? '') ?></td>
                        <td><?= esc($ticket->subject ?? '') ?></td>
                        <td>
                            <?php
                            $statusClass = match($ticket->status ?? '') {
                                'open' => 'bg-success',
                                'waiting_response' => 'bg-warning text-dark',
                                'in_progress' => 'bg-info text-dark',
                                'resolved' => 'bg-primary',
                                'closed' => 'bg-secondary',
                                default => 'bg-secondary'
                            };
                            ?>
                            <span class="badge <?= $statusClass ?>"><?= esc(ucfirst(str_replace('_', ' ', $ticket->status ?? ''))) ?></span>
                        </td>
                        <td>
                            <?php
                            $priorityClass = match($ticket->priority ?? 'medium') {
                                'high' => 'bg-danger',
                                'critical' => 'bg-danger',
                                'low' => 'bg-success',
                                default => 'bg-warning text-dark'
                            };
                            ?>
                            <span class="badge <?= $priorityClass ?>"><?= esc(ucfirst($ticket->priority ?? 'medium')) ?></span>
                        </td>
                        <td><?= date('d M Y', strtotime($ticket->created_at ?? 'now')) ?></td>
                        <td class="text-end">
                            <a href="/client/support/ticket/<?= esc($ticket->uuid ?? $ticket->id) ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye me-1"></i>View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
</div>
        <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
            <p class="text-muted">Belum ada tiket support.</p>
            <a href="/client/support/ticket/create" class="btn btn-primary mt-2"><i class="fas fa-plus me-1"></i>Buat Tiket</a>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
