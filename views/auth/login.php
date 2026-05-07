<?php
// Language switcher handler
if (isset($_GET['set_lang'])) {
    Session::setLang($_GET['set_lang']);
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}

$lang      = Session::getLang();
$isRTL     = ($lang === 'ar');
$pageTitle = APP_NAME . ' — ' . lang('login');

// Read saved theme BEFORE rendering HTML to avoid flash
$savedTheme = $_COOKIE['vana_theme'] ?? 'light';
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>"
      dir="<?php echo $isRTL ? 'rtl' : 'ltr'; ?>"
      data-theme="<?php echo htmlspecialchars($savedTheme); ?>">
<head>
    <?php require BASE_PATH . '/views/layouts/head.php'; ?>
    <title><?php echo $pageTitle; ?></title>
    <style>
        /* Prevent FOUC — theme is set server-side via cookie */
        .auth-lang-btn {
            font-size: var(--fs-xs);
            padding: .35rem .75rem;
            border-radius: var(--r-full);
        }
        [data-theme="dark"] .auth-lang-btn {
            color: var(--text-primary);
            border-color: var(--border-color);
        }
    </style>
</head>
<body class="auth-body">

<div class="auth-layout">

    <!-- Left panel -->
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

    <!-- Right panel -->
    <div class="auth-panel-right">

        <?php require BASE_PATH . '/views/auth/partials/topbar.php'; ?>

        <div class="auth-form-wrap">

            <div class="auth-form-header">
                <div class="auth-icon-badge">
                    <i class="fas fa-sign-in-alt"></i>
                </div>
                <h1 class="auth-title"><?php echo lang('login'); ?></h1>
                <p class="auth-subtitle"><?php echo lang('login_subtitle'); ?></p>
            </div>

            <div id="auth-alert" class="auth-alert d-none"></div>

            <form id="login-form" novalidate>
                <div class="auth-field">
                    <label class="form-label">
                        <i class="fas fa-envelope"></i><?php echo lang('email_mobile'); ?>
                    </label>
                    <input type="text" name="email_mob" id="email_mob"
                           class="form-control form-control-lg"
                           placeholder="<?php echo lang('email_hint'); ?>"
                           autocomplete="username" required>
                </div>

                <div class="auth-field">
                    <label class="form-label">
                        <i class="fas fa-lock"></i><?php echo lang('password'); ?>
                    </label>
                    <div class="auth-password-wrap">
                        <input type="password" name="pass" id="pass"
                               class="form-control form-control-lg"
                               placeholder="<?php echo lang('pass_placeholder'); ?>"
                               autocomplete="current-password" required>
                        <button type="button" class="auth-eye" id="togglePass"
                                aria-label="<?php echo lang('show_password'); ?>">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const APP = { siteUrl: '<?php echo SITE_URL; ?>' };

/* ── Dark mode ──
   Theme is already set on <html> via PHP cookie read.
   JS only handles toggle clicks and syncs the cookie. */
function _applyThemeIcon(theme) {
    const icon = document.querySelector('#darkToggle i');
    if (icon) icon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
}
_applyThemeIcon(document.documentElement.getAttribute('data-theme') || 'light');

document.getElementById('darkToggle')?.addEventListener('click', function () {
    const current = document.documentElement.getAttribute('data-theme');
    const next    = current === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    // Persist in both localStorage AND cookie (cookie lets PHP read it server-side)
    localStorage.setItem('vana_theme', next);
    document.cookie = `vana_theme=${next};path=/;max-age=31536000`;
    _applyThemeIcon(next);
});

/* ── Password toggle ── */
document.getElementById('togglePass')?.addEventListener('click', function () {
    const inp  = document.getElementById('pass');
    const icon = this.querySelector('i');
    inp.type   = inp.type === 'password' ? 'text' : 'password';
    icon.className = inp.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
});

/* ── Alert ── */
function showAlert(msg, type) {
    const el    = document.getElementById('auth-alert');
    const icons = { success:'fa-check-circle', danger:'fa-exclamation-circle', warning:'fa-exclamation-triangle' };
    el.className = `auth-alert auth-alert-${type}`;
    el.innerHTML = `<i class="fas ${icons[type] || 'fa-info-circle'}"></i><span>${msg}</span>`;
}

/* ── Login form ── */
document.getElementById('login-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const btn = document.getElementById('submit-btn');
    btn.classList.add('btn-loading');
    btn.disabled = true;

    const data = new FormData();
    data.append('email_mob', this.elements['email_mob'].value.trim());
    data.append('pass',      this.elements['pass'].value);
    data.append('login',     '');

    fetch(APP.siteUrl + 'api/auth/login', { method: 'POST', body: data })
        .then(r => r.text())
        .then(r => {
            btn.classList.remove('btn-loading');
            btn.disabled = false;
            const msgs = {
                inv_email_mob: '<?php echo addslashes(lang('err_inv_email_mob')); ?>',
                inactive:      '<?php echo addslashes(lang('err_inactive')); ?>',
                invalid_pass:  '<?php echo addslashes(lang('err_invalid_pass')); ?>',
                rate_limit:    '<?php echo addslashes(lang('err_rate_limit')); ?>'
            };
            if (msgs[r]) {
                showAlert(msgs[r], 'danger');
            } else {
                showAlert('<?php echo addslashes(lang('login_redirecting')); ?>', 'success');
                setTimeout(() => window.location.href = APP.siteUrl, 800);
            }
        })
        .catch(() => {
            btn.classList.remove('btn-loading');
            btn.disabled = false;
            showAlert('<?php echo addslashes(lang('connection_error')); ?>', 'danger');
        });
});
</script>
</body>
</html>
