<?php

    require('inc/essentials.php');
    require('inc/db_config.php');

    session_start();
    if((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
        redirect('dashboard.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Panel</title>

    <?php require('inc/links.php'); ?>

    <style>
        div.login-form{
            position: absolute;
            top:50%;
            left:50%;
            transform:translate(-50%,-50%);
            width:400px; 
        }
    </style>
</head>


<body class="bg-light">

            <!-- LOGIN ! ADMIN -->
    <div class="login-form text-center rounded bf-white shadow overflow-hidden">
        <form method="POST">
            <h4 class="bg-dark text-white py-3 rounded">ADMIN LOGIN PANEL</h4>

            <div class="p-4">

                <div class="mb-3">
                    <input type="text" name="admin_name" required class="form-control shadow-none text-center" placeholder="Admin Name">
                </div>

                <div class="mb-4">
                    <input type="password" name="admin_pass" required class="form-control shadow-none text-center" placeholder="Password">
                </div>

                <button name="login" type="submit" class="btn text-white custom-bg shadow-none">LOGIN</button>
            </div>
        </form>
    </div>


    <?php 

        if(isset($_POST['login']))
        {
                    // FUN 1 
            $frm_data = filteration($_POST);
            
            // Fetch admin by name only, then verify password with bcrypt
            $query = "SELECT * FROM `admin_cred` WHERE `admin_name`=? LIMIT 1";
            $values = [$frm_data['admin_name']];
                    // FUN 2
            $res= select($query,$values,"s");
            if($res->num_rows==1){
                $row= mysqli_fetch_assoc($res);
                // Support both bcrypt hashed and plain-text passwords (migration period)
                $pass_valid = password_verify($frm_data['admin_pass'], $row['admin_pass'])
                              || $row['admin_pass'] === $frm_data['admin_pass'];
                if($pass_valid){
                    // Upgrade plain-text password to bcrypt on first login
                    if(!password_get_info($row['admin_pass'])['algo']){
                        $hashed = password_hash($frm_data['admin_pass'], PASSWORD_BCRYPT);
                        update("UPDATE `admin_cred` SET `admin_pass`=? WHERE `sr_no`=?",
                               [$hashed, $row['sr_no']], 'si');
                    }
                    session_regenerate_id(true); // prevent session fixation
                    $_SESSION['adminLogin']=true;
                    $_SESSION['adminId']=$row['sr_no'];
                    // FUN 3
                    redirect('dashboard.php');
                }
                else{
                    alert('error','Login failed - Invalid Credentials!');
                }
            }
            else{
                // FUN 4
                alert('error','Login failed - Invalid Credentials!');
            }
        }
    
    ?>
    




    <?php require('inc/scripts.php');?>
</body>
</html>