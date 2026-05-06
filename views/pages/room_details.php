<?php $pageTitle = APP_NAME . ' — ' . htmlspecialchars($room['name']); ?>
<?php require BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>" class="text-decoration-none"><i class="fas fa-home me-1"></i><?php echo lang('home'); ?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>rooms" class="text-decoration-none"><i class="fas fa-bed me-1"></i><?php echo lang('rooms'); ?></a></li>
            <li class="breadcrumb-item active"><?php echo htmlspecialchars($room['name']); ?></li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Left: Images + Description + Reviews -->
        <div class="col-lg-7">
            <!-- Image Carousel -->
            <div id="roomCarousel" class="carousel slide shadow-sm rounded-3 overflow-hidden" data-bs-ride="carousel">
                <div class="carousel-inner" style="height:380px;">
                    <?php if(empty($room['images'])): ?>
                    <div class="carousel-item active">
                        <img src="<?php echo ROOMS_IMG_PATH; ?>thumbnail.jpg" class="d-block w-100 h-100" style="object-fit:cover;" alt="<?php echo htmlspecialchars($room['name']); ?>">
                    </div>
                    <?php else: ?>
                    <?php foreach($room['images'] as $i => $img): ?>
                    <div class="carousel-item <?php echo $i===0?'active':''; ?>">
                        <img src="<?php echo ROOMS_IMG_PATH . htmlspecialchars($img['image']); ?>"
                             class="d-block w-100 h-100" style="object-fit:cover;"
                             alt="<?php echo htmlspecialchars($room['name']); ?>" loading="lazy">
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

            <!-- Description -->
            <?php if(!empty($room['description'])): ?>
            <div class="card border-0 shadow-sm rounded-3 mt-4 p-4">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-align-left me-2" class="text-primary-custom"></i>Description
                </h5>
                <p class="text-muted mb-0"><?php echo nl2br(htmlspecialchars($room['description'])); ?></p>
            </div>
            <?php endif; ?>

            <!-- Reviews -->
            <div class="card border-0 shadow-sm rounded-3 mt-4 p-4">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-star me-2" class="text-primary-custom"></i>Reviews &amp; Ratings
                    <?php if(!empty($reviews)): ?>
                    <span class="badge bg-light text-dark border ms-2" style="font-size:13px;">
                        <?php echo count($reviews); ?> reviews
                    </span>
                    <?php endif; ?>
                </h5>
                <?php if(empty($reviews)): ?>
                <div class="empty-state py-4">
                    <i class="fas fa-comment-slash"></i>
                    <p>No reviews yet. Be the first!</p>
                </div>
                <?php else: ?>
                <?php foreach($reviews as $rev): ?>
                <div class="border-start border-3 ps-3 mb-4" style="border-color:var(--primary)!important;">
                    <div class="d-flex align-items-center mb-1">
                        <i class="fas fa-user-circle me-2 text-muted fs-5"></i>
                        <strong><?php echo htmlspecialchars($rev['uname']); ?></strong>
                    </div>
                    <p class="text-muted mb-1 small"><?php echo htmlspecialchars($rev['review']); ?></p>
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
                <div class="mb-1" style="font-size:1.8rem; font-weight:700; color:var(--primary);">
                    <?php echo $room['price']; ?>
                </div>
                <p class="text-muted mb-3 small">
                    <i class="fas fa-moon me-1"></i><?php echo lang('per_night'); ?>
                </p>

                <?php if($room['rating'] > 0): ?>
                <div class="mb-3">
                    <?php for($i=0; $i<round($room['rating']); $i++): ?>
                    <i class="fas fa-star text-warning"></i>
                    <?php endfor; ?>
                    <span class="text-muted small ms-1">(<?php echo $room['rating']; ?>)</span>
                </div>
                <?php endif; ?>

                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge bg-light text-dark border">
                        <i class="fas fa-user me-1"></i><?php echo $room['adult']; ?> Adults
                    </span>
                    <span class="badge bg-light text-dark border">
                        <i class="fas fa-child me-1"></i><?php echo $room['children']; ?> Children
                    </span>
                    <?php if(!empty($room['area'])): ?>
                    <span class="badge bg-light text-dark border">
                        <i class="fas fa-expand-arrows-alt me-1"></i><?php echo htmlspecialchars($room['area']); ?> m²
                    </span>
                    <?php endif; ?>
                </div>

                <?php if(!empty($room['features'])): ?>
                <div class="mb-3">
                    <small class="fw-bold text-muted text-uppercase d-block mb-1">
                        <i class="fas fa-list me-1"></i>Features
                    </small>
                    <?php foreach($room['features'] as $f): ?>
                    <span class="badge rounded-pill bg-light text-dark border me-1 mb-1"><?php echo htmlspecialchars($f['name']); ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php if(!empty($room['facilities'])): ?>
                <div class="mb-4">
                    <small class="fw-bold text-muted text-uppercase d-block mb-1">
                        <i class="fas fa-concierge-bell me-1"></i><?php echo lang('facilities'); ?>
                    </small>
                    <?php foreach($room['facilities'] as $f): ?>
                    <span class="badge rounded-pill bg-light text-dark border me-1 mb-1"><?php echo htmlspecialchars($f['name']); ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <hr>
                <?php $login = Auth::isUserLoggedIn() ? 1 : 0; ?>
                <button onclick="checkLoginToBook(<?php echo $login; ?>,<?php echo $room['id']; ?>)"
                        class="btn w-100 text-white custom-bg shadow-none">
                    <i class="fas fa-calendar-check me-2"></i><?php echo lang('book_now'); ?>
                </button>
                <p class="text-muted small text-center mt-2 mb-0">
                    <i class="fas fa-shield-alt me-1"></i>Free cancellation before check-in
                </p>
            </div>
        </div>
    </div>
</div>

<?php require BASE_PATH . '/views/layouts/footer.php'; ?>
