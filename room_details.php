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


    <title>ROOMS DETAILS</title>


</head>

<body class="bg-light">
      
  <?php require('inc/header1.php');
  ?>


    <?php
      if(!isset($_GET['id'])){
        redirect('rooms.php');
      }
      $data=filteration($_GET);
      $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?",[$data['id'],1,0],'iii');

      if(mysqli_num_rows($room_res)==0){
        redirect('rooms.php');
      }
      $room_data = mysqli_fetch_assoc($room_res);


    ?>


      <!-- START HEADER -->

      
      <!-- END HEADER -->

      
      
        <div class="container">
        <div class="row">
          <div class="col-12 my-5 mb-5 px-4">
            <h2 class="fw-bold"><?php echo $room_data['name'] ?></h2>
            <div style="font-size=:14px;">
              <a href="hotel.php" class="text-secondary text-decoration-none">HOME</a>
              <span class="text-secondary"> > </span>
              <a href="rooms.php" class="text-secondary text-decoration-none">ROOMS</a>
            </div>
            <hr>
          </div>
          <div class="col-lg-7 col-md-12 px-4" >
                <div id="roomCarousel" class="carousel slide">
                    <div class="carousel-inner">

                    <?php
                        //get thumbnail of images

                      $room_img = ROOMS_IMG_PATH."thumbnail.jpg";
                      $img_q=mysqli_query($con,"SELECT * FROM `room_images`
                      WHERE room_id='$room_data[id]'");

                      if(mysqli_num_rows($img_q)>0){

                        $active_class='active';
                        while($img_res = mysqli_fetch_assoc($img_q)){
                          echo " 
                          <div class='carousel-item $active_class'>
                            <img src='".ROOMS_IMG_PATH.$img_res['image']."' class='d-block w-100 rounded'>
                          </div>";
                          $active_class='';
                        }
                        
                      }
                      else{
                        echo "<div class='carousel-item active'>
                                <img src='$room_img' class='d-block w-100'>
                              </div>";
                        }
                    
                    ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                    </button>
                  </div>
          </div>
          <div class="col-lg-5 col-md-12 px-4">
              <div class="card mb-4 border-0 shadow-sm rounded-3">
                <div class="card-body">
                  <?php
                    echo<<<price
                      <h4>$$room_data[price] per night</h4>
                    price;

                    $rating_q="SELECT AVG(rating) AS `avg_rating` FROM `rating_review` WHERE `room_id`=$room_data[id]
                    
                    ORDER BY `sr_no`DESC LIMIT 20";

                    $rating_res=mysqli_query($con,$rating_q);
                    $rating_fetch=mysqli_fetch_assoc($rating_res);
                    $rating_data="<i class='bi bi-star-fill text-warning'> </i>";
                    if($rating_fetch['avg_rating']!=NULL){
                      for($i=1;$i<$rating_fetch['avg_rating'];$i++){
                        $rating_data.="   <i class='bi bi-star-fill text-warning'> </i>";
                      }
                      
                    }

                    echo<<<rating
                    <div class="mb-3">
                      $rating_data
                    </div>
                    rating;

                    $feq_q=mysqli_query($con,"SELECT f.name FROM `features` f
                      INNER JOIN `room_features` rfea ON f.id = rfea.features_id
                      WHERE rfea.room_id= '$room_data[id]'");
      
                      $features_data="";
                      while($fea_row = mysqli_fetch_assoc($feq_q)){
                        $features_data .="<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                        $fea_row[name]
                        </span>";}

                        echo<<<features
                        <div class="mb-3">
                          <h6 class="mb-1">Features</h6>
                            $features_data
                        </div>
                        features;
                    
                    $fac_q=mysqli_query($con,"SELECT f.name FROM `facilities` f
                    INNER JOIN `room_facilities` rfec ON f.id = rfec.facilities_id
                    WHERE rfec.room_id= '$room_data[id]'");
    
                    $facilities_data="";
                    while($fea_row = mysqli_fetch_assoc($fac_q)){
                      $facilities_data .="<span class='badge rounded-pill bg-light text-dark text-wrap me- mb-1'>
                      $fea_row[name]
                      </span>";
                    }
                    $login=0;
                    $book_btn="";
                  if(isset($_SESSION['login']) && $_SESSION['login']==true){
                    $login=1;
                  }
                    $book_btn="<button onclick='checkLoginToBook($login,$room_data[id])' class='btn w-100 text-white custom-bg shadow-none mb-1'>Book Now</button>";
                    echo<<<facilities
                        <div class="mb-3">
                          <h6 class="mb-1">Facilities</h6>
                            $facilities_data
                        </div>
                    facilities;

                    echo<<<guests
                      <div class="mb-3">
                          <h6 class="mb-1">Guests </h6>
                          <span class="badge rounded-pill text-bg-light text-dark  text-wrap">
                            $room_data[adult] Adults 
                          </span>
                            <span class="badge rounded-pill text-bg-light text-dark  text-wrap">
                              $room_data[children]  Childern
                            </span>
                      </div>
                    guests;

                    echo<<<area
                      <div class="mb-3">
                        <h6 class="mb-1">Area</h6>
                        <span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                          $room_data[area] </span>
                      </div>
                    area;
                    echo<<<book
                      $book_btn
                    book;





                  ?>
                </div>

              </div>
          </div>

          <!-- START MORE ROOMS -->
          <div class="mt-4 col-12 px-4">
                    <div class="mb-5">
                      <h5>Description</h5>
                      <p>
                        <?php echo $room_data['description'] ?>
                        
                      </p>
                    </div>
                    <div>
                      <h5 class="mb-3">Review $ Rating</h5>

                      <?php

                            $review_q="SELECT rr.*,uc.name AS uname,r.name AS rname FROM `rating_review` rr
                            INNER JOIN `user_cred` uc ON rr.user_id=uc.id
                            INNER JOIN `rooms` r ON rr.room_id=r.id
                            WHERE rr.room_id='$room_data[id]'
                            ORDER BY `sr_no` DESC LIMIT 15";

                            $review_res=mysqli_query($con,$review_q);
                            if(mysqli_num_rows($review_res)==0){
                              echo 'No reviews Yet';
                            }
                            else{
                              while($row = mysqli_fetch_assoc($review_res)){
                                $stars="<i class='bi bi-star-fill text-warning'></i>";
                                  for($i=1;$i<$row['rating'];$i++){
                                    $stars.="<i class='bi bi-star-fill text-warning'></i>";
                                  }
                                echo<<<reviews

                                <div class='mb-4'>
                                  <div class="d-flex alighn-items-center mb-2">
                                      <h6 class="m-0 ms-2">$row[uname]</h6>
                                  </div>
                                    <p class='mb-1'>$row[review]</p>
                                      <div>
                                        $stars
                                      </div>
                                    </div>
                                  
                                reviews;
                              }
                            }
                            
                      ?>
                      
          <!-- END MORE ROOMS -->


        </div>
      </div>

      <!-- START FOOTER -->

      <?php require('inc/footer.php');?>

      <!-- END FOOTER -->



</body>
</html>