<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php 
  require('inc/links.php');
  ?>
  <style>
    .su{
      background-color: #279e8c;
      border-radius: 20px;
      padding:20px;
    }
    .si{
      background-color: red;
      border-radius: 20px;
      padding:20px;
    }
    .p{
      color:white;
    }
    a{
      color:red;
    }
    i{
      color:green
    }
  </style>

  
  
    <!-- swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>


    <title> BOOKING STATUS</title>


</head>

<body class="bg-light">
      
  <?php require('inc/header1.php');
  ?>



      <!-- START HEADER -->

      
      <!-- END HEADER -->

      
      
        <div class="container">
          <div class="row">

            <div class="col-12 my-5 mb-3 px-4">
              <h2 class="fw-bold">PAYMENT STATUS</h2>
              
            </div>
                  <?php
                    $frm_data = filteration($_GET);
                    if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){     
                      redirect('hotel.php');
                    }

                    $order_id = $_GET['order'];

// استعلام للحصول على معلومات الحجز
                  $booking_q = "SELECT * FROM `booking_order` WHERE order_id = ?";
                  $booking_res = select($booking_q, [$order_id], 's');


                    if ($booking_res && mysqli_num_rows($booking_res) > 0) {
                      $booking_fetch = mysqli_fetch_assoc($booking_res);
                      if (isset($booking_fetch['trans_status'])) {
                        if ($booking_fetch['trans_status'] == 'success') {
                            echo<<<data
                            <div class="col-12 pw-3 su">
                              <p class="fw-bold p">
                                <i class="bi bi-check-circle-fill"></i>
                                payment done! Booking succeful
                                <br><br>
                                <br><br>
                                <a href='bookings.php'>Go to Bookings</a>
                              </p>
                            </div>
                          data; 
                        }
                        elseif ($booking_fetch['trans_status'] == 'failed'){
                          echo<<<data
                            <div class="col-12 pw-3 si">
                              <p class="fw-bold p">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                Insufficient balance. Please add funds to your account.
                                <br><br>
                                <br><br>
                              </p>
                            </div>
                          data;
                        }
                    }
                  }
                  
                    
                    
                  ?>

          </div>
      </div>

      <!-- START FOOTER -->

      <?php require('inc/footer.php');?>
      <!-- END FOOTER -->



</body>
</html>