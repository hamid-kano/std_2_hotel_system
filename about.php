<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- LINKS -->


  <?php require('inc/links.php') ?>

  <style>
    .box{
      cursor: pointer;
      border-top-color:#279e8c !important;
    }
  </style>
  
  
    <!-- swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>


    <title>HOTEL - ABOUT</title>


</head>

<body class="bg-light">


      <!-- START HEADER -->

      <?php require('inc/header1.php')
      
      ?>
      <!-- END HEADER -->
      <!-- title -->
      <div class="my-5 px-4">
        <h2 class="fw-bold f-font text-center">ABOUT US</h2>
        <hr>
        <p class="text-center mt-3">At our hotel, we aim to provide a comfortable and enjoyable stay for all our guests. Our experienced team is dedicated to consistently delivering the highest levels of service. We take pride in being the preferred destination for travelers seeking convenience and luxury in the heart of the city.</p>
      </div>
    <!-- sec1 -->
      <div class="container">
        <div class="row justify-content-between align-items-center">
          <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
            <h3 class="mb-3">Elevated Experiences at Our Prestigious Hotel</h3>
            <p>
            At our prestigious hotel, we are dedicated to exceeding the expectations of our discerning guests. Our seasoned hospitality professionals curate tailored experiences that capture the spirit of our vibrant location. As a preferred destination for luxury travelers, we take pride in delivering unparalleled service and exceptional accommodations.
              </p>
          </div>
          <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
            <img src="./images/about/about.jpg" class="w-100 rounded" >
          </div>
        </div>
      </div>
    <!-- sec2 -->
      <div class="container mt-5">
        <div class="row">
          <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
              <img src="./images/about/hotel.svg" width="70px">
              <h4 class="mt-3">100+ ROOMS</h4>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
              <img src="./images/about/rating.svg" width="70px">
              <h4 class="mt-3">150+ REVIEWS</h4>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
              <img src="./images/about/customers.svg" width="70px">
              <h4 class="mt-3">200+CUSTOMERS</h4>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
              <img src="./images/about/staff.svg" width="70px">
              <h4 class="mt-3">200+ STAFFS</h4>
            </div>
          </div>
          
        </div>
      </div>
      <!-- sec3 -->
      <h3 class="my-5 fw-bold h-font text-center">MANAGEMENT TEAM</h3>
      <div class="container px-4">
        <!-- Swiper -->
          <div class="swiper mySwiper">
          <div class="swiper-wrapper mb-5">
            <?php
            $about_r=selectAll('team_detalis3');
            $path=ABOUT_IMG_PATH;
            while($row=mysqli_fetch_assoc($about_r)){
              echo<<<data
              <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                <img src="$path$row[picture]" class="w-100">
                <h5 class="mt-2">$row[name]</h5>
              </div>
              data;

            }
            
            ?> 
    </div>
    <div class="swiper-pagination"></div>
  </div>
  </div>



      <!-- START FOOTER -->

      <?php require('inc/footer.php');?>

      <!-- END FOOTER -->



        <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper(".mySwiper", {
      spaceBetween:40,
      pagination: {
        el: ".swiper-pagination",
      },
      breakpoints:{
      320:{
        slidesPerView:1,
      },
      640:{
        slidesPerView:1,
      },
      768:{
        slidesPerView:3,
      },
      1024:{
        slidesPerView:3,
      },
    }
    });
  </script>
</body>
</html>