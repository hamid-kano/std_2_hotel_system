<?php
    require('inc/essentials.php');
    require('inc/db_config.php');
    adminLogin();
    if(isset($_GET['seen'])){
        $frm_data=filteration($_GET);
        
        if($frm_data['seen']=='all'){
            $q="UPDATE `user_queries1` SET `seen`=?";
            $values=[1];
            if(update($q,$values,'i')){
                alert('success','Marked all as read'); 
            }
            else{
                alert('error','Operation Failed');
            }
        }
        else{
            $q="UPDATE `user_queries1` SET `seen`=? WHERE sr_no=?";
            $values=[1,$frm_data['seen']];
            if(update($q,$values,'ii')){
                alert('success','Marked as read'); 
            }
            else{
                alert('error','Operation Failed');
            }
        }

    }
    if(isset($_GET['del'])){
        $frm_data=filteration($_GET);
        
        if($frm_data['del']=='all'){
            $q="DELETE FROM `user_queries1`";
            if(mysqli_query($con,$q)){
                alert('success','All data deleted!'); 
            }
            else{
                alert('error','Operation failed');
            }
        }
        else{
            $q="DELETE FROM `user_queries1` WHERE `sr_no`=?";
            $values=[$frm_data['del']];
            if(delete($q,$values,'i')){
                alert('success','Data deleted!'); 
            }
            else{
                alert('error','Operation failed');
            }
        }

    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - User Queries</title>

    <?php require('inc/links.php'); ?>
</head>
<style>

.custom-alert{
    position: fixed;
    top:80px;
    right: 25px;
    z-index: 1111;
}
#dashboard-menu{
    position: fixed;
    z-index: 11111;
    height: 100%;
    }


    @media screen and (max-width:991px) {
        #dashboard-menu{
        height: auto;
        width:100%;
        }
        #main-content{
            margin-top:60px;
        }
    }



</style>
<body class="bg-light">
    

        <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hiiden">
                <h4 class="mb-4">USER QUERIES</h4>


                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <a href="?seen=all" class="btn btn-dark rounded-pill shadow-none btn-sm ">
                            <i class="bi bi-check-all"></i>    Mark all read
                            </a>
                            <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm ">
                            <i class="bi bi-trash"></i>   delete all 
                            </a>
                        </div>
                        <div class="table-responsive-md" style="height:300px; overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr>
                                        <th class="bg-dark text-light" scope="col">#</th>
                                        <th class="bg-dark text-light"  scope="col">Name</th>
                                        <th class="bg-dark text-light" scope="col">Email</th>
                                        <th class="bg-dark text-light" scope="col" width="">Subject</th>
                                        <th class="bg-dark text-light" scope="col" width="30%">Message</th>
                                        <th class="bg-dark text-light" scope="col">Date</th>
                                        <th class="bg-dark text-light" scope="col">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        $q="SELECT * FROM `user_queries1` ORDER BY `sr_no` DESC";
                                        $data=mysqli_query($con,$q);
                                        $i=1;
                                        while($row = mysqli_fetch_assoc($data)){
                                            $seen='';
                                            if($row['seen']!=1){
                                                $seen="<a href='?seen=$row[sr_no]' class='btn btn-sm rounded btn-primary'>Mark as read</a>";
                                            }
                                            $seen.="<a href='?del=$row[sr_no]' class='btn btn-sm rounded btn-danger ms-2'>Delete</a>";
                                            echo<<<query
                                                <tr>
                                                    <td>$i</td>
                                                    <td>$row[name]</td>
                                                    <td>$row[email]</td>
                                                    <td>$row[subject]</td>
                                                    <td>$row[message]</td>
                                                    <td>$row[datentime]</td>
                                                    <td>$seen</td>
                                                </tr>
                                            query;
                                            $i++;
                                        }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



                    

                    

            </div>
        </div>
    </div>


    



<?php require('inc/scripts.php'); ?>



</body>
</html>