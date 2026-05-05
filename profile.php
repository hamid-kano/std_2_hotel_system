<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROFILE</title>

    <!-- LINKS -->
    <style>
        .pay_a {
            color: white;
            font-weight: bold;
            font-size: 20px;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn_send1:hover {
            color: rgba(71, 66, 66, 0.384);
        }
    </style>

    <?php require('inc/links.php') ?>
    
    <!-- swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
</head>

<body class="bg-light">
    <?php 
    require('inc/header1.php');

    if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){     
        redirect('hotel.php');
    }
    $u_exist = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], 's');
    if(mysqli_num_rows($u_exist)==0){
        redirect('hotel.php');
    }
    $u_fetch = mysqli_fetch_assoc($u_exist);
    ?>

    <div class="container">
        <div class="row">
            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold">PROFILE</h2>
                <div style="font-size: 14px;">
                    <a href="hotel.php" class="text-secondary text-decoration-none">HOME</a>
                    <span class="text-secondary"> > </span>
                    <a href="#" class="text-secondary text-decoration-none">PROFILE</a>
                </div>
                <hr>
            </div>

            <div class="col-12 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="info-form">
                        <h5 class="mb-4 fw-bold">Basic Information</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" value="<?php echo $u_fetch['name']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phonenum" value="<?php echo $u_fetch['phonenum']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="dob" value="<?php echo $u_fetch['dob']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="pincode" value="<?php echo $u_fetch['pincode']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-8 mb-4">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" value="<?php echo $u_fetch['address']?>" class="form-control shadow-none" required>
                            </div>
                        </div>
                        <button type="submit" class="btn text-white custom-bg shadow-none">Save Changes</button>
                    </form>
                </div>
            </div>
            <div class="col-12 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="pass-form">
                        <h5 class="mb-4 fw-bold">Change Password </h5>
                        <div class="row">
                        <div class="col-md-4 mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="new_pass" class="form-control shadow-none" required>
                        </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_pass" class="form-control shadow-none" required>
                            </div>
                        <button type="submit" class="btn text-white custom-bg shadow-none">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php require('inc/footer.php');?>

    <script>
    let info_form = document.getElementById('info-form');
    let pass_form = document.getElementById('pass-form');
    info_form.addEventListener('submit', function(e) {
        e.preventDefault();
        let data = new FormData(this);
        data.append('info_form', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/profile.php", true);

        xhr.onload = function() {
            if (this.status == 200) {
                let response = this.responseText.trim();
                console.log('Server response:', response); // إضافة سجل للتصحيح

                if (response === 'phone_already') {
                    showAlert('phone number is already registered!', 'error');
                } else if (response === '0') {
                    showAlert('No changes Made!', 'warning');
                } else if (response === '1') {
                    showAlert('Changed Saved!', 'success');
                } else {
                    showAlert('خطأ: استجابة غير متوقعة من الخادم', 'error');
                }
            } else {
                showAlert('خطأ: حدث خطأ أثناء الاتصال بالخادم', 'error');
            }
        }

        xhr.onerror = function() {
            showAlert('خطأ: فشل الاتصال بالخادم', 'error');
        }

        xhr.send(data);
    });

    function showAlert(message, type) {
        let alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        document.querySelector('.container').insertAdjacentElement('afterbegin', alertDiv);

        // إزالة التنبيه تلقائيًا بعد 5 ثوانٍ
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }

    pass_form.addEventListener('submit', function(e) {
        e.preventDefault();
        let new_pass = pass_form.elements['new_pass'].value;
        let confirm_pass = pass_form.elements['confirm_pass'].value;


        if(new_pass!=confirm_pass){
          alert('error','Password do not match!');
          return false;
        }

        let data = new FormData(this);
        data.append('pass_form', new_pass); 
        data.append('confirm_form',confirm_pass);


        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/profile.php", true);

        xhr.onload = function() {
          if(this.responseText=='mismatch'){
            showAlert("password do not match!" , 'error');
          }
          else if(this.responseText==0){
            showAlert("Updating Failed!" , 'error');
          }
          else{
            showAlert("Changes Saved!",'success');
            pass_form.reset();
          }
        }

        xhr.onerror = function() {
            showAlert('خطأ: فشل الاتصال بالخادم', 'error');
        }

        xhr.send(data);
    });




</script>
</body>
</html>