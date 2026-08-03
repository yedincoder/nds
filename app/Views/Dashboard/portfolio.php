<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Portfolio</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Portfolio</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Manage Portfolio</h5>
        <a href="#" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Add Portfolio</a>
    </div>
    <div class="card-body">
        <?php if (!empty($portfolios)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Client</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($portfolios as $item): ?>
                    <tr>
                        <td><strong><?= esc($item->title ?? '') ?></strong></td>
                        <td><?= esc($item->client_name ?? '-') ?></td>
                        <td><?= esc($item->category ?? '-') ?></td>
                        <td>
                            <?php
                            $class = match($item->status ?? 'draft') {
                                'published' => 'bg-success',
                                'archived' => 'bg-secondary',
                                default => 'bg-warning text-dark'
                            };
                            ?>
                            <span class="badge <?= $class ?>"><?= esc(ucfirst($item->status ?? 'draft')) ?></span>
                        </td>
                        <td><?= date('d M Y', strtotime($item->created_at ?? date('Y-m-d'))) ?></td>
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
            <i class="fas fa-briefcase fa-3x mb-3" style="color: var(--text-primary); opacity: 0.3;"></i>
            <h5>No Portfolio Items Yet</h5>
            <p class="text-muted">Portfolio items will appear here once created.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>