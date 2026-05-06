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
                <a href="<?php echo SITE_URL; ?>login"
                   class="btn btn-sm btn-outline-secondary shadow-none">
                    <i class="fas fa-sign-in-alt"></i><?php echo lang('login'); ?>
                </a>
                <a href="<?php echo SITE_URL; ?>register"
                   class="btn btn-sm custom-bg shadow-none">
                    <i class="fas fa-user-plus"></i><?php echo lang('register'); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
