<?php
session_start();
    require_once("process_pages/classes/Tenant.php");
    require_once "process_pages/classes/Site.php";
    $user = new Tenant();
    $listing = new Site();

     require_once "userguard.php";
    $user_deet = $user->fetch_user_detailby_id($_SESSION['useronline']);

    $all_listings = $listing->get_all_listing_bystatus('approved');
    // echo "<pre>";
    // print_r($all_listings);
    // echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tenant</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="animate.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>    
    <link rel="stylesheet" href="style.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">



</head>

<body>
    <!-- Navigation -->
    <?php include 'nav.php'; ?>


    <div class="container-fluid " style="min-height: 900px;">
        <div class="row">

            <!-- Sidebar (Profile and Navigation) -->
            <div class="col-md-2 shadow-sm d-md-block d-none align-item" style="background-color: #f1f1f1;">
                <div class="profile-box d-flex flex-column justify-content-center align-items-center"
                    style="padding: 20px 0px;">
                    <div class="profile-pic d-flex justify-content-center align-items-center"
                        style="width: 110px; height: 110px; background-color: white; border-radius: 50%;   margin-top: 30px;">
                        <img src="media/q.png" alt="Profile Picture" class="box"
                            style="width: 100px; height: 100px; border-radius: 50%;">
                    </div>
                    <h5 class="text-center mt-3 card box p-1"> <?php  echo $user_deet['first_name'] ?></h5>
                    <p class="text-center label ">Scout</p>
                    <div class="profile-menu mt-4">
                        <a href="#" class="d-block py-3 px-5 text-dark box "><i
                                class="px-2 fa-solid fa-house-user"></i> Dashboard</a>
                        <a href="#" class="d-block py-3 px-5 text-dark box "> <i class="px-2 fa-solid fa-list"></i>
                            Browse Listings</a>
                        <a href="#" class="d-block py-3 px-5 text-dark box "><i
                                class="px-2 fa-regular fa-envelope"></i> Messages</a>
                        <a href="#" class="d-block py-3 px-5 text-dark box "><i
                                class="px-2 fa-solid fa-circle-dollar-to-slot"></i> Payments History</a>
                        <a href="#" class="d-block py-3 px-5 text-dark box "><i class="px-2 fa-solid fa-gear"></i>
                            Settings</a>
                        <a href="#" class="d-block py-3 px-5 text-dark box "><i class="px-2 fa-solid fa-user"></i>
                            My Profile </a>
                        <a href="user_logout.php" class="d-block py-3 px-5 text-dark box "><i
                                class="px-2 fa-solid fa-right-from-bracket"></i> Logout</a>
                    </div>

                </div>
            </div>
            <!-- Sidebar (Profile and Navigation) -->

            <!-- Main Content -->
            <div class="col-md-9 px-5 pb-5 pt-3">

                <!-- Mobile Menu Toggle -->
                <div class="row mb-2">
                    <a class="btn btn-primary d-md-none mt-2" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#mobileMenu" aria-controls="mobileMenu">
                        <i class="fa-solid fa-bars"></i>
                    </a>
                </div>

                <!-- Welcome Banner -->
                <div class="row mt-4">
                    <div class="col-12 text-dark p-4 rounded-4" style="background-color: #f1f1f1;">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div>
                                <h1 class="mb-1">Welcome, <?php  echo $user_deet['first_name']; ?></h1>
                                <p class="mb-0 text-muted">You have <strong>3 unread messages</strong> and
                                    <strong>2 new listings</strong> matching your saved search.
                                </p>
                            </div>
                            <a class="rounded-pill btn btn-primary px-4 py-2" href="#">
                                <i class="fa-solid fa-magnifying-glass me-2"></i> Browse Listings
                            </a>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Stats Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="card box border-0 shadow-sm p-3 text-center">
                            <i class="fa-solid fa-bookmark fa-2x mb-2" style="color: #1E3888;"></i>
                            <h5 class="mb-0 fw-bold">12</h5>
                            <small class="text-muted">Saved Properties</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card box border-0 shadow-sm p-3 text-center">
                            <i class="fa-solid fa-magnifying-glass fa-2x text-success mb-2"></i>
                            <h5 class="mb-0 fw-bold">3</h5>
                            <small class="text-muted">Saved Searches</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card box border-0 shadow-sm p-3 text-center">
                            <i class="fa-regular fa-envelope fa-2x text-warning mb-2"></i>
                            <h5 class="mb-0 fw-bold">5</h5>
                            <small class="text-muted">Unread Messages</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card box border-0 shadow-sm p-3 text-center">
                            <i class="fa-solid fa-circle-dollar-to-slot fa-2x text-danger mb-2"></i>
                            <h5 class="mb-0 fw-bold">₦450k</h5>
                            <small class="text-muted">Total Payments</small>
                        </div>
                    </div>
                </div>

                <!-- Recommended Properties -->
                <div class="row mb-2">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Recommended For You</h4>
                        <a href="#" class="text-primary" style="font-size: 0.9em;">View All
                            <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>

                <div class="row g-3 mb-5">

                <?php
                    foreach($all_listings as $li){
                ?>
                    <!-- Property Card 1 -->
                    <div class="col-md-4">
                        <div class="card box border-0 shadow-sm h-100">
                            <div style="position: relative;">
                                <img src="uploads/property_pictures/<?php echo $li['image1'] ?>" class="card-img-top"
                                    style="height: 180px; object-fit: cover;" alt="Property">
                                <span class="badge text-bg-success position-absolute"
                                    style="top: 10px; left: 10px; font-size: 0.75em;">
                                    <i class="fa-solid fa-circle-check me-1"></i> Verified
                                </span>
                                <span class="badge text-bg-primary position-absolute"
                                    style="top: 10px; right: 10px; font-size: 0.75em;">For Rent</span>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title fw-semibold mb-1"><?php echo $li['title']?></h6>
                                <p class="text-muted mb-1" style="font-size: 0.85em;">
                                    <i class="fa-solid fa-location-dot me-1 text-danger"></i>
                                    Lekki Phase 1, Lagos
                                </p>
                                <p class="fw-bold text-primary mb-2"><?php echo $li['price']?><span class="text-muted fw-normal"
                                        style="font-size: 0.8em;">/ yr</span></p>
                                <div class="d-flex gap-3 text-muted mb-3" style="font-size: 0.82em;">
                                    <span><i class="fa-solid fa-bed me-1"></i> <?php echo $li['bedrooms']?> Beds</span>
                                    <span><i class="fa-solid fa-bath me-1"></i> <?php echo $li['bathrooms']?></span>
                                    <span><i class="fa-solid fa-couch me-1"></i> <?php echo $li['furnished_status']?></span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="property_details.php?id=<?php echo $li['property_id']?>" class="btn btn-outline-primary btn-sm flex-grow-1">View Details</a>
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php } ?>

                </div>



            </div>
            <!-- End Main Content -->

            

        </div>




    </div>


    <!-- Footer  -->
     <?php include 'footer.php'; ?>

    <!-- Footer  -->


























    <!-- Off-canvas -->
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="mobileMenu"
        aria-labelledby="mobileMenu">
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




    <script src="jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script>
        


    </script>
</body>

</html>