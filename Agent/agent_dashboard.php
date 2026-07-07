<?php
session_start();
require_once "agentguard.php";
require_once "../process_pages/classes/Agent.php";
$agent = new Agent();
$det = $agent->fetch_agent_details($_SESSION['agent_online']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">


    

</head>

<body>
    <!-- Navigation -->
     <?php //include 'nav.php'; ?>



    <div class="container-fluid " >
        <div class="row" style="min-height:900px;">

            <!-- Sidebar (Profile and Navigation) -->
            <?php include 'agent_nav.php'; ?>
            <!-- Sidebar (Profile and Navigation) -->

            <!-- Main Content -->
            <div class="col-md-9 px-5 mt-3 pb-5" >
                <div class="row" style="gap: 20px; justify-content: center; flex-wrap: wrap;">
                      <?php
                                if(isset($_SESSION['errormsg'])){   
                            ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo $_SESSION['errormsg'];  unset($_SESSION['errormsg']);?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php
                                }
                            ?>
                                <?php
                                    if(isset($_SESSION['successmsg'])){
                                ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?php echo $_SESSION['successmsg']; unset($_SESSION['successmsg']); ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php
                                    }
                                ?>
                    <div class="col-12  text-dark p-3 rounded mt-4 " style="border-radius: 50px; background-color: #f1f1f1;">
                        <h1 class="">Welcome, <?php echo $det['first_name']; ?>!</h1>
                        <p class="">Here are some properties you listed!</p>
                        <a class="text-left rounded-pill btn btn-outline-primary mb-4 px-5 py-2" href="agent_profile.php" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Complete Your Profile <i class=" ms-4 fa-solid fa-arrow-right-long"></i></a>
                    </div>
                    <div class="col-12">
                        <hr class="mb-4 bg-light" style="width: 100%; height: 3px;">
                    </div>
                </div>

                <div class="row g-3 mb-5">

                    <!-- Property Card 1 -->
                    <div class="col-md-4">
                        <div class="card box border-0 shadow-sm h-100">
                            <div style="position: relative;">
                                <img src="../media/singleproperty3.png" class="card-img-top"
                                    style="height: 180px; object-fit: cover;" alt="Property">
                                <span class="badge text-bg-success position-absolute"
                                    style="top: 10px; left: 10px; font-size: 0.75em;">
                                    <i class="fa-solid fa-circle-check me-1"></i> Verified
                                </span>
                                <span class="badge text-bg-primary position-absolute"
                                    style="top: 10px; right: 10px; font-size: 0.75em;">For Rent</span>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title fw-semibold mb-1">3-Bedroom Flat, Lekki</h6>
                                <p class="text-muted mb-1" style="font-size: 0.85em;">
                                    <i class="fa-solid fa-location-dot me-1 text-danger"></i>
                                    Lekki Phase 1, Lagos
                                </p>
                                <p class="fw-bold text-primary mb-2">₦1,200,000 <span
                                        class="text-muted fw-normal" style="font-size: 0.8em;">/ yr</span></p>
                                <div class="d-flex gap-3 text-muted mb-3" style="font-size: 0.82em;">
                                    <span><i class="fa-solid fa-bed me-1"></i> 3 Beds</span>
                                    <span><i class="fa-solid fa-bath me-1"></i> 2 Baths</span>
                                    <span><i class="fa-solid fa-couch me-1"></i> Furnished</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-outline-primary btn-sm flex-grow-1">View Details</a>
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Property Card 2 -->
                    <div class="col-md-4">
                        <div class="card box border-0 shadow-sm h-100">
                            <div style="position: relative;">
                                <img src="../media/singleproperty3.png" class="card-img-top"
                                    style="height: 180px; object-fit: cover;" alt="Property">
                                <span class="badge text-bg-success position-absolute"
                                    style="top: 10px; left: 10px; font-size: 0.75em;">
                                    <i class="fa-solid fa-circle-check me-1"></i> Verified
                                </span>
                                <span class="badge text-bg-primary position-absolute"
                                    style="top: 10px; right: 10px; font-size: 0.75em;">For Rent</span>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title fw-semibold mb-1">Self-Contained, Yaba</h6>
                                <p class="text-muted mb-1" style="font-size: 0.85em;">
                                    <i class="fa-solid fa-location-dot me-1 text-danger"></i>
                                    Herbert Macaulay Way, Yaba
                                </p>
                                <p class="fw-bold text-primary mb-2">₦380,000 <span
                                        class="text-muted fw-normal" style="font-size: 0.8em;">/ yr</span></p>
                                <div class="d-flex gap-3 text-muted mb-3" style="font-size: 0.82em;">
                                    <span><i class="fa-solid fa-bed me-1"></i> 1 Bed</span>
                                    <span><i class="fa-solid fa-bath me-1"></i> 1 Bath</span>
                                    <span><i class="fa-solid fa-couch me-1"></i> Unfurnished</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-outline-primary btn-sm flex-grow-1">View Details</a>
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Property Card 3 -->
                    <div class="col-md-4">
                        <div class="card box border-0 shadow-sm h-100">
                            <div style="position: relative;">
                                <img src="../media/singleproperty3.png" class="card-img-top"
                                    style="height: 180px; object-fit: cover;" alt="Property">
                                <span class="badge text-bg-success position-absolute"
                                    style="top: 10px; left: 10px; font-size: 0.75em;">
                                    <i class="fa-solid fa-circle-check me-1"></i> Verified
                                </span>
                                <span class="badge text-bg-primary position-absolute"
                                    style="top: 10px; right: 10px; font-size: 0.75em;">For Rent</span>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title fw-semibold mb-1">2-Bedroom Flat, Ikeja</h6>
                                <p class="text-muted mb-1" style="font-size: 0.85em;">
                                    <i class="fa-solid fa-location-dot me-1 text-danger"></i>
                                    Allen Avenue, Ikeja
                                </p>
                                <p class="fw-bold text-primary mb-2">₦750,000 <span
                                        class="text-muted fw-normal" style="font-size: 0.8em;">/ yr</span></p>
                                <div class="d-flex gap-3 text-muted mb-3" style="font-size: 0.82em;">
                                    <span><i class="fa-solid fa-bed me-1"></i> 2 Beds</span>
                                    <span><i class="fa-solid fa-bath me-1"></i> 1 Bath</span>
                                    <span><i class="fa-solid fa-couch me-1"></i> Semi-Furnished</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-outline-primary btn-sm flex-grow-1">View Details</a>
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row g-3 mb-5">

                </div>
            </div>
             <!-- Main Content End-->


        </div> 
    </div>

    <!-- Footer  -->
     <?php // include '../footer.php'; ?>
    <!-- Footer  -->














    <script src="jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script>
        


    </script>
</body>

</html>