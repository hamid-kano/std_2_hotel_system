<?php
$settings = Cache::remember('settings_1', 300, fn() => Setting::get());
$pending  = Booking::getPendingCounts();

// Language switcher handler
if (isset($_GET['set_lang'])) {
    Session::setLang($_GET['set_lang']);
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}

$lang       = Session::getLang();
$isRTL      = ($lang === 'ar');
$langLabels = ['ar' => 'العربية 🇮🇶', 'en' => 'English 🇬🇧', 'ku' => 'کوردی 🏳'];

function adminActive(string $path): string {
    return str_contains(Request::uri(), $path) ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo $isRTL ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? lang('admin_panel'); ?> — <?php echo APP_NAME; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/style.css">

    <style>
        body { background: var(--bg-body); }

        :root {
            --admin-sidebar-bg:         #0f172a;
            --admin-sidebar-border:     rgba(255,255,255,.08);
            --admin-sidebar-text:       rgba(255,255,255,.65);
            --admin-sidebar-label:      rgba(255,255,255,.3);
            --admin-sidebar-hover-bg:   rgba(255,255,255,.06);
            --admin-sidebar-hover-text: #ffffff;
        }
        [data-theme="dark"] {
            --admin-sidebar-bg: #060b14;
        }

        .admin-wrapper { display: flex; min-height: 100vh; }

        /* ── Sidebar ── */
        .admin-sidebar {
            width: 240px;
            flex-shrink: 0;
            background: var(--admin-sidebar-bg);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; bottom: 0;
            z-index: var(--z-fixed);
            overflow-y: auto;
            transition: transform var(--t-base);
        }
        /* LTR: left | RTL: right */
        [dir="ltr"] .admin-sidebar { left: 0; }
        [dir="rtl"] .admin-sidebar { right: 0; left: auto; }

        .admin-sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--admin-sidebar-border);
            display: flex;
            align-items: center;
            gap: .6rem;
            color: var(--primary);
            font-family: var(--font-heading);
            font-size: var(--fs-lg);
            font-weight: 800;
            text-decoration: none;
        }
        .admin-sidebar-brand i { width: auto; }

        .admin-nav { padding: 1rem 0; flex: 1; }
        .admin-nav-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--admin-sidebar-label);
            padding: .75rem 1.5rem .25rem;
        }
        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .55rem 1.5rem;
            color: var(--admin-sidebar-text);
            text-decoration: none;
            font-size: var(--fs-sm);
            font-weight: 500;
            transition: all var(--t-fast);
            position: relative;
        }
        .admin-nav-link i { width: 1.1em; text-align: center; flex-shrink: 0; }
        .admin-nav-link:hover { color: var(--admin-sidebar-hover-text); background: var(--admin-sidebar-hover-bg); }
        .admin-nav-link.active { color: var(--primary); background: rgba(46,193,172,.12); }
        .admin-nav-link.active::before {
            content: '';
            position: absolute;
            top: 0; bottom: 0;
            width: 3px;
            background: var(--primary);
        }
        [dir="ltr"] .admin-nav-link.active::before { left: 0; border-radius: 0 3px 3px 0; }
        [dir="rtl"] .admin-nav-link.active::before { right: 0; border-radius: 3px 0 0 3px; }

        .admin-nav-badge {
            margin-inline-start: auto;
            background: #dc3545;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 99px;
            min-width: 18px;
            text-align: center;
        }

        /* ── Main ── */
        .admin-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        [dir="ltr"] .admin-main { margin-left: 240px; }
        [dir="rtl"] .admin-main { margin-right: 240px; }

        /* ── Topbar ── */
        .admin-topbar {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            padding: .75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: var(--z-sticky);
        }
        .admin-topbar-title { font-weight: 700; font-size: var(--fs-lg); color: var(--text-primary); }

        .admin-content { padding: 1.5rem; flex: 1; }

        /* ── Stat cards ── */
        .admin-stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--r-xl);
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
            transition: all var(--t-base);
            box-shadow: var(--shadow-sm);
        }
        .admin-stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }
        .admin-stat-icon {
            width: 52px; height: 52px;
            border-radius: var(--r-lg);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; flex-shrink: 0;
        }
        .admin-stat-icon i { width: auto; }
        .admin-stat-value { font-size: var(--fs-3xl); font-weight: 800; line-height: 1; color: var(--text-primary); }
        .admin-stat-label { font-size: var(--fs-xs); color: var(--text-secondary); margin-top: 2px; }

        /* ── Tables ── */
        .admin-table {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--r-xl);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        .admin-table table { margin: 0; }
        .admin-table thead th {
            background: var(--bg-hover);
            color: var(--text-secondary);
            font-size: var(--fs-xs);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            border: none;
            padding: .875rem 1rem;
        }
        .admin-table tbody td {
            padding: .875rem 1rem;
            border-color: var(--border-light);
            vertical-align: middle;
            font-size: var(--fs-sm);
            color: var(--text-primary);
            background: var(--bg-card);
        }
        .admin-table tbody tr:hover td { background: var(--bg-hover); }

        .admin-search { max-width: 280px; }

        /* ── Mobile ── */
        @media (max-width: 991px) {
            [dir="ltr"] .admin-sidebar { transform: translateX(-100%); }
            [dir="rtl"] .admin-sidebar { transform: translateX(100%); }
            .admin-sidebar.open { transform: translateX(0) !important; }
            [dir="ltr"] .admin-main { margin-left: 0; }
            [dir="rtl"] .admin-main { margin-right: 0; }
        }

        /* ── Dark mode overrides ── */
        [data-theme="dark"] .admin-table tbody td { background: var(--bg-card); }
        [data-theme="dark"] .admin-table tbody tr:hover td { background: var(--bg-hover); }
        [data-theme="dark"] .admin-table thead th { background: var(--bg-hover); }
        [data-theme="dark"] .admin-topbar { background: var(--bg-card); border-bottom-color: var(--border-color); }
        [data-theme="dark"] .admin-content .card { background: var(--bg-card); border-color: var(--border-color); }
        [data-theme="dark"] .admin-content .form-control,
        [data-theme="dark"] .admin-content .form-select { background: var(--bg-input); color: var(--text-primary); border-color: var(--border-color); }
        [data-theme="dark"] .admin-content .modal-content { background: var(--bg-card); border-color: var(--border-color); }
        [data-theme="dark"] .admin-content .modal-header,
        [data-theme="dark"] .admin-content .modal-footer { border-color: var(--border-color); }
        [data-theme="dark"] .admin-content .table { color: var(--text-primary); }
        [data-theme="dark"] .admin-content .table td,
        [data-theme="dark"] .admin-content .table th { border-color: var(--border-color); }
        [data-theme="dark"] .admin-content .btn-outline-secondary { color: var(--text-primary); border-color: var(--border-color); }
        [data-theme="dark"] .admin-content .btn-outline-secondary:hover { background: var(--bg-hover); color: var(--primary); border-color: var(--primary); }
        [data-theme="dark"] .admin-content input[type="file"] { background: var(--bg-input); color: var(--text-primary); border-color: var(--border-color); }
    </style>
