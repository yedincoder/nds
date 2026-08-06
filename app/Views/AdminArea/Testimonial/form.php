<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3><?= !empty($testimonial) ? 'Edit Testimonial' : 'Add Testimonial' ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item"><a href="/admin/testimonial">Testimonials</a></li>
            <li class="breadcrumb-item active"><?= !empty($testimonial) ? 'Edit' : 'Add' ?></li>
        </ol>
    </nav>
</div>

<?php if (session()->getFlashdata('errors')): ?>
<div class="alert alert-danger">
    <ul class="mb-0">
        <?php foreach (session('errors') as $e): ?>
        <li><?= esc($e) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <div class="card-title"><?= !empty($testimonial) ? 'Edit Testimonial' : 'Add Testimonial' ?></div>
    </div>
    <div class="card-body">
        <?php $testimonial = $testimonial ?? new stdClass(); ?>
        <form method="post" action="<?= !empty($testimonial->id) ? "/admin/testimonials/update/{$testimonial->id}" : "/admin/testimonials/create" ?>">
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Customer Name *</label>
                    <input type="text" class="form-control" name="customer_name" value="<?= esc($testimonial->customer_name ?? set_value('customer_name')) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Customer Email</label>
                    <input type="email" class="form-control" name="customer_email" value="<?= esc($testimonial->customer_email ?? set_value('customer_email')) ?>">
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Company</label>
                    <input type="text" class="form-control" name="company" value="<?= esc($testimonial->company ?? set_value('company')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Position</label>
                    <input type="text" class="form-control" name="position" value="<?= esc($testimonial->position ?? set_value('position')) ?>">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Title *</label>
                <input type="text" class="form-control" name="title" value="<?= esc($testimonial->title ?? set_value('title')) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Message *</label>
                <textarea class="form-control" name="message" rows="5" required><?= esc($testimonial->message ?? set_value('message')) ?></textarea>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label">Rating *</label>
                    <select class="form-select" name="rating" required>
                        <option value="5" <?= ($testimonial->rating ?? set_value('rating', '5')) == 5 ? 'selected' : '' ?>>5 - Excellent</option>
                        <option value="4" <?= ($testimonial->rating ?? '') == 4 ? 'selected' : '' ?>>4 - Good</option>
                        <option value="3" <?= ($testimonial->rating ?? '') == 3 ? 'selected' : '' ?>>3 - Average</option>
                        <option value="2" <?= ($testimonial->rating ?? '') == 2 ? 'selected' : '' ?>>2 - Poor</option>
                        <option value="1" <?= ($testimonial->rating ?? '') == 1 ? 'selected' : '' ?>>1 - Very Poor</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status *</label>
                    <select class="form-select" name="status" required>
                        <option value="pending" <?= ($testimonial->status ?? set_value('status', 'pending')) === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="approved" <?= ($testimonial->status ?? '') === 'approved' ? 'selected' : '' ?>>Approved</option>
                        <option value="rejected" <?= ($testimonial->status ?? '') === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" <?= !empty($testimonial->featured) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="featured">Featured on homepage</label>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i><?= !empty($testimonial->id) ? 'Update' : 'Save' ?> Testimonial</button>
                <a href="/admin/testimonial" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>