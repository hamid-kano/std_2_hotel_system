<?php $pageTitle = APP_NAME . ' — ' . lang('about'); ?>
<?php require BASE_PATH . '/views/layouts/header.php'; ?>

<div class="page-hero text-center">
    <h2 class="fw-800 d-flex align-items-center justify-content-center gap-2">
        <i class="fas fa-info-circle text-primary-custom"></i><?php echo lang('about_us'); ?>
    </h2>
    <div class="section-divider"></div>
    <p class="text-secondary mx-auto" style="max-width:700px;">
        <?php echo lang('about_intro'); ?>
    </p>
</div>

<div class="container mb-5">
    <div class="row justify-content-between align-items-center">
        <div class="col-lg-6 mb-4 order-lg-1 order-2">
            <h3 class="mb-3 fw-700 d-flex align-items-center gap-2">
                <i class="fas fa-star text-primary-custom"></i><?php echo lang('elevated_exp'); ?>
            </h3>
            <p class="text-secondary"><?php echo lang('elevated_exp_text'); ?></p>
        </div>
        <div class="col-lg-5 mb-4 order-lg-2 order-1">
            <img src="<?php echo ABOUT_IMG_PATH; ?>about.jpg" class="w-100 rounded-3 shadow" alt="<?php echo lang('about_us'); ?>" loading="lazy">
        </div>
    </div>
</div>

<!-- Stats -->
<div class="container mb-5">
    <div class="row">
        <?php
        $stats = [
            ['icon'=>'fas fa-door-open', 'value'=>'100+', 'key'=>'stat_rooms'],
            ['icon'=>'fas fa-star',      'value'=>'150+', 'key'=>'stat_reviews'],
            ['icon'=>'fas fa-users',     'value'=>'200+', 'key'=>'stat_customers'],
            ['icon'=>'fas fa-user-tie',  'value'=>'200+', 'key'=>'stat_staff'],
        ];
        foreach($stats as $s):
        ?>
        <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class="stat-card">
                <i class="<?php echo $s['icon']; ?> fa-2x mb-3"></i>
                <h4 class="fw-800"><?php echo $s['value']; ?></h4>
                <p class="text-secondary mb-0"><?php echo lang($s['key']); ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Management Team -->
<div class="container mb-5">
    <div class="section-header">
        <h3 class="fw-700 d-flex align-items-center justify-content-center gap-2">
            <i class="fas fa-users text-primary-custom"></i><?php echo lang('mgmt_team'); ?>
        </h3>
        <div class="section-divider"></div>
    </div>
    <div class="swiper swiper-team">
        <div class="swiper-wrapper mb-5">
            <?php foreach($team as $member): ?>
            <div class="swiper-slide text-center overflow-hidden rounded-3 p-3" style="background:var(--bg-card); border:1px solid var(--border-color);">
                <img src="<?php echo ABOUT_IMG_PATH . htmlspecialchars($member['picture']); ?>"
                     class="w-100 rounded-3 mb-3" style="height:200px;object-fit:cover;"
                     alt="<?php echo htmlspecialchars($member['name']); ?>" loading="lazy">
                <h6 class="fw-700"><?php echo htmlspecialchars($member['name']); ?></h6>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>

<?php require BASE_PATH . '/views/layouts/footer.php'; ?>

<script>
new Swiper('.swiper-team', {
    spaceBetween:24,
    pagination:{el:'.swiper-pagination', clickable:true},
    breakpoints:{320:{slidesPerView:1}, 768:{slidesPerView:3}, 1024:{slidesPerView:3}}
});
</script>
