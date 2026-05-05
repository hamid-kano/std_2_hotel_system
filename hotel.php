    <!DOCTYPE html>
    <html lang="en">
    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- LINKS -->


      <?php require('inc/links.php') ?>

        <!-- swiper -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    

        <title>HOTEL - HOME</title>


    </head>

    <body class="bg-light">
      <!-- START HEADER -->

          <?php require('inc/header1.php')
          
          ?>
          <!-- END HEADER -->


        <!-- end Modal register-->

        <!-- start Swiper -->

        <div class="container-fluid px-lg-4 mt-4 ">
            <div class="swiper swiper-container">
                <div class="swiper-wrapper">
                  <?php
                    $res=selectAll('carousel');
                    while($row=mysqli_fetch_assoc($res)){
                      $path=CAROUSEL_IMG_PATH;
          
                      echo <<<data
                      <div class="swiper-slide">
                        <img src="$path$row[image]" class="w-100 d-block rounded-3"/>
                      </div>
                      data;
                  }
                  ?>
                </div>
              </div>
        </div>

        <!-- end Swiper -->

        <!-- Start check availability form -->

        <div class="container availability-form">
            <div class="row">
                <div class="col-lg-12 bg-white shadow p-4 rounded">
                    <h5 class="mb-4">Check Booking availability </h5>
                    <form action="rooms.php">
                        <div class="row align-items-end">

                            <div class="col-lg-3 mb-3">
                                <label class="form-label" style="font-weight:500;">Check in</label>
                                <input type="date" class="form-control shadow-none" name="checkin" required>
                            </div>

                            <div class="col-lg-3 mb-3">
                                <label class="form-label" style="font-weight:500;">Check out</label>
                                <input type="date" class="form-control shadow-none" name="checkout" required>
                            </div>

                            <div class="col-lg-3 mb-3">
                                <label class="form-label" style="font-weight:500;">Adult</label>
                                <select class="form-select shadow-none select" name="adult">
                                  <?php
                                    $guests_q=mysqli_query($con,"SELECT MAX(adult) AS `max_adult` ,MAX(children) AS `max_children` FROM `rooms` WHERE `status`='1' AND `removed`='0'");

                                    $guests_res=mysqli_fetch_assoc($guests_q);
                                    for($i=1;$i<=$guests_res['max_adult'];$i++){  
                                      echo"<option value='$i'>$i</option>";

                                    }
                                  ?>
                                    
                                  </select>
                            </div>

                            <div class="col-lg-2 mb-3">
                                <label class="form-label" style="font-weight:500;">Childern</label>
                                <select class="form-select shadow-none select" name="children">
                                  <?php
                                  for($i=1;$i<=$guests_res['max_children'];$i++){  
                                    echo"<option value='$i'>$i</option>";

                                  }
                                  ?>
                                
                                  </select>
                            </div>
                            <input type="hidden" name="check_availablity">

                            <div class="col-lg-1 mb-lg-3 mt-2">
                                <button type="submit" class="btn text-white shodow-none custom-bg">Submit</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- End check avilabilty form -->

        <!-- start our rooms -->

        <h2 class="mt-5 pt-4 text-center fw-bold h-font">OUR ROOMS</h2>
        <div class="container">
          <div class="row">
          <?php
              $room_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=? ORDER BY `id` DESC LIMIT 3  ",[1,0],'ii');
              while($room_data = mysqli_fetch_assoc($room_res)){
                // get faetures of room
                $feq_q=mysqli_query($con,"SELECT f.name FROM `features` f
                INNER JOIN `room_features` rfea ON f.id = rfea.features_id
                WHERE rfea.room_id= '$room_data[id]'");

                $features_data="";
                while($fea_row = mysqli_fetch_assoc($feq_q)){
                  $features_data .="<span class='badge rounded-pill bg-light text-dark text-wrap'>
                  $fea_row[name]
                  </span>";
                }


                     // get facilities of room
                    $fac_q=mysqli_query($con,"SELECT f.name FROM `facilities` f
                    INNER JOIN `room_facilities` rfec ON f.id = rfec.facilities_id
                    WHERE rfec.room_id= '$room_data[id]'");
    
                    $facilities_data="";
                    while($fea_row = mysqli_fetch_assoc($fac_q)){
                      $facilities_data .="<span class='badge rounded-pill bg-light text-dark text-wrap'>
                      $fea_row[name]
                      </span>";
                    }

                    //get thumbnail of images

                    $room_thumb = ROOMS_IMG_PATH."thumbnail.jpg";
                    $thumb_q=mysqli_query($con,"SELECT * FROM `room_images`
                    WHERE room_id= '$room_data[id]' AND `thumb`=1");

                    if(mysqli_num_rows($thumb_q)>0){
                      $thumb_res = mysqli_fetch_assoc($thumb_q);
                      $room_thumb = ROOMS_IMG_PATH.$thumb_res['image'];
                    }
                    $login=0;
                    $book_btn="";
                if(isset($_SESSION['login']) && $_SESSION['login']==true){
                  $login=1;
                  
                }
                $book_btn="<button onclick='checkLoginToBook($login,$room_data[id])' class='btn btn-sm text-white custom-bg shadow-none'>Book Now</button>";
                $rating_q="SELECT AVG(rating) AS `avg_rating` FROM `rating_review` WHERE `room_id`=$room_data[id]
                
                ORDER BY `sr_no`DESC LIMIT 20";

                $rating_res=mysqli_query($con,$rating_q);
                $rating_fetch=mysqli_fetch_assoc($rating_res);
                $rating_data="";
                if($rating_fetch['avg_rating']!=NULL){
                  $rating_data = "<div class='rating mb-4'>
                  <h6 class='mb-1'>Rating</h6>
                  <span class='badge rounded-pill'>";
                  for($i=0;$i<$rating_fetch['avg_rating'];$i++){
                    $rating_data.="<i class='bi bi-star-fill text-warning'></i>";
                  }
                  $rating_data.="</span>
                  </div>";
                }


            echo<<<data
                <div class="col-lg-4 col-md-6 my-3">

                          <div class="card border-0 shadow" style="max-width: 350px; margin:auto">
                            <img src="$room_thumb" class="card-img-top">

                            <div class="card-body">
                                  <h5>$room_data[name]</h5>
                                  <h6 class="mb-4">$$room_data[price] per night</h6>

                                <div class="features mb-4">
                                  $features_data
                                </div>
                                <div class="facilities mb-4">
                                          <h6 class="mb-1">Facilities</h6>
                                        $facilities_data
                                </div>
                                <div class="guests mb-4">
                                    <h6 class="mb-1">Guests </h6>
                                    <span class="badge rounded-pill text-bg-light text-dark  text-wrap">
                                        $room_data[adult] Adults 
                                      </span>
                                      <span class="badge rounded-pill text-bg-light text-dark  text-wrap">
                                      $room_data[children]  Childern
                                      </span>
                                </div>
                                  $rating_data
                                  <div class="d-flex justify-content-evenly mb-2">
                                  $book_btn
                                    <a href="room_details.php?id=$room_data[id]" class="btn btn-sm btn-outline-dark shadow-none">More details</a>
                                  </div>
                              </div>

                            </div>
                </div>
            data;
              }
            ?>
            <div class="col-lg-12 text-center mt-5">
              <a href="rooms.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Rooms</a>
            </div>
          </div>
        </div>

        <!-- end our rooms -->

        <!-- START OUR FACILITIES -->

        <h2 class="mt-5 pt-4 text-center fw-bold h-font ">OUR FACILITIES</h2>
        <div class="container">
          <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
            <?php
                $res=mysqli_query($con,"SELECT * FROM `facilities` ORDER BY `id` DESC LIMIT 5 ");
                $path=FACILITIES_IMG_PATH;
                  while($row=mysqli_fetch_assoc($res)){
                    echo<<<data
                      <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                        <img src="$path$row[icon]" width="60px">
                        <h5 class="mt-3">$row[name]</h5>
                      </div>
                    data;
                  }
              ?>
            <div class="col-lg-12 text-center mt-5">
              <a href="facalites.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">Know More</a>
            </div>
          </div>
        </div>

        <!-- END OUR FACILITIES -->

        <!-- START TESTIMONIALS -->
        <h2 class="mt-5 pt-4 text-center fw-bold h-font ">TESTIMONIALS</h2>
        <div class="container mt-5">
            <!-- Swiper -->
            <div class="swiper swiper-testimonials">
              <div class="swiper-wrapper mb-5">

              <?php
              $review_q="SELECT rr.*,uc.name AS uname,r.name AS rname FROM `rating_review` rr
              INNER JOIN `user_cred` uc ON rr.user_id=uc.id
              INNER JOIN `rooms` r ON rr.room_id=r.id
              ORDER BY `sr_no` DESC LIMIT 6";
              $review_res=mysqli_query($con,$review_q);
              if(mysqli_num_rows($review_res)==0){
                echo 'NO reviews yet';

              }
              else{
                while($row=mysqli_fetch_assoc($review_res)){
                  $stars="<i class='bi bi-star-fill text-warning'> </i>";
                  for($i=1;$i<$row['rating'];$i++){
                    $stars.="<i class='bi bi-star-fill text-warning'> </i>";
                  }
                  echo<<<slides
                  <div class="swiper-slide bg-white p-4">
                    <div class="profile d-flex alighn-items-center mb-3">
                      <h6 class="m-0 ms-2">$row[uname]</h6>
                    </div>
                    <p>$row[review]</p>
                    <div class="rating">
                      $stars
                    </div>
                  </div>

                  slides;
                }
              }
              ?>

              </div>
              <div class="swiper-pagination"></div>
      </div>
              <div class="col-lg-12 text-center mt-5">
                <a href="about.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">Know more</a>
              </div>

      <!-- Swiper JS -->
        </div>

        <!-- END TESTIMONIALS -->

        <!-- START REACH US -->



        <h2 class="mt-5 pt-4 text-center fw-bold h-font ">REACH US</h2>
        <div class="container">
          <div class="row">
          <!-- ifram -->
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
              <iframe src="<?php echo $contact_r['iframe'] ?>" class="w-100 rounded" height="320"></iframe>
            </div>
          <!-- contacts -->
            <div class="col-lg-4 col-md-4">
              <div class="bg-white p-4 rounded mb-4 shadow">
                <h5>Call us</h5>
                <a href="tel: +<?php echo $contact_r['pn1'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                  <i class="bi bi-telephone-fill"></i> +<?php echo $contact_r['pn1'] ?>
                </a>
                <br>

                <?php
                if($contact_r['pn2']!=''){
                  echo<<<data
                  <a href="tel: +$contact_r[pn2]" class="d-inline-block mb-2 text-decoration-none text-dark">
                  <i class="bi bi-telephone-fill"></i> +$contact_r[pn2]
                  </a>
                  data;
                }
                ?>

              </div>
              <div class="bg-white p-4 rounded mb-4 shadow" >
                <h5>Follow us</h5>
                <?php
                if($contact_r['tw']!=''){
                  echo<<<data
                  <a href="$contact_r[tw]" class="d-inline-block mb-3 text-decoration-none text-dark">
                  <i class="bi bi-twitter me-1"></i> Twitter
                  </a> 
                  <br>
                  data;
                }
                ?>


                <a href="<?php echo $contact_r['fb']?>" class="d-inline-block mb-3 text-decoration-none text-dark">
                  <i class="bi bi-facebook me-1"></i> Facebook
                </a>
                <br>
                <a href="<?php echo $contact_r['insta']?>" class="d-inline-block mb-3 text-decoration-none text-dark">
                  <i class="bi bi-instagram me-1"></i>Instagram
                </a>
              </div>
            </div>

          </div>
        </div>

        <!-- END REACH US -->

        <!-- START FOOTER -->

                <?php require('inc/footer.php');?>

        <!-- END FOOTER -->











    <!-- start swiper -->

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- end swiper -->

    <!-- main js -->
    <script src="./hotel.js"></script>


    </body>
    </html>