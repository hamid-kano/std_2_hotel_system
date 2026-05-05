<!DOCTYPE html>
<html lang="<?php echo ($_SESSION['lang'] ?? 'ar') === 'en' ? 'en' : 'ar'; ?>"
      dir="<?php echo ($_SESSION['lang'] ?? 'ar') === 'en' ? 'ltr' : 'rtl'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <title>Vana Hotel — <?php echo lang('booking_confirm'); ?></title>
    <style>
        .room-preview img { height:260px; object-fit:cover; width:100%; border-radius:12px; }
        .step-badge { background:var(--teal); color:#fff; border-radius:50%; width:28px; height:28px;
                      display:inline-flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; }
        .availability-status { border-radius:10px; padding:14px 16px; font-size:14px; }
    </style>
</head>
<body class="bg-light">

<?php
require('inc/header1.php');

// Auth & param guards
if(!isset($_GET['id'])) redirect('rooms.php');
if(!(isset($_SESSION['login']) && $_SESSION['login']==true)) redirect('rooms.php');

$data     = filteration($_GET);
$room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?",
                   [$data['id'], 1, 0], 'iii');
if(mysqli_num_rows($room_res)==0) redirect('rooms.php');

$room_data = mysqli_fetch_assoc($room_res);

$_SESSION['room'] = [
    'id'        => $room_data['id'],
    'name'      => $room_data['name'],
    'price'     => $room_data['price'],
    'payment'   => null,
    'available' => false,
];

$user_res  = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], 'i');
$user_data = mysqli_fetch_assoc($user_res);

// Room thumbnail (prepared statement)
$thumb_res = select("SELECT image FROM `room_images` WHERE room_id=? AND `thumb`=1 LIMIT 1",
                    [$room_data['id']], 'i');
$room_thumb = (mysqli_num_rows($thumb_res) > 0)
    ? ROOMS_IMG_PATH . mysqli_fetch_assoc($thumb_res)['image']
    : ROOMS_IMG_PATH . 'thumbnail.jpg';

// Rating
$rating_res   = select("SELECT AVG(rating) AS avg_rating FROM `rating_review` WHERE room_id=?",
                        [$room_data['id']], 'i');
$rating_fetch = mysqli_fetch_assoc($rating_res);
$stars = '';
if(!empty($rating_fetch['avg_rating'])){
    for($i=0; $i<round($rating_fetch['avg_rating']); $i++)
        $stars .= "<i class='bi bi-star-fill text-warning'></i>";
}
?>

<div class="container my-5">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="hotel.php" class="text-decoration-none"><?php echo lang('home'); ?></a></li>
            <li class="breadcrumb-item"><a href="rooms.php" class="text-decoration-none"><?php echo lang('rooms'); ?></a></li>
            <li class="breadcrumb-item active"><?php echo lang('booking_confirm'); ?></li>
        </ol>
    </nav>

    <div class="row g-4">

        <!-- Left: Room preview -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="room-preview">
                    <img src="<?php echo htmlspecialchars($room_thumb); ?>"
                         alt="<?php echo htmlspecialchars($room_data['name']); ?>" loading="lazy">
                </div>
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-1"><?php echo htmlspecialchars($room_data['name']); ?></h4>
                    <p class="text-muted mb-2">
                        <i class="bi bi-moon-stars me-1"></i>
                        <strong><?php echo $room_data['price']; ?></strong> <?php echo lang('per_night'); ?>
                    </p>
                    <?php if($stars): ?>
                    <div class="mb-2"><?php echo $stars; ?></div>
                    <?php endif; ?>
                    <div class="d-flex gap-2 flex-wrap mt-3">
                        <span class="badge bg-light text-dark border">
                            <i class="bi bi-people me-1"></i><?php echo $room_data['adult']; ?> Adults
                        </span>
                        <span class="badge bg-light text-dark border">
                            <i class="bi bi-person me-1"></i><?php echo $room_data['children']; ?> Children
                        </span>
                        <?php if(!empty($room_data['area'])): ?>
                        <span class="badge bg-light text-dark border">
                            <i class="bi bi-aspect-ratio me-1"></i><?php echo htmlspecialchars($room_data['area']); ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Booking form -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        <span class="step-badge me-2">1</span>
                        <?php echo lang('booking_confirm'); ?>
                    </h5>

                    <form action="pay_now.php" method="POST" id="booking_form">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-500"><?php echo lang('name'); ?></label>
                                <input type="text" name="name"
                                       value="<?php echo htmlspecialchars($user_data['name']); ?>"
                                       class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-500"><?php echo lang('phone'); ?></label>
                                <input type="text" name="phonenum"
                                       value="<?php echo htmlspecialchars($user_data['phonenum']); ?>"
                                       class="form-control shadow-none" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-500">Address</label>
                                <textarea name="address" rows="1" class="form-control shadow-none" required><?php echo htmlspecialchars($user_data['address']); ?></textarea>
                            </div>

                            <div class="col-12"><hr class="my-1"></div>

                            <div class="col-md-6">
                                <label class="form-label fw-500">
                                    <i class="bi bi-calendar-check me-1"></i><?php echo lang('check_in'); ?>
                                </label>
                                <input type="date" name="checkin" id="checkin_input"
                                       onchange="check_availability()"
                                       class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-500">
                                    <i class="bi bi-calendar-x me-1"></i><?php echo lang('check_out'); ?>
                                </label>
                                <input type="date" name="checkout" id="checkout_input"
                                       onchange="check_availability()"
                                       class="form-control shadow-none" required>
                            </div>

                            <!-- Availability status -->
                            <div class="col-12">
                                <div id="avail_loader" class="d-none text-center py-2">
                                    <div class="spinner-border spinner-border-sm text-info" role="status">
                                        <span class="visually-hidden">Checking...</span>
                                    </div>
                                    <span class="ms-2 text-muted small">Checking availability...</span>
                                </div>
                                <div id="avail_status" class="availability-status bg-light text-muted d-none"></div>
                            </div>

                            <!-- Summary box -->
                            <div class="col-12 d-none" id="summary_box">
                                <div class="p-3 rounded-3 border" style="background:rgba(46,193,172,.08);">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted small">Nights</span>
                                        <strong id="summary_nights">—</strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted small"><?php echo lang('total_price'); ?></span>
                                        <strong id="summary_total" style="color:var(--teal);">—</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-2">
                                <button name="pay_now" id="pay_btn" type="submit"
                                        class="btn w-100 text-white custom-bg shadow-none"
                                        disabled>
                                    <i class="bi bi-credit-card me-2"></i><?php echo lang('booking_confirm'); ?>
                                </button>
                                <p class="text-muted small text-center mt-2 mb-0">
                                    <i class="bi bi-shield-check me-1"></i>Secure booking
                                </p>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require('inc/footer.php'); ?>

