<!DOCTYPE html>
<html lang="<?php echo ($_SESSION['lang'] ?? 'ar') === 'en' ? 'en' : 'ar'; ?>"
      dir="<?php echo ($_SESSION['lang'] ?? 'ar') === 'en' ? 'ltr' : 'rtl'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <style>
        .room-carousel img { height:380px; object-fit:cover; width:100%; border-radius:12px; }
        .review-card { border-left:3px solid var(--teal); padding-left:12px; }
        .info-card   { border-radius:16px; }
        .price-tag   { font-size:1.6rem; font-weight:700; color:var(--teal); }
    </style>
    <title>Vana Hotel — <?php echo lang('room_details'); ?></title>
</head>
<body class="bg-light">

<?php
require('inc/header1.php');

if(!isset($_GET['id'])) redirect('rooms.php');
$data     = filteration($_GET);
$room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?",
                   [$data['id'], 1, 0], 'iii');
if(mysqli_num_rows($room_res)==0) redirect('rooms.php');
$room_data = mysqli_fetch_assoc($room_res);
$rid = $room_data['id'];

// Bulk queries — no N+1
$img_res  = select("SELECT image, thumb FROM `room_images` WHERE room_id=? ORDER BY thumb DESC", [$rid], 'i');
$feat_res = select("SELECT f.name FROM `features` f INNER JOIN `room_features` rfea ON f.id=rfea.features_id WHERE rfea.room_id=?", [$rid], 'i');
$fac_res  = select("SELECT f.name FROM `facilities` f INNER JOIN `room_facilities` rfec ON f.id=rfec.facilities_id WHERE rfec.room_id=?", [$rid], 'i');
$rating_r = mysqli_fetch_assoc(select("SELECT AVG(rating) AS avg, COUNT(*) AS total FROM `rating_review` WHERE room_id=?", [$rid], 'i'));
$review_r = select("SELECT rr.review, rr.rating, uc.name AS uname FROM `rating_review` rr
                    INNER JOIN `user_cred` uc ON rr.user_id=uc.id
                    WHERE rr.room_id=? ORDER BY rr.sr_no DESC LIMIT 15", [$rid], 'i');

$login    = (isset($_SESSION['login']) && $_SESSION['login']==true) ? 1 : 0;
$book_btn = "<button onclick='checkLoginToBook($login,$rid)'
                class='btn w-100 text-white custom-bg shadow-none'>
                <i class='bi bi-calendar-check me-2'></i>" . lang('book_now') . "
             </button>";

// Stars
$stars = '';
if(!empty($rating_r['avg'])){
    for($i=0; $i<round($rating_r['avg']); $i++)
        $stars .= "<i class='bi bi-star-fill text-warning'></i>";
}

// Features & facilities badges
$features_html = $facilities_html = '';
while($r = mysqli_fetch_assoc($feat_res))
    $features_html .= "<span class='badge rounded-pill bg-light text-dark border me-1 mb-1'>{$r['name']}</span>";
while($r = mysqli_fetch_assoc($fac_res))
    $facilities_html .= "<span class='badge rounded-pill bg-light text-dark border me-1 mb-1'>{$r['name']}</span>";
?>

<div class="container my-5">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="hotel.php" class="text-decoration-none"><?php echo lang('home'); ?></a></li>
            <li class="breadcrumb-item"><a href="rooms.php" class="text-decoration-none"><?php echo lang('rooms'); ?></a></li>
            <li class="breadcrumb-item active"><?php echo htmlspecialchars($room_data['name']); ?></li>
        </ol>
    </nav>

    <div class="row g-4">

        <!-- Left: Image carousel -->
        <div class="col-lg-7">
            <div id="roomCarousel" class="carousel slide shadow-sm rounded-3 overflow-hidden" data-bs-ride="carousel">
                <div class="carousel-inner room-carousel">
                <?php
                    $imgs = [];
                    while($r = mysqli_fetch_assoc($img_res)) $imgs[] = $r;
                    if(empty($imgs)){
                        echo "<div class='carousel-item active'>
                                <img src='" . ROOMS_IMG_PATH . "thumbnail.jpg'
                                     class='d-block w-100' alt='" . htmlspecialchars($room_data['name']) . "' loading='lazy'>
                              </div>";
                    } else {
                        foreach($imgs as $i => $img){
                            $active = ($i===0) ? 'active' : '';
                            echo "<div class='carousel-item $active'>
                                    <img src='" . ROOMS_IMG_PATH . htmlspecialchars($img['image']) . "'
                                         class='d-block w-100 lazy' alt='" . htmlspecialchars($room_data['name']) . "' loading='lazy'>
                                  </div>";
                        }
                    }
                ?>
                </div>
                <?php if(count($imgs) > 1): ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                <?php endif; ?>
            </div>

            <!-- Description -->
            <?php if(!empty($room_data['description'])): ?>
            <div class="card border-0 shadow-sm rounded-3 mt-4 p-4">
                <h5 class="fw-bold mb-3">Description</h5>
                <p class="text-muted mb-0"><?php echo nl2br(htmlspecialchars($room_data['description'])); ?></p>
            </div>
            <?php endif; ?>

            <!-- Reviews -->
            <div class="card border-0 shadow-sm rounded-3 mt-4 p-4">
                <h5 class="fw-bold mb-4">
                    Reviews &amp; Ratings
                    <?php if(!empty($rating_r['total'])): ?>
                    <span class="badge bg-light text-dark border ms-2" style="font-size:13px;">
                        <?php echo $rating_r['total']; ?> reviews
                    </span>
                    <?php endif; ?>
                </h5>
                <?php
                $reviews = [];
                while($r = mysqli_fetch_assoc($review_r)) $reviews[] = $r;
                if(empty($reviews)){
                    echo "<div class='empty-state py-4'>
                            <i class='bi bi-chat-square-heart'></i>
                            <p>No reviews yet. Be the first!</p>
                          </div>";
                } else {
                    foreach($reviews as $row){
                        $s = str_repeat("<i class='bi bi-star-fill text-warning'></i>", (int)$row['rating']);
                        echo "<div class='review-card mb-4'>
                                <div class='d-flex align-items-center mb-1'>
                                    <i class='bi bi-person-circle me-2 text-muted'></i>
                                    <strong>" . htmlspecialchars($row['uname']) . "</strong>
                                </div>
                                <p class='text-muted mb-1 small'>" . htmlspecialchars($row['review']) . "</p>
                                <div>$s</div>
                              </div>";
                    }
                }
                ?>
            </div>
        </div>

        <!-- Right: Info & booking -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm info-card p-4 sticky-top" style="top:80px;">

                <div class="price-tag mb-1"><?php echo $room_data['price']; ?></div>
                <p class="text-muted mb-3 small"><?php echo lang('per_night'); ?></p>

                <?php if($stars): ?>
                <div class="mb-3"><?php echo $stars; ?>
                    <?php if(!empty($rating_r['avg'])): ?>
                    <span class="text-muted small ms-1">(<?php echo round($rating_r['avg'],1); ?>)</span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Guests & Area -->
                <div class="d-flex flex-wrap gap-2 mb-3">
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

                <?php if($features_html): ?>
                <div class="mb-3">
                    <small class="fw-bold text-muted text-uppercase d-block mb-1">Features</small>
                    <?php echo $features_html; ?>
                </div>
                <?php endif; ?>

                <?php if($facilities_html): ?>
                <div class="mb-4">
                    <small class="fw-bold text-muted text-uppercase d-block mb-1"><?php echo lang('facilities'); ?></small>
                    <?php echo $facilities_html; ?>
                </div>
                <?php endif; ?>

                <hr>
                <?php echo $book_btn; ?>
                <p class="text-muted small text-center mt-2 mb-0">
                    <i class="bi bi-shield-check me-1"></i>Free cancellation before check-in
                </p>

            </div>
        </div>

    </div>
</div>

<?php require('inc/footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>
</html>
