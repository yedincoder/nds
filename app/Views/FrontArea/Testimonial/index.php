<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Testimonials</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Testimonials</li>
        </ol>
    </nav>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card" style="border-left-color: #1ABB9C;">
            <h3><?= number_format(($stats['approved'] ?? 0) + ($stats['pending'] ?? 0) + ($stats['rejected'] ?? 0)) ?></h3>
            <p>Total Testimonials</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="border-left-color: #26B99A;">
            <h3><?= number_format($stats['approved'] ?? 0) ?></h3>
            <p>Approved</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="border-left-color: #F39C12;">
            <h3><?= number_format($stats['pending'] ?? 0) ?></h3>
            <p>Pending</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="border-left-color: #E74C3C;">
            <h3><?= number_format($stats['rejected'] ?? 0) ?></h3>
            <p>Rejected</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Manage Testimonials</h5>
        <a href="/admin/testimonials/create" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Add Testimonial</a>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <a href="/admin/testimonials" class="btn btn-sm btn-outline-secondary <?= ($current_status ?? 'all') === 'all' ? 'active' : '' ?>">All</a>
            <a href="/admin/testimonials?status=pending" class="btn btn-sm btn-outline-warning <?= ($current_status ?? '') === 'pending' ? 'active' : '' ?>">Pending</a>
            <a href="/admin/testimonials?status=approved" class="btn btn-sm btn-outline-success <?= ($current_status ?? '') === 'approved' ? 'active' : '' ?>">Approved</a>
            <a href="/admin/testimonials?status=rejected" class="btn btn-sm btn-outline-danger <?= ($current_status ?? '') === 'rejected' ? 'active' : '' ?>">Rejected</a>
        </div>

        <?php if (!empty($testimonials)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Rating</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($testimonials as $item): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <?php if (!empty($item->avatar)): ?>
                                <img src="<?= esc($item->avatar) ?>" class="rounded-circle me-2" width="36" height="36" alt="">
                                <?php else: ?>
                                <div class="rounded-circle me-2 d-flex align-items-center justify-content-center text-white" style="width:36px;height:36px;background:#1ABB9C;">
                                    <?= esc(strtoupper(substr($item->customer_name ?? '?', 0, 1))) ?>
                                </div>
                                <?php endif; ?>
                                <div>
                                    <strong><?= esc($item->customer_name ?? '') ?></strong>
                                    <?php if (!empty($item->company)): ?><br><small class="text-muted"><?= esc($item->company) ?></small><?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star <?= $i <= (int)($item->rating ?? 0) ? 'text-warning' : 'text-muted' ?>"></i>
                            <?php endfor; ?>
                        </td>
                        <td style="max-width:250px">
                            <div class="text-truncate"><?= esc($item->title ?? '') ?></div>
                            <small class="text-muted text-truncate d-block"><?= esc(substr($item->message ?? '', 0, 60)) ?>...</small>
                        </td>
                        <td>
                            <?php
                            $class = match($item->status ?? 'pending') {
                                'approved' => 'bg-success',
                                'rejected' => 'bg-danger',
                                default => 'bg-warning text-dark'
                            };
                            ?>
                            <span class="badge <?= $class ?>"><?= esc(ucfirst($item->status ?? 'pending')) ?></span>
                        </td>
                        <td>
                            <?php if (($item->featured ?? 0) == 1): ?>
                            <i class="fas fa-star text-warning"></i>
                            <?php else: ?>
                            <i class="far fa-star text-muted"></i>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d M Y', strtotime($item->created_at ?? date('Y-m-d'))) ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="/admin/testimonials/edit/<?= $item->id ?>" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                <a href="/admin/testimonials/status/<?= $item->id ?>" class="btn btn-sm btn-outline-<?= ($item->status ?? '') === 'approved' ? 'warning' : 'success' ?>" title="Toggle status"><i class="fas fa-toggle-on"></i></a>
                                <a href="/admin/testimonials/delete/<?= $item->id ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if (isset($pager) && $pager): ?>
        <div class="d-flex justify-content-end mt-3">
            <?= $pager->links() ?>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-quote-left fa-3x mb-3" style="color: var(--text-primary); opacity: 0.3;"></i>
            <h5>No Testimonials Yet</h5>
            <p class="text-muted">Customer testimonials will appear here.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
