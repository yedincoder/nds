<?= $this->extend('layout/layout_adminarea') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Media</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
            <li class="breadcrumb-item active">Media</li>
        </ol>
    </nav>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <h3><?= number_format(count($media)) ?></h3>
            <p>Total files</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Media Manager</div>
        <form method="post" action="/admin/media/upload" enctype="multipart/form-data" class="d-flex gap-2 align-items-center">
                    <?= csrf_field() ?>
            <input type="file" name="file" class="form-control" style="max-width:250px" required>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-upload me-1"></i>Upload</button>
        </form>
    </div>
    <div class="card-body" style="padding:8px 16px">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Filename</th>
                        <th>Type</th>
                        <th>Size</th>
                        <th>Uploaded</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($media)): ?>
                        <?php foreach ($media as $i => $m): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><strong><?= esc($m->file_name ?? '-') ?></strong></td>
                                <td><?= esc($m->mime_type ?? '-') ?></td>
                                <td><?= number_format(($m->file_size ?? 0) / 1024, 1) ?> KB</td>
                                <td><?= date('d M Y', strtotime($m->created_at ?? '')) ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="/admin/media/delete/<?= esc($m->id) ?>" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center py-4">Belum ada file media</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
