<?php
$lang  = Session::getLang();
$isRTL = $lang === 'ar';
$pageTitle = APP_NAME . ' — ' . lang('login');
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo $isRTL ? 'rtl' : 'ltr'; ?>">
<head>
    <?php require BASE_PATH . '/views/layouts/head.php'; ?>
    <title><?php echo $pageTitle; ?></title>
</head>
<body class="auth-body">

<div class="auth-layout">

    <!-- Left panel — branding -->
    <div class="auth-panel-left d-none d-lg-flex">
        <div class="auth-panel-overlay"></div>
        <div class="auth-panel-content">
            <a href="<?php echo SITE_URL; ?>" class="auth-brand">
                <i class="fas fa-hotel"></i>
                <span><?php echo APP_NAME; ?></span>
            </a>
            <div class="auth-panel-tagline">
                <h2><?php echo lang('login_welcome'); ?></h2>
                <p><?php echo lang('login_welcome_sub'); ?></p>
            </div>
            <div class="auth-panel-features">
                <div class="auth-feature">
                    <i class="fas fa-calendar-check"></i>
                    <span><?php echo lang('feat_manage_book'); ?></span>
                </div>
                <div class="auth-feature">
                    <i class="fas fa-star"></i>
                    <span><?php echo lang('feat_rate_review'); ?></span>
                </div>
                <div class="auth-feature">
                    <i class="fas fa-wallet"></i>
                    <span><?php echo lang('feat_track_bal'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right panel — form -->
    <div class="auth-panel-right">

        <!-- Top bar -->
        <div class="auth-topbar">
            <a href="<?php echo SITE_URL; ?>" class="auth-back">
                <i class="fas fa-arrow-left"></i>
                <span><?php echo lang('back_to_site'); ?></span>
            </a>
            <div class="d-flex align-items-center gap-2">
                <button class="dark-toggle" id="darkToggle" aria-label="Toggle dark mode">
                    <i class="fas fa-moon"></i>
                </button>
            </div>
        </div>

        <!-- Form -->
        <div class="auth-form-wrap">

            <div class="auth-form-header">
                <div class="auth-icon-badge">
                    <i class="fas fa-sign-in-alt"></i>
                </div>
                <h1 class="auth-title"><?php echo lang('login'); ?></h1>
                <p class="auth-subtitle"><?php echo lang('login_subtitle'); ?></p>
            </div>

            <!-- Alert area -->
            <div id="auth-alert" class="auth-alert d-none"></div>

            <form id="login-form" novalidate>

                <div class="auth-field">
                    <label class="form-label">
                        <i class="fas fa-envelope"></i><?php echo lang('email'); ?> / Mobile
                    </label>
                    <input type="text" name="email_mob" id="email_mob"
                           class="form-control form-control-lg"
                           placeholder="<?php echo lang('email_hint'); ?> <?php echo lang('phone_hint'); ?>"
                           autocomplete="username" required>
                </div>

                <div class="auth-field">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label mb-0">
                            <i class="fas fa-lock"></i><?php echo lang('password'); ?>
                        </label>
                    </div>
                    <div class="auth-password-wrap">
                        <input type="password" name="pass" id="pass"
                               class="form-control form-control-lg"
                               placeholder="<?php echo lang('pass_placeholder'); ?>"
                               autocomplete="current-password" required>
                        <button type="button" class="auth-eye" id="togglePass" aria-label="<?php echo lang('show_password'); ?>">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn custom-bg w-100 btn-lg mt-2" id="submit-btn">
                    <i class="fas fa-sign-in-alt"></i><?php echo lang('login'); ?>
                </button>

            </form>

            <p class="auth-switch">
                <?php echo lang('no_account'); ?>
                <a href="<?php echo SITE_URL; ?>register">
                    <i class="fas fa-user-plus"></i><?php echo lang('register'); ?>
                </a>
            </p>

        </div>
    </div>

</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const APP = { siteUrl: '<?php echo SITE_URL; ?>' };

/* Dark mode */
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

/* Password toggle */
document.getElementById('togglePass')?.addEventListener('click', function(){
    const inp = document.getElementById('pass');
    const icon = this.querySelector('i');
    if(inp.type === 'password'){
        inp.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        inp.type = 'password';
        icon.className = 'fas fa-eye';
    }
});

/* Alert helper */
function showAlert(msg, type){
    const el = document.getElementById('auth-alert');
    const icons = { success:'fa-check-circle', danger:'fa-exclamation-circle', warning:'fa-exclamation-triangle' };
    el.className = `auth-alert auth-alert-${type}`;
    el.innerHTML = `<i class="fas ${icons[type]||'fa-info-circle'}"></i><span>${msg}</span>`;
}

/* Login form */
document.getElementById('login-form').addEventListener('submit', function(e){
    e.preventDefault();
    const btn = document.getElementById('submit-btn');
    btn.classList.add('btn-loading');
    btn.disabled = true;

    const data = new FormData();
    data.append('email_mob', this.elements['email_mob'].value.trim());
    data.append('pass', this.elements['pass'].value);
    data.append('login', '');

    fetch(APP.siteUrl + 'api/auth/login', { method:'POST', body:data })
        .then(r => r.text())
        .then(r => {
            btn.classList.remove('btn-loading');
            btn.disabled = false;
            const msgs = {
                inv_email_mob: '<?php echo lang('err_inv_email_mob'); ?>',
                inactive:      '<?php echo lang('err_inactive'); ?>',
                invalid_pass:  '<?php echo lang('err_invalid_pass'); ?>',
                rate_limit:    '<?php echo lang('err_rate_limit'); ?>'
            };
            if(msgs[r]){
                showAlert(msgs[r], 'danger');
            } else {
                showAlert('<?php echo lang('login_redirecting'); ?>', 'success');
                setTimeout(() => window.location.href = APP.siteUrl, 800);
            }
        })
        .catch(() => {
            btn.classList.remove('btn-loading');
            btn.disabled = false;
            showAlert('Connection error. Please try again.', 'danger');
        });
});
</script>
<script src="<?php echo ASSETS_URL; ?>css/../js/main.js" defer></script>
</body>
</html>
