<?= $this->extend('ClientArea/layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="mb-1"><i class="fas fa-ticket-alt me-2"></i>Ticket #<?= esc($ticket->ticket_number ?? '') ?></h3>
        <div class="d-flex gap-2 flex-wrap">
            <span class="badge bg-primary"><?= esc($ticket->subject ?? '') ?></span>
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
            <span class="badge bg-secondary"><?= date('d M Y H:i', strtotime($ticket->created_at ?? 'now')) ?></span>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="/client/support/tickets" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Back</a>
        <?php if (!in_array($ticket->status ?? '', ['closed', 'resolved'])): ?>
        <a href="/client/support/ticket/<?= esc($ticket->uuid ?? $ticket->id) ?>/close" class="btn btn-outline-danger" onclick="return confirm('Tutup tiket ini?')"><i class="fas fa-times me-1"></i>Close</a>
        <?php endif; ?>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Percakapan</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($ticket->messages)): ?>
            <?php foreach ($ticket->messages as $msg): ?>
            <div class="d-flex mb-3 <?= ($msg->user_id ?? 0) == session()->get('user_id') ? 'justify-content-end' : '' ?>">
                <div class="p-3 rounded <?= ($msg->user_id ?? 0) == session()->get('user_id') ? 'bg-primary text-white' : 'bg-light' ?>" style="max-width: 75%;">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <small><strong><?= ($msg->user_id ?? 0) == session()->get('user_id') ? 'Anda' : 'Support' ?></strong></small>
                        <small class="ms-3 <?= ($msg->user_id ?? 0) == session()->get('user_id') ? 'text-white-50' : 'text-muted' ?>"><?= date('d M Y H:i', strtotime($msg->created_at ?? 'now')) ?></small>
                    </div>
                    <div><?= nl2br(esc($msg->message ?? '')) ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
        <p class="text-muted text-center py-3">Belum ada pesan.</p>
        <?php endif; ?>
    </div>
</div>

<?php if (!in_array($ticket->status ?? '', ['closed', 'resolved'])): ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Balas</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($errors = session()->getFlashdata('errors'))): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <form method="POST" action="/client/support/ticket/<?= esc($ticket->uuid ?? $ticket->id) ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <textarea name="message" class="form-control" rows="4" required placeholder="Tulis balasan Anda..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1"></i>Kirim Balasan</button>
        </form>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
