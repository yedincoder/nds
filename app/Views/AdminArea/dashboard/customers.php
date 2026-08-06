<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Customers</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item active">Customers</li>
        </ol>
    </nav>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <h3><?= number_format(count($customers)) ?></h3>
            <p>Total ditampilkan</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Manage Customers</div>
    </div>
    <div class="card-body" style="padding:8px 16px">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($customers)): ?>
                        <?php foreach ($customers as $i => $customer): ?>
                            <tr>
                                <td><?= $i + 1 + (($pager->getCurrentPage() - 1) * $pager->getPerPage()) ?></td>
                                <td><strong><?= esc($customer->username ?? '-') ?></strong></td>
                                <td><?= esc($customer->email ?? '-') ?></td>
                                <td>
                                    <?php $st = ($customer->status ?? 'active') === 'active' ? 'bg-success' : 'bg-secondary'; ?>
                                    <span class="badge <?= $st ?>"><?= ucfirst(esc($customer->status ?? 'active')) ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($customer->created_at ?? '')) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center py-4">Belum ada customer</td></tr>
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
