<?= $this->extend('Layout/layout_mitraarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Profil Mitra</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/mitra/dashboard">Mitra</a></li>
            <li class="breadcrumb-item active">Profil</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Profil Mitra</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Info Mitra</h5>
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-muted w-25">Kode Mitra</td>
                                    <td><strong><?= esc($mitra->mitra_code ?? '-') ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Referral Code</td>
                                    <td><strong><?= esc($mitra->referral_code ?? '-') ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Komisi Rate</td>
                                    <td><strong><?= number_format($mitra->commission_rate ?? 0, 2) ?>%</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Status</td>
                                    <td>
                                        <?php $st = match($mitra->status ?? 'pending') {
                                            'active' => 'bg-success', 'pending' => 'bg-warning',
                                            'suspended' => 'bg-danger', default => 'bg-secondary'
                                        }; ?>
                                        <span class="badge <?= $st ?>"><?= ucfirst($mitra->status ?? 'pending') ?></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5>Info User</h5>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="text-muted w-25">Username</td>
                                <td><strong><?= esc($user['username'] ?? '-') ?></strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Email</td>
                                <td><?= esc($user['email'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Nama Lengkap</td>
                                <td><?= esc($user['full_name'] ?? '-') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>