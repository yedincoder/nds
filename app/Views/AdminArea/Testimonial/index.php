<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Testimonials</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item active">Testimonials</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Manage Testimonials</div>
        <a href="/admin/testimonials/create" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i>Add</a>
    </div>
    <div class="card-body" style="padding:8px 16px">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Company</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($testimonials)): ?>
                        <?php foreach ($testimonials as $i => $testimonial): ?>
                            <tr>
                                <td><?= $i + 1 + (($pager->getCurrentPage() - 1) * $pager->getPerPage()) ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= esc($testimonial->customer_photo ?? '') ?>" alt="Photo" onerror="this.src='https://via.placeholder.com/40'" class="rounded-circle me-3" style="width:40px;height:40px;object-fit:cover">
                                        <div>
                                            <strong><?= esc($testimonial->customer_name) ?></strong>
                                            <small class="text-muted d-block"><?= esc($testimonial->customer_email ?? '') ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><?= esc($testimonial->company ?? '-') ?></td>
                                <td>
                                    <div class="star-rating">
                                        <?php for ($j = 1; $j <= 5; $j++): ?>
                                            <span class="star <?= $j <= $testimonial->rating ? 'text-warning' : 'text-muted' ?>">★</span>
                                        <?php endfor; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php $sc = match($testimonial->status ?? 'pending') {
                                        'approved' => 'bg-success', 'rejected' => 'bg-danger', default => 'bg-warning'
                                    }; ?>
                                    <span class="badge <?= $sc ?>"><?= ucfirst($testimonial->status ?? 'pending') ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($testimonial->created_at ?? '')) ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="/admin/testimonials/edit/<?= esc($testimonial->id) ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <a href="/admin/testimonials/delete/<?= esc($testimonial->id) ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center py-4">Belum ada testimoni</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <?= $pager ? $pager->links() : '' ?>
    </div>
</div>

<?= $this->endSection() ?>