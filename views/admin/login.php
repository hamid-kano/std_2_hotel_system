<?php
$lang  = Session::getLang();
$isRTL = ($lang === 'ar');
// Language switcher on login page
if (isset($_GET['set_lang'])) {
    Session::setLang($_GET['set_lang']);
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}
$langLabels = ['ar' => 'العربية 🇮🇶', 'en' => 'English 🇬🇧', 'ku' => 'کوردی 🏳'];

// Read theme from cookie — prevents flash on page load
$savedTheme = $_COOKIE['vana_theme'] ?? 'light';
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>"
      dir="<?php echo $isRTL ? 'rtl' : 'ltr'; ?>"
      data-theme="<?php echo htmlspecialchars($savedTheme); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo lang('admin_login_title'); ?> — <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/style.css">
    <style>
        /* ── Admin Login — theme-aware ── */

        /* Font */
        body, input, button, select, textarea {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        [dir="rtl"] body,
        [dir="rtl"] input,
        [dir="rtl"] button,
        [dir="rtl"] select,
        [dir="rtl"] textarea {
            font-family: 'Tajawal', 'Segoe UI', Tahoma, sans-serif;
            font-size: 1.02rem;
            line-height: 1.75;
        }

        /* Light theme: clean white card on light grey */
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-body);
        }

        .admin-login-wrap {
            width: 100%;
            max-width: 400px;
            padding: var(--sp-3);
        }

        .admin-login-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--r-2xl);
            padding: 2.5rem;
            box-shadow: var(--shadow-xl);
        }

        /* Form controls inherit design system */
        .admin-login-card .form-control {
            background: var(--bg-input);
            border-color: var(--border-color);
            color: var(--text-primary);
            border-radius: var(--r-lg);
        }
        .admin-login-card .form-control:focus {
            background: var(--bg-input);
            border-color: var(--primary);
            color: var(--text-primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }
        .admin-login-card .form-control::placeholder {
            color: var(--text-muted);
        }
        .admin-login-card .form-label {
            color: var(--text-secondary);
            font-size: var(--fs-sm);
            font-weight: 500;
        }

        .admin-login-title {
            color: var(--text-primary);
            font-family: var(--font-heading);
        }
        .admin-login-sub {
            color: var(--text-secondary);
            font-size: var(--fs-sm);
        }
        .admin-login-back {
            color: var(--text-muted);
            font-size: var(--fs-xs);
            text-decoration: none;
            transition: color var(--t-fast);
        }
        .admin-login-back:hover { color: var(--primary); }

        /* Topbar */
        .admin-login-topbar {
            position: fixed;
            top: var(--sp-2);
            right: var(--sp-3);
            display: flex;
            gap: var(--sp-1);
            z-index: 100;
        }
        [dir="rtl"] .admin-login-topbar { right: auto; left: var(--sp-3); }

        /* Lang button adapts to theme */
        .admin-lang-btn {
            font-size: var(--fs-xs);
            padding: .35rem .75rem;
            border-radius: var(--r-full);
            background: var(--bg-card);
            border-color: var(--border-color);
            color: var(--text-primary);
        }
        .admin-lang-btn:hover {
            background: var(--bg-hover);
            color: var(--primary);
            border-color: var(--primary);
        }

        /* Dropdown adapts to theme */
        .admin-login-topbar .dropdown-menu {
            background: var(--bg-card);
            border-color: var(--border-color);
        }
        .admin-login-topbar .dropdown-item {
            color: var(--text-primary);
        }
        .admin-login-topbar .dropdown-item:hover {
            background: var(--bg-hover);
            color: var(--primary);
        }

        /* Dark theme — add a subtle accent to the card */
        [data-theme="dark"] .admin-login-card {
            background: var(--bg-card);
            border-color: var(--border-color);
            box-shadow: var(--shadow-xl);
        }
        [data-theme="dark"] body {
            background: var(--bg-body);
        }
    </style>
</head>
<body>

<!-- Top controls -->
<div class="admin-login-topbar">
    <!-- Language switcher -->
    <div class="dropdown">
        <button class="btn btn-sm dropdown-toggle shadow-none admin-lang-btn"
                type="button" data-bs-toggle="dropdown">
            <i class="fas fa-language"></i> <?php echo $langLabels[$lang]; ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <?php foreach($langLabels as $code => $label): ?>
            <?php if($code !== $lang): ?>
            <li><a class="dropdown-item" href="?set_lang=<?php echo $code; ?>"><?php echo $label; ?></a></li>
            <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
    <!-- Dark toggle -->
    <button class="dark-toggle" id="darkToggle" aria-label="<?php echo lang('toggle_dark'); ?>">
        <i class="fas fa-moon"></i>
    </button>
</div>

<div class="admin-login-wrap">
    <div class="admin-login-card">
        <div class="text-center mb-4">
            <div class="mb-3" style="font-size:2.5rem; color:var(--primary);">
                <i class="fas fa-hotel"></i>
            </div>
            <h4 class="fw-800 admin-login-title mb-1"><?php echo APP_NAME; ?></h4>
            <p class="admin-login-sub mb-0"><?php echo lang('admin_login_title'); ?></p>
        </div>

        <?php if(isset($error)): ?>
        <div class="alert alert-danger d-flex align-items-center gap-2 mb-4" style="font-size:var(--fs-sm);">
            <i class="fas fa-exclamation-circle"></i><?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo SITE_URL; ?>admin/login">
            <div class="mb-3">
                <label class="form-label">
                    <i class="fas fa-user"></i> <?php echo lang('admin_admin_name'); ?>
                </label>
                <input type="text" name="admin_name" class="form-control"
                       placeholder="<?php echo lang('admin_enter_name'); ?>"
                       required autofocus autocomplete="username">
            </div>
            <div class="mb-4">
                <label class="form-label">
                    <i class="fas fa-lock"></i> <?php echo lang('password'); ?>
                </label>
                <input type="password" name="admin_pass" class="form-control"
                       placeholder="<?php echo lang('pass_placeholder'); ?>"
                       required autocomplete="current-password">
            </div>
            <button type="submit" class="btn custom-bg w-100 btn-lg">
                <i class="fas fa-sign-in-alt"></i> <?php echo lang('admin_login_btn'); ?>
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="<?php echo SITE_URL; ?>" class="admin-login-back">
                <i class="fas fa-arrow-left"></i> <?php echo lang('admin_back_site'); ?>
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function(){
    // Theme already set on <html> by PHP — just sync the icon
    const t    = document.documentElement.getAttribute('data-theme') || 'light';
    const icon = document.querySelector('#darkToggle i');
    if (icon) icon.className = t === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
})();

document.getElementById('darkToggle')?.addEventListener('click', function(){
    const current = document.documentElement.getAttribute('data-theme');
    const next    = current === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('vana_theme', next);
    document.cookie = `vana_theme=${next};path=/;max-age=31536000`;
    const icon = this.querySelector('i');
    if (icon) icon.className = next === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
});
</script>
</body>
</html>
