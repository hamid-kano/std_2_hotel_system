<?php
session_start();

if(isset($_POST['info_form'])) {
    require_once '../admin/inc/db_config.php';
    require_once '../admin/inc/essentials.php';

    $frm_data = filteration($_POST);
    
    // التحقق من وجود رقم الهاتف لمستخدم آخر
    $u_exist = select("SELECT * FROM `user_cred` WHERE `phonenum`=? AND `id`!=? LIMIT 1",
                    [$frm_data['phonenum'], $_SESSION['uId']], 
                    "si");

    if(mysqli_num_rows($u_exist) != 0){
        echo 'phone_already';
        exit;
    }

    $query = "UPDATE `user_cred` SET `name`=?, `address`=?, `phonenum`=?, `pincode`=?, `dob`=? WHERE `id`=?";
    $values = [$frm_data['name'], $frm_data['address'], $frm_data['phonenum'], $frm_data['pincode'], $frm_data['dob'], $_SESSION['uId']];

    if(update($query, $values, 'sssssi')) {
        $_SESSION['uName'] = $frm_data['name'];
        echo '1';
    } else {
        echo '0';
    }
} else {
    echo 'invalid_request';
}

if(isset($_POST['pass_form'])){
    require_once '../admin/inc/db_config.php';
    require_once '../admin/inc/essentials.php';

    $frm_data = filteration($_POST);

    if($frm_data['new_pass']!=$frm_data['confirm_pass']){
        echo 'mismatch';
        exit;
    }
    $enc_pass=password_hash($frm_data['new_pass'],PASSWORD_BCRYPT);
    $query = "UPDATE `user_cred` SET `password`=? WHERE `id`=? LIMIT 1";

    $values=[$enc_pass,$_SESSION['uId']];

    if(update($query,$values,'ss')){
        echo 1;
    }
    else{
        echo 0;
    }
}
?>