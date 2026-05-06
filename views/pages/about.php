<?php $pageTitle = APP_NAME . ' — ' . lang('about'); ?>
<?php require BASE_PATH . '/views/layouts/header.php'; ?>

<!-- Hero -->
<div class="my-5 px-4 text-center">
    <h2 class="fw-bold">
        <i class="fas fa-info-circle me-2" style="color:var(--teal);"></i>About Us
    </h2>
    <hr class="mx-auto" style="width:80px;border-color:var(--teal);border-width:3px;">
    <p class="text-muted mt-3 mx-auto" style="max-width:700px;">
        At our hotel, we aim to provide a comfortable and enjoyable stay for all our guests.
        Our experienced team is dedicated to consistently delivering the highest levels of service.
    </p>
</div>

<!-- Section 1 -->
<div class="container mb-5">
    <div class="row justify-content-between align-items-center">
        <div class="col-lg-6 mb-4 order-lg-1 order-2">
            <h3 class="mb-3 fw-bold">
                <i class="fas fa-star me-2" style="color:var(--teal);"></i>Elevated Experiences
            </h3>
            <p class="text-muted">
                At our prestigious hotel, we are dedicated to exceeding the expectations of our discerning guests.
                Our seasoned hospitality professionals curate tailored experiences that capture the spirit of our vibrant location.
            </p>
        </div>
        <div class="col-lg-5 mb-4 order-lg-2 order-1">
            <img src="<?php echo ABOUT_IMG_PATH; ?>about.jpg" class="w-100 rounded-3 shadow" alt="About" loading="lazy">
        </div>
    </div>
</div>

<!-- Stats -->
<div class="container mb-5">
    <div class="row">
        <?php
        $stats = [
            ['icon'=>'fas fa-door-open', 'value'=>'100+', 'label'=>'Rooms'],
            ['icon'=>'fas fa-star',      'value'=>'150+', 'label'=>'Reviews'],
            ['icon'=>'fas fa-users',     'value'=>'200+', 'label'=>'Customers'],
            ['icon'=>'fas fa-user-tie',  'value'=>'200+', 'label'=>'Staff'],
        ];
        foreach($stats as $s):
        ?>
        <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class="card border-0 shadow-sm rounded-3 p-4 text-center border-top border-4" style="border-color:var(--teal)!important;">
                <i class="<?php echo $s['icon']; ?> fa-2x mb-3" style="color:var(--teal);"></i>
                <h4 class="fw-bold"><?php echo $s['value']; ?></h4>
                <p class="text-muted mb-0"><?php echo $s['label']; ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Management Team -->
<div class="container mb-5">
    <div class="text-center mb-5">
        <h3 class="fw-bold">
            <i class="fas fa-users me-2" style="color:var(--teal);"></i>Management Team
        </h3>
    </div>
    <div class="swiper swiper-team">
        <div class="swiper-wrapper mb-5">
            <?php foreach($team as $member): ?>
            <div class="swiper-slide bg-white text-center overflow-hidden rounded-3 shadow-sm p-3">
                <img src="<?php echo ABOUT_IMG_PATH . htmlspecialchars($member['picture']); ?>"
                     class="w-100 rounded-3 mb-3" style="height:200px;object-fit:cover;"
                     alt="<?php echo htmlspecialchars($member['name']); ?>" loading="lazy">
                <h6 class="fw-bold"><?php echo htmlspecialchars($member['name']); ?></h6>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>

<?php require BASE_PATH . '/views/layouts/footer.php'; ?>

<script>
new Swiper('.swiper-team', {
    spaceBetween:40,
    pagination:{el:'.swiper-pagination'},
    breakpoints:{320:{slidesPerView:1}, 768:{slidesPerView:3}, 1024:{slidesPerView:3}}
});
</script>