</head>
<body>
<div class="admin-wrapper">

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <a href="<?php echo SITE_URL; ?>admin/dashboard" class="admin-sidebar-brand">
            <i class="fas fa-hotel"></i><?php echo APP_NAME; ?>
        </a>

        <nav class="admin-nav">
            <div class="admin-nav-label"><?php echo lang('admin_overview'); ?></div>
            <a href="<?php echo SITE_URL; ?>admin/dashboard" class="admin-nav-link <?php echo adminActive('dashboard'); ?>">
                <i class="fas fa-tachometer-alt"></i><?php echo lang('admin_dashboard'); ?>
            </a>

            <div class="admin-nav-label"><?php echo lang('admin_bookings'); ?></div>
            <a href="<?php echo SITE_URL; ?>admin/bookings/new" class="admin-nav-link <?php echo adminActive('bookings/new'); ?>">
                <i class="fas fa-calendar-plus"></i><?php echo lang('admin_new_bookings'); ?>
                <?php if(($pending['new_bookings'] ?? 0) > 0): ?>
                <span class="admin-nav-badge"><?php echo $pending['new_bookings']; ?></span>
                <?php endif; ?>
            </a>
            <a href="<?php echo SITE_URL; ?>admin/bookings/refunds" class="admin-nav-link <?php echo adminActive('refunds'); ?>">
                <i class="fas fa-undo"></i><?php echo lang('admin_refunds'); ?>
                <?php if(($pending['refund_bookings'] ?? 0) > 0): ?>
                <span class="admin-nav-badge"><?php echo $pending['refund_bookings']; ?></span>
                <?php endif; ?>
            </a>
            <a href="<?php echo SITE_URL; ?>admin/bookings/records" class="admin-nav-link <?php echo adminActive('records'); ?>">
                <i class="fas fa-list-alt"></i><?php echo lang('admin_records'); ?>
            </a>

            <div class="admin-nav-label"><?php echo lang('admin_content'); ?></div>
            <a href="<?php echo SITE_URL; ?>admin/rooms" class="admin-nav-link <?php echo adminActive('admin/rooms'); ?>">
                <i class="fas fa-bed"></i><?php echo lang('rooms'); ?>
            </a>
            <a href="<?php echo SITE_URL; ?>admin/facilities" class="admin-nav-link <?php echo adminActive('facilities'); ?>">
                <i class="fas fa-concierge-bell"></i><?php echo lang('admin_features_fac'); ?>
            </a>
            <a href="<?php echo SITE_URL; ?>admin/carousel" class="admin-nav-link <?php echo adminActive('carousel'); ?>">
                <i class="fas fa-images"></i><?php echo lang('admin_carousel'); ?>
            </a>

            <div class="admin-nav-label"><?php echo lang('admin_users_section'); ?></div>
            <a href="<?php echo SITE_URL; ?>admin/users" class="admin-nav-link <?php echo adminActive('admin/users'); ?>">
                <i class="fas fa-users"></i><?php echo lang('admin_users'); ?>
            </a>
            <a href="<?php echo SITE_URL; ?>admin/queries" class="admin-nav-link <?php echo adminActive('queries'); ?>">
                <i class="fas fa-comments"></i><?php echo lang('admin_queries'); ?>
            </a>
            <a href="<?php echo SITE_URL; ?>admin/reviews" class="admin-nav-link <?php echo adminActive('reviews'); ?>">
                <i class="fas fa-star"></i><?php echo lang('admin_reviews'); ?>
            </a>

            <div class="admin-nav-label"><?php echo lang('admin_system'); ?></div>
            <a href="<?php echo SITE_URL; ?>admin/settings" class="admin-nav-link <?php echo adminActive('settings'); ?>">
                <i class="fas fa-cog"></i><?php echo lang('admin_settings'); ?>
            </a>
            <a href="<?php echo SITE_URL; ?>" class="admin-nav-link" target="_blank">
                <i class="fas fa-external-link-alt"></i><?php echo lang('admin_view_site'); ?>
            </a>
            <a href="<?php echo SITE_URL; ?>admin/logout" class="admin-nav-link" style="color:#f87171;">
                <i class="fas fa-sign-out-alt"></i><?php echo lang('admin_logout'); ?>
            </a>
        </nav>
    </aside>

    <!-- Main -->
    <div class="admin-main">

        <!-- Topbar -->
        <div class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-outline-secondary d-lg-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="admin-topbar-title"><?php echo $pageTitle ?? lang('admin_dashboard'); ?></span>
            </div>
            <div class="d-flex align-items-center gap-2">

                <!-- Language Switcher -->
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle shadow-none"
                            type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-language"></i>
                        <?php echo $langLabels[$lang]; ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <?php foreach($langLabels as $code => $label): ?>
                        <?php if($code !== $lang): ?>
                        <li>
                            <a class="dropdown-item" href="?set_lang=<?php echo $code; ?>">
                                <?php echo $label; ?>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Dark Mode -->
                <button class="dark-toggle" id="darkToggle" aria-label="<?php echo lang('toggle_dark'); ?>">
                    <i class="fas fa-moon"></i>
                </button>

                <span class="text-secondary d-none d-md-inline" style="font-size:var(--fs-sm);">
                    <i class="fas fa-user-shield text-primary-custom"></i>
                    <?php echo lang('admin_panel'); ?>
                </span>
            </div>
        </div>

        <!-- Content -->
        <div class="admin-content">
            <?php echo $content ?? ''; ?>
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

/* Sidebar toggle (mobile) */
document.getElementById('sidebarToggle')?.addEventListener('click', () => {
    document.getElementById('adminSidebar').classList.toggle('open');
});

/* Alert helper */
function alert(type, msg){
    const cls  = type === 'success' ? 'alert-success' : 'alert-danger';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    const el   = document.createElement('div');
    el.innerHTML = `<div class="alert ${cls} alert-dismissible fade show custom-alert" role="alert">
        <i class="fas ${icon}"></i><strong>${msg}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>`;
    document.body.append(el);
    setTimeout(() => el.querySelector('.alert')?.remove(), 4000);
}
</script>
<?php if(isset($scripts)) echo $scripts; ?>
</body>
</html>
