<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Create New Ticket</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item"><a href="/admin/support">Support</a></li>
            <li class="breadcrumb-item active">Create Ticket</li>
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
        <div class="card-title">Create New Ticket</div>
    </div>
    <div class="card-body">
        <form method="post" action="/admin/support/create">
                    <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Category *</label>
                <select class="form-select" name="category_id" required>
                    <option value="">Select Category</option>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= esc($cat->id) ?>"><?= esc($cat->name) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Subject *</label>
                <input type="text" class="form-control" name="subject" value="<?= set_value('subject') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Message *</label>
                <textarea class="form-control" name="message" rows="5" required><?= set_value('message') ?></textarea>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Create Ticket</button>
                <a href="/admin/support" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
