<?php
// header.php — settings & contact injected by BaseController::view()
if (!isset($settings)) {
    $settings = Cache::remember('settings_1', 300, fn() => Setting::get());
}
if (!isset($contact)) {
    $contact = Cache::remember('contact_1', 300, fn() => Setting::getContact());
}
$lang  = Session::getLang();
$isRTL = $lang === 'ar';
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo $isRTL ? 'rtl' : 'ltr'; ?>">
<head>
    <?php require BASE_PATH . '/views/layouts/head.php'; ?>
    <title><?php echo $pageTitle ?? APP_NAME; ?></title>
</head>
<body style="background-color:var(--bg-body);">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top" id="nav-bar">
    <div class="container-fluid px-lg-4">
        <a class="navbar-brand" href="<?php echo SITE_URL; ?>">
            <i class="fas fa-hotel"></i><?php echo APP_NAME; ?>
        </a>

        <button class="navbar-toggler shadow-none border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo SITE_URL; ?>">
                        <i class="fas fa-home"></i><?php echo lang('home'); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo SITE_URL; ?>rooms">
                        <i class="fas fa-bed"></i><?php echo lang('rooms'); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo SITE_URL; ?>facilities">
                        <i class="fas fa-concierge-bell"></i><?php echo lang('facilities'); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo SITE_URL; ?>contact">
                        <i class="fas fa-envelope"></i><?php echo lang('contact'); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo SITE_URL; ?>about">
                        <i class="fas fa-info-circle"></i><?php echo lang('about'); ?>
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-2">
                <button class="dark-toggle" id="darkToggle" aria-label="Toggle dark mode">
                    <i class="fas fa-moon"></i>
                </button>

                <div class="dropdown lang-switcher">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle shadow-none"
                            type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-language"></i>
                        <?php echo ['ar'=>'العربية','en'=>'English','ku'=>'کوردی'][$lang]; ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <?php foreach(['ar'=>'العربية 🇮🇶','en'=>'English 🇬🇧','ku'=>'کوردی 🏳'] as $code=>$label): ?>
                        <?php if($code !== $lang): ?>
                        <li>
                            <a class="dropdown-item" href="<?php echo SITE_URL; ?>set-lang?set_lang=<?php echo $code; ?>">
                                <?php echo $label; ?>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <?php if(Auth::isUserLoggedIn()): ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle shadow-none"
                            data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i><?php echo htmlspecialchars(Auth::userName()); ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-lg-end">
                        <li>
                            <a class="dropdown-item" href="<?php echo SITE_URL; ?>profile">
                                <i class="fas fa-user text-primary-custom"></i><?php echo lang('profile'); ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo SITE_URL; ?>bookings">
                                <i class="fas fa-calendar-check text-primary-custom"></i><?php echo lang('bookings'); ?>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="<?php echo SITE_URL; ?>logout">
                                <i class="fas fa-sign-out-alt"></i><?php echo lang('logout'); ?>
                            </a>
                        </li>
                    </ul>
                </div>
                <?php else: ?>
                <button type="button" class="btn btn-sm btn-outline-secondary shadow-none"
                        data-bs-toggle="modal" data-bs-target="#LoginModal">
                    <i class="fas fa-sign-in-alt"></i><?php echo lang('login'); ?>
                </button>
                <button type="button" class="btn btn-sm custom-bg shadow-none"
                        data-bs-toggle="modal" data-bs-target="#RegisterModal">
                    <i class="fas fa-user-plus"></i><?php echo lang('register'); ?>
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Login Modal -->
<div class="modal fade" id="LoginModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="login-form">
                <div class="modal-header">
                    <h5 class="modal-title fw-700">
                        <i class="fas fa-sign-in-alt text-primary-custom"></i><?php echo lang('login'); ?>
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-envelope"></i><?php echo lang('email'); ?> / Mobile
                        </label>
                        <input type="text" name="email_mob" required class="form-control">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-lock"></i><?php echo lang('password'); ?>
                        </label>
                        <input type="password" required name="pass" class="form-control">
                    </div>
                    <button type="submit" class="btn custom-bg w-100">
                        <i class="fas fa-sign-in-alt"></i><?php echo lang('login'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="RegisterModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="register-form">
                <div class="modal-header">
                    <h5 class="modal-title fw-700">
                        <i class="fas fa-user-plus text-primary-custom"></i><?php echo lang('register'); ?>
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-user"></i><?php echo lang('name'); ?></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-envelope"></i><?php echo lang('email'); ?></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-phone"></i><?php echo lang('phone'); ?></label>
                            <input type="text" name="phonenum" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-map-marker-alt"></i>Address</label>
                            <input name="address" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-map-pin"></i>Pincode</label>
                            <input name="pincode" type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-calendar"></i>Date of birth</label>
                            <input name="dob" type="date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-lock"></i><?php echo lang('password'); ?></label>
                            <input name="pass" type="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-lock"></i>Confirm Password</label>
                            <input name="cpass" type="password" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn custom-bg w-100">
                                <i class="fas fa-user-plus"></i><?php echo lang('register'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
