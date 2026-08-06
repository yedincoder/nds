<?= $this->extend('Layout/layout_mitraarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Penarikan</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/mitra/dashboard">Mitra</a></li>
            <li class="breadcrumb-item"><a href="/mitra/pendapatan/balance">Pendapatan</a></li>
            <li class="breadcrumb-item active">Penarikan</li>
        </ol>
    </nav>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Ajukan Penarikan</div>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-3">
                    Saldo tersedia: <strong>Rp <?= number_format($wallet->balance ?? 0, 0, ',', '.') ?></strong>
                </div>
                <form method="post" action="/mitra/pendapatan/withdraw">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Jumlah (Rp) *</label>
                        <input type="number" step="0.01" min="1" class="form-control" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Bank *</label>
                        <input type="text" class="form-control" name="bank_name" required placeholder="BCA / BNI / Mandiri / dll">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Rekening *</label>
                        <input type="text" class="form-control" name="account_number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Pemilik Rekening *</label>
                        <input type="text" class="form-control" name="account_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-money-bill-wave me-1"></i>Ajukan Penarikan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Riwayat Penarikan</div>
            </div>
            <div class="card-body" style="padding:8px 16px">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Jumlah</th>
                                <th>Bank</th>
                                <th>Rekening</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($withdrawals)): ?>
                                <?php foreach ($withdrawals as $i => $wd): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td>Rp <?= number_format($wd->amount ?? 0, 0, ',', '.') ?></td>
                                        <td><?= esc($wd->bank_name ?? '-') ?></td>
                                        <td><?= esc($wd->account_number ?? '-') ?> <small class="text-muted">(<?= esc($wd->account_name ?? '') ?>)</small></td>
                                        <td>
                                            <?php $sc = match($wd->status ?? '') {
                                                'approved','completed' => 'bg-success',
                                                'pending' => 'bg-warning',
                                                'rejected' => 'bg-danger',
                                                default => 'bg-secondary'
                                            }; ?>
                                            <span class="badge <?= $sc ?>"><?= ucfirst($wd->status ?? 'pending') ?></span>
                                        </td>
                                        <td><?= date('d M Y', strtotime($wd->created_at ?? '')) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center py-4">Belum ada penarikan</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>