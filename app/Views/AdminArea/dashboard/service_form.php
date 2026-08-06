<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3><?= !empty($service) ? 'Edit Service' : 'Create Service' ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item"><a href="/admin/services">Services</a></li>
            <li class="breadcrumb-item active"><?= !empty($service) ? 'Edit' : 'Create' ?></li>
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

<?php $service = $service ?? new stdClass(); ?>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title"><?= !empty($service) ? 'Edit Service' : 'Create Service' ?></div>
            </div>
            <div class="card-body">
                <form method="post" action="<?= !empty($service->id) ? "/admin/services/update/{$service->id}" : "/admin/services/create" ?>">
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Name *</label>
                            <input type="text" class="form-control" name="name" value="<?= esc($service->name ?? set_value('name')) ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status *</label>
                            <select class="form-select" name="status" required>
                                <option value="draft" <?= ($service->status ?? set_value('status', 'draft')) === 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="active" <?= ($service->status ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= ($service->status ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                <option value="archived" <?= ($service->status ?? '') === 'archived' ? 'selected' : '' ?>>Archived</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Slug *</label>
                            <input type="text" class="form-control" name="slug" value="<?= esc($service->slug ?? set_value('slug')) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category_id">
                                <option value="">Select Category</option>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $cat): ?>
                                    <option value="<?= esc($cat->id) ?>" <?= ($service->category_id ?? set_value('category_id')) == $cat->id ? 'selected' : '' ?>><?= esc($cat->name) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control ckeditor" name="description" rows="10"><?= esc($service->description ?? set_value('description')) ?></textarea>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Price Type *</label>
                            <select class="form-select" name="price_type" required>
                                <option value="fixed" <?= ($service->price_type ?? set_value('price_type', 'fixed')) === 'fixed' ? 'selected' : '' ?>>Fixed</option>
                                <option value="starting" <?= ($service->price_type ?? '') === 'starting' ? 'selected' : '' ?>>Starting From</option>
                                <option value="custom" <?= ($service->price_type ?? '') === 'custom' ? 'selected' : '' ?>>Custom Quote</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Price</label>
                            <input type="number" step="0.01" class="form-control" name="price" value="<?= esc($service->price ?? set_value('price')) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status *</label>
                            <select class="form-select" name="status" required>
                                <option value="draft" <?= ($service->status ?? set_value('status', 'draft')) === 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="active" <?= ($service->status ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= ($service->status ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                <option value="archived" <?= ($service->status ?? '') === 'archived' ? 'selected' : '' ?>>Archived</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Thumbnail URL</label>
                        <input type="text" class="form-control" name="thumbnail" value="<?= esc($service->thumbnail ?? set_value('thumbnail')) ?>" placeholder="https://...">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">SEO Title</label>
                            <input type="text" class="form-control" name="seo_title" value="<?= esc($service->seo_title ?? set_value('seo_title')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">SEO Description</label>
                            <input type="text" class="form-control" name="seo_description" value="<?= esc($service->seo_description ?? set_value('seo_description')) ?>">
                        </div>
                    </div>

                    <?php if (!empty($service->id)): ?>
                    <hr>
                    <h5 class="mb-3">Service Packages</h5>
                    <div class="mb-3">
                        <a href="/admin/services/<?= esc($service->id) ?>/package/create" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i>Add Package</a>
                    </div>
                    <?php if (!empty($packages)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr><th>Name</th><th>Price</th><th>Actions</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($packages as $pkg): ?>
                                <tr>
                                    <td><strong><?= esc($pkg->package_name) ?></strong><br><small class="text-muted"><?= esc($pkg->description ?? '') ?></small></td>
                                    <td>Rp <?= number_format($pkg->price ?? 0, 0, ',', '.') ?></td>
                                    <td>
                                        <a href="/admin/services/<?= esc($service->id) ?>/package/edit/<?= esc($pkg->id) ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <a href="/admin/services/<?= esc($service->id) ?>/package/delete/<?= esc($pkg->id) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')">Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                    <?php endif; ?>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i><?= !empty($service->id) ? 'Update' : 'Create' ?> Service</button>
                        <a href="/admin/services" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
<script>
document.querySelectorAll('.ckeditor').forEach(function(el) {
    ClassicEditor.create(el).catch(function(err) { console.error(err); });
});
</script>
<?= $this->endSection() ?>