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

// Read theme from cookie to avoid flash
$savedTheme = $_COOKIE['vana_theme'] ?? 'light';

function adminActive(string $path): string {
    return str_contains(Request::uri(), $path) ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>"
      dir="<?php echo $isRTL ? 'rtl' : 'ltr'; ?>"
      data-theme="<?php echo htmlspecialchars($savedTheme); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? lang('admin_panel'); ?> — <?php echo APP_NAME; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Inter (EN) + Tajawal (AR) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/style.css">

    <style>
        body { background: var(--bg-body); }

        /* ── Fonts — inherit from design system ── */
        /* Inter for LTR, Tajawal for RTL (set on <html dir>) */
        [dir="rtl"] body,
        [dir="rtl"] .admin-nav-link,
        [dir="rtl"] .admin-nav-label,
        [dir="rtl"] .admin-topbar-title,
        [dir="rtl"] .admin-content {
            font-family: 'Tajawal', 'Segoe UI', Tahoma, sans-serif;
            font-size: 1.02rem;
            line-height: 1.75;
        }
        [dir="rtl"] h1,[dir="rtl"] h2,[dir="rtl"] h3,
        [dir="rtl"] h4,[dir="rtl"] h5,[dir="rtl"] h6 {
            font-family: 'Tajawal', 'Segoe UI', Tahoma, sans-serif;
        }

        /* ── Sidebar tokens ── */
        :root {
            --sb-bg:          #0f172a;
            --sb-border:      rgba(255,255,255,.07);
            --sb-text:        rgba(255,255,255,.6);
            --sb-label:       rgba(255,255,255,.25);
            --sb-hover-bg:    rgba(255,255,255,.05);
            --sb-hover-text:  #ffffff;
            --sb-active-bg:   rgba(46,193,172,.14);
            --sb-active-text: #2ec1ac;
            --sb-width:       256px;
            --sb-collapsed:   68px;
            --topbar-h:       56px;
        }
        [data-theme="dark"] {
            --sb-bg:    #060b14;
            --sb-border: rgba(255,255,255,.05);
        }

        /* ── Layout ── */
        .admin-wrapper { display: flex; min-height: 100vh; }

        /* ── Sidebar ── */
        .admin-sidebar {
            width: var(--sb-width);
            flex-shrink: 0;
            background: var(--sb-bg);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; bottom: 0;
            z-index: var(--z-fixed);
            overflow: hidden;
            transition: width .25s cubic-bezier(.4,0,.2,1),
                        transform .25s cubic-bezier(.4,0,.2,1);
            /* Scrollable nav without visible scrollbar */
            overflow-y: auto;
            scrollbar-width: none;
        }
        .admin-sidebar::-webkit-scrollbar { display: none; }

        [dir="ltr"] .admin-sidebar { left: 0; }
        [dir="rtl"] .admin-sidebar { right: 0; left: auto; }

        /* Collapsed state (desktop) */
        .admin-sidebar.collapsed { width: var(--sb-collapsed); }
        .admin-sidebar.collapsed .admin-nav-label,
        .admin-sidebar.collapsed .admin-nav-text,
        .admin-sidebar.collapsed .admin-nav-badge,
        .admin-sidebar.collapsed .admin-sidebar-brand span { opacity: 0; width: 0; overflow: hidden; white-space: nowrap; }
        .admin-sidebar.collapsed .admin-sidebar-brand { justify-content: center; padding: 1.25rem .75rem; }
        .admin-sidebar.collapsed .admin-nav-link { justify-content: center; padding: .65rem; }
        .admin-sidebar.collapsed .admin-nav-link i { margin: 0; }

        /* ── Brand ── */
        .admin-sidebar-brand {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--sb-border);
            display: flex;
            align-items: center;
            gap: .6rem;
            color: var(--primary);
            font-family: var(--font-heading);
            font-size: var(--fs-lg);
            font-weight: 800;
            text-decoration: none;
            flex-shrink: 0;
            transition: padding .25s, justify-content .25s;
            white-space: nowrap;
        }
        .admin-sidebar-brand i { width: auto; flex-shrink: 0; font-size: 1.2rem; }
        .admin-sidebar-brand span { transition: opacity .2s, width .25s; }

        /* ── Nav ── */
        .admin-nav { padding: .75rem 0 1rem; flex: 1; }

        .admin-nav-section { margin-bottom: .25rem; }

        .admin-nav-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--sb-label);
            padding: .875rem 1.25rem .3rem;
            white-space: nowrap;
            transition: opacity .2s;
        }

        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .5rem 1.25rem;
            color: var(--sb-text);
            text-decoration: none;
            font-size: var(--fs-sm);
            font-weight: 500;
            transition: background var(--t-fast), color var(--t-fast), padding .25s;
            position: relative;
            border-radius: 0;
            white-space: nowrap;
            outline: none;
        }
        .admin-nav-link i {
            width: 1.15em;
            text-align: center;
            flex-shrink: 0;
            font-size: .95rem;
            transition: transform .2s;
        }
        .admin-nav-text { transition: opacity .2s, width .25s; }

        /* Hover */
        .admin-nav-link:hover,
        .admin-nav-link:focus-visible {
            color: var(--sb-hover-text);
            background: var(--sb-hover-bg);
        }
        .admin-nav-link:hover i { transform: translateX(2px); }
        [dir="rtl"] .admin-nav-link:hover i { transform: translateX(-2px); }

        /* Active */
        .admin-nav-link.active {
            color: var(--sb-active-text);
            background: var(--sb-active-bg);
            font-weight: 600;
        }
        .admin-nav-link.active::before {
            content: '';
            position: absolute;
            top: 0; bottom: 0;
            width: 3px;
            background: var(--primary);
            border-radius: 0 3px 3px 0;
        }
        [dir="ltr"] .admin-nav-link.active::before { left: 0; }
        [dir="rtl"] .admin-nav-link.active::before { right: 0; left: auto; border-radius: 3px 0 0 3px; }

        /* Badge */
        .admin-nav-badge {
            margin-inline-start: auto;
            background: #ef4444;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 99px;
            min-width: 18px;
            text-align: center;
            flex-shrink: 0;
            transition: opacity .2s;
        }

        /* Tooltip when collapsed */
        .admin-sidebar.collapsed .admin-nav-link {
            position: relative;
        }
        .admin-sidebar.collapsed .admin-nav-link::after {
            content: attr(data-tooltip);
            position: absolute;
            left: calc(var(--sb-collapsed) + 8px);
            top: 50%;
            transform: translateY(-50%);
            background: #1e293b;
            color: #fff;
            font-size: var(--fs-xs);
            font-weight: 500;
            padding: .3rem .65rem;
            border-radius: var(--r-md);
            white-space: nowrap;
            pointer-events: none;
            opacity: 0;
            transition: opacity .15s;
            z-index: 9999;
            box-shadow: var(--shadow-md);
        }
        [dir="rtl"] .admin-sidebar.collapsed .admin-nav-link::after {
            left: auto;
            right: calc(var(--sb-collapsed) + 8px);
        }
        .admin-sidebar.collapsed .admin-nav-link:hover::after { opacity: 1; }

        /* Divider before logout */
        .admin-nav-divider {
            height: 1px;
            background: var(--sb-border);
            margin: .5rem 1.25rem;
        }

        /* ── Collapse toggle button ── */
        .sidebar-collapse-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px; height: 28px;
            border-radius: var(--r-full);
            background: var(--sb-hover-bg);
            border: 1px solid var(--sb-border);
            color: var(--sb-text);
            cursor: pointer;
            transition: all var(--t-fast);
            flex-shrink: 0;
        }
        .sidebar-collapse-btn:hover { background: rgba(46,193,172,.2); color: var(--primary); border-color: var(--primary); }
        .sidebar-collapse-btn i { width: auto; font-size: .75rem; transition: transform .25s; }
        .admin-sidebar.collapsed .sidebar-collapse-btn i { transform: rotate(180deg); }
        [dir="rtl"] .admin-sidebar.collapsed .sidebar-collapse-btn i { transform: rotate(-180deg); }

        /* ── Main ── */
        .admin-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin .25s cubic-bezier(.4,0,.2,1);
        }
        [dir="ltr"] .admin-main { margin-left: var(--sb-width); }
        [dir="rtl"] .admin-main { margin-right: var(--sb-width); }
        [dir="ltr"] .admin-sidebar.collapsed ~ .admin-main { margin-left: var(--sb-collapsed); }
        [dir="rtl"] .admin-sidebar.collapsed ~ .admin-main { margin-right: var(--sb-collapsed); }

        /* ── Topbar ── */
        .admin-topbar {
            height: var(--topbar-h);
            background: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: var(--z-sticky);
        }
        .admin-topbar-title { font-weight: 700; font-size: var(--fs-base); color: var(--text-primary); }

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
        .admin-stat-icon { width: 52px; height: 52px; border-radius: var(--r-lg); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
        .admin-stat-icon i { width: auto; }
        .admin-stat-value { font-size: var(--fs-3xl); font-weight: 800; line-height: 1; color: var(--text-primary); }
        .admin-stat-label { font-size: var(--fs-xs); color: var(--text-secondary); margin-top: 2px; }

        /* ── Tables ── */
        .admin-table { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--r-xl); overflow: hidden; box-shadow: var(--shadow-sm); }
        .admin-table table { margin: 0; }
        .admin-table thead th { background: var(--bg-hover); color: var(--text-secondary); font-size: var(--fs-xs); font-weight: 700; text-transform: uppercase; letter-spacing: .5px; border: none; padding: .875rem 1rem; }
        .admin-table tbody td { padding: .875rem 1rem; border-color: var(--border-light); vertical-align: middle; font-size: var(--fs-sm); color: var(--text-primary); background: var(--bg-card); }
        .admin-table tbody tr:hover td { background: var(--bg-hover); }
        .admin-search { max-width: 280px; }

        /* ── Mobile overlay ── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.5);
            z-index: calc(var(--z-fixed) - 1);
            backdrop-filter: blur(2px);
        }
        .sidebar-overlay.show { display: block; }

        @media (max-width: 991px) {
            [dir="ltr"] .admin-sidebar { transform: translateX(-100%); width: var(--sb-width) !important; }
            [dir="rtl"] .admin-sidebar { transform: translateX(100%); width: var(--sb-width) !important; }
            .admin-sidebar.mobile-open { transform: translateX(0) !important; }
            [dir="ltr"] .admin-main { margin-left: 0 !important; }
            [dir="rtl"] .admin-main { margin-right: 0 !important; }
            .sidebar-collapse-btn { display: none; }
            /* Always show text on mobile */
            .admin-sidebar .admin-nav-label,
            .admin-sidebar .admin-nav-text,
            .admin-sidebar .admin-nav-badge,
            .admin-sidebar .admin-sidebar-brand span { opacity: 1 !important; width: auto !important; }
            .admin-sidebar .admin-nav-link { justify-content: flex-start !important; padding: .5rem 1.25rem !important; }
            .admin-sidebar .admin-sidebar-brand { justify-content: flex-start !important; padding: 1rem 1.25rem !important; }
        }

        /* ── Dark mode ── */
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

