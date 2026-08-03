<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - NgAppID</title>
    <script>(function(){try{var t=localStorage.getItem("dash26-theme"),e=window.matchMedia("(prefers-color-scheme: dark)").matches;document.documentElement.setAttribute("data-theme",t||(e?"dark":"light"))}catch(t){document.documentElement.setAttribute("data-theme","light")}})();</script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="/assets/adminator/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        .auth-form { display: flex; flex-direction: column; gap: 14px; }
        .auth-field { display: flex; flex-direction: column; gap: 6px; }
        .auth-label { color: var(--t-base); font-size: 13px; font-weight: 500; }
        .auth-input { background: var(--bg-card); border: 1px solid var(--border); border-radius: 8px; color: var(--t-base); font-size: 13px; padding: 10px 12px; width: 100%; }
        .auth-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-ring); }
        .auth-btn { align-items: center; background: var(--primary); border: none; border-radius: 8px; color: #fff; cursor: pointer; display: inline-flex; font-size: 13px; font-weight: 600; justify-content: center; padding: 10px 16px; transition: background-color .18s ease; }
        .auth-btn:hover { background: var(--primary-dark); }
        .auth-link { color: var(--primary); font-size: 13px; text-decoration: none; }
        .auth-link:hover { text-decoration: underline; }
        .auth-title { color: var(--t-base); font-size: 22px; font-weight: 700; margin: 0 0 6px; }
        .auth-subtitle { color: var(--t-muted); font-size: 13px; margin: 0 0 24px; }
        .auth-error { background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.3); border-radius: 8px; color: #dc2626; font-size: 13px; margin-bottom: 16px; padding: 10px 14px; }
        .auth-success { background: rgba(16,185,129,.1); border: 1px solid rgba(16,185,129,.3); border-radius: 8px; color: #059669; font-size: 13px; margin-bottom: 16px; padding: 10px 14px; }
        .auth-theme-toggle { background: transparent; border: none; color: var(--t-muted); cursor: pointer; font-size: 16px; position: absolute; right: 24px; top: 24px; }
        .auth-aside-eyebrow { font-size: 12px; letter-spacing: .15em; opacity: .8; text-transform: uppercase; }
        .auth-aside h1 { font-size: 28px; font-weight: 700; line-height: 1.3; margin: 16px 0 12px; }
        .auth-aside p { font-size: 14px; line-height: 1.6; opacity: .85; }
        .auth-row { display: flex; gap: 12px; }
        .auth-row .auth-field { flex: 1; }
        @media (max-width: 768px) {
            .auth-shell { display: block; }
            .auth-aside { display: none; }
            .auth-row { flex-direction: column; }
        }
    </style>
</head>
<body>
<div class="auth-shell">
    <aside class="auth-aside">
        <div class="auth-brand">
            <i class="fas fa-cube fa-2x"></i>
            <div class="name" style="font-size:20px;font-weight:700">NgAppID</div>
        </div>
        <div class="auth-aside-body" style="margin:auto 0">
            <span class="auth-aside-eyebrow">PT. YEDIN DIGITAL MANDIRI</span>
            <h1>Bergabunglah bersama kami.</h1>
            <p>Akses ke produk digital, invoice, download, dan dukungan pelanggan dalam satu platform.</p>
        </div>
        <div class="auth-aside-footer" style="display:flex;gap:16px;font-size:12px;opacity:.7">
            <span>&copy; 2026</span><span>Rangkasbitung, Banten</span>
        </div>
    </aside>
    <main class="auth-main" style="position:relative">
        <button class="auth-theme-toggle" id="themeToggle" title="Toggle theme"><i class="fas fa-sun"></i></button>
        <div class="auth-card">
            <div style="margin-bottom:24px">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
                    <div style="align-items:center;background:var(--primary);border-radius:10px;color:#fff;display:inline-flex;height:44px;justify-content:center;width:44px"><i class="fas fa-cube"></i></div>
                    <span style="color:var(--t-base);font-size:18px;font-weight:700">NgAppID</span>
                </div>
                <h2 class="auth-title">Buat Akun</h2>
                <p class="auth-subtitle">Daftar untuk mulai menggunakan platform.</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
            <div class="auth-error"><i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
            <div class="auth-success"><i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (!empty(session()->getFlashdata('errors')) && is_array(session()->getFlashdata('errors'))): ?>
            <div class="auth-error">
                <ul style="margin:0;padding-left:18px">
                    <?php foreach (session()->getFlashdata('errors') as $e): ?>
                    <li><?= esc($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <form method="POST" action="/auth/register" class="auth-form">
                <?= csrf_field() ?>
                <div class="auth-field">
                    <label class="auth-label" for="full_name">Nama Lengkap</label>
                    <input type="text" id="full_name" name="full_name" class="auth-input" placeholder="Nama lengkap Anda" value="<?= old('full_name') ?>" required>
                </div>
                <div class="auth-field">
                    <label class="auth-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="auth-input" placeholder="nama@email.com" value="<?= old('email') ?>" required>
                </div>
                <div class="auth-row">
                    <div class="auth-field">
                        <label class="auth-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="auth-input" placeholder="Minimal 8 karakter" required>
                    </div>
                    <div class="auth-field">
                        <label class="auth-label" for="password_confirm">Konfirmasi</label>
                        <input type="password" id="password_confirm" name="password_confirm" class="auth-input" placeholder="Ulangi password" required>
                    </div>
                </div>
                <button type="submit" class="auth-btn">
                    <i class="fas fa-user-plus me-2"></i>Daftar
                </button>
            </form>

            <p style="color:var(--t-muted);font-size:13px;margin-top:20px;text-align:center">
                Sudah punya akun? <a class="auth-link" href="/auth/login">Masuk</a>
            </p>
        </div>
    </main>
</div>
<script>
document.getElementById('themeToggle')?.addEventListener('click', function() {
    var html = document.documentElement;
    var next = html.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
    html.setAttribute('data-theme', next);
    localStorage.setItem('dash26-theme', next);
    this.querySelector('i').className = next === 'light' ? 'fas fa-sun' : 'fas fa-moon';
});
</script>
</body>
</html>
