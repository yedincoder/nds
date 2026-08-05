<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3><?= isset($testimonial) ? 'Edit Testimonial' : 'Add Testimonial' ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/admin/testimonials">Testimonials</a></li>
            <li class="breadcrumb-item active"><?= isset($testimonial) ? 'Edit' : 'Add' ?></li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= isset($testimonial) ? '/admin/testimonials/update/' . $testimonial->id : '/admin/testimonials/create' ?>" method="POST">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                        <input type="text" name="customer_name" class="form-control" value="<?= esc($testimonial->customer_name ?? '') ?>" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="customer_email" class="form-control" value="<?= esc($testimonial->customer_email ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Company</label>
                            <input type="text" name="company" class="form-control" value="<?= esc($testimonial->company ?? '') ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Position</label>
                            <input type="text" name="position" class="form-control" value="<?= esc($testimonial->position ?? '') ?>" placeholder="e.g. CEO, CTO, Founder">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Title / Headline</label>
                            <input type="text" name="title" class="form-control" value="<?= esc($testimonial->title ?? '') ?>" placeholder="e.g. Excellent Service">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Testimonial <span class="text-danger">*</span></label>
                        <textarea name="message" class="form-control" rows="5" required><?= esc($testimonial->message ?? '') ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="pending" <?= ($testimonial->status ?? 'pending') == 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="approved" <?= ($testimonial->status ?? '') == 'approved' ? 'selected' : '' ?>>Approved</option>
                            <option value="rejected" <?= ($testimonial->status ?? '') == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rating <span class="text-danger">*</span></label>
                        <select name="rating" class="form-select" required>
                            <?php for ($i = 5; $i >= 1; $i--): ?>
                            <option value="<?= $i ?>" <?= ($testimonial->rating ?? 5) == $i ? 'selected' : '' ?>><?= $i ?> Star<?= $i > 1 ? 's' : '' ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="featured" value="1" class="form-check-input" id="featured" <?= ($testimonial->featured ?? 0) == 1 ? 'checked' : '' ?>>
                            <label class="form-check-label" for="featured">Featured Testimonial</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">User ID (optional)</label>
                        <input type="number" name="user_id" class="form-control" value="<?= esc($testimonial->user_id ?? '') ?>" placeholder="Link to registered user">
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary"><?= isset($testimonial) ? 'Update Testimonial' : 'Create Testimonial' ?></button>
                <a href="/admin/testimonials" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
