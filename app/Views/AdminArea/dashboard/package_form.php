<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3><?= !empty($package) ? 'Edit Service Package' : 'Add Service Package' ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item"><a href="/admin/services">Services</a></li>
            <li class="breadcrumb-item"><a href="/admin/services/edit/<?= esc($service->id) ?>"><?= esc($service->name) ?></a></li>
            <li class="breadcrumb-item active"><?= !empty($package) ? 'Edit' : 'Add' ?> Package</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title"><?= !empty($package) ? 'Edit Package' : 'Add Package' ?></div>
            </div>
            <div class="card-body">
                <?php $package = $package ?? new stdClass(); ?>
                <form method="post" action="<?= !empty($package->id) ? "/admin/services/{$service->id}/package/update/{$package->id}" : "/admin/services/{$service->id}/package/create" ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Package Name *</label>
                        <input type="text" class="form-control" name="package_name" value="<?= esc($package->package_name ?? set_value('package_name')) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" name="price" value="<?= esc($package->price ?? set_value('price')) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="4"><?= esc($package->description ?? set_value('description')) ?></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i><?= !empty($package->id) ? 'Update' : 'Add' ?> Package</button>
                        <a href="/admin/services/edit/<?= esc($service->id) ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>