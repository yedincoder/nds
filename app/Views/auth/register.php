<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - NgAppID</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2A3F54;
            --secondary-color: #1ABB9C;
            --light-bg: #F7F7F7;
            --white-color: #FFFFFF;
            --border-color: #E5E5E5;
            --text-primary: #73879C;
            --text-dark: #2A3F54;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        [data-bs-theme="dark"] {
            --primary-color: #1F2937;
            --light-bg: #1F2937;
            --white-color: #111827;
            --border-color: #374151;
            --text-primary: #9CA3AF;
            --text-dark: #F3F4F6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: var(--text-primary);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        [data-bs-theme="dark"] body {
            background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
        }

        .register-container {
            width: 100%;
            max-width: 520px;
            padding: 20px;
        }

        .register-card {
            background: var(--white-color);
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
            transition: var(--transition);
        }

        .register-header {
            background: var(--secondary-color);
            color: var(--white-color);
            padding: 25px 20px;
            text-align: center;
        }

        .register-header h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .register-header p {
            font-size: 14px;
            opacity: 0.9;
            margin: 0;
        }

        .register-body {
            padding: 35px 30px;
        }

        .theme-toggle {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--white-color);
            border: 2px solid var(--border-color);
            color: var(--text-dark);
            width: 40px;
            height: 40px;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            z-index: 100;
        }

        .theme-toggle:hover {
            border-color: var(--secondary-color);
            color: var(--secondary-color);
        }

        .form-label {
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .form-control {
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 14px;
            transition: var(--transition);
            background: var(--white-color);
            color: var(--text-dark);
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(26, 188, 156, 0.1);
        }

        .input-group-text {
            background: var(--light-bg);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        .btn-primary {
            background: var(--secondary-color);
            border: none;
            border-radius: 6px;
            padding: 12px 20px;
            font-weight: 600;
            transition: var(--transition);
            width: 100%;
        }

        .btn-primary:hover {
            background: #169f82;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(26, 188, 156, 0.3);
        }

        .btn-outline-secondary {
            border: 2px solid var(--border-color);
            color: var(--text-primary);
            background: transparent;
            border-radius: 6px;
            padding: 10px 16px;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-outline-secondary:hover {
            border-color: var(--secondary-color);
            color: var(--secondary-color);
        }

        .form-text {
            font-size: 12px;
            color: var(--text-primary);
        }

        .text-center {
            text-align: center;
        }

        .mt-4 {
            margin-top: 20px !important;
        }

        .mb-4 {
            margin-bottom: 20px !important;
        }

        .mb-3 {
            margin-bottom: 16px !important;
        }

        .alert {
            border-radius: 8px;
            border: none;
            padding: 12px 16px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d1e7dd;
            color: #0f5132;
        }

        .alert-danger {
            background: #f8d7da;
            color: #842029;
        }

        .text-primary {
            color: var(--secondary-color) !important;
        }

        .text-danger {
            color: #E74C3C !important;
        }

        .text-decoration-underline {
            text-decoration: underline !important;
        }

        .invalid-feedback {
            display: block;
            font-size: 12px;
            color: #E74C3C;
        }

        @media (max-width: 480px) {
            .register-card {
                border-radius: 8px;
            }
            
            .register-header {
                padding: 20px 15px;
            }
            
            .register-body {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <button class="theme-toggle" id="theme-toggle" title="Toggle theme">
            <i class="fas fa-moon"></i>
        </button>

        <div class="register-card">
            <div class="register-header">
                <h2><i class="fas fa-user-plus me-2"></i>Create Account</h2>
                <p>Join NgAppID and get started with our platform</p>
            </div>

            <div class="register-body">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>

                <form method="POST" action="/auth/register" id="registerForm">
                    <?= csrf_field() ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" 
                                       class="form-control <?= session()->getFlashdata('errors') && session()->getFlashdata('errors')['full_name'] ? 'is-invalid' : '' ?>" 
                                       id="full_name" 
                                       name="full_name" 
                                       placeholder="Enter your full name" 
                                       required
                                       value="<?= old('full_name') ?>">
                                <?php if (session()->getFlashdata('errors') && session()->getFlashdata('errors')['full_name']): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('errors')['full_name'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" 
                                       class="form-control <?= session()->getFlashdata('errors') && session()->getFlashdata('errors')['email'] ? 'is-invalid' : '' ?>" 
                                       id="email" 
                                       name="email" 
                                       placeholder="Enter your email address" 
                                       required
                                       value="<?= old('email') ?>">
                                <div class="form-text">We'll never share your email with anyone else.</div>
                                <?php if (session()->getFlashdata('errors') && session()->getFlashdata('errors')['email']): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('errors')['email'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" 
                                       class="form-control <?= session()->getFlashdata('errors') && session()->getFlashdata('errors')['password'] ? 'is-invalid' : '' ?>" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Create a password" 
                                       required>
                                <div class="form-text">Minimum 8 characters</div>
                                <?php if (session()->getFlashdata('errors') && session()->getFlashdata('errors')['password']): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('errors')['password'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-4">
                                <label for="password_confirm" class="form-label">Confirm Password</label>
                                <input type="password" 
                                       class="form-control <?= session()->getFlashdata('errors') && session()->getFlashdata('errors')['password_confirm'] ? 'is-invalid' : '' ?>" 
                                       id="password_confirm" 
                                       name="password_confirm" 
                                       placeholder="Confirm your password" 
                                       required>
                                <?php if (session()->getFlashdata('errors') && session()->getFlashdata('errors')['password_confirm']): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('errors')['password_confirm'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#" class="text-primary text-decoration-underline">Terms of Service</a> and <a href="#" class="text-primary text-decoration-underline">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i>Create Account
                        </button>
                    </div>

                    <div class="text-center mt-4">
                        <p class="mb-0">
                            Already have an account? <a href="/auth/login" class="text-primary text-decoration-underline">Login</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Theme toggle
        const themeToggle = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement;
        
        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        htmlElement.setAttribute('data-bs-theme', savedTheme);
        updateThemeIcon(savedTheme);
        
        themeToggle.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            htmlElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });
        
        function updateThemeIcon(theme) {
            const icon = themeToggle.querySelector('i');
            icon.className = theme === 'light' ? 'fas fa-moon' : 'fas fa-sun';
        }
        
        // Auto-detect system theme
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!localStorage.getItem('theme')) {
                const newTheme = e.matches ? 'dark' : 'light';
                htmlElement.setAttribute('data-bs-theme', newTheme);
                updateThemeIcon(newTheme);
            }
        });
        
        // Password validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirm').value;
            const terms = document.getElementById('terms');
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
                return false;
            }
            
            if (!terms.checked) {
                e.preventDefault();
                alert('You must agree to the Terms of Service and Privacy Policy.');
                return false;
            }
            
            return true;
        });
    </script>
</body>
</html>