<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Services</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item active">Services</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Manage Services</div>
    </div>
    <div class="card-body" style="padding:8px 16px">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($services)): ?>
                        <?php foreach ($services as $i => $service): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><strong><?= esc($service->name ?? '-') ?></strong></td>
                                <td><?= esc($service->category_name ?? $service->category ?? '-') ?></td>
                                <td>
                                    <?php $st = ($service->status ?? 'active') === 'active' ? 'bg-success' : 'bg-secondary'; ?>
                                    <span class="badge <?= $st ?>"><?= ucfirst(esc($service->status ?? 'active')) ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($service->created_at ?? '')) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center py-4">Belum ada layanan</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>