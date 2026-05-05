<!DOCTYPE html>
<html lang="<?php echo ($_SESSION['lang'] ?? 'ar') === 'en' ? 'en' : 'ar'; ?>"
      dir="<?php echo ($_SESSION['lang'] ?? 'ar') === 'en' ? 'ltr' : 'rtl'; ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php') ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <title>Vana Hotel</title>
</head>

<body class="bg-light">

    <?php require('inc/header1.php'); ?>

    <!-- Swiper carousel -->
    <div class="container-fluid px-lg-4 mt-4">
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
              <?php
                $res = selectAll('carousel');
                while($row = mysqli_fetch_assoc($res)){
                    $path = CAROUSEL_IMG_PATH;
                    echo "<div class='swiper-slide'>
                            <img src='{$path}{$row['image']}' class='w-100 d-block rounded-3'
                                 alt='Vana Hotel' loading='lazy'>
                          </div>";
                }
              ?>
            </div>
        </div>
    </div>

    <!-- Check availability form -->
    <div class="container availability-form">
        <div class="row">
            <div class="col-lg-12 bg-white shadow p-4 rounded">
                <h5 class="mb-4"><?php echo lang('check_in'); ?> / <?php echo lang('check_out'); ?></h5>
                <form action="rooms.php" id="avail-form">
                    <div class="row align-items-end">
                        <div class="col-lg-3 mb-3">
                            <label class="form-label fw-500"><?php echo lang('check_in'); ?></label>
                            <input type="date" class="form-control shadow-none" name="checkin" id="home_checkin" required>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label fw-500"><?php echo lang('check_out'); ?></label>
                            <input type="date" class="form-control shadow-none" name="checkout" id="home_checkout" required>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label fw-500">Adult</label>
                            <select class="form-select shadow-none select" name="adult">
                              <?php
                                $guests_q   = mysqli_query($con,"SELECT MAX(adult) AS max_adult, MAX(children) AS max_children FROM `rooms` WHERE `status`='1' AND `removed`='0'");
                                $guests_res = mysqli_fetch_assoc($guests_q);
                                for($i=1; $i<=$guests_res['max_adult']; $i++)
                                    echo "<option value='$i'>$i</option>";
                              ?>
                            </select>
                        </div>
                        <div class="col-lg-2 mb-3">
                            <label class="form-label fw-500">Children</label>
                            <select class="form-select shadow-none select" name="children">
                              <?php
                                for($i=1; $i<=$guests_res['max_children']; $i++)
                                    echo "<option value='$i'>$i</option>";
                              ?>
                            </select>
                        </div>
                        <input type="hidden" name="check_availablity">
                        <div class="col-lg-1 mb-lg-3 mt-2">
                            <button type="submit" class="btn text-white custom-bg shadow-none">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Our Rooms -->
    <h2 class="mt-5 pt-4 text-center fw-bold h-font"><?php echo lang('rooms'); ?></h2>
    <div class="container">
        <div class="row">
        <?php
            $room_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=? ORDER BY `id` DESC LIMIT 3", [1,0], 'ii');
            $has_rooms = false;
            while($room_data = mysqli_fetch_assoc($room_res)){
                $has_rooms = true;

                $feq_q = mysqli_query($con,"SELECT f.name FROM `features` f
                    INNER JOIN `room_features` rfea ON f.id=rfea.features_id
                    WHERE rfea.room_id='$room_data[id]'");
                $features_data = "";
                while($r = mysqli_fetch_assoc($feq_q))
                    $features_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap'>$r[name]</span> ";

                $fac_q = mysqli_query($con,"SELECT f.name FROM `facilities` f
                    INNER JOIN `room_facilities` rfec ON f.id=rfec.facilities_id
                    WHERE rfec.room_id='$room_data[id]'");
                $facilities_data = "";
                while($r = mysqli_fetch_assoc($fac_q))
                    $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap'>$r[name]</span> ";

                $room_thumb = ROOMS_IMG_PATH."thumbnail.jpg";
                $thumb_q = mysqli_query($con,"SELECT * FROM `room_images` WHERE room_id='$room_data[id]' AND `thumb`=1");
                if(mysqli_num_rows($thumb_q)>0){
                    $thumb_res  = mysqli_fetch_assoc($thumb_q);
                    $room_thumb = ROOMS_IMG_PATH.$thumb_res['image'];
                }

                $login    = (isset($_SESSION['login']) && $_SESSION['login']==true) ? 1 : 0;
                $book_btn = "<button onclick='checkLoginToBook($login,$room_data[id])'
                                class='btn btn-sm text-white custom-bg shadow-none flex-fill'>
                                ".lang('book_now')."
                             </button>";

                $rating_q     = select("SELECT AVG(rating) AS avg_rating FROM `rating_review` WHERE `room_id`=?", [$room_data['id']], 'i');
                $rating_fetch = mysqli_fetch_assoc($rating_q);
                $rating_data  = "";
                if(!empty($rating_fetch['avg_rating'])){
                    $stars = "";
                    for($i=0; $i<round($rating_fetch['avg_rating']); $i++)
                        $stars .= "<i class='bi bi-star-fill text-warning'></i>";
                    $rating_data = "<div class='mb-3'><small class='text-muted'>Rating</small><br>$stars</div>";
                }

                echo "
                <div class='col-lg-4 col-md-6 my-3'>
                  <div class='card room-card'>
                    <img src='$room_thumb' class='card-img-top lazy' alt='$room_data[name]' loading='lazy'>
                    <div class='card-body p-4'>
                      <h5 class='fw-bold mb-1'>$room_data[name]</h5>
                      <p class='text-muted mb-3' style='font-size:14px;'>
                        <i class='bi bi-moon-stars me-1'></i>$room_data[price] ".lang('per_night')."
                      </p>
                      <div class='features mb-2'>$features_data</div>
                      <div class='facilities mb-2'>
                        <small class='fw-bold text-muted text-uppercase'>".lang('facilities')."</small><br>
                        $facilities_data
                      </div>
                      <div class='guests mb-3'>
                        <small class='fw-bold text-muted text-uppercase'>".lang('guests')."</small><br>
                        <span class='badge rounded-pill text-bg-light text-dark'>$room_data[adult] Adults</span>
                        <span class='badge rounded-pill text-bg-light text-dark'>$room_data[children] Children</span>
                      </div>
                      $rating_data
                      <div class='d-flex gap-2 mt-3'>
                        $book_btn
                        <a href='room_details.php?id=$room_data[id]' class='btn btn-sm btn-outline-dark shadow-none flex-fill'>".lang('room_details')."</a>
                      </div>
                    </div>
                  </div>
                </div>";
            }
            if(!$has_rooms){
                echo "<div class='col-12 empty-state'>
                        <i class='bi bi-door-closed'></i>
                        <p>No rooms available at the moment.</p>
                      </div>";
            }
        ?>
            <div class="col-lg-12 text-center mt-4">
                <a href="rooms.php" class="btn btn-outline-dark rounded-0 fw-bold shadow-none">More Rooms</a>
            </div>
        </div>
    </div>

    <!-- Our Facilities -->
    <h2 class="mt-5 pt-4 text-center fw-bold h-font"><?php echo lang('facilities'); ?></h2>
    <div class="container">
        <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
          <?php
            $res  = mysqli_query($con,"SELECT * FROM `facilities` ORDER BY `id` DESC LIMIT 5");
            $path = FACILITIES_IMG_PATH;
            while($row = mysqli_fetch_assoc($res)){
                echo "<div class='col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3'>
                        <img src='{$path}{$row['icon']}' width='60' alt='{$row['name']}' loading='lazy'>
                        <h5 class='mt-3'>$row[name]</h5>
                      </div>";
            }
          ?>
            <div class="col-lg-12 text-center mt-4">
                <a href="facalites.php" class="btn btn-outline-dark rounded-0 fw-bold shadow-none">Know More</a>
            </div>
        </div>
    </div>

    <!-- Testimonials -->
    <h2 class="mt-5 pt-4 text-center fw-bold h-font">TESTIMONIALS</h2>
    <div class="container mt-5">
        <div class="swiper swiper-testimonials">
            <div class="swiper-wrapper mb-5">
              <?php
                $review_q   = "SELECT rr.*, uc.name AS uname FROM `rating_review` rr
                               INNER JOIN `user_cred` uc ON rr.user_id=uc.id
                               ORDER BY rr.sr_no DESC LIMIT 6";
                $review_res = mysqli_query($con, $review_q);
                if(mysqli_num_rows($review_res)==0){
                    echo "<div class='empty-state'><i class='bi bi-chat-square-heart'></i><p>No reviews yet.</p></div>";
                } else {
                    while($row = mysqli_fetch_assoc($review_res)){
                        $stars = str_repeat("<i class='bi bi-star-fill text-warning'></i>", (int)$row['rating']);
                        echo "<div class='swiper-slide bg-white p-4 rounded shadow-sm'>
                                <h6 class='mb-2'>".htmlspecialchars($row['uname'])."</h6>
                                <p class='text-muted'>".htmlspecialchars($row['review'])."</p>
                                <div>$stars</div>
                              </div>";
                    }
                }
              ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="col-lg-12 text-center mt-4">
            <a href="about.php" class="btn btn-outline-dark rounded-0 fw-bold shadow-none">Know more</a>
        </div>
    </div>

    <!-- Reach Us -->
    <h2 class="mt-5 pt-4 text-center fw-bold h-font">REACH US</h2>
    <div class="container mb-5">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
                <iframe src="<?php echo htmlspecialchars($contact_r['iframe'] ?? ''); ?>"
                        class="w-100 rounded" height="320" title="Map" loading="lazy"></iframe>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="bg-white p-4 rounded mb-4 shadow">
                    <h5>Call us</h5>
                    <a href="tel:+<?php echo htmlspecialchars($contact_r['pn1'] ?? ''); ?>"
                       class="d-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> +<?php echo htmlspecialchars($contact_r['pn1'] ?? ''); ?>
                    </a>
                    <?php if(!empty($contact_r['pn2'])): ?>
                    <a href="tel:+<?php echo htmlspecialchars($contact_r['pn2']); ?>"
                       class="d-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> +<?php echo htmlspecialchars($contact_r['pn2']); ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php require('inc/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="./hotel.js"></script>

    <!-- Date validation for availability form -->
    <script>
    document.getElementById('avail-form')?.addEventListener('submit', function(e){
        const today    = new Date().toISOString().split('T')[0];
        const checkin  = document.getElementById('home_checkin').value;
        const checkout = document.getElementById('home_checkout').value;
        if(checkin < today){ e.preventDefault(); alert('error','Check-in cannot be in the past!'); return; }
        if(checkout <= checkin){ e.preventDefault(); alert('error','Check-out must be after check-in!'); return; }
    });
    </script>
</body>
</html>
