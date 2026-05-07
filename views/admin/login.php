<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/style.css">
    <style>
        /* Admin login always uses a dark background regardless of theme —
           this is intentional: it signals "you are entering a restricted area" */
        body {
            background: #0a0f1e;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .admin-login-wrap {
            width: 100%;
            max-width: 400px;
            padding: var(--sp-3);
        }

        .admin-login-card {
            background: #111827;
            border: 1px solid rgba(255,255,255,.08);
            border-radius: var(--r-2xl);
            padding: 2.5rem;
            box-shadow: 0 24px 64px rgba(0,0,0,.6);
        }

        /* Override form controls for the dark card */
        .admin-login-card .form-control {
            background: rgba(255,255,255,.06);
            border-color: rgba(255,255,255,.12);
            color: #e2e8f0;
            border-radius: var(--r-lg);
        }
        .admin-login-card .form-control:focus {
            background: rgba(255,255,255,.1);
            border-color: var(--primary);
            color: #e2e8f0;
            box-shadow: 0 0 0 3px var(--primary-light);
        }
        .admin-login-card .form-control::placeholder { color: rgba(255,255,255,.25); }
        .admin-login-card .form-label {
            color: rgba(255,255,255,.6);
            font-size: var(--fs-sm);
            font-weight: 500;
        }

        .admin-login-title { color: #f1f5f9; font-family: var(--font-heading); }
        .admin-login-sub   { color: rgba(255,255,255,.35); font-size: var(--fs-sm); }
        .admin-login-back  { color: rgba(255,255,255,.3); font-size: var(--fs-xs); text-decoration: none; transition: color var(--t-fast); }
        .admin-login-back:hover { color: var(--primary); }

        /* Dark toggle in top-right corner */
        .admin-login-topbar {
            position: fixed;
            top: var(--sp-2);
            right: var(--sp-3);
        }
    </style>
</head>
<body>

<!-- Dark mode toggle -->
<div class="admin-login-topbar">
    <button class="dark-toggle" id="darkToggle" aria-label="Toggle dark mode">
        <i class="fas fa-moon"></i>
    </button>
</div>

<div class="admin-login-wrap">
    <div class="admin-login-card">

        <!-- Brand -->
        <div class="text-center mb-4">
            <div class="mb-3" style="font-size:2.5rem; color:var(--primary);">
                <i class="fas fa-hotel"></i>
            </div>
            <h4 class="fw-800 admin-login-title mb-1"><?php echo APP_NAME; ?></h4>
            <p class="admin-login-sub mb-0">Admin Panel</p>
        </div>

        <!-- Error -->
        <?php if(isset($error)): ?>
        <div class="alert alert-danger d-flex align-items-center gap-2 mb-4" style="font-size:var(--fs-sm);">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST" action="<?php echo SITE_URL; ?>admin/login">
            <div class="mb-3">
                <label class="form-label">
                    <i class="fas fa-user"></i> Admin Name
                </label>
                <input type="text" name="admin_name" class="form-control"
                       placeholder="Enter admin name" required autofocus autocomplete="username">
            </div>
            <div class="mb-4">
                <label class="form-label">
                    <i class="fas fa-lock"></i> Password
                </label>
                <input type="password" name="admin_pass" class="form-control"
                       placeholder="••••••••" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn custom-bg w-100 btn-lg">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>

        <!-- Back link -->
        <div class="text-center mt-4">
            <a href="<?php echo SITE_URL; ?>" class="admin-login-back">
                <i class="fas fa-arrow-left"></i> Back to site
            </a>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
/* Dark mode — applies to the toggle button icon only;
   the login card background is intentionally always dark */
(function(){
    const t = localStorage.getItem('vana_theme') || 'light';
    document.documentElement.setAttribute('data-theme', t);
    const icon = document.querySelector('#darkToggle i');
    if(icon) icon.className = t === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
})();
document.getElementById('darkToggle')?.addEventListener('click', function(){
    const next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('vana_theme', next);
    const icon = this.querySelector('i');
    if(icon) icon.className = next === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
});
</script>
</body>
</html>
