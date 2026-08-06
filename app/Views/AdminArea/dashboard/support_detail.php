<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Ticket #<?= esc($ticket->ticket_number ?? $ticket->id) ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item"><a href="/admin/support">Support</a></li>
            <li class="breadcrumb-item active"><?= esc($ticket->ticket_number ?? '') ?></li>
        </ol>
    </nav>
</div>

<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title"><?= esc($ticket->subject ?? '') ?></div>
                <?php $sc = match($ticket->status ?? 'open') {
                    'closed','resolved' => 'bg-success', 'open' => 'bg-warning',
                    'waiting_response' => 'bg-info', default => 'bg-secondary'
                }; ?>
                <span class="badge <?= $sc ?>"><?= ucfirst(str_replace('_', ' ', $ticket->status ?? 'open')) ?></span>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3"><strong><?= esc($ticket->username ?? 'Guest') ?></strong> Â· <?= date('d M Y H:i', strtotime($ticket->created_at ?? '')) ?></p>
                <p style="line-height:1.7"><?= nl2br(esc($ticket->message ?? '')) ?></p>

                <hr>

                <?php if (!empty($replies)): ?>
                <h5 style="font-size:14px;font-weight:600;margin:16px 0">Replies</h5>
                <?php foreach ($replies as $reply): ?>
                <div class="py-2 border-bottom">
                    <p class="mb-1"><strong><?= esc($reply->username ?? 'System') ?></strong> <small class="text-muted">Â· <?= date('d M Y H:i', strtotime($reply->created_at ?? '')) ?></small></p>
                    <p class="mb-0" style="line-height:1.6"><?= nl2br(esc($reply->message ?? '')) ?></p>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Reply</div>
            </div>
            <div class="card-body">
                <form method="post" action="/admin/support/ticket/<?= esc($ticket->id) ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-reply me-1"></i>Send Reply</button>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Actions</div>
            </div>
            <div class="card-body">
                <a href="/admin/support/ticket/<?= esc($ticket->id) ?>/close" class="btn btn-sm btn-outline-danger w-100"><i class="fas fa-check-circle me-1"></i>Close Ticket</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
