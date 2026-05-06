<?php $pageTitle = APP_NAME . ' — ' . lang('home'); ?>
<?php require BASE_PATH . '/views/layouts/header.php'; ?>

<!-- Hero Carousel -->
<div class="container-fluid px-lg-4 mt-4">
    <div class="swiper swiper-hero hero-carousel">
        <div class="swiper-wrapper">
            <?php foreach($carousel as $slide): ?>
            <div class="swiper-slide">
                <img src="<?php echo CAROUSEL_IMG_PATH . htmlspecialchars($slide['image']); ?>"
                     class="w-100 d-block" alt="<?php echo APP_NAME; ?>" loading="lazy">
            </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>

<!-- Availability Form -->
<div class="container availability-form">
    <div class="card shadow-lg border-0 p-4">
        <h5 class="mb-4 fw-600">
            <i class="fas fa-search me-2 text-primary-custom"></i>
            <?php echo lang('check_in'); ?> / <?php echo lang('check_out'); ?>
        </h5>
        <form action="<?php echo SITE_URL; ?>rooms" id="avail-form">
            <div class="row align-items-end g-3">
                <div class="col-lg-3">
                    <label class="form-label">
                        <i class="fas fa-calendar-check me-1"></i><?php echo lang('check_in'); ?>
                    </label>
                    <input type="date" class="form-control" name="checkin" id="home_checkin" required>
                </div>
                <div class="col-lg-3">
                    <label class="form-label">
                        <i class="fas fa-calendar-times me-1"></i><?php echo lang('check_out'); ?>
                    </label>
                    <input type="date" class="form-control" name="checkout" id="home_checkout" required>
                </div>
                <div class="col-lg-3">
                    <label class="form-label">
                        <i class="fas fa-user-friends me-1"></i>Adults
                    </label>
                    <select class="form-select" name="adult">
                        <?php for($i=1; $i<=($maxGuests['max_adult'] ?? 5); $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-lg-2">
                    <label class="form-label">
                        <i class="fas fa-child me-1"></i>Children
                    </label>
                    <select class="form-select" name="children">
                        <?php for($i=0; $i<=($maxGuests['max_children'] ?? 5); $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <input type="hidden" name="check_availablity">
                <div class="col-lg-1">
                    <button type="submit" class="btn custom-bg w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Our Rooms -->
<div class="container mt-5 pt-4">
    <div class="section-header">
        <h2><i class="fas fa-bed me-2 text-primary-custom"></i><?php echo lang('rooms'); ?></h2>
        <div class="section-divider"></div>
        <p>Discover our luxurious rooms designed for your comfort</p>
    </div>
    <div class="row">
        <?php if(empty($rooms)): ?>
        <div class="col-12 empty-state">
            <i class="fas fa-door-closed"></i>
            <p>No rooms available at the moment.</p>
        </div>
        <?php else: ?>
        <?php foreach($rooms as $room):
            $rid    = $room['id'];
            $thumb  = $thumbnails[$rid] ?? ROOMS_IMG_PATH . 'thumbnail.jpg';
            $rating = $ratings[$rid] ?? 0;
            $login  = Auth::isUserLoggedIn() ? 1 : 0;
        ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card room-card h-100">
                <div class="overflow-hidden">
                    <img src="<?php echo $thumb; ?>" class="card-img-top"
                         alt="<?php echo htmlspecialchars($room['name']); ?>" loading="lazy">
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="fw-700 mb-0"><?php echo htmlspecialchars($room['name']); ?></h5>
                        <?php if($rating > 0): ?>
                        <span class="badge bg-light ms-2">
                            <i class="fas fa-star text-warning me-1"></i><?php echo $rating; ?>
                        </span>
                        <?php endif; ?>
                    </div>
                    <p class="text-secondary mb-3" style="font-size:var(--text-sm);">
                        <i class="fas fa-moon me-1 text-primary-custom"></i>
                        <strong><?php echo $room['price']; ?></strong> <?php echo lang('per_night'); ?>
                    </p>

                    <?php if(!empty($features[$rid])): ?>
                    <div class="mb-2">
                        <?php foreach(array_slice($features[$rid], 0, 3) as $f): ?>
                        <span class="badge bg-light me-1 mb-1"><?php echo htmlspecialchars($f); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <small class="fw-600 text-secondary text-uppercase d-block mb-1" style="font-size:var(--text-xs); letter-spacing:.5px;">
                            <i class="fas fa-concierge-bell me-1"></i><?php echo lang('facilities'); ?>
                        </small>
                        <?php foreach(array_slice($facilities[$rid] ?? [], 0, 3) as $f): ?>
                        <span class="badge bg-light me-1 mb-1"><?php echo htmlspecialchars($f['name']); ?></span>
                        <?php endforeach; ?>
                    </div>

                    <div class="mb-3">
                        <span class="badge bg-light me-1">
                            <i class="fas fa-user me-1"></i><?php echo $room['adult']; ?> Adults
                        </span>
                        <span class="badge bg-light">
                            <i class="fas fa-child me-1"></i><?php echo $room['children']; ?> Children
                        </span>
                    </div>

                    <div class="d-flex gap-2 mt-auto">
                        <button onclick="checkLoginToBook(<?php echo $login; ?>,<?php echo $rid; ?>)"
                                class="btn btn-sm custom-bg flex-fill">
                            <i class="fas fa-calendar-check me-1"></i><?php echo lang('book_now'); ?>
                        </button>
                        <a href="<?php echo SITE_URL; ?>room/<?php echo $rid; ?>"
                           class="btn btn-sm btn-outline-secondary flex-fill">
                            <i class="fas fa-eye me-1"></i><?php echo lang('room_details'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <div class="col-12 text-center mt-2 mb-4">
            <a href="<?php echo SITE_URL; ?>rooms" class="btn btn-outline-secondary px-5">
                <i class="fas fa-th-list me-2"></i>More Rooms
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Facilities -->
<div class="container mt-5 pt-2">
    <div class="section-header">
        <h2><i class="fas fa-concierge-bell me-2 text-primary-custom"></i><?php echo lang('facilities'); ?></h2>
        <div class="section-divider"></div>
        <p>Everything you need for a perfect stay</p>
    </div>
    <div class="row justify-content-center">
        <?php foreach($facilitiesList as $fac): ?>
        <div class="col-lg-2 col-md-3 col-6 mb-4">
            <div class="facility-card">
                <img src="<?php echo FACILITIES_IMG_PATH . htmlspecialchars($fac['icon']); ?>"
                     width="52" alt="<?php echo htmlspecialchars($fac['name']); ?>" loading="lazy">
                <h6 class="mt-3 mb-0 fw-600" style="font-size:var(--text-sm);">
                    <?php echo htmlspecialchars($fac['name']); ?>
                </h6>
            </div>
        </div>
        <?php endforeach; ?>
        <div class="col-12 text-center mt-2 mb-4">
            <a href="<?php echo SITE_URL; ?>facilities" class="btn btn-outline-secondary px-5">
                <i class="fas fa-plus me-2"></i>Know More
            </a>
        </div>
    </div>
</div>

<!-- Testimonials -->
<div class="container mt-5 pt-2">
    <div class="section-header">
        <h2><i class="fas fa-quote-left me-2 text-primary-custom"></i>Testimonials</h2>
        <div class="section-divider"></div>
        <p>What our guests say about us</p>
    </div>
    <?php if(empty($testimonials)): ?>
    <div class="empty-state"><i class="fas fa-comment-slash"></i><p>No reviews yet.</p></div>
    <?php else: ?>
    <div class="swiper swiper-testimonials">
        <div class="swiper-wrapper pb-5">
            <?php foreach($testimonials as $review): ?>
            <div class="swiper-slide">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                             style="width:44px;height:44px;background:var(--primary-light);color:var(--primary);">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-600"><?php echo htmlspecialchars($review['uname']); ?></h6>
                            <div>
                                <?php for($i=0; $i<(int)$review['rating']; $i++): ?>
                                <i class="fas fa-star text-warning" style="font-size:var(--text-xs);"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    <p class="text-secondary mb-0" style="font-size:var(--text-sm);">
                        "<?php echo htmlspecialchars($review['review']); ?>"
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <?php endif; ?>
</div>

<!-- Reach Us -->
<div class="container mt-5 pt-2 mb-5">
    <div class="section-header">
        <h2><i class="fas fa-map-marker-alt me-2 text-primary-custom"></i>Reach Us</h2>
        <div class="section-divider"></div>
    </div>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius:var(--radius-xl);">
                <iframe src="<?php echo htmlspecialchars($contact['iframe'] ?? ''); ?>"
                        class="w-100 d-block" height="340" title="Map" loading="lazy"
                        style="border:none;"></iframe>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 h-100" style="border-radius:var(--radius-xl);">
                <h5 class="fw-700 mb-3">
                    <i class="fas fa-phone me-2 text-primary-custom"></i>Call us
                </h5>
                <?php if(!empty($contact['pn1'])): ?>
                <a href="tel:+<?php echo htmlspecialchars($contact['pn1']); ?>"
                   class="d-flex align-items-center gap-2 mb-2 text-decoration-none" style="color:var(--text-primary);">
                    <i class="fas fa-phone-alt text-primary-custom"></i>
                    +<?php echo htmlspecialchars($contact['pn1']); ?>
                </a>
                <?php endif; ?>
                <?php if(!empty($contact['pn2'])): ?>
                <a href="tel:+<?php echo htmlspecialchars($contact['pn2']); ?>"
                   class="d-flex align-items-center gap-2 text-decoration-none" style="color:var(--text-primary);">
                    <i class="fas fa-phone-alt text-primary-custom"></i>
                    +<?php echo htmlspecialchars($contact['pn2']); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require BASE_PATH . '/views/layouts/footer.php'; ?>

<script>
new Swiper('.swiper-hero', {
    effect: 'fade', loop: true,
    autoplay: { delay: 3500, disableOnInteraction: false },
    navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
    pagination: { el: '.swiper-pagination', clickable: true }
});
new Swiper('.swiper-testimonials', {
    grabCursor: true, loop: true, spaceBetween: 24,
    pagination: { el: '.swiper-pagination', clickable: true },
    breakpoints: { 320: { slidesPerView: 1 }, 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
});
document.getElementById('avail-form')?.addEventListener('submit', function(e){
    const today = new Date().toISOString().split('T')[0];
    const ci = document.getElementById('home_checkin').value;
    const co = document.getElementById('home_checkout').value;
    if(ci < today){ e.preventDefault(); alert('error','Check-in cannot be in the past!'); return; }
    if(co <= ci){ e.preventDefault(); alert('error','Check-out must be after check-in!'); return; }
});
</script>
