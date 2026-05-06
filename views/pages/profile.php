<?php $pageTitle = APP_NAME . ' — ' . lang('profile'); ?>
<?php require BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-12 my-5 px-4">
            <h2 class="fw-bold">
                <i class="fas fa-user-circle" class="text-primary-custom"></i><?php echo lang('profile'); ?>
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>" class="text-decoration-none"><i class="fas fa-home"></i>Home</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </nav>
            <hr>
        </div>

        <!-- Basic Info -->
        <div class="col-12 mb-4 px-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="fas fa-id-card" class="text-primary-custom"></i>Basic Information
                    </h5>
                    <form id="info-form">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-user"></i>Name
                                </label>
                                <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-envelope"></i>Email
                                </label>
                                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-phone"></i>Phone Number
                                </label>
                                <input type="text" name="phonenum" value="<?php echo htmlspecialchars($user['phonenum']); ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-8 mb-4">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt"></i>Address
                                </label>
                                <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" class="form-control shadow-none" required>
                            </div>
                        </div>
                        <button type="submit" class="btn text-white custom-bg shadow-none">
                            <i class="fas fa-save"></i>Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-12 mb-4 px-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="fas fa-lock" class="text-primary-custom"></i>Change Password
                    </h5>
                    <form id="pass-form">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-lock"></i>Current Password
                                </label>
                                <input type="password" name="current_pass" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-key"></i>New Password
                                </label>
                                <input type="password" name="new_pass" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label">
                                    <i class="fas fa-check-circle"></i>Confirm Password
                                </label>
                                <input type="password" name="confirm_pass" class="form-control shadow-none" required>
                            </div>
                        </div>
                        <button type="submit" class="btn text-white custom-bg shadow-none">
                            <i class="fas fa-save"></i>Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require BASE_PATH . '/views/layouts/footer.php'; ?>

<script>
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
            if(r==='phone_already') alert('error','Phone already registered!');
            else if(r==='1') alert('success','Changes saved!');
            else alert('error','No changes made.');
        });
});

document.getElementById('pass-form').addEventListener('submit', function(e){
    e.preventDefault();
    const np = this.elements['new_pass'].value;
    const cp = this.elements['confirm_pass'].value;
    if(np !== cp){ alert('error','Passwords do not match!'); return; }
    const btn = this.querySelector('[type=submit]');
    btn.classList.add('btn-loading');
    const data = new FormData(this);
    fetch(APP.siteUrl + 'api/user/update-password', {method:'POST', body:data})
        .then(r=>r.text())
        .then(r=>{
            btn.classList.remove('btn-loading');
            if(r==='pass_mismatch') alert('error','Passwords do not match!');
            else if(r==='invalid_current_pass') alert('error','Current password is incorrect!');
            else if(r==='1'){ alert('success','Password updated!'); this.reset(); }
            else alert('error','Update failed!');
        }.bind(this));
});
</script>
