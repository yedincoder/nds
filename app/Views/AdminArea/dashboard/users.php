<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Auth Users</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item active">Auth Users</li>
        </ol>
    </nav>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:var(--primary-soft);color:var(--primary)"><i class="fas fa-users"></i></div>
                    <div class="kpi-label">Total Users</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['total'] ?? 0) ?></div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:rgba(16,185,129,.12);color:#059669"><i class="fas fa-user-check"></i></div>
                    <div class="kpi-label">Active</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['active'] ?? 0) ?></div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:rgba(245,158,11,.14);color:#b45309"><i class="fas fa-user-clock"></i></div>
                    <div class="kpi-label">Inactive</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['inactive'] ?? 0) ?></div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon" style="background:rgba(239,68,68,.12);color:#dc2626"><i class="fas fa-user-slash"></i></div>
                    <div class="kpi-label">Suspended</div>
                </div>
            </div>
            <div class="kpi-value"><?= number_format($stats['suspended'] ?? 0) ?></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Manage Users</div>
        <a href="/admin/auth/create" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i>Add User</a>
    </div>
    <div class="card-body" style="padding:8px 16px">
        <form method="get" class="row g-2 mb-3 align-items-end">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search username/email..." value="<?= esc($search ?? '') ?>">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="all" <?= ($current_status ?? 'all') === 'all' ? 'selected' : '' ?>>All Status</option>
                    <option value="active" <?= ($current_status ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= ($current_status ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    <option value="suspended" <?= ($current_status ?? '') === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100"><i class="fas fa-search me-1"></i>Filter</button>
            </div>
            <div class="col-md-2">
                <a href="/admin/auth" class="btn btn-secondary w-100">Reset</a>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $i => $user): ?>
                            <tr>
                                <td><?= $i + 1 + (($pager->getCurrentPage() - 1) * $pager->getPerPage()) ?></td>
                                <td><strong><?= esc($user->username) ?></strong></td>
                                <td><?= esc($user->email) ?></td>
                                <td>
                                    <?php $sc = match($user->status ?? 'active') {
                                        'active' => 'bg-success', 'inactive' => 'bg-secondary',
                                        'suspended' => 'bg-danger', default => 'bg-secondary'
                                    }; ?>
                                    <span class="badge <?= $sc ?>"><?= ucfirst($user->status ?? 'active') ?></span>
                                </td>
                                <td><?= $user->last_login_at ? date('d M Y H:i', strtotime($user->last_login_at)) : 'Never' ?></td>
                                <td><?= date('d M Y', strtotime($user->created_at)) ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="/admin/auth/edit/<?= esc($user->id) ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <a href="/admin/auth/status/<?= esc($user->id) ?>" class="btn btn-sm btn-outline-warning" title="Toggle Status"><i class="fas fa-sync-alt"></i></a>
                                        <a href="/admin/auth/delete/<?= esc($user->id) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this user?')">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center py-4">No users found</td></tr>
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