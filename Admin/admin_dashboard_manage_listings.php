<?php 
 session_start();
 require_once "classes/Admin.php";
 require_once "adminguard.php";
 $listing = new Admin();
 $all = $listing->fetch_All_listings();
 


?>
   


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Listings</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="preconnect" href="../https://fonts.googleapis.com">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">

    
    <style>
        .profile-menu a{
            text-decoration: none;
        }
    </style>


</head>

<body>
    <!-- Navigation -->

    <div class="container-fluid " style="min-height: 900px;">
        <div class="row">
           <!-- Sidebar (Profile and Navigation) -->
                <?php include 'admin_nav.php'; ?>
            <!-- Sidebar (Profile and Navigation) -->

            <!-- Main Content -->

            <div class="col-md-9 px-5 pb-5 pt-3">

                <!-- Page Header -->
                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0">Manage Listings</h2>
                            <p class="text-muted mb-0">Total Listings: <strong>100</strong></p>
                        </div>
                        <button class="btn btn-primary px-4">
                            <i class="fa-solid fa-download me-2"></i> Export CSV </button>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Stats Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card box p-3 text-center border-0 shadow-sm">
                            <i class="fa-solid fa-users fa-2x text-primary mb-2"></i>
                            <h5 class="mb-0">100</h5>
                            <small class="text-muted">Total Listings</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card box p-3 text-center border-0 shadow-sm">
                            <i class="fa-solid fa-circle-check fa-2x text-success mb-2"></i>
                            <h5 class="mb-0">70</h5>
                            <small class="text-muted">Live</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card box p-3 text-center border-0 shadow-sm">
                            <i class="fa-solid fa-clock fa-2x text-warning mb-2"></i>
                            <h5 class="mb-0">30</h5>
                            <small class="text-muted">Pending approval</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card box p-3 text-center border-0 shadow-sm">
                            <i class="fa-solid fa-ban fa-2x text-danger mb-2"></i>
                            <h5 class="mb-0">10</h5>
                            <small class="text-muted">Flagged</small>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="row g-3 mb-4 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search by title o location...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option selected>All property types</option>
                            <option value="all">All property types</option>
                            <option value="flat">Flat</option>
                            <option value="self-contained">Self-contained</option>
                            <option value="miniflat">Mini flat</option>
                            <option value="duplex">Duplex</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select">
                            <option selected>All location</option>
                            <option value="all">All location</option>
                            <option value="abia">Abia</option>
                            <option value="adamawa">Adamawa</option>
                            <option value="akwa-Ibom">Akwa Ibom</option>
                            <option value="anambra">Anambra</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select">
                            <option selected>Sort By</option>
                            <option value="lowest">Price: low to high</option>
                            <option value="highest">Price: high to low</option>
                            <option value="reported">Most reported</option>
                        </select>
                    </div>

                    <hr>
                </div>

                <!-- Listings Grid -->
                <div class="row ">
                    <div class="col-12 my-3 d-flxe g-4">
                        <button class="badge rounded-pill  bg-primary text-muted px-3 py-2 border filter act" id='all'>All (100) </button>
                        <button class="badge rounded-pill text-muted border px-3 py-2 border filter act" id='live'>Live (70)</button>
                        <button class="badge rounded-pill text-muted border px-3 py-2 filter act" id='pending'>Pending (20) </button>
                        <button class="badge rounded-pill text-muted border px-3 py-2 filter act" id='rejected'> Rejected (10) </button>
                        <button class="badge rounded-pill text-muted border px-3 py-2 filter act" id='suspended'>Suspended(7) </button>

                    </div>

                    <!-- Listed Properties -->
                    <?php
                        foreach($all as $prop){
                    ?>
                        <div class="col-md-4 property  <?php echo  $prop[0]; ?>">
                                    <div class="card box border-0 shadow-sm h-100">
                                        <div style="position: relative;">
                                            <img src="../uploads/property_pictures/<?php echo $prop['image1']; ?>" class="card-img-top"
                                                style="height: 180px; object-fit: cover;" alt="Property">
                                            <span class="badge position-absolute ta"
                                                style="top: 10px; left: 10px; font-size: 0.75em;">
                                                <i class="fa-solid fa-circle-check me-1"></i>  <?php //echo $prop[0]; ?> </span>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="card-title fw-semibold mb-1"><?php echo $prop['title']; ?></h6>
                                            <p class="text-muted mb-1" style="font-size: 0.85em;">
                                                <i class="fa-solid fa-location-dot me-1 text-danger"></i>
                                                <?php echo  $prop['LGA']." ".$prop['state'];; ?>
                                            </p>
                                            <p class="fw-bold text-primary mb-2"><?php echo $prop['price']; ?> <span class="text-muted fw-normal"
                                                    style="font-size: 0.8em;">/ yr</span></p>
                                            <div class="d-flex gap-3 text-muted mb-3" style="font-size: 0.82em;">
                                                <span><i class="fa-solid fa-bed me-1"></i> <?php echo $prop['bedrooms']; ?> Beds</span>
                                                <span><i class="fa-solid fa-bath me-1"></i> <?php echo $prop['bathrooms']; ?> Baths</span>
                                                <span><i class="fa-solid fa-couch me-1"></i> <?php echo $prop['furnished_status']; ?></span>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <a href="single_listing.php?id=<?php echo $prop['property_id']; ?>" class="btn btn-outline-primary btn-sm flex-grow-1">View Details</a>
                                                <button class="btn btn-outline-secondary btn-sm">
                                                    <i class="fa-regular fa-bookmark"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                    <?php
                        }

                    ?>

                    

                </div>
        
                <!-- Pagination -->
                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <small class="text-muted">Showing 1 - 5 of 11,200 tenants</small>
                        <nav>
                            <ul class="pagination mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#">Previous</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            
            </div>

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
                        <div class="profile-box d-flex flex-column justify-content-center align-items-center"style="padding: 20px;">
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


    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {

        $('.Live .ta').addClass('text-bg-success');
        $('.Pending .ta').addClass('text-bg-secondary');
        $('.rejected .ta').addClass('text-bg-danger');
        $('.suspended .ta').addClass('text-bg-warning');



            $('.filter').click(function(){
                $('.filter').removeClass('bg-primary act');
                $(this).toggleClass('bg-primary text-light act');

            })

            $('#all').click(function(){
                $('.Live').show();
                $('.Pending').show();
                $('.suspended').show();
                $('.rejected').show();
            })

            $('#live').click(function(){
                $('.Live').show();
                $('.Pending').hide();
                $('.suspended').hide();
                $('.rejected').hide();
            })
            $('#pending').click(function(){
                $('.Pending').show();
                $('.Live').hide();
                $('.suspended').hide();
                $('.rejected').hide();
            })

            $('#rejected').click(function(){
                $('.Pending').hide();
                $('.Live').hide();
                $('.suspended').hide();
                $('.rejected').show();
            })

            $('#suspended').click(function(){
                $('.Pending').hide();
                $('.Live').hide();
                $('.suspended').show();
                $('.rejected').hide();
            })

            

        })


    </script>
</body>

</html>