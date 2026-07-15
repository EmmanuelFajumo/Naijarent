<?php 
 session_start();
 require_once "classes/Admin.php";
 require_once "adminguard.php";
 $listing = new Admin();
 $all = $listing->fetch_All_listings();

//  echo "<pre>";
//  print_r($all);
//  echo "</pre>";
 
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Manage Listings</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="preconnect" href="../https://fonts.googleapis.com">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="admin.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">

    <style>
        .profile-menu a { text-decoration: none; }
    </style>

</head>

<body>
    <div class="container-fluid" style="min-height: 100vh;">
        <div class="row" style="min-height: 100vh;">
           <!-- Sidebar -->
            <?php include 'admin_nav.php'; ?>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 px-4 px-lg-5 pb-5 pt-3" style="background:#f4f6fb;">

                <!-- Mobile Menu Toggle -->
                <div class="row mb-3">
                    <div class="col-12 d-md-none">
                        <button class="mobile-menu-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                            <i class="fa-solid fa-bars me-2"></i> Menu
                        </button>
                    </div>
                </div>

                <!-- Page Header -->
                <div class="row mt-3 mb-4">
                    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="page-header">
                            <h2 class="mb-1">Manage Listings</h2>
                            <p class="mb-0">Total Listings: <strong><?php echo count($all); ?></strong></p>
                        </div>
                        <button class="btn-export">
                            <i class="fa-solid fa-download me-2"></i> Export CSV
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-4">
                        <div class="stat-card text-center">
                            <div class="stat-icon mx-auto"><i class="fa-solid fa-house-chimney"></i></div>
                            <div class="stat-value"><?php echo count($all); ?></div>
                            <div class="stat-label">Total Listings</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="stat-card text-center">
                            <div class="stat-icon mx-auto"><i class="fa-solid fa-circle-check"></i></div>
                            <div class="stat-value">70</div>
                            <div class="stat-label">Live</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="stat-card text-center">
                            <div class="stat-icon mx-auto"><i class="fa-solid fa-clock"></i></div>
                            <div class="stat-value">30</div>
                            <div class="stat-label">Pending Approval</div>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="row g-3 mb-4 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group filter-input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search by title or location...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select form-select-custom">
                            <option selected>All property types</option>
                            <option value="all">All property types</option>
                            <option value="flat">Flat</option>
                            <option value="self-contained">Self-contained</option>
                            <option value="miniflat">Mini flat</option>
                            <option value="duplex">Duplex</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select form-select-custom">
                            <option selected>All location</option>
                            <option value="all">All location</option>
                            <option value="abia">Abia</option>
                            <option value="adamawa">Adamawa</option>
                            <option value="akwa-Ibom">Akwa Ibom</option>
                            <option value="anambra">Anambra</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select form-select-custom">
                            <option selected>Sort By</option>
                            <option value="lowest">Price: low to high</option>
                            <option value="highest">Price: high to low</option>
                            <option value="reported">Most reported</option>
                        </select>
                    </div>
                </div>

                <!-- Filter Badges -->
                <div class="row mb-4">
                    <div class="col-12 d-flex gap-2 flex-wrap">
                        <span class="filter-badge active" id="all">All (<?php echo count($all); ?>)</span>
                        <span class="filter-badge" id="live">Live (70)</span>
                        <span class="filter-badge" id="pending">Pending (20)</span>
                        <span class="filter-badge" id="rejected">Rejected (10)</span>
                        <span class="filter-badge" id="suspended">Suspended (7)</span>
                    </div>
                </div>

                <!-- Listings Grid -->
                <div class="row g-4">
                    <?php
                        foreach($all as $prop){
                    ?>
                        <div class="col-md-4 property <?php echo $prop['verification_status']; ?>">
                            <div class="property-card">
                                <div style="position: relative;">
                                    <img src="../uploads/property_pictures/<?php echo $prop['image1']; ?>" class="card-img-top" alt="Property">
                                    <span class="badge position-absolute ta" style="top: 10px; left: 10px; font-size: 0.72em; padding: 5px 12px; border-radius: 50px;">
                                        <i class="fa-solid fa-circle-check me-1"></i> <?php echo $prop['verification_status']; ?>
                                    </span>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title"><?php echo $prop['title']; ?></h6>
                                    <p class="card-location">
                                        <i class="fa-solid fa-location-dot me-1 text-danger"></i>
                                        <?php echo $prop['LGA']." ".$prop['state']; ?>
                                    </p>
                                    <div class="property-price">₦<?php echo number_format($prop['price']); ?> <span class="fw-normal" style="font-size:0.75em;color:#9ca3af;">/ yr</span></div>
                                    <div class="property-features">
                                        <span><i class="fa-solid fa-bed"></i> <?php echo $prop['bedrooms']; ?> Beds</span>
                                        <span><i class="fa-solid fa-bath"></i> <?php echo $prop['bathrooms']; ?> Baths</span>
                                        <span><i class="fa-solid fa-couch"></i> <?php echo $prop['furnished_status']; ?></span>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="single_listing.php?id=<?php echo $prop['property_id']; ?>" class="btn btn-sm flex-grow-1 btn-details">View Details</a>
                                        <button class="btn btn-sm" style="border:1px solid #e5e7eb;border-radius:8px;color:#6b7280;">
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
                    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <small class="text-muted">Showing 1 - <?php echo count($all); ?> of <?php echo count($all); ?> listings</small>
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
                    <div class="profile-box d-flex flex-column justify-content-center align-items-center" style="padding: 20px;">
                        <div class="profile-pic d-flex justify-content-center align-items-center"
                            style="width: 110px; height: 110px; background-color: white; border-radius: 50%; margin-top: 30px;">
                            <img src="media/q.png" alt="Profile Picture" class="box"
                                style="width: 100px; height: 100px; border-radius: 50%;">
                        </div>
                        <h5 class="text-center mt-3 card box p-1">Samson Johnson</h5>
                        <p class="text-center label">Scout</p>
                        <div class="profile-menu mt-4">
                            <a href="tenant_dashbord.html" class="d-block py-2 px-3 text-dark">Dashboard</a>
                            <a href="#" class="d-block py-2 px-3 text-dark">Browse Listings</a>
                            <a href="#" class="d-block py-2 px-3 text-dark">Messages</a>
                            <a href="#" class="d-block py-2 px-3 text-dark">Settings</a>
                            <a href="#" class="d-block py-2 px-3 text-dark">My Profile</a>
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

            $('.Live .ta').addClass('text-bg-success');
            $('.Pending .ta').addClass('text-bg-secondary');
            $('.rejected .ta').addClass('text-bg-danger');
            $('.suspended .ta').addClass('text-bg-warning');

            $('.filter-badge').click(function(){
                $('.filter-badge').removeClass('active');
                $(this).addClass('active');
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