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
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo $isRTL ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo lang('admin_login_title'); ?> — <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/style.css">
    <style>
        body { background: #0a0f1e; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .admin-login-wrap { width: 100%; max-width: 400px; padding: var(--sp-3); }
        .admin-login-card {
            background: #111827;
            border: 1px solid rgba(255,255,255,.08);
            border-radius: var(--r-2xl);
            padding: 2.5rem;
            box-shadow: 0 24px 64px rgba(0,0,0,.6);
        }
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
        .admin-login-card .form-label { color: rgba(255,255,255,.6); font-size: var(--fs-sm); font-weight: 500; }
        .admin-login-title { color: #f1f5f9; font-family: var(--font-heading); }
        .admin-login-sub   { color: rgba(255,255,255,.35); font-size: var(--fs-sm); }
        .admin-login-back  { color: rgba(255,255,255,.3); font-size: var(--fs-xs); text-decoration: none; transition: color var(--t-fast); }
        .admin-login-back:hover { color: var(--primary); }
        .admin-login-topbar { position: fixed; top: var(--sp-2); right: var(--sp-3); display: flex; gap: var(--sp-1); }
        [dir="rtl"] .admin-login-topbar { right: auto; left: var(--sp-3); }
    </style>
</head>
<body>

<!-- Top controls -->
<div class="admin-login-topbar">
    <!-- Language switcher -->
    <div class="dropdown">
        <button class="btn btn-sm btn-outline-secondary dropdown-toggle shadow-none"
                type="button" data-bs-toggle="dropdown"
                style="background:rgba(255,255,255,.06); border-color:rgba(255,255,255,.15); color:#e2e8f0; font-size:var(--fs-xs);">
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
