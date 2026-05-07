<?php
/**
 * Auth Topbar — shared between login & register
 * Expects: $lang, $isRTL, $langLabels, $backUrl (optional)
 */
$backUrl    = $backUrl ?? SITE_URL;
$langLabels = ['ar' => 'العربية 🇮🇶', 'en' => 'English 🇬🇧', 'ku' => 'کوردی 🏳'];
?>
<div class="auth-topbar">
    <a href="<?php echo $backUrl; ?>" class="auth-back">
        <i class="fas fa-arrow-<?php echo $isRTL ? 'right' : 'left'; ?>"></i>
        <span><?php echo lang('back_to_site'); ?></span>
    </a>

    <div class="d-flex align-items-center gap-2">
        <!-- Language Switcher -->
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle shadow-none auth-lang-btn"
                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-language"></i>
                <?php echo $langLabels[$lang]; ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <?php foreach($langLabels as $code => $label): ?>
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

        <!-- Dark Mode Toggle -->
        <button class="dark-toggle" id="darkToggle" aria-label="<?php echo lang('toggle_dark'); ?>">
            <i class="fas fa-moon"></i>
        </button>
    </div>
</div>
