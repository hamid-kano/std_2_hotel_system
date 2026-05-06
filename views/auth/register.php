<?php
$lang  = Session::getLang();
$isRTL = $lang === 'ar';
$pageTitle = APP_NAME . ' — ' . lang('register');
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo $isRTL ? 'rtl' : 'ltr'; ?>">
<head>
    <?php require BASE_PATH . '/views/layouts/head.php'; ?>
    <title><?php echo $pageTitle; ?></title>
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
                <h2><?php echo lang('register_welcome'); ?></h2>
                <p><?php echo lang('register_welcome_sub'); ?></p>
            </div>
            <div class="auth-panel-features">
                <div class="auth-feature">
                    <i class="fas fa-bed"></i>
                    <span><?php echo lang('feat_browse_rooms'); ?></span>
                </div>
                <div class="auth-feature">
                    <i class="fas fa-shield-alt"></i>
                    <span><?php echo lang('feat_secure'); ?></span>
                </div>
                <div class="auth-feature">
                    <i class="fas fa-history"></i>
                    <span><?php echo lang('feat_history'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right panel -->
    <div class="auth-panel-right">

        <div class="auth-topbar">
            <a href="<?php echo SITE_URL; ?>" class="auth-back">
                <i class="fas fa-arrow-left"></i>
                <span><?php echo lang('back_to_site'); ?></span>
            </a>
            <button class="dark-toggle" id="darkToggle" aria-label="Toggle dark mode">
                <i class="fas fa-moon"></i>
            </button>
        </div>

        <div class="auth-form-wrap auth-form-wrap--wide">

            <div class="auth-form-header">
                <div class="auth-icon-badge">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h1 class="auth-title"><?php echo lang('register'); ?></h1>
                <p class="auth-subtitle"><?php echo lang('register_subtitle'); ?></p>
            </div>

            <div id="auth-alert" class="auth-alert d-none"></div>

            <form id="register-form" novalidate>
                <div class="row g-3">

                    <div class="col-md-6 auth-field">
                        <label class="form-label">
                            <i class="fas fa-user"></i><?php echo lang('name'); ?>
                        </label>
                        <input type="text" name="name" class="form-control"
                               placeholder="Full name" autocomplete="name" required>
                    </div>

                    <div class="col-md-6 auth-field">
                        <label class="form-label">
                            <i class="fas fa-envelope"></i><?php echo lang('email'); ?>
                        </label>
                        <input type="email" name="email" class="form-control"
                               placeholder="email@example.com" autocomplete="email" required>
                    </div>

                    <div class="col-md-6 auth-field">
                        <label class="form-label">
                            <i class="fas fa-phone"></i><?php echo lang('phone'); ?>
                        </label>
                        <input type="text" name="phonenum" class="form-control"
                               placeholder="07xxxxxxxx" autocomplete="tel" required>
                    </div>

                    <div class="col-md-6 auth-field">
                        <label class="form-label">
                            <i class="fas fa-calendar"></i><?php echo lang('date_of_birth'); ?>
                        </label>
                        <input type="date" name="dob" class="form-control" required>
                    </div>

                    <div class="col-12 auth-field">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt"></i><?php echo lang('address'); ?>
                        </label>
                        <input type="text" name="address" class="form-control"
                               placeholder="<?php echo lang('address_hint'); ?>" autocomplete="street-address" required>
                    </div>

                    <div class="col-md-6 auth-field">
                        <label class="form-label">
                            <i class="fas fa-map-pin"></i><?php echo lang('pincode'); ?>
                        </label>
                        <input type="text" name="pincode" class="form-control"
                               placeholder="<?php echo lang('pincode_hint'); ?>" required>
                    </div>

                    <div class="col-md-6"></div><!-- spacer -->

                    <div class="col-md-6 auth-field">
                        <label class="form-label">
                            <i class="fas fa-lock"></i><?php echo lang('password'); ?>
                        </label>
                        <div class="auth-password-wrap">
                            <input type="password" name="pass" id="pass"
                                   class="form-control"
                                   placeholder="Min. 8 characters"
                                   autocomplete="new-password" required>
                            <button type="button" class="auth-eye" id="togglePass" aria-label="Show password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-6 auth-field">
                        <label class="form-label">
                            <i class="fas fa-lock"></i><?php echo lang('confirm_password'); ?>
                        </label>
                        <div class="auth-password-wrap">
                            <input type="password" name="cpass" id="cpass"
                                   class="form-control"
                                   placeholder="<?php echo lang('pass_repeat'); ?>"
                                   autocomplete="new-password" required>
                            <button type="button" class="auth-eye" id="toggleCpass" aria-label="Show password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Password strength -->
                    <div class="col-12">
                        <div class="auth-strength">
                            <div class="auth-strength-bar" id="strengthBar"></div>
                        </div>
                        <p class="auth-strength-label" id="strengthLabel"></p>
                    </div>

                    <div class="col-12 mt-1">
                        <button type="submit" class="btn custom-bg w-100 btn-lg" id="submit-btn">
                            <i class="fas fa-user-plus"></i><?php echo lang('register'); ?>
                        </button>
                    </div>

                </div>
            </form>

            <p class="auth-switch">
                <?php echo lang('have_account'); ?>
                <a href="<?php echo SITE_URL; ?>login">
                    <i class="fas fa-sign-in-alt"></i><?php echo lang('login'); ?>
                </a>
            </p>

        </div>
    </div>

</div>

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

/* Password toggles */
function makeToggle(btnId, inputId){
    document.getElementById(btnId)?.addEventListener('click', function(){
        const inp = document.getElementById(inputId);
        const icon = this.querySelector('i');
        inp.type = inp.type === 'password' ? 'text' : 'password';
        icon.className = inp.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
    });
}
makeToggle('togglePass', 'pass');
makeToggle('toggleCpass', 'cpass');

/* Password strength */
document.getElementById('pass')?.addEventListener('input', function(){
    const v = this.value;
    const bar = document.getElementById('strengthBar');
    const lbl = document.getElementById('strengthLabel');
    let score = 0;
    if(v.length >= 8) score++;
    if(/[A-Z]/.test(v)) score++;
    if(/[0-9]/.test(v)) score++;
    if(/[^A-Za-z0-9]/.test(v)) score++;
    const levels = [
        { w:'0%',   color:'transparent', text:'' },
        { w:'25%',  color:'#dc3545',     text:'<?php echo lang('pass_strength_weak'); ?>' },
        { w:'50%',  color:'#ffc107',     text:'<?php echo lang('pass_strength_fair'); ?>' },
        { w:'75%',  color:'#17a2b8',     text:'<?php echo lang('pass_strength_good'); ?>' },
        { w:'100%', color:'#28a745',     text:'<?php echo lang('pass_strength_strong'); ?>' },
    ];
    bar.style.width  = levels[score].w;
    bar.style.background = levels[score].color;
    lbl.textContent  = levels[score].text;
    lbl.style.color  = levels[score].color;
});

/* Alert helper */
function showAlert(msg, type){
    const el = document.getElementById('auth-alert');
    const icons = { success:'fa-check-circle', danger:'fa-exclamation-circle', warning:'fa-exclamation-triangle' };
    el.className = `auth-alert auth-alert-${type}`;
    el.innerHTML = `<i class="fas ${icons[type]||'fa-info-circle'}"></i><span>${msg}</span>`;
}

/* Register form */
document.getElementById('register-form').addEventListener('submit', function(e){
    e.preventDefault();
    const pass  = this.elements['pass'].value;
    const cpass = this.elements['cpass'].value;
    if(pass !== cpass){ showAlert('<?php echo lang('err_pass_mismatch'); ?>', 'warning'); return; }
    if(pass.length < 8){ showAlert('<?php echo lang('err_pass_min'); ?>', 'warning'); return; }

    const btn = document.getElementById('submit-btn');
    btn.classList.add('btn-loading');
    btn.disabled = true;

    const data = new FormData();
    ['name','email','phonenum','address','pincode','dob','pass','cpass'].forEach(k => {
        data.append(k, this.elements[k].value);
    });
    data.append('register', '');

    fetch(APP.siteUrl + 'api/auth/register', { method:'POST', body:data })
        .then(r => r.text())
        .then(r => {
            btn.classList.remove('btn-loading');
            btn.disabled = false;
            const msgs = {
                pass_mismatch: '<?php echo lang('err_pass_mismatch'); ?>',
                email_already: '<?php echo lang('err_email_exists'); ?>',
                phone_already: '<?php echo lang('err_phone_exists'); ?>',
                ins_failed:    '<?php echo lang('err_reg_failed'); ?>'
            };
            if(msgs[r]){
                showAlert(msgs[r], 'danger');
            } else {
                showAlert('<?php echo lang('register_created'); ?>', 'success');
                setTimeout(() => window.location.href = APP.siteUrl + 'login', 1200);
            }
        })
        .catch(() => {
            btn.classList.remove('btn-loading');
            btn.disabled = false;
            showAlert('Connection error. Please try again.', 'danger');
        });
});
</script>
</body>
</html>
