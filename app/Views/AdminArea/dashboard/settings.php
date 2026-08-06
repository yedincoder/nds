<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Settings</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item active">Settings</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <div class="card-title">General Settings</div>
            </div>
            <div class="card-body">
                <form method="post" action="/admin/settings/update">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Site Name</label>
                        <input type="text" class="form-control" name="site_name" value="NgAppID" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Site Description</label>
                        <input type="text" class="form-control" name="site_description" value="Digital Platform">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Email</label>
                        <input type="email" class="form-control" name="contact_email" value="info@ngappid.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" name="phone_number" value="08977487315">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Currency</label>
                        <input type="text" class="form-control" name="currency" value="IDR">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Timezone</label>
                        <select class="form-select" name="timezone">
                            <option value="Asia/Jakarta">Asia/Jakarta (WIB)</option>
                            <option value="Asia/Pontianak">Asia/Pontianak (WITA)</option>
                            <option value="Asia/Jayapura">Asia/Jayapura (WIT)</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Save Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Database Management</div>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">Factory Reset will drop all tables and re-run all migrations. This action is irreversible.</p>
                <form method="post" action="/admin/settings/factory-reset" onsubmit="return confirm('Yakin ingin Factory Reset database? Semua data akan terhapus dan migrasi akan dijalankan ulang.')">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Admin Password *</label>
                        <input type="password" class="form-control" name="password" required placeholder="Masukkan password admin">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-danger"><i class="fas fa-database me-1"></i>Factory Reset Database</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
