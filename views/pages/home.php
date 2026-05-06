<?php $pageTitle = APP_NAME . ' — ' . lang('home'); ?>
<?php require BASE_PATH . '/views/layouts/header.php'; ?>

<!-- Hero Carousel -->
<div class="container-fluid px-lg-4 mt-4">
    <div class="swiper swiper-hero rounded-3 overflow-hidden shadow">
        <div class="swiper-wrapper">
            <?php foreach($carousel as $slide): ?>
            <div class="swiper-slide">
                <img src="<?php echo CAROUSEL_IMG_PATH . htmlspecialchars($slide['image']); ?>"
                     class="w-100 d-block" style="height:480px;object-fit:cover;"
                     alt="<?php echo APP_NAME; ?>" loading="lazy">
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
    <div class="row">
        <div class="col-lg-12 bg-white shadow p-4 rounded-3">
            <h5 class="mb-4">
                <i class="fas fa-search me-2" style="color:var(--teal);"></i>
                <?php echo lang('check_in'); ?> / <?php echo lang('check_out'); ?>
            </h5>
            <form action="<?php echo SITE_URL; ?>rooms" id="avail-form">
                <div class="row align-items-end">
                    <div class="col-lg-3 mb-3">
                        <label class="form-label fw-500">
                            <i class="fas fa-calendar-check me-1"></i><?php echo lang('check_in'); ?>
                        </label>
                        <input type="date" class="form-control shadow-none" name="checkin" id="home_checkin" required>
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label class="form-label fw-500">
                            <i class="fas fa-calendar-times me-1"></i><?php echo lang('check_out'); ?>
                        </label>
                        <input type="date" class="form-control shadow-none" name="checkout" id="home_checkout" required>
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label class="form-label fw-500">
                            <i class="fas fa-user-friends me-1"></i>Adults
                        </label>
                        <select class="form-select shadow-none" name="adult">
                            <?php for($i=1; $i<=($maxGuests['max_adult'] ?? 5); $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-lg-2 mb-3">
                        <label class="form-label fw-500">
                            <i class="fas fa-child me-1"></i>Children
                        </label>
                        <select class="form-select shadow-none" name="children">
                            <?php for($i=0; $i<=($maxGuests['max_children'] ?? 5); $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <input type="hidden" name="check_availablity">
                    <div class="col-lg-1 mb-lg-3 mt-2">
                        <button type="submit" class="btn text-white custom-bg shadow-none w-100">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Our Rooms -->
<div class="container mt-5 pt-4">
    <div class="text-center mb-5">
        <h2 class="fw-bold h-font">
            <i class="fas fa-bed me-2" style="color:var(--teal);"></i><?php echo lang('rooms'); ?>
        </h2>
        <p class="text-muted">Discover our luxurious rooms designed for your comfort</p>
    </div>
    <div class="row">
        <?php if(empty($rooms)): ?>
        <div class="col-12 empty-state">
            <i class="fas fa-door-closed"></i>
            <p>No rooms available at the moment.</p>
        </div>
        <?php else: ?>
        <?php foreach($rooms as $room): ?>
        <?php
            $rid = $room['id'];
            $thumb = $thumbnails[$rid] ?? ROOMS_IMG_PATH . 'thumbnail.jpg';
            $rating = $ratings[$rid] ?? 0;
            $login = Auth::isUserLoggedIn() ? 1 : 0;
        ?>
        <div class="col-lg-4 col-md-6 my-3">
            <div class="card room-card h-100">
                <img src="<?php echo $thumb; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($room['name']); ?>" loading="lazy">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($room['name']); ?></h5>
                    <p class="text-muted mb-3" style="font-size:14px;">
                        <i class="fas fa-moon me-1"></i><?php echo $room['price']; ?> <?php echo lang('per_night'); ?>
                    </p>

                    <?php if(!empty($features[$rid])): ?>
                    <div class="features mb-2">
                        <?php foreach($features[$rid] as $f): ?>
                        <span class="badge rounded-pill bg-light text-dark text-wrap border"><?php echo htmlspecialchars($f); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <div class="mb-2">
                        <small class="fw-bold text-muted text-uppercase">
                            <i class="fas fa-concierge-bell me-1"></i><?php echo lang('facilities'); ?>
                        </small><br>
                        <?php foreach($facilities[$rid] ?? [] as $f): ?>
                        <span class="badge rounded-pill bg-light text-dark text-wrap border"><?php echo htmlspecialchars($f['name']); ?></span>
                        <?php endforeach; ?>
                    </div>

                    <div class="mb-3">
                        <small class="fw-bold text-muted text-uppercase">
                            <i class="fas fa-users me-1"></i><?php echo lang('guests'); ?>
                        </small><br>
                        <span class="badge rounded-pill text-bg-light border">
                            <i class="fas fa-user me-1"></i><?php echo $room['adult']; ?> Adults
                        </span>
                        <span class="badge rounded-pill text-bg-light border">
                            <i class="fas fa-child me-1"></i><?php echo $room['children']; ?> Children
                        </span>
                    </div>

                    <?php if($rating > 0): ?>
                    <div class="mb-3">
                        <?php for($i=0; $i<round($rating); $i++): ?>
                        <i class="fas fa-star text-warning"></i>
                        <?php endfor; ?>
                        <small class="text-muted ms-1">(<?php echo $rating; ?>)</small>
                    </div>
                    <?php endif; ?>

                    <div class="d-flex gap-2 mt-3">
                        <button onclick="checkLoginToBook(<?php echo $login; ?>,<?php echo $rid; ?>)"
                                class="btn btn-sm text-white custom-bg shadow-none flex-fill">
                            <i class="fas fa-calendar-check me-1"></i><?php echo lang('book_now'); ?>
                        </button>
                        <a href="<?php echo SITE_URL; ?>room/<?php echo $rid; ?>"
                           class="btn btn-sm btn-outline-dark shadow-none flex-fill">
                            <i class="fas fa-eye me-1"></i><?php echo lang('room_details'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <div class="col-lg-12 text-center mt-4">
            <a href="<?php echo SITE_URL; ?>rooms" class="btn btn-outline-dark rounded-0 fw-bold shadow-none">
                <i class="fas fa-th-list me-2"></i>More Rooms
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Facilities -->
<div class="container mt-5 pt-4">
    <div class="text-center mb-5">
        <h2 class="fw-bold h-font">
            <i class="fas fa-concierge-bell me-2" style="color:var(--teal);"></i><?php echo lang('facilities'); ?>
        </h2>
        <p class="text-muted">Everything you need for a perfect stay</p>
    </div>
    <div class="row justify-content-evenly">
        <?php foreach($facilitiesList as $fac): ?>
        <div class="col-lg-2 col-md-3 col-6 text-center bg-white rounded shadow py-4 my-3">
            <img src="<?php echo FACILITIES_IMG_PATH . htmlspecialchars($fac['icon']); ?>"
                 width="60" alt="<?php echo htmlspecialchars($fac['name']); ?>" loading="lazy">
            <h6 class="mt-3"><?php echo htmlspecialchars($fac['name']); ?></h6>
        </div>
        <?php endforeach; ?>
        <div class="col-lg-12 text-center mt-4">
            <a href="<?php echo SITE_URL; ?>facilities" class="btn btn-outline-dark rounded-0 fw-bold shadow-none">
                <i class="fas fa-plus me-2"></i>Know More
            </a>
        </div>
    </div>
</div>

<!-- Testimonials -->
<div class="container mt-5 pt-4">
    <div class="text-center mb-5">
        <h2 class="fw-bold h-font">
            <i class="fas fa-quote-left me-2" style="color:var(--teal);"></i>Testimonials
        </h2>
        <p class="text-muted">What our guests say about us</p>
    </div>
    <?php if(empty($testimonials)): ?>
    <div class="empty-state"><i class="fas fa-comment-slash"></i><p>No reviews yet.</p></div>
    <?php else: ?>
    <div class="swiper swiper-testimonials">
        <div class="swiper-wrapper mb-5">
            <?php foreach($testimonials as $review): ?>
            <div class="swiper-slide bg-white p-4 rounded-3 shadow-sm">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                         style="width:48px;height:48px;background:var(--teal);color:#fff;font-size:20px;">
                        <i class="fas fa-user"></i>
                    </div>
                    <h6 class="mb-0"><?php echo htmlspecialchars($review['uname']); ?></h6>
                </div>
                <p class="text-muted mb-3"><?php echo htmlspecialchars($review['review']); ?></p>
                <div>
                    <?php for($i=0; $i<(int)$review['rating']; $i++): ?>
                    <i class="fas fa-star text-warning"></i>
                    <?php endfor; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <?php endif; ?>
</div>

<!-- Reach Us -->
<div class="container mt-5 pt-4 mb-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold h-font">
            <i class="fas fa-map-marker-alt me-2" style="color:var(--teal);"></i>Reach Us
        </h2>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded-3">
            <iframe src="<?php echo htmlspecialchars($contact['iframe'] ?? ''); ?>"
                    class="w-100 rounded" height="320" title="Map" loading="lazy"></iframe>
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="bg-white p-4 rounded-3 mb-4 shadow">
                <h5><i class="fas fa-phone me-2" style="color:var(--teal);"></i>Call us</h5>
                <?php if(!empty($contact['pn1'])): ?>
                <a href="tel:+<?php echo htmlspecialchars($contact['pn1']); ?>"
                   class="d-block mb-2 text-decoration-none text-dark">
                    <i class="fas fa-phone-alt me-2"></i>+<?php echo htmlspecialchars($contact['pn1']); ?>
                </a>
                <?php endif; ?>
                <?php if(!empty($contact['pn2'])): ?>
                <a href="tel:+<?php echo htmlspecialchars($contact['pn2']); ?>"
                   class="d-block mb-2 text-decoration-none text-dark">
                    <i class="fas fa-phone-alt me-2"></i>+<?php echo htmlspecialchars($contact['pn2']); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require BASE_PATH . '/views/layouts/footer.php'; ?>

<script>
// Hero Swiper
new Swiper('.swiper-hero', {
    effect:'fade', loop:true,
    autoplay:{delay:3500, disableOnInteraction:false},
    navigation:{nextEl:'.swiper-button-next', prevEl:'.swiper-button-prev'},
    pagination:{el:'.swiper-pagination', clickable:true}
});

// Testimonials Swiper
new Swiper('.swiper-testimonials', {
    effect:'coverflow', grabCursor:true, centeredSlides:true, loop:true,
    coverflowEffect:{rotate:50, stretch:0, depth:100, modifier:1, slideShadows:false},
    pagination:{el:'.swiper-pagination'},
    breakpoints:{320:{slidesPerView:1}, 768:{slidesPerView:2}, 1024:{slidesPerView:3}}
});

// Date validation
document.getElementById('avail-form')?.addEventListener('submit', function(e){
    const today = new Date().toISOString().split('T')[0];
    const ci = document.getElementById('home_checkin').value;
    const co = document.getElementById('home_checkout').value;
    if(ci < today){ e.preventDefault(); alert('error','Check-in cannot be in the past!'); return; }
    if(co <= ci){ e.preventDefault(); alert('error','Check-out must be after check-in!'); return; }
});
</script>
