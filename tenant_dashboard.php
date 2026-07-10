<?php
session_start();
    require_once "userguard.php";
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
    <title>Tenant Dashboard</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="animate.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>    
    <link rel="stylesheet" href="style.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --navy-dark: #14213D;
            --navy-light: #1E3888;
            --gold: #FFD700;
            --gold-hover: #FFA500;
            --bg-light: #f8f9fc;
        }

        body {
            background: var(--bg-light);
        }

        /* ── Welcome Banner ── */
        .welcome-banner-tenant {
            background: linear-gradient(135deg, var(--navy-dark), var(--navy-light));
            border-radius: 20px;
            padding: 32px 36px;
            position: relative;
            overflow: hidden;
        }
        .welcome-banner-tenant::after {
            content: '';
            position: absolute;
            top: -40%;
            right: -10%;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: rgba(255,255,255,0.03);
        }
        .welcome-banner-tenant::before {
            content: '';
            position: absolute;
            bottom: -30%;
            left: 30%;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: rgba(255,215,0,0.04);
        }
        .welcome-banner-tenant h1 {
            color: #ffffff;
            font-family: "Voltaire", sans-serif;
            font-size: 2em;
            margin-bottom: 4px;
            position: relative;
            z-index: 1;
        }
        .welcome-banner-tenant p {
            color: rgba(255,255,255,0.75);
            margin-bottom: 0;
            position: relative;
            z-index: 1;
            font-size: 0.92em;
        }
        .welcome-banner-tenant p strong {
            color: #FFD700;
        }
        .welcome-banner-tenant .btn-browse {
            background: #FFD700;
            border: none;
            color: var(--navy-dark);
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 50px;
            font-size: 0.85em;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(255,215,0,0.3);
            position: relative;
            z-index: 1;
            white-space: nowrap;
        }
        .welcome-banner-tenant .btn-browse:hover {
            background: #ffe033;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(255,215,0,0.4);
        }

        /* ── Stats Cards ── */
        .stat-card-tenant {
            border: none;
            border-radius: 14px;
            padding: 20px 16px;
            transition: all 0.3s ease;
            background: #ffffff;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            position: relative;
            overflow: hidden;
        }
        .stat-card-tenant::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            border-radius: 14px 0 0 14px;
        }
        .stat-card-tenant:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.08);
        }
        .stat-card-tenant .stat-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2em;
            margin-bottom: 12px;
        }
        .stat-card-tenant .stat-number {
            font-family: "Voltaire", sans-serif;
            font-size: 1.8em;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1px;
        }
        .stat-card-tenant .stat-label {
            font-size: 0.8em;
            color: #8a94a6;
            font-weight: 500;
        }

        .stat-card-tenant.navy::before { background: var(--navy-light); }
        .stat-card-tenant.navy .stat-icon-box { background: #eef1fa; color: var(--navy-light); }
        .stat-card-tenant.navy .stat-number { color: var(--navy-light); }

        .stat-card-tenant.green::before { background: #10b981; }
        .stat-card-tenant.green .stat-icon-box { background: #ecfdf5; color: #10b981; }
        .stat-card-tenant.green .stat-number { color: #10b981; }

        .stat-card-tenant.amber::before { background: #f59e0b; }
        .stat-card-tenant.amber .stat-icon-box { background: #fffbeb; color: #f59e0b; }
        .stat-card-tenant.amber .stat-number { color: #f59e0b; }

        .stat-card-tenant.rose::before { background: #ef4444; }
        .stat-card-tenant.rose .stat-icon-box { background: #fef2f2; color: #ef4444; }
        .stat-card-tenant.rose .stat-number { color: #ef4444; }

        /* ── Section Header ── */
        .section-header-tenant {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }
        .section-header-tenant h4 {
            font-family: "Voltaire", sans-serif;
            font-size: 1.4em;
            color: var(--navy-dark);
            margin-bottom: 0;
        }
        .section-header-tenant a {
            font-size: 0.85em;
            color: var(--navy-light);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .section-header-tenant a:hover {
            color: var(--navy-dark);
            gap: 6px;
        }

        /* ── Property Cards ── */
        .property-card-tenant {
            border: none;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            transition: all 0.3s ease;
            height: 100%;
            background: #ffffff;
        }
        .property-card-tenant:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.08);
        }
        .property-card-tenant .img-wrap {
            position: relative;
            overflow: hidden;
        }
        .property-card-tenant .img-wrap img {
            height: 190px;
            object-fit: cover;
            transition: transform 0.5s ease;
            width: 100%;
        }
        .property-card-tenant:hover .img-wrap img {
            transform: scale(1.05);
        }
        .property-card-tenant .badge-verified {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 0.72em;
            padding: 4px 12px;
            border-radius: 50px;
            background: rgba(25,135,84,0.9);
            color: #fff;
            backdrop-filter: blur(4px);
        }
        .property-card-tenant .badge-rent {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 0.72em;
            padding: 4px 12px;
            border-radius: 50px;
        }
        .property-card-tenant .card-body {
            padding: 16px;
        }
        .property-card-tenant .prop-title {
            font-size: 0.92em;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .property-card-tenant .prop-location {
            font-size: 0.8em;
            color: #9ca3af;
            margin-bottom: 8px;
        }
        .property-card-tenant .prop-location i {
            color: #dc3545;
        }
        .property-card-tenant .prop-price {
            font-size: 1em;
            font-weight: 700;
            color: var(--navy-light);
            margin-bottom: 10px;
        }
        .property-card-tenant .prop-price small {
            font-weight: 400;
            color: #9ca3af;
            font-size: 0.7em;
        }
        .property-card-tenant .prop-features {
            display: flex;
            gap: 14px;
            font-size: 0.78em;
            color: #6b7280;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f3f4f6;
        }
        .property-card-tenant .prop-features span {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .property-card-tenant .prop-features span i { color: var(--navy-light); }
        .property-card-tenant .btn-outline-primary {
            color: var(--navy-light) !important;
            border-color: var(--navy-light) !important;
            border-radius: 8px;
            font-size: 0.82em;
            font-weight: 600;
        }
        .property-card-tenant .btn-outline-primary:hover {
            background: var(--navy-light) !important;
            color: #fff !important;
        }

        .alert-custom {
            border-radius: 12px;
            border-left: 4px solid;
        }
        .alert-custom.alert-success {
            border-left-color: #198754;
        }
        .alert-custom.alert-danger {
            border-left-color: #dc3545;
        }

        .section-divider {
            height: 2px;
            background: linear-gradient(to right, transparent, rgba(20, 33, 61, 0.12), transparent);
            border: none;
            margin: 20px 0;
            opacity: 1;
        }
    </style>

</head>

<body>
    <!-- Navigation -->
    <?php include 'nav.php'; ?>

    <div class="container" style="min-height: 900px; padding-top: 32px;">
        <div class="row justify-content-center">
            <!-- Main Content -->
            <div class="col-md-11 px-3 px-lg-4 pb-5">

                <!-- Welcome Banner -->
                <div class="welcome-banner-tenant mb-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                        <div>
                            <h1>Welcome back, <?php echo $user_deet['first_name']; ?> 👋</h1>
                            <p>You have <strong>3 unread messages</strong> and <strong>2 new listings</strong> matching your saved search.</p>
                        </div>
                        <a class="btn-browse" href="all_properties.php">
                            <i class="fa-solid fa-magnifying-glass me-2"></i> Browse Listings
                        </a>
                    </div>
                </div>

                <!-- Alert Messages -->
                <?php if(isset($_SESSION['errormsg'])){ ?>
                    <div class="alert alert-danger alert-dismissible fade show alert-custom" role="alert">
                        <i class="fa-solid fa-circle-exclamation me-2"></i>
                        <?php echo $_SESSION['errormsg']; unset($_SESSION['errormsg']);?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
                <?php if(isset($_SESSION['successmsg'])){ ?>
                    <div class="alert alert-success alert-dismissible fade show alert-custom" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i>
                        <?php echo $_SESSION['successmsg']; unset($_SESSION['successmsg']);?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <!-- Stats Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="stat-card-tenant navy p-3">
                            <div class="stat-icon-box">
                                <i class="fa-solid fa-bookmark"></i>
                            </div>
                            <div class="stat-number">12</div>
                            <div class="stat-label">Saved Properties</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card-tenant green p-3">
                            <div class="stat-icon-box">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <div class="stat-number">3</div>
                            <div class="stat-label">Saved Searches</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card-tenant amber p-3">
                            <div class="stat-icon-box">
                                <i class="fa-regular fa-envelope"></i>
                            </div>
                            <div class="stat-number">5</div>
                            <div class="stat-label">Unread Messages</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card-tenant rose p-3">
                            <div class="stat-icon-box">
                                <i class="fa-solid fa-circle-dollar-to-slot"></i>
                            </div>
                            <div class="stat-number">₦450k</div>
                            <div class="stat-label">Total Payments</div>
                        </div>
                    </div>
                </div>

                <hr class="section-divider">

                <!-- Recommended Properties -->
                <div class="section-header-tenant">
                    <h4><i class="fa-solid fa-thumbs-up me-2" style="color:var(--navy-light);"></i>Recommended For You</h4>
                    <a href="all_properties.php">
                        View All <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="row g-3 mb-5">

                <?php
                    foreach($all_listings as $li){
                ?>
                    <div class="col-md-4">
                        <div class="card property-card-tenant">
                            <div class="img-wrap">
                                <img src="uploads/property_pictures/<?php echo $li['image1'] ?>" alt="Property">
                                <span class="badge-verified">
                                    <i class="fa-solid fa-circle-check me-1"></i> Verified
                                </span>
                                <span class="badge-rent badge bg-primary">For Rent</span>
                            </div>
                            <div class="card-body">
                                <div class="prop-title"><?php echo $li['title']?></div>
                                <div class="prop-location">
                                    <i class="fa-solid fa-location-dot me-1"></i>
                                    Lekki Phase 1, Lagos
                                </div>
                                <div class="prop-price"><?php echo $li['price']?> <small>/ yr</small></div>
                                <div class="prop-features">
                                    <span><i class="fa-solid fa-bed"></i> <?php echo $li['bedrooms']?> Beds</span>
                                    <span><i class="fa-solid fa-bath"></i> <?php echo $li['bathrooms']?></span>
                                    <span><i class="fa-solid fa-couch"></i> <?php echo $li['furnished_status']?></span>
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

    <!-- Footer -->
    <?php include 'footer.php'; ?>

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
                            style="width: 110px; height: 110px; background-color: white; border-radius: 50%; margin-top: 30px;">
                            <img src="media/q.png" alt="Profile Picture" class="box"
                                style="width: 100px; height: 100px; border-radius: 50%;">
                        </div>
                        <h5 class="text-center mt-3 card box p-1">Samson Johnson</h5>
                        <p class="text-center label">Scout</p>
                        <div class="profile-menu mt-4">
                            <a href="tenant_dashboard.html" class="d-block py-2 px-3 text-dark">Dashboard</a>
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

    <script src="jquery.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>