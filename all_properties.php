<?php
session_start();
//require_once "Agent/agentguard.php";
require_once "process_pages/classes/Site.php";
require_once "process_pages/classes/Tenant.php";
require_once "process_pages/classes/Agent.php";

$prop = new Site();
$all_listings = $prop->get_all_listing_bystatus("approved");
   
$featured_listings = $prop->fetch_featured_properties();
    // echo "<pre>";
    // print_r($featured_listings);
    // echo "</pre>";
    if(isset($_SESSION['useronline'])){
    $user = new Tenant;
    $user_deet = $user->fetch_user_detailby_id($_SESSION['useronline']);
}
if(isset($_SESSION['agent_online'])){
    
    $user_deet = $user->fetch_user_detailby_id($_SESSION['agent_online']);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <meta name="description" content="A Rental Management App" />
	<meta name="author" content="Emmanuel Fajumo" />

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="animate.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap" rel="stylesheet">


    <style>
        /* h1{
            font-size: 5em;
            font-family: "Voltaire", sans-serif;
            font-weight: bold;
        } */
    </style>


</head>
<body>

    <!-- Navigation -->
    <?php include 'nav.php'; ?>

    <!-- Navigation -->


    <!-- Hero Section -->
    <div class="container-fluid hero-section" style="background-image: url('media/singleproperty1.png'); background-size: cover; background-position: center; height: 300px; position: relative;">
        <div class="row h-100 d-flex justify-content-center align-items-center" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="col-md-10  d-flex flex-column justify-content-center align-items-center text-light animate__animated animate__fadeIn animate__slow">
                <div class="mb-4  rounded round-fluid" style="width: 100%; min-height: 100px;">
                    <div class="mb-4 bg-light" id="rentSearch" style="width: 100%; min-height: 100px;" style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                       <form action="" class="form p-3">
                            <div class="row p-3">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Location">
                                </div>
                                <div class="col-md-3">
                                    <select name="" id="" class="form-select">
                                        <option value="">Property Type</option>
                                        <option value="">Bungalow</option>
                                        <option value="">Duplex</option>
                                        <option value="">Flat</option>
                                        <option value="">Mini Flat</option>
                                        <option value="">Room & Palour</option>
                                        <option value="">Self-con</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="" id="" class="form-select">
                                        <option value="">Price Range</option>
                                        <option value="">N300000 - N500000</option>
                                        <option value="">N500000 - N1000000</option>
                                        <option value="">N1000000 - N2000000</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary w-100">Search</button>
                                </div>
                            </div>

                       </form>
                    </div>
                   
                </div>

                   
            </div>
        </div>


    </div>

    <!-- Hero section end -->

    <!-- Featured properties -->
    <div class="container section">

            <div class="row">
                <div class="col-md-6">
                    <h2 class="text-left mb-4">All Properties</h2>
                    <hr class="mb-4 bg-primary" style="width: 100px; height: 3px;">
                    <p>Latest Listed Properties</p> 
                </div>
                
            </div>


        <div class="row g-3 mb-5">

                    <!-- Property Card 1 -->
                     <?php 
                        foreach($all_listings as $listing){

                        
                     ?>
                    <div class="col-md-4">
                        <div class="card box border-0 shadow-sm h-100">
                            <div style="position: relative;">
                                <img src="uploads/property_pictures/<?php echo $listing['image1'] ?>" class="card-img-top"
                                    style="height: 180px; object-fit: cover;" alt="Property">
                                <span class="badge text-bg-success position-absolute"
                                    style="top: 10px; left: 10px; font-size: 0.75em;">
                                    <i class="fa-solid fa-circle-check me-1"></i> Verified
                                </span>
                                <span class="badge text-bg-primary position-absolute"
                                    style="top: 10px; right: 10px; font-size: 0.75em;">For Rent</span>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title fw-semibold mb-1"><?php echo $listing['title'] ?></h6>
                                <p class="text-muted mb-1" style="font-size: 0.85em;">
                                    <i class="fa-solid fa-location-dot me-1 text-danger"></i>
                                    <?php echo $listing['address'] ?>
                                </p>
                                <p class="fw-bold text-primary mb-2"><?php echo $listing['price'] ?><span
                                        class="text-muted fw-normal" style="font-size: 0.8em;">/ yr</span></p>
                                <div class="d-flex gap-3 text-muted mb-3" style="font-size: 0.82em;">
                                    <span><i class="fa-solid fa-bed me-1"></i> <?php echo $listing['bedrooms'] ?> Beds</span>
                                    <span><i class="fa-solid fa-bath me-1"></i> <?php echo $listing['bathrooms'] ?> Baths</span>
                                    <span><i class="fa-solid fa-couch me-1"></i><?php echo $listing['furnished_status'] ?></span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="property_details.php?id=<?php echo $listing['property_id'] ?>" class="btn btn-outline-primary btn-sm flex-grow-1">View Details</a>
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


          <!-- Footer  -->
        <?php include 'footer.php'; ?>
    <!-- Footer  -->





    <script src="jquery.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){

            $('#saleSearch').hide();

            $('#forRent').click(function(){
                 $('#saleSearch').hide()
                 $('#rentSearch').show()
            })
            $('#forSale').click(function(){
                 $('#saleSearch').show()
                 $('#rentSearch').hide()
            })


        })


    </script>
</body>
</html>