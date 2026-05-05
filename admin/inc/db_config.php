<?php 


    $hname='localhost';
    $port=3333;
    $uname='homework_std_ro_db';
    $pass='Hamid.1234!';
    $db='homework_std_ro_db';


    $con = mysqli_connect($hname,$uname,$pass,$db,$port);

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


    function insert($sql, $values, $datatypes) {
        $con = $GLOBALS['con'];
        
        if ($stmt = mysqli_prepare($con, $sql)) {
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
            
            if (mysqli_stmt_execute($stmt)) {
                $res = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $res;
            } else {
                $error = mysqli_stmt_error($stmt);
                mysqli_stmt_close($stmt);
                // بدلاً من إنهاء البرنامج، نعيد رسالة الخطأ
                return "Query execution failed: " . $error;
            }
        } else {
            // بدلاً من إنهاء البرنامج، نعيد رسالة الخطأ
            return "Query preparation failed: " . mysqli_error($con);
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
        


?>