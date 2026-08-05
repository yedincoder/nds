<?= $this->extend('ClientArea/layout') ?>

<?= $this->section('content') ?>

<h3>My Profile</h3>

<div class="card">
    <div class="card-body">
        <?php
        $userData = $profile['user'] ?? $profile->user ?? null;
        $profileData = $profile['profile'] ?? $profile->profile ?? $profile ?? null;
        $fullName = $profileData->full_name ?? session()->get('username') ?? '';
        $phone = $profileData->phone ?? '';
        $address = $profileData->address ?? '';
        $city = $profileData->city ?? '';
        $province = $profileData->province ?? '';
        ?>
        <form method="POST" action="/client/profile/update">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" value="<?= esc($fullName) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?= esc($phone) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2"><?= esc($address) ?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" value="<?= esc($city) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Province</label>
                        <input type="text" name="province" class="form-control" value="<?= esc($province) ?>">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save Profile</button>
        </form>
    </div>