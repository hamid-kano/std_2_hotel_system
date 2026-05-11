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

        <?php if (!empty($success)): ?>
        <div class="col-12 px-4 mb-3">
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($success); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
        <div class="col-12 px-4 mb-3">
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        <?php endif; ?>

        <!-- Basic Info -->
        <div class="col-12 mb-4 px-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-700 mb-4 d-flex align-items-center gap-2">
                        <i class="fas fa-id-card text-primary-custom"></i><?php echo lang('basic_info'); ?>
                    </h5>
                    <form method="POST" action="<?php echo SITE_URL; ?>profile">
                        <input type="hidden" name="form_type" value="info">
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
                    <form method="POST" action="<?php echo SITE_URL; ?>profile">
                        <input type="hidden" name="form_type" value="password">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label"><i class="fas fa-lock"></i><?php echo lang('current_password'); ?></label>
                                <input type="password" name="current_pass" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"><i class="fas fa-key"></i><?php echo lang('new_password'); ?></label>
                                <input type="password" name="new_pass" id="new_pass" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"><i class="fas fa-check-circle"></i><?php echo lang('confirm_password'); ?></label>
                                <input type="password" name="confirm_pass" id="confirm_pass" class="form-control" required>
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
document.querySelectorAll('form[action*="profile"]').forEach(form => {
    if (form.querySelector('[name="form_type"][value="password"]')) {
        form.addEventListener('submit', function(e) {
            const np = this.elements['new_pass'].value;
            const cp = this.elements['confirm_pass'].value;
            if (np !== cp) {
                e.preventDefault();
                alert('<?php echo addslashes(lang('err_pass_mismatch')); ?>');
            }
        });
    }
});
</script>
