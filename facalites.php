<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- LINKS -->


  <?php require('inc/links.php') ?>
  <style>
    .pop:hover{
      cursor: pointer;
      border-top-color:#2ec1ac !important;
      transform:scale(1.03);
      transition: all 0.3s;
    }
  </style>
  
  
    <!-- swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>


    <title>HOTEL - FACILITIES</title>


</head>

<body class="bg-light">


      <!-- START HEADER -->

      <?php require('inc/header1.php')
      
      ?>
      <!-- END HEADER -->
      <div class="my-5 px-4">
        <h2 class="fw-bold f-font text-center">OUR FACILITIES</h2>
        <hr>
        <p class="text-center mt-3">The Hyatt Regency Hotel features a state-of-the-art fitness center, a tranquil on-site spa offering rejuvenating treatments, <br>and versatile meeting and event spaces to accommodate gatherings of all sizes. Guests can indulge in the culinary delights of the hotel's signature restaurant,<br> which showcases inventive global cuisine, or socialize over expertly-crafted cocktails in the chic bar and lounge. Throughout the stay, the attentive and knowledgeable staff will cater to the guests' every need, ensuring an unforgettable experience.</p>
      </div>
      <div class="container">
        <div class="row">
          <?php
            $res=selectAll('facilities');
            $path=FACILITIES_IMG_PATH;
            while($row=mysqli_fetch_assoc($res)){
              echo<<<data

              <div class="col-lg-4 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
                    <div class="d-flex align-items-center mb-2">
                      <img src="$path$row[icon]" width="40px">
                      <h5 class="m-0 ms-3">$row[name]</h5>               
                    </div>
                  <p>$row[description]</p>
                </div>
              </div>

              data;
            }
          ?>
        </div>
      </div>

      <!-- START FOOTER -->

      <?php require('inc/footer.php');?>

      <!-- END FOOTER -->



</body>
</html>