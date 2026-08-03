<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-title">
    <h3>Settings</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Settings</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-3 col-md-4 mb-4">
        <div class="card">
            <div class="card-body p-0">
                <ul class="nav flex-column nav-settings">
                    <li class="nav-item">
                        <a class="nav-link active" href="#general" data-bs-toggle="tab">
                            <i class="fas fa-cog me-2"></i> General
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#profile" data-bs-toggle="tab">
                            <i class="fas fa-user me-2"></i> Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#security" data-bs-toggle="tab">
                            <i class="fas fa-lock me-2"></i> Security
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#notifications" data-bs-toggle="tab">
                            <i class="fas fa-bell me-2"></i> Notifications
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-lg-9 col-md-8">
        <div class="tab-content">
            <!-- General Settings -->
            <div class="tab-pane fade show active" id="general">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">General Settings</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Site Name</label>
                                    <input type="text" class="form-control" value="NgAppID">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Site URL</label>
                                    <input type="text" class="form-control" value="https://nds.test">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Support Email</label>
                                    <input type="email" class="form-control" value="support@nds.test">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Timezone</label>
                                    <select class="form-select">
                                        <option value="Asia/Jakarta" selected>Asia/Jakarta (WIB)</option>
                                        <option value="Asia/Makassar">Asia/Makassar (WITA)</option>
                                        <option value="Asia/Jayapura">Asia/Jayapura (WIT)</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Profile Settings -->
            <div class="tab-pane fade" id="profile">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Profile Settings</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" value="<?= esc(session()->get('username') ?? 'Admin') ?>">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="<?= esc(session()->get('email') ?? '') ?>">
                                </div>
                                <div class="col-12 mb-4">
                                    <label class="form-label">Bio</label>
                                    <textarea class="form-control" rows="4" placeholder="Tell us about yourself"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Security Settings -->
            <div class="tab-pane fade" id="security">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Security Settings</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-4">
                                <label class="form-label">Current Password</label>
                                <input type="password" class="form-control" placeholder="Enter current password">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">New Password</label>
                                    <input type="password" class="form-control" placeholder="Enter new password">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" placeholder="Confirm new password">
                                </div>
                            </div>
                            <div class="form-check form-switch mb-4">
                                <input class="form-check-input" type="checkbox" id="twoFactor">
                                <label class="form-check-label" for="twoFactor">Enable Two-Factor Authentication</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Security</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Notification Settings -->
            <div class="tab-pane fade" id="notifications">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Notification Preferences</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="notifOrders" checked>
                            <label class="form-check-label" for="notifOrders">New Order Notifications</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="notifPayments" checked>
                            <label class="form-check-label" for="notifPayments">Payment Notifications</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="notifCustomers">
                            <label class="form-check-label" for="notifCustomers">New Customer Registrations</label>
                        </div>
                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" id="notifEmails">
                            <label class="form-check-label" for="notifEmails">Email Notifications</label>
                        </div>
                        <button class="btn btn-primary">Save Preferences</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>