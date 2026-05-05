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

    if(isset($_POST['check_availability'])){
        $frm_data=filteration($_POST);
        $status="";
        $result=""; 


        $today_date=new DateTime(date("Y-m-d"));
        $checkin_date = new DateTime($frm_data['check_in']);
        $checkout_date = new DateTime($frm_data['check_out']);

        if($checkin_date==$checkout_date){
            $status = 'check_in_out_equal';
            $result=json_encode(["status"=>$status]);

        }
        else if($checkout_date < $checkin_date){
            $status = 'check_out_earlier';
            $result=json_encode(["status"=>$status]);
            
        }
        else if($checkin_date < $today_date){
            $status = 'check_in_earlier';
            $result=json_encode(["status"=>$status]);
        }

        if($status!=''){
            echo $result;
            
        }
        else{

            session_start();

            $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
            WHERE Booking_status=? AND room_id=?
            AND check_out > ? AND check_in < ? ";


            $values = ['booked',$_SESSION['room']['id'],$frm_data['check_in'],$frm_data['check_out']];

            $tb_fetch=mysqli_fetch_assoc(select($tb_query,$values,'siss'));

            $rq_result=select("SELECT `quantity` FROM `rooms` WHERE `id`=?",[ $_SESSION['room']['id']],'i');

            $rq_fetch = mysqli_fetch_assoc($rq_result);
            if(($rq_fetch['quantity'] - $tb_fetch['total_bookings'])==0){
                $status='unavailable';
                $result = json_encode(['status'=>$status]);
                echo $result;
                exit;
            }


            $count_days = date_diff($checkin_date,$checkout_date)->days;
            $payment = $_SESSION['room']['price'] * $count_days ;
            $_SESSION['room']['price']=$payment;
            $_SESSION['room']['available']=true;
            
            $result = json_encode(["status"=>'available' , "days"=>$count_days , "payment"=>$payment]);
            echo $result;
        }

    }


    ?>