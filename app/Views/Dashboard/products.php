<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Products</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Products</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Manage Products</h5>
        <div>
            <button class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i> Add Product</button>
        </div>
    </div>
    <div class="card-body">
        <?php if (!empty($products)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= esc($product->id) ?></td>
                        <td><?= esc($product->name ?? '-') ?></td>
                        <td>Rp <?= number_format($product->price ?? 0, 0, ',', '.') ?></td>
                        <td><?= esc($product->stock ?? '-') ?></td>
                        <td>
                            <?php
                            $statusClass = ($product->status ?? 'active') === 'active' ? 'bg-success' : 'bg-secondary';
                            ?>
                            <span class="badge <?= $statusClass ?>"><?= ucfirst(esc($product->status ?? 'active')) ?></span>
                        </td>
                        <td><?= date('d M Y', strtotime($product->created_at ?? date('Y-m-d'))) ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="#" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <?php if (isset($pager)): ?>
        <div class="d-flex justify-content-end mt-3">
            <?= $pager->links() ?>
        </div>
        <?php endif; ?>
        
        <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-box-open fa-3x mb-3" style="color: var(--text-primary); opacity: 0.3;"></i>
            <h5>No Products Yet</h5>
            <p class="text-muted">Start adding your first product to the store.</p>
            <button class="btn btn-primary"><i class="fas fa-plus me-1"></i> Add Product</button>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>