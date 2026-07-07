<?php
    session_start();
    require_once "adminguard.php";
    require_once "classes/Admin.php";
    $user_id = $_GET['id'];
    $user = new Admin();
    $response = $user->get_user($user_id);

   

    // echo "<pre>";
    // print_r($response);
    // echo "</pre>";
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="preconnect" href="../https://fonts.googleapis.com">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../style.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">

    <style>
        .susp{
            background-color: #fff3cd; color: #856404;
        }
    </style>


</head>

<body>
 


    <div class="container-fluid " style="min-height: 900px;">
        <div class="row" style="min-height: 900px;">

            <!-- Sidebar (Profile and Navigation) -->
                <?php include 'admin_nav.php'; ?>
            <!-- Sidebar (Profile and Navigation) -->

            <!-- Main Content -->

            <div class="col-md-9 px-5 pb-5 pt-3">

                <!-- Page Header -->
                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0"><?php echo $response['first_name']." ".$response['last_name']  ?></h2>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-success px-4">
                                <i class="fa-solid fa-check me-2"></i> Verify
                            </button>
                            <button class="btn btn-warning px-4">
                                <i class="fa-solid fa-suspend me-2"></i> Suspend
                            </button>
                            <button class="btn btn-outline-danger px-4">
                                <i class="fa-solid fa-delete-left me-2"></i> Delete Account
                            </button>
                        </div>
                    </div>
                </div>

                <hr class="my-4">    
                <div class="col-12">
                    <div class="card rounded-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Personal Information</h5>
                            <p class="card-text"><strong>Email:</strong> <?php echo $response['email']  ?></p>
                            <p class="card-text"><strong>Phone Number:</strong> <?php echo $response['phone']  ?></p>
                            <p class="card-text"><strong>Role:</strong> <?php echo $response['date_joined']  ?></p>
                            <p class="card-text"><strong>Status:</strong> <?php echo $response['is_verified']  ?></p>

                    </div>
                </div>

            </div>

             <!-- Main Content -->


        </div>   
    </div>


  






        <!-- Off-canvas -->
         <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenu">
            <div class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="profile-box d-flex flex-column justify-content-center align-items-center"
                    style="padding: 20px;">
                    <div class="profile-pic d-flex justify-content-center align-items-center"
                        style="width: 110px; height: 110px; background-color: white; border-radius: 50%;   margin-top: 30px;">
                        <img src="media/q.png" alt="Profile Picture" class="box"
                            style="width: 100px; height: 100px; border-radius: 50%;">
                    </div>
                    <h5 class="text-center mt-3 card box p-1">Samson Johnson</h5>
                    <p class="text-center label ">Scout</p>
                    <div class="profile-menu mt-4">
                        <a href="tenant_dashbord.html" class="d-block py-2 px-3 text-dark">Dashboard</a>
                        <a href="#" class="d-block py-2 px-3 text-dark">Browse Listings</a>
                        <a href="#" class="d-block py-2 px-3 text-dark">Messages</a>
                        <a href="#" class="d-block py-2 px-3 text-dark">Settings</a>
                        <a href="#" class="d-block py-2 px-3 text-dark">My Profile </a>
                        <a href="#" class="d-block py-2 px-3 text-dark">Logout</a>
                    </div>

                </div>
                    </div>
                </div>
            </div>
        </div>




    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.verified').addClass('text-bg-success');
            $('.pending').addClass('text-bg-warning');
            $('.suspended').addClass('susp');
            $('.banned').addClass('text-bg-danger');
        })


    </script>
</body>

</html>