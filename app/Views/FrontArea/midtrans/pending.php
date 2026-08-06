<?= $this->extend('Layout/layout_clientarea') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="container">
        <h1>Payment Pending</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Payment Pending</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Menunggu Pembayaran</h4>
                    </div>
                    <div class="card-body text-center py-5">
                        <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <h4 class="mb-3">Menunggu Konfirmasi Pembayaran</h4>
                        <p class="text-muted">Pembayaran Anda sedang diproses. Silakan selesaikan pembayaran di halaman Midtrans.</p>
                        <div class="d-flex justify-content-center gap-2 mt-4">
                            <a href="/payment/midtrans/success" class="btn btn-primary">Cek Status</a>
                            <a href="/payment" class="btn btn-outline-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>