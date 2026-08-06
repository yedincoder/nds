<?= $this->extend('Layout/layout_mitraarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Produk Mitra</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/mitra/dashboard">Mitra</a></li>
            <li class="breadcrumb-item active">Produk</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Kelola Produk</div>
    </div>
    <div class="card-body" style="padding:8px 16px">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $i => $product): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if (!empty($product->thumbnail)): ?>
                                    <img src="<?= esc($product->thumbnail) ?>" alt="" class="rounded me-2" style="width:40px;height:40px;object-fit:cover">
                                    <?php endif; ?>
                                    <strong><?= esc($product->name ?? '-') ?></strong>
                                    <small class="text-muted d-block"><?= esc($product->slug ?? '') ?></small>
                                </div>
                            </td>
                            <td>Rp <?= number_format($product->price ?? 0, 0, ',', '.') ?></td>
                            <td>
                                <?php $st = ($product->status ?? 'active') === 'active' ? 'bg-success' : 'bg-secondary'; ?>
                                <span class="badge <?= $st ?>"><?= ucfirst(esc($product->status ?? 'active')) ?></span>
                            </td>
                            <td>
                                <a href="/mitra/ecommerce/products/edit/<?= esc($product->id) ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center py-4">Belum ada produk</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>