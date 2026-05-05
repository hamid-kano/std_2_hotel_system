<?php
    // require('../admin/inc/db_config');
    // require('../admin/inc/essentials');

    $hname='localhost';
    $uname='root';
    $pass='';
    $db='homework_std_ro_db';


    $con = mysqli_connect($hname,$uname,$pass,$db);

    if(!$con){
        die("Cannot Connect to Database".mysqli_connect_error());
    }

        // START FILTERATION
    function filteration($data){
        foreach($data as $key => $value)
        {
            // 'site_title':'last pr'
            $value=trim($value); 
            $value=stripslashes($value); 
            $value=strip_tags($value); 
            $value=htmlspecialchars($value);

            $data[$key]=$value;


        }
        return $data;

    }   
        // END FILTERATION
        function selectAll($table){ 
            $con=$GLOBALS['con'];
            $res = mysqli_query($con,"SELECT * FROM $table");
            return $res;
        }
        // START SELECT
    function select($sql,$values,$datatypes){
        $con=$GLOBALS['con'];
        if($stmt = mysqli_prepare($con,$sql)){
            mysqli_stmt_bind_param($stmt,$datatypes,...$values);

            if(mysqli_stmt_execute($stmt)) {
                $res= mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);
                return $res; 
            }
            else{
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Select");
            }
        }
        else{
            die("Query cannot be prepared - Select");
        }
    }
        // END SELECT


    function update($sql,$values,$datatypes){
        $con=$GLOBALS['con'];
        if($stmt = mysqli_prepare($con,$sql)){
            mysqli_stmt_bind_param($stmt,$datatypes,...$values); 

            if(mysqli_stmt_execute($stmt)) {
                $res= mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $res; 
            }
            else{
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Update");
            }
        }
        else{
            die("Query cannot be prepared - Update");
        }
    }


    function insert($sql,$values,$datatypes){
        $con=$GLOBALS['con'];
        if($stmt = mysqli_prepare($con,$sql)){
            mysqli_stmt_bind_param($stmt,$datatypes,...$values);    

            if(mysqli_stmt_execute($stmt)) {
                $res= mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $res; 
            }
            else{
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Insert");
            }
        }
        else{
            die("Query cannot be prepared - Insert");
        }
    }

    function delete($sql,$values,$datatypes){
        $con=$GLOBALS['con'];
        if($stmt = mysqli_prepare($con,$sql)){
            mysqli_stmt_bind_param($stmt,$datatypes,...$values); 

            if(mysqli_stmt_execute($stmt)) {
                $res= mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $res; 
            }
            else{
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Delete");
            }
        }
        else{
            die("Query cannot be prepared - Delete");
        }
    }






    define('SITE_URL','http://localhost/my_project/last pr/');
    define("ABOUT_IMG_PATH",SITE_URL.'images/about/');
    define("CAROUSEL_IMG_PATH",SITE_URL.'images/carousel/');
    define("FACILITIES_IMG_PATH",SITE_URL.'images/facilities/');
    define("ROOMS_IMG_PATH",SITE_URL.'images/rooms/');
    define("USERS_IMG_PATH",SITE_URL.'images/users/');



    define('UPLOAD_IMAGE_PATH',$_SERVER['DOCUMENT_ROOT'].'/last pr/images/');

    define('ABOUT_FOLDER','about/');
    define('CAROUSEL_FOLDER','carousel/');
    define('FACILITIES_FOLDER','facilities/');
    define('ROOMS_FOLDER','rooms/');
    define('USERS_FOLDER','users/');


    define('SENDGRID_EMAIL',"shyrwkabary444@gmail.com");
    define('SENDGRID_NAME',"SHERO");


    function adminLogin(){
        session_start();
        if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
            echo"
            <script>
                window.location.href='index.php';
            </script>
            ";
            exit;
        }

    }

    function redirect($url){
        echo"
        <script>
            window.location.href='$url';
        </script>
        ";
        exit;
    }


    function alert($type,$msg){
        $bs_class = ($type=="success") ? "alert-success": "alert-danger";

        echo <<<alert
            <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
                <strong class="me-3">$msg</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        alert;
    }

    function uploadImage($image,$folder){
        $valid_mime= ['image/jpeg','image/png','image/webp'];
        $img_mime=$image['type'];

        if(!in_array($img_mime,$valid_mime)){
            return 'inv_img';
            }
        else if(($image['size']/(1024*1024))>2){
            return 'inv_size';
        }
        else{

            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);

            $rname='IMG_'.random_int(11111,99999).".$ext";

            $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;   

            if(move_uploaded_file($image['tmp_name'],$img_path)){
                return $rname;
            }
            else{
                return 'upd_failed';
            }
        }
    }

    function deleteImage($image,$folder){
        if(unlink(UPLOAD_IMAGE_PATH.$folder.$image)){
            return true;
        }
        else{
            return false;
        }

    }

    function uploadSVGImage($image,$folder){
        $valid_mime= ['image/svg+xml'];
        $img_mime=$image['type'];

        if(!in_array($img_mime,$valid_mime)){
            return 'inv_img';
            }
        else if(($image['size']/(1024*1024))>1){
            return 'inv_size';
        }
        else{

            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);

            $rname='IMG_'.random_int(11111,99999).".$ext";

            $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;   

            if(move_uploaded_file($image['tmp_name'],$img_path)){
                return $rname;
            }
            else{
                return 'upd_failed';
            }
        }
    }
    // function uploadUserImage($image){
    //     $valid_mime= ['image/jpeg','image/png','image/webp'];
    //     $img_mime=$image['type'];

    //     if(!in_array($img_mime,$valid_mime)){
    //         return 'inv_img';
    //         }
    //     else if(($image['size']/(1024*1024))>2){
    //         return 'inv_size';
    //     }
    //     else{

    //         $ext = pathinfo($image['name'], PATHINFO_EXTENSION);

    //         $rname='IMG_'.random_int(11111,99999).".jpeg";

    //         $img_path = UPLOAD_IMAGE_PATH.USERS_FOLDER.$rname;   

    //         if(imagejpeg($image['tmp_name'],$img_path)){
    //             return $rname;
    //         }
    //         else{
    //             return 'upd_failed';
    //         }
    //     }
    // }
    // function uploadUserImage($image){
    //     $valid_mime= ['image/jpeg','image/png','image/webp'];
    //     $img_mime=$image['type'];

    //     if(!in_array($img_mime,$valid_mime)){
    //         return 'inv_img';
    //     }
    //     else{

    //         $ext = pathinfo($image['name'], PATHINFO_EXTENSION);

    //         $rname='IMG_'.random_int(11111,99999).".jpeg";

    //         $img_path = UPLOAD_IMAGE_PATH.USERS_FOLDER.$rname; 
            
    //         if($ext == 'png' || $ext== 'PNG'){
    //             $img = imagecraetefrompng($image);
    //         }
    //         else if($ext =='webp' || $ext=='WEBP'){ 
    //             $img = imagecreatefromwebp($image);
    //         }
    //         else{
    //             $img = imagecreatefromjpeg($image);
                
    //         }
    //         if(imagejpeg($img,$img_path,75)){
    //             return $rname;
    //         }
    //         else{
    //             return 'upd_failed';
    //         }
    //     }
    // }










    // require("../inc/sendgrid/sendgrid-php.php");


    // function send_mail($uemail,$name,$token){
    //     $email=new \SendGrid\Mail\Mail();
    //     $email->setFrom("shyrwkabary444@gmail.com","TJ WEDEV");
    //     $email->setSubject("Account Verification Link");
    //     $email->addTo($uemail,$name);
    //     $email->addContent(
    //         "text/html",
    //         "Click the link to confirm you email:<br>
    //         <a href='".SITE_URL."email_confirm.php?email=$uemail&token=$token"."'>
    //         CLICK ME
    //         </a>
    //         "
    //     );
    //     $sendgrid = new \SendGrid(SENDGRID_API_KEY);
    //     try{
    //         $sendgrid->send($email);
    //         return 1;
    //     }
        
    //     catch(Exception $e){
    //         return 0 ;
    //     }
    // }

    if(isset($_POST['register'])){

        $data = filteration($_POST);    

        if($data['pass'] != $data['cpass']){ 
            echo 'pass_mismatch';
            exit;
        }
        $u_exist = select("SELECT * FROM `user_cred` WHERE  `email`= ? OR `phonenum`=? LIMIT 1",[$data['email'],$data['phonenum']],"ss");
        if(mysqli_num_rows($u_exist)!=0){
            $u_exist_fetch=mysqli_fetch_assoc($u_exist);
            echo($u_exist_fetch['email'] == $data['email']) ? 'email_already' : 'phone_already';
            exit;
        }

        // $img = uploadUserImage($_FILES['profile']);

        // if($img == 'inv_img'){
        //     echo 'inv_img';
        //     exit;
        // }
        // else if($img == 'upd_failed'){
        //     echo 'upd_failed';
        //     exit;
        // }
        $token = bin2hex(random_bytes(16));
            // if(!send_mail($data['email'],$data['name'],$token)){
            //     echo 'mail_failed';
            //     exit;
            // }   
        $enc_pass = password_hash($data['pass'],PASSWORD_BCRYPT);
        $query = "INSERT INTO `user_cred`( `name`, `email`, `address`, `phonenum`, `pincode`, `dob`, `password`, `token`) VALUES (?,?,?,?,?,?,?,?)";

        $values = [$data['name'],$data['email'],$data['address'],$data['phonenum'],$data['pincode'],$data['dob'],$enc_pass,$token];

        if(insert($query,$values,'ssssssss')){
            echo 1;
        }
        else{
            echo 'ins_failed';
        }
        
    }

    if(isset($_POST['login'])){
        $data = filteration($_POST);
        $u_exist = select("SELECT * FROM `user_cred` WHERE  `email`= ? OR `phonenum`=? LIMIT 1",[$data['email_mob'],$data['email_mob']],"ss");
        if(mysqli_num_rows($u_exist)==0){
            echo "inv_email_mob";
        }
        else{
            $u_fetch=mysqli_fetch_assoc($u_exist);
            // if($u_fetch['is_verified']==0){
            //     echo "not_verified";
            // }
            if($u_fetch['status']==0){
                echo "inactive";
            }
            else{
                if(!password_verify($data['pass'],$u_fetch['password'])){
                    echo "invalid_pass";
                }
                else{
                    session_start();
                    $_SESSION['login']=true;
                    $_SESSION['uId']=$u_fetch['id'];
                    $_SESSION['uName']=$u_fetch['name'];
                    $_SESSION['uPhone']=$u_fetch['phonenum'];
                    echo 1;
                }
            }
        }
    }

?>