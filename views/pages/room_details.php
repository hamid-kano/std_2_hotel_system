<?php 
$roomName = getTranslation('rooms_translations', $room['id'], 'name', $room['name']);
$pageTitle = APP_NAME . ' — ' . htmlspecialchars($roomName); 
?>
<?php require BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container my-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>"><i class="fas fa-home"></i><?php echo lang('home'); ?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>rooms"><i class="fas fa-bed"></i><?php echo lang('rooms'); ?></a></li>
            <li class="breadcrumb-item active"><?php echo htmlspecialchars($roomName); ?></li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Left: Images + Description + Reviews -->
        <div class="col-lg-7">
            <div id="roomCarousel" class="carousel slide shadow-sm rounded-3 overflow-hidden" data-bs-ride="carousel">
                <div class="carousel-inner" style="height:380px;">
                    <?php if(empty($room['images'])): ?>
                    <div class="carousel-item active">
                        <img src="<?php echo ROOMS_IMG_PATH; ?>thumbnail.jpg" class="d-block w-100 h-100" style="object-fit:cover;" alt="<?php echo htmlspecialchars($roomName); ?>">
                    </div>
                    <?php else: ?>
                    <?php foreach($room['images'] as $i => $img): ?>
                    <div class="carousel-item <?php echo $i===0?'active':''; ?>">
                        <img src="<?php echo ROOMS_IMG_PATH . htmlspecialchars($img['image']); ?>"
                             class="d-block w-100 h-100" style="object-fit:cover;"
                             alt="<?php echo htmlspecialchars($roomName); ?>" loading="lazy">
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <?php if(count($room['images'] ?? []) > 1): ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
                <?php endif; ?>
            </div>

            <?php 
            $roomDescription = getTranslation('rooms_translations', $room['id'], 'description', $room['description']);
            if(!empty($roomDescription)): 
            ?>
            <div class="card border-0 shadow-sm rounded-3 mt-4 p-4">
                <h5 class="fw-700 mb-3">
                    <i class="fas fa-align-left text-primary-custom"></i><?php echo lang('description'); ?>
                </h5>
                <p class="text-secondary mb-0"><?php echo nl2br(htmlspecialchars($roomDescription)); ?></p>
            </div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm rounded-3 mt-4 p-4">
                <h5 class="fw-700 mb-4">
                    <i class="fas fa-star text-primary-custom"></i><?php echo lang('reviews_ratings'); ?>
                    <?php if(!empty($reviews)): ?>
                    <span class="badge bg-light ms-2"><?php echo count($reviews); ?> <?php echo lang('reviews'); ?></span>
                    <?php endif; ?>
                </h5>
                <?php if(empty($reviews)): ?>
                <div class="empty-state py-4">
                    <i class="fas fa-comment-slash"></i>
                    <p><?php echo lang('no_reviews_first'); ?></p>
                </div>
                <?php else: ?>
                <?php foreach($reviews as $rev): ?>
                <div class="review-card">
                    <div class="d-flex align-items-center mb-1 gap-2">
                        <i class="fas fa-user-circle text-secondary fs-5"></i>
                        <strong><?php echo htmlspecialchars($rev['uname']); ?></strong>
                    </div>
                    <p class="text-secondary mb-1" style="font-size:var(--fs-sm);"><?php echo htmlspecialchars($rev['review']); ?></p>
                    <div>
                        <?php for($i=0; $i<(int)$rev['rating']; $i++): ?>
                        <i class="fas fa-star text-warning"></i>
                        <?php endfor; ?>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right: Info & Booking -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-3 p-4 sticky-top" style="top:80px;">
                <div class="price-tag mb-1"><?php echo $room['price']; ?></div>
                <p class="text-secondary mb-3" style="font-size:var(--fs-sm);">
                    <i class="fas fa-moon"></i><?php echo lang('per_night'); ?>
                </p>

                <?php if($room['rating'] > 0): ?>
                <div class="mb-3">
                    <?php for($i=0; $i<round($room['rating']); $i++): ?>
                    <i class="fas fa-star text-warning"></i>
                    <?php endfor; ?>
                    <span class="text-secondary ms-1" style="font-size:var(--fs-sm);">(<?php echo $room['rating']; ?>)</span>
                </div>
                <?php endif; ?>

                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge bg-light">
                        <i class="fas fa-user"></i><?php echo $room['adult']; ?> <?php echo lang('adults'); ?>
                    </span>
                    <span class="badge bg-light">
                        <i class="fas fa-child"></i><?php echo $room['children']; ?> <?php echo lang('children'); ?>
                    </span>
                    <?php if(!empty($room['area'])): ?>
                    <span class="badge bg-light">
                        <i class="fas fa-expand-arrows-alt"></i><?php echo htmlspecialchars($room['area']); ?> m²
                    </span>
                    <?php endif; ?>
                </div>

                <?php if(!empty($room['features'])): ?>
                <div class="mb-3">
                    <small class="fw-700 text-secondary text-uppercase d-block mb-1" style="font-size:var(--fs-xs); letter-spacing:.5px;">
                        <i class="fas fa-list"></i><?php echo lang('features'); ?>
                    </small>
                    <?php foreach($room['features'] as $f): ?>
                    <span class="badge bg-light me-1 mb-1"><?php echo getTranslation('features_translations', $f['id'], 'name', $f['name']); ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php if(!empty($room['facilities'])): ?>
                <div class="mb-4">
                    <small class="fw-700 text-secondary text-uppercase d-block mb-1" style="font-size:var(--fs-xs); letter-spacing:.5px;">
                        <i class="fas fa-concierge-bell"></i><?php echo lang('facilities'); ?>
                    </small>
                    <?php foreach($room['facilities'] as $f): ?>
                    <span class="badge bg-light me-1 mb-1"><?php echo getTranslation('facilities_translations', $f['id'], 'name', $f['name']); ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <hr>
                <?php $login = Auth::isUserLoggedIn() ? 1 : 0; ?>
                <button onclick="checkLoginToBook(<?php echo $login; ?>,<?php echo $room['id']; ?>)"
                        class="btn w-100 custom-bg">
                    <i class="fas fa-calendar-check"></i><?php echo lang('book_now'); ?>
                </button>
                <p class="text-secondary text-center mt-2 mb-0" style="font-size:var(--fs-xs);">
                    <i class="fas fa-shield-alt"></i><?php echo lang('free_cancel'); ?>
                </p>
            </div>
        </div>
    </div>
</div>

<?php require BASE_PATH . '/views/layouts/footer.php'; ?>
