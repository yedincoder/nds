<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Products</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item active">Products</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Manage Products</div>
        <a href="/admin/products/create" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i>Add Product</a>
    </div>
    <div class="card-body" style="padding:8px 16px">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $i => $product): ?>
                            <tr>
                                <td><?= $i + 1 + (($pager->getCurrentPage() - 1) * $pager->getPerPage()) ?></td>
                                <td><strong><?= esc($product->name ?? '-') ?></strong><br><small class="text-muted"><?= esc($product->slug ?? '') ?></small></td>
                                <td>Rp <?= number_format($product->price ?? 0, 0, ',', '.') ?></td>
                                <td>
                                    <?php $st = ($product->status ?? 'active') === 'active' ? 'bg-success' : ($product->status === 'draft' ? 'bg-secondary' : 'bg-warning'); ?>
                                    <span class="badge <?= $st ?>"><?= ucfirst(esc($product->status ?? 'active')) ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($product->created_at ?? '')) ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="/admin/products/edit/<?= esc($product->id) ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                        <a href="/admin/products/delete/<?= esc($product->id) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this product?')"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center py-4">Belum ada produk</td></tr>
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