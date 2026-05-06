<?php $pageTitle = APP_NAME . ' — ' . lang('profile'); ?>
<?php require BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-12 my-5 px-4">
            <h2 class="fw-700 d-flex align-items-center gap-2">
                <i class="fas fa-user-circle text-primary-custom"></i><?php echo lang('profile'); ?>
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>"><i class="fas fa-home"></i><?php echo lang('home'); ?></a></li>
                    <li class="breadcrumb-item active"><?php echo lang('profile'); ?></li>
                </ol>
            </nav>
            <hr>
        </div>

        <!-- Basic Info -->
        <div class="col-12 mb-4 px-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-700 mb-4 d-flex align-items-center gap-2">
                        <i class="fas fa-id-card text-primary-custom"></i><?php echo lang('basic_info'); ?>
                    </h5>
                    <form id="info-form">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label"><i class="fas fa-user"></i><?php echo lang('name'); ?></label>
                                <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"><i class="fas fa-envelope"></i><?php echo lang('email'); ?></label>
                                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"><i class="fas fa-phone"></i><?php echo lang('phone'); ?></label>
                                <input type="text" name="phonenum" value="<?php echo htmlspecialchars($user['phonenum']); ?>" class="form-control" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label"><i class="fas fa-map-marker-alt"></i><?php echo lang('address'); ?></label>
                                <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" class="form-control" required>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn custom-bg">
                                <i class="fas fa-save"></i><?php echo lang('save_changes'); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-12 mb-4 px-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-700 mb-4 d-flex align-items-center gap-2">
                        <i class="fas fa-lock text-primary-custom"></i><?php echo lang('change_password'); ?>
                    </h5>
                    <form id="pass-form">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label"><i class="fas fa-lock"></i><?php echo lang('current_password'); ?></label>
                                <input type="password" name="current_pass" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"><i class="fas fa-key"></i><?php echo lang('new_password'); ?></label>
                                <input type="password" name="new_pass" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"><i class="fas fa-check-circle"></i><?php echo lang('confirm_password'); ?></label>
                                <input type="password" name="confirm_pass" class="form-control" required>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn custom-bg">
                                <i class="fas fa-save"></i><?php echo lang('update_password'); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require BASE_PATH . '/views/layouts/footer.php'; ?>

<script>
const LANG = {
    pass_mismatch:   '<?php echo lang('err_pass_mismatch'); ?>',
    phone_taken:     '<?php echo lang('err_phone_taken'); ?>',
    no_changes:      '<?php echo lang('err_no_changes'); ?>',
    update_failed:   '<?php echo lang('err_update_failed'); ?>',
    curr_pass_wrong: '<?php echo lang('err_curr_pass'); ?>',
    changes_saved:   '<?php echo lang('changes_saved'); ?>',
    pass_updated:    '<?php echo lang('pass_updated'); ?>',
};

document.getElementById('info-form').addEventListener('submit', function(e){
    e.preventDefault();
    const btn = this.querySelector('[type=submit]');
    btn.classList.add('btn-loading');
    const data = new FormData(this);
    data.append('info_form','');
    fetch(APP.siteUrl + 'api/user/update-profile', {method:'POST', body:data})
        .then(r=>r.text())
        .then(r=>{
            btn.classList.remove('btn-loading');
            if(r==='phone_already') alert('error', LANG.phone_taken);
            else if(r==='1') alert('success', LANG.changes_saved);
            else alert('error', LANG.no_changes);
        });
});

document.getElementById('pass-form').addEventListener('submit', function(e){
    e.preventDefault();
    const np = this.elements['new_pass'].value;
    const cp = this.elements['confirm_pass'].value;
    if(np !== cp){ alert('error', LANG.pass_mismatch); return; }
    const btn = this.querySelector('[type=submit]');
    btn.classList.add('btn-loading');
    const data = new FormData(this);
    fetch(APP.siteUrl + 'api/user/update-password', {method:'POST', body:data})
        .then(r=>r.text())
        .then(r=>{
            btn.classList.remove('btn-loading');
            if(r==='pass_mismatch') alert('error', LANG.pass_mismatch);
            else if(r==='invalid_current_pass') alert('error', LANG.curr_pass_wrong);
            else if(r==='1'){ alert('success', LANG.pass_updated); this.reset(); }
            else alert('error', LANG.update_failed);
        }.bind(this));
});
</script>
