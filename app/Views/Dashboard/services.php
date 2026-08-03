<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Services</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Services</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Manage Services</h5>
        <a href="#" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Add Service</a>
    </div>
    <div class="card-body">
        <?php if (!empty($services)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $service): ?>
                    <tr>
                        <td><strong><?= esc($service->name ?? '') ?></strong></td>
                        <td><?= esc($service->category_name ?? '-') ?></td>
                        <td>Rp <?= number_format($service->price ?? 0, 0, ',', '.') ?></td>
                        <td>
                            <?php
                            $class = match($service->status ?? 'draft') {
                                'active' => 'bg-success',
                                'inactive' => 'bg-secondary',
                                'archived' => 'bg-danger',
                                default => 'bg-warning text-dark'
                            };
                            ?>
                            <span class="badge <?= $class ?>"><?= esc(ucfirst($service->status ?? 'draft')) ?></span>
                        </td>
                        <td><?= date('d M Y', strtotime($service->created_at ?? date('Y-m-d'))) ?></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>
                            <a href="#" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')" title="Delete"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-cogs fa-3x mb-3" style="color: var(--text-primary); opacity: 0.3;"></i>
            <h5>No Services Yet</h5>
            <p class="text-muted">Services will appear here once created.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>