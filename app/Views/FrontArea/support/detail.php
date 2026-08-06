<?= $this->extend('Layout/layout_clientarea') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Ticket #<?= esc($ticket->ticket_number) ?></h1>
            <div>
                <span class="badge bg-<?= $ticket->status === 'open' ? 'success' : 'info' ?>">
                    <?= esc(ucfirst($ticket->status)) ?>
                </span>
                <span class="badge bg-<?= $ticket->priority === 'critical' ? 'danger' : 'warning' ?> ms-2">
                    <?= esc(ucfirst($ticket->priority)) ?>
                </span>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5><?= esc($ticket->subject) ?></h5>
                <p class="text-muted">Created: <?= esc($ticket->created_at) ?> by <?= esc($ticket->user_name ?? 'Customer') ?></p>
                <hr>
                <div class="content">
                    <?= nl2br(esc($ticket->message)) ?>
                </div>
                <?php if ($ticket->attachment): ?>
                    <hr>
                    <a href="<?= site_url('support/attachment/' . $ticket->attachment) ?>" class="btn btn-sm btn-outline-primary">Download Attachment</a>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($ticket->replies)): ?>
            <h4 class="mb-3">Replies</h4>
            <?php foreach ($ticket->replies as $reply): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <strong><?= esc($reply->user_name ?? 'Support') ?></strong>
                            <small class="text-muted"><?= esc($reply->created_at) ?></small>
                        </div>
                        <div class="content">
                            <?= nl2br(esc($reply->message)) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <h5>Add Reply</h5>
                <form action="<?= site_url('support/ticket/' . $ticket->id) ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <textarea name="message" class="form-control" rows="4" required placeholder="Your reply..."></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="file" name="attachment" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Reply</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
