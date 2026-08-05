<?= $this->extend('ClientArea/layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0"><i class="fas fa-user-cog me-2"></i>My Profile</h3>
</div>

<?php if (!empty($errors = session()->getFlashdata('errors'))): ?>
<div class="alert alert-danger">
    <ul class="mb-0">
        <?php foreach ($errors as $error): ?>
        <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<?php
$userData = $profile['user'] ?? $profile->user ?? null;
$profileData = $profile['profile'] ?? $profile->profile ?? $profile ?? null;
$fullName = $profileData->full_name ?? session()->get('username') ?? '';
$email = $userData->email ?? session()->get('email') ?? '';
$username = $userData->username ?? session()->get('username') ?? '';
$phone = $profileData->phone ?? '';
$address = $profileData->address ?? '';
$city = $profileData->city ?? '';
$province = $profileData->province ?? '';
?>

<div class="row mb-4">
    <div class="col-xl-6 col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Recent Orders</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/client/profile/update">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="full_name" class="form-control" value="<?= esc(old('full_name', $fullName)) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="<?= esc($email) ?>" readonly disabled>
                        <small class="text-muted">Email tidak dapat diubah</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" value="<?= esc($username) ?>" readonly disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. Telepon / WA</label>
                        <input type="text" name="phone" class="form-control" value="<?= esc(old('phone', $phone)) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="address" class="form-control" rows="2"><?= esc(old('address', $address)) ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kota</label>
                            <input type="text" name="city" class="form-control" value="<?= esc(old('city', $city)) ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Provinsi</label>
                            <input type="text" name="province" class="form-control" value="<?= esc(old('province', $province)) ?>">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Unpaid Invoices</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/client/profile/change-password">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="new_password" class="form-control" required minlength="8">
                        <small class="text-muted">Minimal 8 karakter</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-key me-1"></i>Ganti Password</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>
