<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Media Manager</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Media</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Uploaded Media Files</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($media)): ?>
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-3">
            <?php foreach ($media as $item): ?>
            <div class="col">
                <div class="card">
                    <div class="card-body p-2">
                        <img src="/<?= esc($item->path) ?>" class="img-fluid rounded" alt="<?= esc($item->original_name) ?>" style="max-height: 150px; object-fit: contain;">
                    </div>
                    <div class="card-footer p-2">
                        <small class="text-muted"><?= esc(substr($item->original_name, 0, 30)) ?></small>
                        <a href="/admin/media/<?= $item->uuid ?>" class="float-end text-danger"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-4">
            <i class="fas fa-images fa-2x mb-2" style="color: var(--text-primary);"></i>
            <p>No media files uploaded yet.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.querySelector('[data-bs-badge]').forEach(function(el) {
    var count = parseInt(el.getAttribute('data-bs-badge') || '0');
    if (count > 0) {
        var badge = document.createElement('span');
        badge.className = 'badge bg-danger rounded-pill';
        badge.textContent = count;
        badge.style.cssText = 'position: absolute; top: 8px; right: 8px; font-size: 10px;';
        el.style.position = 'relative';
        el.appendChild(badge);
    }
});
</script>
<?= $this->endSection() ?>