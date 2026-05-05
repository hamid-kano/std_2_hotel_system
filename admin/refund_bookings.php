<?php
    require('inc/essentials.php');
    require('inc/db_config.php');
    adminLogin();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel New Bookings</title>

    <?php require('inc/links.php'); ?> 
</head>
<style>

.custom-alert{
    position: fixed;
    top:80px;
    right: 25px;
}
    #dashboard-menu{
    position: fixed;
    z-index: 11;
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
                        <h4 class="mb-4">Refund Bookings</h4>
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">

                            <div class="text-end mb-4">
                                <input type="text" oninput="get_bookings(this.value)" class="from-control shadow-none w-25 ms-auto" placeholder="Type to search...">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover border">
                                    <thead>
                                        <tr>
                                            <th class="bg-dark text-light" scope="col">#</th>
                                            <th class="bg-dark text-light"  scope="col">User Details</th>
                                            <th class="bg-dark text-light" scope="col">Room Details</th>
                                            <th class="bg-dark text-light" scope="col">Refund Amount</th>
                                            <th class="bg-dark text-light" scope="col">Action</th>
                                        </tr>
                                    </thead>


                                    <tbody id="table-data">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> 
                    </div>
                </div>
            </div>

        </div>


<?php require('inc/scripts.php'); ?>
<script src="./scripts/refund_bookings.js"></script>



</body>
</html>