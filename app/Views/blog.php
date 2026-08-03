<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="container">
        <h1>Blog</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Blog</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Artikel Terbaru</h2>
            <p class="section-subtitle">Wawasan, tips, dan update teknologi terbaru dari tim kami</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="product-card h-100">
                    <div class="product-img">
                        <i class="fas fa-code"></i>
                    </div>
                    <div class="card-body">
                        <span class="badge bg-primary mb-2">Development</span>
                        <h5>Best Practices CodeIgniter 4</h5>
                        <p class="text-muted mb-3">Panduan lengkap best practices pengembangan aplikasi dengan CodeIgniter 4.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">15 Jan 2026</small>
                            <a href="#" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="product-card h-100">
                    <div class="product-img" style="background: linear-gradient(135deg, var(--accent), #9B59B6)">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="card-body">
                        <span class="badge bg-info mb-2">Security</span>
                        <h5>Security Best Practices Web App</h5>
                        <p class="text-muted mb-3">10 langkah keamanan wajib untuk melindungi aplikasi web dari serangan.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">10 Jan 2026</small>
                            <a href="#" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="product-card h-100">
                    <div class="product-img" style="background: linear-gradient(135deg, var(--success), #2ECC71)">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <div class="card-body">
                        <span class="badge bg-success mb-2">Performance</span>
                        <h5>Optimasi Performa Web App</h5>
                        <p class="text-muted mb-3">Teknik optimasi performa aplikasi web untuk loading time yang lebih cepat.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">05 Jan 2026</small>
                            <a href="#" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="product-card h-100">
                    <div class="product-img" style="background: linear-gradient(135deg, var(--warning), var(--danger))">
                        <i class="fas fa-database"></i>
                    </div>
                    <div class="card-body">
                        <span class="badge bg-warning text-dark mb-2">Database</span>
                        <h5>Optimasi Query Database</h5>
                        <p class="text-muted mb-3">Teknik optimasi query MySQL/PostgreSQL untuk performa database maksimal.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">28 Dec 2025</small>
                            <a href="#" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="product-card h-100">
                    <div class="product-img" style="background: linear-gradient(135deg, var(--accent), #9B59B6)">
                        <i class="fas fa-cloud"></i>
                    </div>
                    <div class="card-body">
                        <span class="badge bg-info mb-2">Cloud</span>
                        <h5>Deploy Aplikasi ke AWS</h5>
                        <p class="text-muted mb-3">Panduan lengkap deploy aplikasi CodeIgniter ke AWS dengan CI/CD.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">22 Dec 2025</small>
                            <a href="#" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="product-card h-100">
                    <div class="product-img" style="background: linear-gradient(135deg, var(--warning), var(--danger))">
                        <i class="fas fa-code-branch"></i>
                    </div>
                    <div class="card-body">
                        <span class="badge bg-warning text-dark mb-2">DevOps</span>
                        <h5>CI/CD Pipeline dengan GitHub Actions</h5>
                        <p class="text-muted mb-3">Setup pipeline otomatis untuk testing dan deployment aplikasi.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">15 Dec 2025</small>
                            <a href="#" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="/blog" class="btn btn-outline-primary">Lihat Semua Artikel</a>
        </div>
    </div>
</section>

<?= $this->endSection() ?>