<!-- Mobile overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="admin-wrapper">

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar" role="navigation" aria-label="<?php echo lang('admin_panel'); ?>">

        <!-- Brand + collapse toggle -->
        <div class="admin-sidebar-brand">
            <i class="fas fa-hotel" aria-hidden="true"></i>
            <span><?php echo APP_NAME; ?></span>
            <button class="sidebar-collapse-btn ms-auto d-none d-lg-flex"
                    id="sidebarCollapseBtn"
                    aria-label="Collapse sidebar"
                    title="Collapse sidebar">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>

        <nav class="admin-nav">

            <!-- Overview -->
            <div class="admin-nav-section">
                <div class="admin-nav-label"><?php echo lang('admin_overview'); ?></div>
                <a href="<?php echo SITE_URL; ?>admin/dashboard"
                   class="admin-nav-link <?php echo adminActive('dashboard'); ?>"
                   data-tooltip="<?php echo lang('admin_dashboard'); ?>">
                    <i class="fas fa-tachometer-alt" aria-hidden="true"></i>
                    <span class="admin-nav-text"><?php echo lang('admin_dashboard'); ?></span>
                </a>
            </div>

            <!-- Bookings -->
            <div class="admin-nav-section">
                <div class="admin-nav-label"><?php echo lang('admin_bookings'); ?></div>
                <a href="<?php echo SITE_URL; ?>admin/bookings/new"
                   class="admin-nav-link <?php echo adminActive('bookings/new'); ?>"
                   data-tooltip="<?php echo lang('admin_new_bookings'); ?>">
                    <i class="fas fa-calendar-plus" aria-hidden="true"></i>
                    <span class="admin-nav-text"><?php echo lang('admin_new_bookings'); ?></span>
                    <?php if(($pending['new_bookings'] ?? 0) > 0): ?>
                    <span class="admin-nav-badge" aria-label="<?php echo $pending['new_bookings']; ?> new">
                        <?php echo $pending['new_bookings']; ?>
                    </span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo SITE_URL; ?>admin/bookings/refunds"
                   class="admin-nav-link <?php echo adminActive('refunds'); ?>"
                   data-tooltip="<?php echo lang('admin_refunds'); ?>">
                    <i class="fas fa-undo" aria-hidden="true"></i>
                    <span class="admin-nav-text"><?php echo lang('admin_refunds'); ?></span>
                    <?php if(($pending['refund_bookings'] ?? 0) > 0): ?>
                    <span class="admin-nav-badge"><?php echo $pending['refund_bookings']; ?></span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo SITE_URL; ?>admin/bookings/records"
                   class="admin-nav-link <?php echo adminActive('records'); ?>"
                   data-tooltip="<?php echo lang('admin_records'); ?>">
                    <i class="fas fa-list-alt" aria-hidden="true"></i>
                    <span class="admin-nav-text"><?php echo lang('admin_records'); ?></span>
                </a>
            </div>

            <!-- Content -->
            <div class="admin-nav-section">
                <div class="admin-nav-label"><?php echo lang('admin_content'); ?></div>
                <a href="<?php echo SITE_URL; ?>admin/rooms"
                   class="admin-nav-link <?php echo adminActive('admin/rooms'); ?>"
                   data-tooltip="<?php echo lang('rooms'); ?>">
                    <i class="fas fa-bed" aria-hidden="true"></i>
                    <span class="admin-nav-text"><?php echo lang('rooms'); ?></span>
                </a>
                <a href="<?php echo SITE_URL; ?>admin/facilities"
                   class="admin-nav-link <?php echo adminActive('facilities'); ?>"
                   data-tooltip="<?php echo lang('admin_features_fac'); ?>">
                    <i class="fas fa-concierge-bell" aria-hidden="true"></i>
                    <span class="admin-nav-text"><?php echo lang('admin_features_fac'); ?></span>
                </a>
                <a href="<?php echo SITE_URL; ?>admin/carousel"
                   class="admin-nav-link <?php echo adminActive('carousel'); ?>"
                   data-tooltip="<?php echo lang('admin_carousel'); ?>">
                    <i class="fas fa-images" aria-hidden="true"></i>
                    <span class="admin-nav-text"><?php echo lang('admin_carousel'); ?></span>
                </a>
            </div>

            <!-- Users -->
            <div class="admin-nav-section">
                <div class="admin-nav-label"><?php echo lang('admin_users_section'); ?></div>
                <a href="<?php echo SITE_URL; ?>admin/users"
                   class="admin-nav-link <?php echo adminActive('admin/users'); ?>"
                   data-tooltip="<?php echo lang('admin_users'); ?>">
                    <i class="fas fa-users" aria-hidden="true"></i>
                    <span class="admin-nav-text"><?php echo lang('admin_users'); ?></span>
                </a>
                <a href="<?php echo SITE_URL; ?>admin/queries"
                   class="admin-nav-link <?php echo adminActive('queries'); ?>"
                   data-tooltip="<?php echo lang('admin_queries'); ?>">
                    <i class="fas fa-comments" aria-hidden="true"></i>
                    <span class="admin-nav-text"><?php echo lang('admin_queries'); ?></span>
                </a>
                <a href="<?php echo SITE_URL; ?>admin/reviews"
                   class="admin-nav-link <?php echo adminActive('reviews'); ?>"
                   data-tooltip="<?php echo lang('admin_reviews'); ?>">
                    <i class="fas fa-star" aria-hidden="true"></i>
                    <span class="admin-nav-text"><?php echo lang('admin_reviews'); ?></span>
                </a>
            </div>

            <!-- System -->
            <div class="admin-nav-section">
                <div class="admin-nav-label"><?php echo lang('admin_system'); ?></div>
                <a href="<?php echo SITE_URL; ?>admin/settings"
                   class="admin-nav-link <?php echo adminActive('settings'); ?>"
                   data-tooltip="<?php echo lang('admin_settings'); ?>">
                    <i class="fas fa-cog" aria-hidden="true"></i>
                    <span class="admin-nav-text"><?php echo lang('admin_settings'); ?></span>
                </a>
                <a href="<?php echo SITE_URL; ?>" class="admin-nav-link" target="_blank" rel="noopener"
                   data-tooltip="<?php echo lang('admin_view_site'); ?>">
                    <i class="fas fa-external-link-alt" aria-hidden="true"></i>
                    <span class="admin-nav-text"><?php echo lang('admin_view_site'); ?></span>
                </a>
            </div>

            <!-- Logout -->
            <div class="admin-nav-divider"></div>
            <a href="<?php echo SITE_URL; ?>admin/logout"
               class="admin-nav-link"
               style="color:#f87171;"
               data-tooltip="<?php echo lang('admin_logout'); ?>">
                <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
                <span class="admin-nav-text"><?php echo lang('admin_logout'); ?></span>
            </a>

        </nav>
    </aside>

    <!-- Main -->
    <div class="admin-main" id="adminMain">

        <!-- Topbar -->
        <div class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <!-- Mobile hamburger -->
                <button class="btn btn-sm btn-outline-secondary d-lg-none"
                        id="sidebarToggle" aria-label="Toggle menu">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="admin-topbar-title"><?php echo $pageTitle ?? lang('admin_dashboard'); ?></span>
            </div>
            <div class="d-flex align-items-center gap-2">

                <!-- Language Switcher -->
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle shadow-none"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-language"></i>
                        <span class="d-none d-md-inline"><?php echo $langLabels[$lang]; ?></span>
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
                <button class="dark-toggle" id="darkToggle"
                        aria-label="<?php echo lang('toggle_dark'); ?>"
                        title="<?php echo lang('toggle_dark'); ?>">
                    <i class="fas fa-moon"></i>
                </button>

                <!-- Admin badge -->
                <span class="d-none d-md-flex align-items-center gap-1 text-secondary"
                      style="font-size:var(--fs-xs); padding:.25rem .6rem; background:var(--bg-hover); border-radius:var(--r-full); border:1px solid var(--border-color);">
                    <i class="fas fa-user-shield text-primary-custom"></i>
                    Admin
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

