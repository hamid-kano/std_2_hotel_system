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
    <title>Admin Panel features_facilites</title>

    <?php require('inc/links.php'); ?>
</head>
<style>

.custom-alert{
    position: fixed;
    top:80px;
    right: 25px;
    z-index: 111;
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
                <h4 class="mb-4">FEATURES & FACILITES</h4>


                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5 class="card-title m-0">Features</h5>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#features-s">
                                <i class="bi bi-plus-square"></i> Add
                                </button>
                        </div>
                        <div class="table-responsive-md" style="height:300px; overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr>
                                        <th class="bg-dark text-light" scope="col">#</th>
                                        <th class="bg-dark text-light"  scope="col">Name</th>
                                        <th class="bg-dark text-light" scope="col">Action</th>
                                    </tr>
                                </thead>

                                <tbody id="features-data">
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5 class="card-title m-0">Facilities</h5>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#facility-s">
                                <i class="bi bi-plus-square"></i> Add
                                </button>
                        </div>
                        <div class="table-responsive-md" style="height:300px; overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr>
                                        <th class="bg-dark text-light" scope="col">#</th>
                                        <th class="bg-dark text-light"  scope="col">Icon</th>
                                        <th class="bg-dark text-light"  scope="col">Name</th>
                                        <th class="bg-dark text-light" width="40%"  scope="col">Description</th>

                                        <th class="bg-dark text-light" scope="col">Action</th>
                                    </tr>
                                </thead>

                                <tbody id="facilities-data">
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



                    

                    

            </div>
        </div>
    </div>


                        <!--feature Modal -->
                        <div class="modal fade" id="features-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form id="feature_s_form">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Add Feature</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Name</label>
                                                <input type="text"  name="feature_name" class="form-control shadow-none" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                                            <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                                        </div>
                                    </div>
                                </form>
                                
                            </div>
                        </div>

                        <!-- facilities Model -->

                        
                        <!--feature Modal -->
                        <div class="modal fade" id="facility-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form id="facility_s_form">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Add Facility</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Name</label>
                                                <input type="text"  name="facility_name" class="form-control shadow-none" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Icon</label>
                                                <input type="file"  name="facility_icon" accept=".svg" class="form-control shadow-none" required>
                                            </div>
                                            <div class=" mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="facility_desc" class="form-control shadow-none" row="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                                            <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                                        </div>
                                    </div>
                                </form>
                                
                            </div>
                        </div>



<?php require('inc/scripts.php'); ?>
<script src="./scripts/features_facilites.js"></script>



</body>
</html>