<?= $this->extend('ClientArea/layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Create New Ticket</h3>
    <a href="/client/support/tickets" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

<?php if (!empty($errors = session()->getFlashdata('errors'))): ?>
<div class="alert alert-danger">
    <ul class="mb-0">
        <?php foreach ($errors as $error): ?>
        <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/client/support/ticket/create">
            <?= csrf_field() ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Kategori *</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat->id ?>" <?= old('category_id') == $cat->id ? 'selected' : '' ?>>
                            <?= esc($cat->name) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted">Pilih kategori yang sesuai dengan masalah Anda</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Prioritas</label>
                    <select name="priority" class="form-select">
                        <option value="medium" <?= old('priority') == 'medium' ? 'selected' : '' ?>>Medium</option>
                        <option value="low" <?= old('priority') == 'low' ? 'selected' : '' ?>>Low</option>
                        <option value="high" <?= old('priority') == 'high' ? 'selected' : '' ?>>High</option>
                        <option value="critical" <?= old('priority') == 'critical' ? 'selected' : '' ?>>Critical</option>
                    </select>
                    <small class="text-muted">Prioritas default: Medium</small>
                </div>
                <div class="col-12">
                    <label class="form-label">Subjek *</label>
                    <input type="text" name="subject" class="form-control" value="<?= esc(old('subject')) ?>" required placeholder="Contoh: Tidak bisa login ke akun">
                </div>
                <div class="col-12">
                    <label class="form-label">Deskripsi Masalah *</label>
                    <textarea name="message" class="form-control" rows="5" required placeholder="Jelaskan masalah Anda secara detail..."><?= esc(old('message')) ?></textarea>
                    <small class="text-muted">Semakin detail, semakin cepat kami membantu Anda</small>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1"></i>Submit Ticket</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
