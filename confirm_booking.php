<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- LINKS -->
    <style>
    /* .pay_a{
      color: white;
      font-weight: bold;
      font-size: 20px;
      text-decoration: none;
      transition: 0.3s;

    }
    .btn_send1:hover{
      color: rgba(71, 66, 66, 0.384);
    } */
    </style>
<style>
    .pay_a {
      color: white;
      font-weight: bold;
      font-size: 20px;
      text-decoration: none;
      transition: 0.3s;
    }
    .btn_send1 {
      opacity: 0.6;
      cursor: not-allowed;
      transition: all 0.3s ease;
    }
    .btn_send1.active {
      opacity: 1;
      cursor: pointer;
      background-color: #007bff !important;
      color: white !important;
    }
    .btn_send1.active:hover {
      background-color: #0056b3 !important;
    }
</style>

  <?php require('inc/links.php') ?>

  
  
    <!-- swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>


    <title>CONFIRM BOOKING</title>


</head>

<body class="bg-light">
      
  <?php require('inc/header1.php');
  ?>


    <?php
      if(!isset($_GET['id'])){
        redirect('rooms.php');
      }
      elseif(!(isset($_SESSION['login']) && $_SESSION['login']==true)){     
        redirect('rooms.php');
      }
      $data=filteration($_GET);
      $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?",[$data['id'],1,0],'iii');

      if(mysqli_num_rows($room_res)==0){
        redirect('rooms.php');
      }
      $room_data = mysqli_fetch_assoc($room_res);

      $_SESSION['room']=[
        "id" => $room_data['id'],
        "name" => $room_data['name'],
        "price" => $room_data['price'],
        "payment"=>null,
        "available"=>false,
      ];

      $user_res = select("SELECT * FROM `user_cred` WHERE  `id`= ? LIMIT 1",[$_SESSION['uId'],],"i");
      $user_data=mysqli_fetch_assoc($user_res);


    ?>


      <!-- START HEADER -->

      
      <!-- END HEADER -->

      
      
        <div class="container">
          <div class="row">
            <div class="col-12 my-5 mb-5 px-4">
              <h2 class="fw-bold">confirm booking</h2>
              <div style="font-size=:14px;">
                <a href="hotel.php" class="text-secondary text-decoration-none">HOME</a>
                <span class="text-secondary"> > </span>
                <a href="rooms.php" class="text-secondary text-decoration-none">ROOMS</a>
                <span class="text-secondary"> > </span>
                <a href="rooms.php" class="text-secondary text-decoration-none">CONFIRM</a>
              </div>
              <hr>
            </div>
            <div class="col-lg-7 col-md-12 px-4">
              <?php
                $room_thumb = ROOMS_IMG_PATH."thumbnail.jpg";
                $thumb_q=mysqli_query($con,"SELECT * FROM `room_images`
                WHERE room_id= '$room_data[id]' AND `thumb`=1");

                if(mysqli_num_rows($thumb_q)>0){
                  $thumb_res = mysqli_fetch_assoc($thumb_q);
                  $room_thumb = ROOMS_IMG_PATH.$thumb_res['image'];
                }
                echo<<<data
                  <div class="card p-3 shadow-sm rounded">
                    <img src="$room_thumb" class"img-fluid rounded mb-3"> 
                    <h5>$room_data[name]</h5>
                    <h6>$$room_data[price] pre night</h6>
                  
                  </div>
                data;
              ?>
            </div>
            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                  <div class="card-body">
                    <form action="pay_now.php" method="POST" id="booking_form">
                      <h6 class="mb-3">BOOKING DETAILS</h6>
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label class="form-label ">Name</label>
                          <input type="text" name="name" value=<?php echo $user_data['name']?> class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label class="form-label">Phone Number</label>
                          <input type="text" name="phonenum" value=<?php echo $user_data['phonenum']?> class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-12 mb-3">
                          <label class="form-label ">Address</label>
                          <textarea name="address" rows="1" class="form-control shadow-none" required><?php echo $user_data['address']?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label class="form-label">Check-in</label>
                          <input type="date" onchange="check_availability()" name="checkin" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-4">
                          <label class="form-label">Check-out</label>
                          <input type="date"  onchange="check_availability()" name="checkout" class="form-control shadow-none" required>
                        </div>
                        <div class="col-12">
                            <div class="spinner-border text-info mb-3 d-none" id="info_loader" role="status">
                              <span class="visually-hidden">Loding...</span>
                            </div>
                            <h6 class="mb-3 text-danger" id="pay_info">Provid check-in & check-out date !</h6>
                            <button name="pay_now" class="btn w-100 text-white custom-bg shadow-none mb-1 btn_send1 pay-now-btn" >Pay Now</button>
                        </div>
                      </div>
                    </form>

                  </div>

                </div>
            </div>

          </div>
      </div>

      <!-- START FOOTER -->

      <?php require('inc/footer.php');?>
      <!-- END FOOTER -->

      <script>
        let booking_form=document.getElementById('booking_form');
        let info_loader=document.getElementById('info_loader');
        let pay_info=document.getElementById('pay_info');

  function check_availability(){
          let checkin_val = booking_form.elements['checkin'].value;
          let checkout_val = booking_form.elements['checkout'].value;
          let pay_now_btn = booking_form.elements['pay_now'];
    
    // إزالة الفئة النشطة في البداية
    pay_now_btn.classList.remove('active');

    if(checkin_val != '' && checkout_val != '')
    { 
        pay_info.classList.add('d-none');
        pay_info.classList.replace('text-dark' , 'text-danger');
        info_loader.classList.remove('d-none');

        let data = new FormData();
        data.append('check_availability','');
        data.append('check_in', checkin_val);
        data.append('check_out', checkout_val);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/confirm_booking.php", true);

        xhr.onload = function(){
            let data = JSON.parse(this.responseText);
            if(data.status == 'check_in_out_equal'){
                pay_info.innerText = "You cannot check-out on the same day!";
            }
            else if(data.status == 'check_out_earlier'){
                pay_info.innerText = "Check-out date is earlier than check-in date!";
            }
            else if(data.status == 'check_in_earlier'){
                pay_info.innerText = "Check-in date is earlier than today's date!";
            }
            else if(data.status == 'unavailable'){
                pay_info.innerText = "Room not available for this check-in date!";
            }
            else{
                pay_info.innerHTML = "No. of Days: " + data.days + "<br> Total Amount to Pay: " + data.payment;
                pay_info.classList.replace('text-danger' , 'text-dark');
                pay_now_btn.classList.add('active');  // إضافة الفئة النشطة
            }
            pay_info.classList.remove('d-none');
            info_loader.classList.add('d-none');
        }
        xhr.send(data);
    }
}

// إضافة مستمع حدث للنقر على الزر
booking_form.elements['pay_now'].addEventListener('click', function(e) {
    if (!this.classList.contains('active')) {
        e.preventDefault();  // منع إرسال النموذج إذا لم يكن الزر نشطًا
    }
});
      </script>



</body>
</html>