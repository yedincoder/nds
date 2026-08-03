<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NgAppID</title>
    
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

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-card {
            background: var(--white-color);
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
            transition: var(--transition);
        }

        .login-header {
            background: var(--secondary-color);
            color: var(--white-color);
            padding: 30px 20px;
            text-align: center;
        }

        .login-header h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .login-header p {
            font-size: 14px;
            opacity: 0.9;
            margin: 0;
        }

        .login-body {
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

        .form-text {
            font-size: 13px;
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

        .text-decoration-underline {
            text-decoration: underline !important;
        }

        @media (max-width: 480px) {
            .login-card {
                border-radius: 8px;
            }
            
            .login-header {
                padding: 25px 15px;
            }
            
            .login-body {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <button class="theme-toggle" id="theme-toggle" title="Toggle theme">
            <i class="fas fa-moon"></i>
        </button>

        <div class="login-card">
            <div class="login-header">
                <h2><i class="fas fa-cube me-2"></i>NgAppID</h2>
                <p>Welcome back! Please sign in to continue.</p>
            </div>

            <div class="login-body">
                <?= session()->getFlashdata('error') ? '<div class="alert alert-danger">' . session()->getFlashdata('error') . '</div>' : '' ?>
                <?= session()->getFlashdata('success') ? '<div class="alert alert-success">' . session()->getFlashdata('success') . '</div>' : '' ?>

                <form method="POST" action="/auth/login">
                    <?= csrf_field() ?>

                    <div class="mb-4">
                        <label for="login" class="form-label">Email or Username</label>
                        <input type="text" 
                               class="form-control" 
                               id="login" 
                               name="login" 
                               placeholder="Enter your email or username" 
                               required
                               value="<?= old('login') ?>">
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" 
                               class="form-control" 
                               id="password" 
                               name="password" 
                               placeholder="Enter your password" 
                               required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>

                    <div class="text-center mt-4">
                        <p class="mb-0">
                            Don't have an account? <a href="/auth/register" class="text-primary text-decoration-underline">Register</a>
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
    </script>
</body>
</html>