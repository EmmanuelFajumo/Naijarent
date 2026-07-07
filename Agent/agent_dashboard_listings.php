 <?php 
    session_start();
    require_once "../process_pages/classes/Agent.php";
    require_once "agentguard.php";
    $agent = new Agent();

    $det = $agent->fetch_agent_details($_SESSION['agent_online']);

    $listings = $agent->fetch_All_listings($_SESSION['agent_online']);
    // foreach($listings as $l){
    //     echo $l['description'];
    // }
    //     echo "<pre>";
    //  print_r($listings);
    // echo "</pre>";            
         ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../css/animate.min.css">
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
    <div class="container-fluid " style="min-height: 900px;">
        <div class="row">
            <!-- Sidebar (Profile and Navigation) -->
            <?php include 'agent_nav.php'; ?>
            <!-- Sidebar (Profile and Navigation) -->
            <!-- Main Content -->
             <div class="col-md-9 px-5 pb-5 pt-3">
                <!-- Page Header -->
                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0">My Listings</h2>
                            <p class="text-muted mb-0">Manage all you property listings in one place </p>
                        </div>
                        <a class="btn  btn-outline-secondary rounded px-4" href='agent_dashboard_create_listing.php' type="submit"><i class="fa-solid fa-plus me-2"></i> Create New Listing </a>
                    </div>
                </div>
                <hr class="my-4">
                <!-- Stats Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card box p-3 text-center border-0 shadow-sm">
                            <i class="fa-solid fa-users fa-2x text-primary mb-2"></i>
                            <h5 class="mb-0">20</h5>
                            <small class="text-muted">Total Listings</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card box p-3 text-center border-0 shadow-sm">
                            <i class="fa-solid fa-circle-check fa-2x text-success mb-2"></i>
                            <h5 class="mb-0">19</h5>
                            <small class="text-muted">Live</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card box p-3 text-center border-0 shadow-sm">
                            <i class="fa-solid fa-clock fa-2x text-warning mb-2"></i>
                            <h5 class="mb-0">1</h5>
                            <small class="text-muted">Pending</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card box p-3 text-center border-0 shadow-sm">
                            <i class="fa-solid fa-eye fa-2x text-danger mb-2"></i>
                            <h5 class="mb-0">1000</h5>
                            <small class="text-muted">Total Views</small>
                        </div>
                    </div>
                </div>
                <!-- Search and Filter -->
                <div class="row g-3 mb-4 align-items-center">
                     <?php
                                if(isset($_SESSION['errormsg'])){
                                ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert"><?php echo $_SESSION['errormsg'];  unset($_SESSION['errormsg']);?>
                                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php
                                    }
                                ?>

                                <?php
                                    if(isset($_SESSION['successmsg'])){
                                ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert"><?php echo $_SESSION['successmsg'];  unset($_SESSION['successmsg']);?>
                                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                                
                                </div>
                                <?php
                                    }
                                ?>       
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search your listings...">
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
                        foreach($listings as $list){
                    ?>
                        <div class="col-md-4 property  <?php //echo $listing[0]; ?>">
                                    <div class="card box border-0 shadow-sm h-100">
                                        <div style="position: relative;">
                                            <img src="../uploads/property_pictures/<?php echo $list['image1']; ?>" class="card-img-top"
                                                style="height: 180px; object-fit: cover;" alt="Property">
                                            <span class="badge position-absolute ta"
                                                style="top: 10px; left: 10px; font-size: 0.75em;">
                                                <i class="fa-solid fa-circle-check me-1"></i>  <?php //echo $listing[0]; ?> </span>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="card-title fw-semibold mb-1"><?php echo $list['title']; ?></h6>
                                            <p class="text-muted mb-1" style="font-size: 0.85em;">
                                                <i class="fa-solid fa-location-dot me-1 text-danger"></i>
                                                <?php echo $list['LGA']." ".$list['state']; ?>
                                            </p>
                                            <p class="fw-bold text-primary mb-2"><?php echo $list['price']; ?> <span class="text-muted fw-normal"
                                                    style="font-size: 0.8em;">/ yr</span></p>
                                            <div class="d-flex gap-3 text-muted mb-3" style="font-size: 0.82em;">
                                                <span><i class="fa-solid fa-bed me-1"></i> <?php echo $list["bedrooms"]; ?> Beds</span>
                                                <span><i class="fa-solid fa-bath me-1"></i> <?php echo $list["bathrooms"]; ?> Baths</span>
                                                <span><i class="fa-solid fa-couch me-1"></i> <?php echo $list["furnished_status"]; ?></span>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <a href="agent_dashboard_edit_listing.php?property_id=<?php echo $list['property_id']; ?>" class="btn btn-outline-primary btn-sm flex-grow-1">Edit</a>
                                                <a href="#" class="btn btn-outline-secondary btn-sm flex-grow-1">Delete</a>
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
             <!-- Main Content End-->


        </div> 
    </div>

    <!-- Footer  -->
     <?php // include '../footer.php'; ?>
    <!-- Footer  -->














    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script>
        


    </script>
</body>

</html>