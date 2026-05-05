<?php
    require('admin/inc/essentials.php');
    require('admin/inc/db_config.php');
    session_start();
    function regenrate_session($uid){
        $user_q=select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1",[$uid],'i');
        $user_fetch=mysqli_fetch_assoc($user_q);
        $_SESSION['login']=true;
        $_SESSION['uId']=$user_fetch['id'];
        $_SESSION['uName']=$user_fetch['name'];
        $_SESSION['uPhone']=$user_fetch['phonenum'];
    }

    unset($_SESSION['room']);
    $isValidCheckSum="FALSE";
    $paramList = $_POST;
    
    // Fixed SQL Injection - using prepared statement
    $slct_query = "SELECT `booking_id`, `user_id` FROM `booking_order` WHERE `order_id` = ?";
    $slct_res = select($slct_query, [$_POST['ORDERID']], 's');
    if(mysqli_num_rows($slct_res)==0){
        redirect('hotel.php');
    }
    $slct_fetch = mysqli_fetch_assoc($slct_res);
    if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
        regenrate_session($slct_fetch['user_id']);

    }

    if($_POST['STATUS'] == 1){
        
        redirect('pay_status.php?order='.$_POST['ORDERID']);
    }else{
        
        redirect('pay_status.php?order='.$_POST['ORDERID']);

    }
?>