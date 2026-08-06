<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3><?= !empty($product) ? 'Edit Product' : 'Create Product' ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item"><a href="/admin/products">Products</a></li>
            <li class="breadcrumb-item active"><?= !empty($product) ? 'Edit' : 'Create' ?></li>
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

<?php $product = $product ?? new stdClass(); ?>

<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Product Info</div>
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data" action="<?= !empty($product->id) ? "/admin/products/update/{$product->id}" : "/admin/products/create" ?>">
                    <?= csrf_field() ?>
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Name *</label>
                            <input type="text" class="form-control" name="name" value="<?= esc($product->name ?? set_value('name')) ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status *</label>
                            <select class="form-select" name="status" required>
                                <option value="draft" <?= ($product->status ?? set_value('status', 'draft')) === 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="active" <?= ($product->status ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= ($product->status ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                <option value="archived" <?= ($product->status ?? '') === 'archived' ? 'selected' : '' ?>>Archived</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Slug *</label>
                            <input type="text" class="form-control" name="slug" value="<?= esc($product->slug ?? set_value('slug')) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category_id">
                                <option value="">Select Category</option>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $cat): ?>
                                    <option value="<?= esc($cat->id) ?>" <?= ($product->category_id ?? set_value('category_id')) == $cat->id ? 'selected' : '' ?>><?= esc($cat->name) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Short Description</label>
                        <input type="text" class="form-control" name="short_description" value="<?= esc($product->short_description ?? set_value('short_description')) ?>">
                    </div>
<div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control ckeditor" name="description" rows="10"><?= esc($product->description ?? set_value('description')) ?></textarea>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Price *</label>
                            <input type="number" step="0.01" class="form-control" name="price" value="<?= esc($price->price ?? set_value('price')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Discount Price</label>
                            <input type="number" step="0.01" class="form-control" name="discount_price" value="<?= esc($price->discount_price ?? set_value('discount_price')) ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Thumbnail URL</label>
                        <input type="text" class="form-control" name="thumbnail" value="<?= esc($product->thumbnail ?? set_value('thumbnail')) ?>" placeholder="https://...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Package File (ZIP) <?= !empty($product->id) ? '(optional)' : '' ?></label>
                        <input type="file" class="form-control" name="package_file" accept=".zip,.rar,.tar,.gz,.7z" <?= !empty($product->id) ? '' : 'required' ?>>
                        <div class="form-text">Upload paket download produk (ZIP) untuk customer.</div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">SEO Title</label>
                            <input type="text" class="form-control" name="seo_title" value="<?= esc($product->seo_title ?? set_value('seo_title')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">SEO Description</label>
                            <input type="text" class="form-control" name="seo_description" value="<?= esc($product->seo_description ?? set_value('seo_description')) ?>">
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i><?= !empty($product->id) ? 'Update' : 'Create' ?> Product</button>
                        <a href="/admin/products" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if (!empty($product->id)): ?>
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <div class="card-title">Package Files (Download)</div>
            </div>
            <div class="card-body">
                <?php if (!empty($files)): ?>
                    <?php foreach ($files as $f): ?>
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <strong style="font-size:13px"><?= esc($f->file_name) ?></strong>
                            <br><small class="text-muted"><?= number_format(($f->file_size ?? 0) / 1048576, 2) ?> MB Â· v<?= esc($f->version ?? '1.0') ?></small>
                        </div>
                        <div class="btn-group">
                            <a href="/admin/products/file/delete/<?= esc($f->id) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this file?')"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center">Belum ada file paket</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">License / API / Token</div>
            </div>
            <div class="card-body">
<form method="post" action="/admin/products/license/create/<?= esc($product->id) ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-select" name="license_type">
                            <option value="license">License Key</option>
                            <option value="api_key">API Key</option>
                            <option value="access_token">Access Token</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">API Key / Secret (optional)</label>
                        <input type="text" class="form-control" name="api_key" placeholder="Key">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Domain Limit</label>
                            <input type="number" class="form-control" name="domain_limit" value="1" min="1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Max Devices</label>
                            <input type="number" class="form-control" name="max_devices" value="1" min="1">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Expires At</label>
                        <input type="date" class="form-control" name="expires_at">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100"><i class="fas fa-key me-1"></i>Generate</button>
                </form>

                <hr>

                <?php if (!empty($licenses)): ?>
                    <?php foreach ($licenses as $lic): ?>
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <strong style="font-size:12px"><?= esc($lic->license_key) ?></strong>
                            <br><small class="text-muted"><?= esc($lic->license_type) ?> Â· <?= ucfirst($lic->status ?? 'active') ?></small>
                        </div>
                        <a href="/admin/products/license/delete/<?= esc($lic->id) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this license?')"><i class="fas fa-trash"></i></a>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center">Belum ada license</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
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
