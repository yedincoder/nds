<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="container">
        <h1>Contact Us</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Contact</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 mb-4">
                <h2 class="section-title">Hubungi Kami</h2>
                <p class="text-muted mb-4">Punya pertanyaan atau butuh konsultasi? Jangan ragu untuk menghubungi kami.</p>

                <div class="d-flex align-items-start mb-4">
                    <div class="feature-icon me-3" style="background: rgba(230,92,0,0.1); color: var(--primary); width: 50px; height: 50px;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Alamat</h6>
                        <p class="text-muted mb-0">Jl. RA. Kartini No.23L, Rangkasbitung, Lebak, Banten 42314</p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-4">
                    <div class="feature-icon me-3" style="background: rgba(230,92,0,0.1); color: var(--primary); width: 50px; height: 50px;">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Telepon / WhatsApp</h6>
                        <p class="text-muted mb-0">08977487315</p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-4">
                    <div class="feature-icon me-3" style="background: rgba(230,92,0,0.1); color: var(--primary); width: 50px; height: 50px;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Email</h6>
                        <p class="text-muted mb-0">info@ngappid.com</p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-4">
                    <div class="feature-icon me-3" style="background: rgba(230,92,0,0.1); color: var(--primary); width: 50px; height: 50px;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Jam Kerja</h6>
                        <p class="text-muted mb-0">Senin - Jumat: 09.00 - 18.00<br>Sabtu: 09.00 - 14.00</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card p-4">
                    <h4 class="fw-bold mb-4" style="color: var(--secondary)">Kirim Pesan</h4>

                    <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
                    <?php endif; ?>

                    <?php if (!empty($errors = session()->getFlashdata('errors'))): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                            <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="/contact">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Subjek</label>
                                <input type="text" name="subject" class="form-control" required>
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Pesan</label>
                                <textarea name="message" class="form-control" rows="6" required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
