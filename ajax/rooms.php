<?php
require_once '../admin/inc/db_config.php';
require_once '../admin/inc/essentials.php';
session_start();

if(!isset($_GET['fetch_rooms'])) exit;

// ── Date validation ──────────────────────────────────────────────────────────
$chk_avail    = json_decode($_GET['chk_avail'] ?? '{}', true);
$checkin_str  = $chk_avail['checkin']  ?? '';
$checkout_str = $chk_avail['checkout'] ?? '';

if($checkin_str !== '' && $checkout_str !== ''){
    $today    = new DateTime(date("Y-m-d"));
    $checkin  = new DateTime($checkin_str);
    $checkout = new DateTime($checkout_str);
    if($checkin >= $checkout || $checkin < $today){
        echo "<div class='empty-state'><i class='bi bi-calendar-x'></i><p>Invalid dates entered.</p></div>";
        exit;
    }
}

$guests       = json_decode($_GET['guests']       ?? '{}', true);
$facility_list= json_decode($_GET['facility_list'] ?? '{"facilities":[]}', true);
$adults       = max(0, (int)($guests['adults']   ?? 0));
$children     = max(0, (int)($guests['children'] ?? 0));

// ── #25 Fix N+1: fetch ALL features, facilities, thumbnails in 3 bulk queries ─
$room_res = select(
    "SELECT * FROM `rooms` WHERE adult>=? AND children>=? AND `status`=? AND `removed`=?",
    [$adults, $children, 1, 0], 'iiii'
);
if(!$room_res){ exit; }

// Collect all room IDs first
$rooms = [];
while($r = mysqli_fetch_assoc($room_res)) $rooms[] = $r;

if(empty($rooms)){
    echo "<div class='empty-state'><i class='bi bi-door-closed'></i><p>No rooms available.</p></div>";
    exit;
}

$ids        = array_column($rooms, 'id');
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$types      = str_repeat('i', count($ids));

// Bulk: features
$feat_map = [];
$fq = select("SELECT rfea.room_id, f.name FROM `features` f
              INNER JOIN `room_features` rfea ON f.id=rfea.features_id
              WHERE rfea.room_id IN ($placeholders)", $ids, $types);
while($r = mysqli_fetch_assoc($fq))
    $feat_map[$r['room_id']][] = $r['name'];

// Bulk: facilities (with id for filter)
$fac_map = [];
$fq2 = select("SELECT rfec.room_id, f.id, f.name FROM `facilities` f
               INNER JOIN `room_facilities` rfec ON f.id=rfec.facilities_id
               WHERE rfec.room_id IN ($placeholders)", $ids, $types);
while($r = mysqli_fetch_assoc($fq2))
    $fac_map[$r['room_id']][] = $r;

// Bulk: thumbnails
$thumb_map = [];
$tq = select("SELECT room_id, image FROM `room_images`
              WHERE room_id IN ($placeholders) AND `thumb`=1", $ids, $types);
while($r = mysqli_fetch_assoc($tq))
    $thumb_map[$r['room_id']] = $r['image'];

// Bulk: availability counts (only if dates provided)
$avail_map = [];
if($checkin_str !== '' && $checkout_str !== ''){
    $aq = select(
        "SELECT room_id, COUNT(*) AS total FROM `booking_order`
         WHERE booking_status='booked' AND room_id IN ($placeholders)
         AND check_out > ? AND check_in < ?
         GROUP BY room_id",
        array_merge($ids, [$checkin_str, $checkout_str]),
        $types . 'ss'
    );
    while($r = mysqli_fetch_assoc($aq))
        $avail_map[$r['room_id']] = (int)$r['total'];
}

// ── #26 Simple in-request cache key (avoids re-running same query) ────────────
$login    = (isset($_SESSION['login']) && $_SESSION['login'] == true) ? 1 : 0;
$output   = '';
$count    = 0;
$selected_facs = $facility_list['facilities'] ?? [];

foreach($rooms as $room){
    $rid = $room['id'];

    // Facility filter
    if(!empty($selected_facs)){
        $room_fac_ids = array_column($fac_map[$rid] ?? [], 'id');
        foreach($selected_facs as $sf){
            if(!in_array($sf, $room_fac_ids)) continue 2;
        }
    }

    // Availability filter
    if($checkin_str !== '' && $checkout_str !== ''){
        $booked = $avail_map[$rid] ?? 0;
        if(($room['quantity'] - $booked) <= 0) continue;
    }

    // Build badges
    $features_html = '';
    foreach($feat_map[$rid] ?? [] as $name)
        $features_html .= "<span class='badge rounded-pill bg-light text-dark text-wrap'>$name</span> ";

    $facilities_html = '';
    foreach($fac_map[$rid] ?? [] as $f)
        $facilities_html .= "<span class='badge rounded-pill bg-light text-dark text-wrap'>{$f['name']}</span> ";

    $thumb = isset($thumb_map[$rid])
        ? ROOMS_IMG_PATH . $thumb_map[$rid]
        : ROOMS_IMG_PATH . 'thumbnail.jpg';

    $book_btn = "<button onclick='checkLoginToBook($login,$rid)'
                    class='btn btn-sm w-100 text-white custom-bg shadow-none mb-2'>
                    " . lang('book_now') . "
                 </button>";

    $output .= "
        <div class='card room-card mb-4'>
            <div class='row g-0 p-3 align-items-center'>
                <div class='col-md-4 mb-lg-0 mb-3'>
                    <img src='$thumb' class='img-fluid rounded lazy' alt='{$room['name']}' loading='lazy'>
                </div>
                <div class='col-md-6 px-lg-3 px-md-3 px-0'>
                    <h5 class='mb-2 fw-bold'>{$room['name']}</h5>
                    <div class='features mb-2'>
                        <small class='fw-bold text-muted text-uppercase'>Features</small><br>
                        $features_html
                    </div>
                    <div class='facilities mb-2'>
                        <small class='fw-bold text-muted text-uppercase'>Facilities</small><br>
                        $facilities_html
                    </div>
                    <div class='guests'>
                        <small class='fw-bold text-muted text-uppercase'>Guests</small><br>
                        <span class='badge rounded-pill text-bg-light text-dark'>{$room['adult']} Adults</span>
                        <span class='badge rounded-pill text-bg-light text-dark'>{$room['children']} Children</span>
                    </div>
                </div>
                <div class='col-md-2 mt-lg-0 mt-4 text-center'>
                    <h6 class='mb-3'>{$room['price']} " . lang('per_night') . "</h6>
                    $book_btn
                    <a href='room_details.php?id=$rid' class='btn btn-sm w-100 btn-outline-dark shadow-none'>
                        " . lang('room_details') . "
                    </a>
                </div>
            </div>
        </div>";
    $count++;
}

if($count > 0){
    echo $output;
} else {
    echo "<div class='empty-state'>
            <i class='bi bi-search'></i>
            <p>No rooms match your filters.</p>
          </div>";
}