<script>
const checkin_input  = document.getElementById('checkin_input');
const checkout_input = document.getElementById('checkout_input');
const avail_loader   = document.getElementById('avail_loader');
const avail_status   = document.getElementById('avail_status');
const summary_box    = document.getElementById('summary_box');
const pay_btn        = document.getElementById('pay_btn');

// Set min date to today
const today = new Date().toISOString().split('T')[0];
checkin_input.min  = today;
checkout_input.min = today;

checkin_input.addEventListener('change', () => {
    if(checkin_input.value) checkout_input.min = checkin_input.value;
});

function setStatus(msg, type){
    avail_status.className = `availability-status alert alert-${type}`;
    avail_status.innerHTML = msg;
    avail_status.classList.remove('d-none');
}

function check_availability(){
    const ci = checkin_input.value;
    const co = checkout_input.value;
    if(!ci || !co) return;

    // Client-side validation first
    if(ci >= co){ setStatus('<i class="bi bi-exclamation-circle me-1"></i>Check-out must be after check-in.', 'danger'); return; }
    if(ci < today){ setStatus('<i class="bi bi-exclamation-circle me-1"></i>Check-in cannot be in the past.', 'danger'); return; }

    avail_status.classList.add('d-none');
    summary_box.classList.add('d-none');
    pay_btn.disabled = true;
    avail_loader.classList.remove('d-none');

    let data = new FormData();
    data.append('check_availability', '');
    data.append('check_in',  ci);
    data.append('check_out', co);

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/confirm_booking.php', true);
    xhr.onload = function(){
        avail_loader.classList.add('d-none');
        try {
            const res = JSON.parse(this.responseText);
            if(res.status === 'available'){
                setStatus('<i class="bi bi-check-circle me-1"></i>Room is available!', 'success');
                document.getElementById('summary_nights').textContent = res.days + ' night(s)';
                document.getElementById('summary_total').textContent  = res.payment;
                summary_box.classList.remove('d-none');
                pay_btn.disabled = false;
            } else {
                const msgs = {
                    check_in_out_equal: 'Check-in and check-out cannot be the same day.',
                    check_out_earlier:  'Check-out must be after check-in.',
                    check_in_earlier:   'Check-in cannot be in the past.',
                    unavailable:        'Room is not available for these dates.'
                };
                setStatus('<i class="bi bi-x-circle me-1"></i>' + (msgs[res.status] || 'Please try different dates.'), 'danger');
            }
        } catch(e){ setStatus('Server error. Please try again.', 'danger'); }
    };
    xhr.onerror = () => { avail_loader.classList.add('d-none'); setStatus('Connection error.', 'danger'); };
    xhr.send(data);
}
</script>
</body>
</html>
