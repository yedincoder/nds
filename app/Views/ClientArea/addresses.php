<?= $this->extend('ClientArea/layout') ?>

<?= $this->section('content') ?>

<h3>My Addresses</h3>

<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header"><h5 class="mb-0">Saved Addresses</h5></div>
            <div class="card-body">
                <?php if (!empty($addresses)): ?>
                <?php foreach ($addresses as $addr): ?>
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <strong><?= esc($addr->name ?? '') ?></strong>
                        <?php if (($addr->is_default ?? 0) == 1): ?><span class="badge bg-success ms-2">Default</span><?php endif; ?>
                        <br>
                        <small class="text-muted">
                            <?= esc($addr->address ?? '') ?>, <?= esc($addr->city ?? '') ?>, <?= esc($addr->province ?? '') ?>
                        </small>
                    </div>
                    <a href="/client/address/delete/<?= esc($addr->id ?? $addr->uuid ?? '') ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this address?')"><i class="fas fa-trash"></i></a>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p class="text-muted text-center py-5">No addresses saved yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-header"><h5 class="mb-0">Add Address</h5></div>
            <div class="card-body">
                <form method="POST" action="/client/address/add">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Province</label>
                            <input type="text" name="province" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="is_default" value="1" class="form-check-input" id="isDefault">
                        <label class="form-check-label" for="isDefault">Set as default address</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Address</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>