<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3><?= !empty($user) ? 'Edit User' : 'Create User' ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item"><a href="/admin/auth">Auth Users</a></li>
            <li class="breadcrumb-item active"><?= !empty($user) ? 'Edit' : 'Create' ?></li>
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

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title"><?= !empty($user) ? 'Edit User' : 'Create User' ?></div>
            </div>
            <div class="card-body">
                <?php $user = $user ?? new stdClass(); ?>
<form method="post" action="<?= !empty($user->id) ? "/admin/auth/update/{$user->id}" : "/admin/auth/create" ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Username *</label>
                        <input type="text" class="form-control" name="username" value="<?= esc($user->username ?? set_value('username')) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" name="email" value="<?= esc($user->email ?? set_value('email')) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password <?= !empty($user->id) ? '(leave empty to keep)' : '*' ?></label>
                        <input type="password" class="form-control" name="password" <?= !empty($user->id) ? '' : 'required' ?>>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status *</label>
                        <select class="form-select" name="status" required>
                            <option value="active" <?= ($user->status ?? set_value('status', 'active')) === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= ($user->status ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            <option value="suspended" <?= ($user->status ?? '') === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i><?= !empty($user->id) ? 'Update' : 'Create' ?> User</button>
                        <a href="/admin/auth" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
