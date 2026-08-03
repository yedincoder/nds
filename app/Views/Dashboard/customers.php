<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Customers</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Customers</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Manage Customers</h5>
        <div>
            <button class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i> Add Customer</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Full Name</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($customers)): ?>
                        <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?= esc($customer->id) ?></td>
                            <td><?= esc($customer->username ?? '-') ?></td>
                            <td><?= esc($customer->email ?? '-') ?></td>
                            <td><?= esc($customer->full_name ?? '-') ?></td>
                            <td><?= esc($customer->role_name ?? 'customer') ?></td>
                            <td>
                                <?php
                                $statusClass = match($customer->status ?? 'active') {
                                    'active' => 'bg-success',
                                    'inactive' => 'bg-secondary',
                                    'suspended' => 'bg-warning text-dark',
                                    'blocked' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                                ?>
                                <span class="badge <?= $statusClass ?>"><?= ucfirst(esc($customer->status ?? 'active')) ?></span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="#" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-info" title="View"><i class="fas fa-eye"></i></a>
                                    <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">No customers found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if (isset($pager)): ?>
        <div class="d-flex justify-content-end mt-3">
            <?= $pager->links() ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>