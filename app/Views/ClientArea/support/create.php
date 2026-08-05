<?= $this->extend('ClientArea/layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1"><i class="fas fa-plus-circle me-2"></i>Buat Tiket Baru</h3>
        <small class="text-muted">Ajukan masalah Anda, kami akan merespons secepatnya</small>
    </div>
    <a href="/client/support/tickets" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>

<?php if (!empty($errors = session()->getFlashdata('errors'))): ?>
<div class="alert alert-danger">
    <strong><i class="fas fa-exclamation-circle me-1"></i>Periksa kembali input Anda:</strong>
    <ul class="mb-0 mt-1">
        <?php foreach ($errors as $error): ?>
        <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="fas fa-ticket-alt me-2 text-primary"></i>Form Tiket</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/client/support/ticket/create" id="createTicketForm">
            <?= csrf_field() ?>
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label"><i class="fas fa-tag me-1 text-primary"></i> Kategori <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat->id ?>" <?= old('category_id') == $cat->id ? 'selected' : '' ?>>
                            <?= esc($cat->name) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted">Pilih kategori yang paling sesuai dengan masalah Anda</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i class="fas fa-exclamation-triangle me-1 text-warning"></i> Prioritas</label>
                    <select name="priority" class="form-select">
                        <option value="medium" <?= old('priority') == 'medium' ? 'selected' : '' ?>>🟡 Medium</option>
                        <option value="low" <?= old('priority') == 'low' ? 'selected' : '' ?>>🟢 Low</option>
                        <option value="high" <?= old('priority') == 'high' ? 'selected' : '' ?>>🟠 High</option>
                        <option value="critical" <?= old('priority') == 'critical' ? 'selected' : '' ?>>🔴 Critical</option>
                    </select>
                    <small class="text-muted">Prioritas default: Medium</small>
                </div>

                <div class="col-12">
                    <label class="form-label"><i class="fas fa-heading me-1 text-primary"></i> Subjek <span class="text-danger">*</span></label>
                    <input type="text" name="subject" class="form-control" value="<?= esc(old('subject')) ?>" required placeholder="Contoh: Tidak bisa login ke akun" maxlength="255">
                    <small class="text-muted">Ringkas masalah Anda dalam satu kalimat</small>
                </div>

                <div class="col-12">
                    <label class="form-label"><i class="fas fa-align-left me-1 text-primary"></i> Deskripsi Masalah <span class="text-danger">*</span></label>
                    <textarea name="message" class="form-control" rows="6" required placeholder="Jelaskan masalah Anda secara detail. Sertakan langkah yang sudah Anda coba, pesan error, atau screenshot jika ada..."><?= esc(old('message')) ?></textarea>
                    <div class="d-flex justify-content-between mt-1">
                        <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Semakin detail, semakin cepat kami membantu Anda</small>
                        <small class="text-muted" id="charCount">0 / 2000</small>
                    </div>
                </div>

                <div class="col-12 border-top pt-3">
                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-outline-secondary"><i class="fas fa-undo me-1"></i>Reset</button>
                        <button type="submit" class="btn btn-primary px-4"><i class="fas fa-paper-plane me-1"></i>Kirim Tiket</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var msg = document.querySelector('textarea[name="message"]');
    var counter = document.getElementById('charCount');
    if (msg && counter) {
        var max = 2000;
        msg.setAttribute('maxlength', max);
        var update = function() {
            counter.textContent = msg.value.length + ' / ' + max;
        };
        msg.addEventListener('input', update);
        update();
    }
});
</script>
<?= $this->endSection() ?>