/* ── Dark mode ── */
(function(){
    const t    = document.documentElement.getAttribute('data-theme') || 'light';
    const icon = document.querySelector('#darkToggle i');
    if(icon) icon.className = t === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
})();
document.getElementById('darkToggle')?.addEventListener('click', function(){
    const next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('vana_theme', next);
    document.cookie = `vana_theme=${next};path=/;max-age=31536000`;
    const icon = this.querySelector('i');
    if(icon) icon.className = next === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
});

/* ── Sidebar collapse (desktop) ── */
const sidebar      = document.getElementById('adminSidebar');
const collapseBtn  = document.getElementById('sidebarCollapseBtn');
const COLLAPSED_KEY = 'admin_sidebar_collapsed';

// Restore saved state
if(localStorage.getItem(COLLAPSED_KEY) === '1') {
    sidebar?.classList.add('collapsed');
}

collapseBtn?.addEventListener('click', () => {
    const isCollapsed = sidebar.classList.toggle('collapsed');
    localStorage.setItem(COLLAPSED_KEY, isCollapsed ? '1' : '0');
    collapseBtn.setAttribute('aria-label', isCollapsed ? 'Expand sidebar' : 'Collapse sidebar');
});

/* ── Sidebar mobile ── */
const overlay     = document.getElementById('sidebarOverlay');
const toggleBtn   = document.getElementById('sidebarToggle');

function openMobileSidebar() {
    sidebar?.classList.add('mobile-open');
    overlay?.classList.add('show');
    document.body.style.overflow = 'hidden';
    toggleBtn?.setAttribute('aria-expanded', 'true');
}
function closeMobileSidebar() {
    sidebar?.classList.remove('mobile-open');
    overlay?.classList.remove('show');
    document.body.style.overflow = '';
    toggleBtn?.setAttribute('aria-expanded', 'false');
}

toggleBtn?.addEventListener('click', () => {
    sidebar?.classList.contains('mobile-open') ? closeMobileSidebar() : openMobileSidebar();
});
overlay?.addEventListener('click', closeMobileSidebar);

// Close on Escape
document.addEventListener('keydown', e => {
    if(e.key === 'Escape') closeMobileSidebar();
});

/* ── Alert helper ── */
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
