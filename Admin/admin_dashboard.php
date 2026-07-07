<?php
    session_start();
    require_once "adminguard.php";
    require_once "classes/Admin.php";
    $admin = new Admin();
    $tenants = $admin->get_all_tenants();
    $agents = $admin->get_all_agents();
    $listings = $admin->fetch_All_listings();
    


    $no_of_listing = 18;
    $no_of_agents = 6;
    $no_of_reports = 7;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="preconnect" href="../https://fonts.googleapis.com">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">


    <style>
        /* font-family: "Voltaire", sans-serif; */
        /* font-family: "Inter", sans-serif; */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Voltaire", sans-serif;
        }

        a {
            text-decoration: none;
        }

        body {
            font-family: "Inter", sans-serif;
        }

        .nlink {
            margin-left: 10px;
            font-family: "Inter", sans-serif;
            text-transform: uppercase;
            font-size: 1em;
        }

        .label {
            font-family: "Inter", sans-serif;
            font-size: 0.8em;
            font-weight: 400;
        }

        .icon {
            width: 30px;
            object-fit: cover;
        }

        .box:hover {
            background-color: white;
            transform: scale(1.02);
            transition: 0.5s;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        .footer-section {
            background: linear-gradient(135deg, #14213D, #1E3888);
            border-top-left-radius: 30px;
            border-top-right-radius: 30px;
        }

        .footer-title {
            font-weight: 600;
            margin-bottom: 20px;
            color: #ffffff;
        }

        .footer-text {
            color: rgba(255, 255, 255, 0.75);
            max-width: 500px;
            margin: auto;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            text-decoration: none;
            color: rgba(255, 255, 255, 0.75);
            transition: 0.3s ease;
        }

        .footer-links a:hover {
            color: #ffffff;
            padding-left: 5px;
        }

        .footer-line {
            border-color: rgba(255, 255, 255, 0.15);
        }

        .footer-section p {
            color: rgba(255, 255, 255, 0.75);
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
                                <h1 class="mb-1">Admin Dashboard </h1>
                                <p class="mb-0 text-muted">Welcome back, <strong>Admin.</strong> Here's what's
                                    happening on NaijaRent today.</p>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="admin_dashboard_verifications.php" class="rounded-pill btn btn-primary px-4 py-2">
                                    <i class="fa-solid fa-check-double me-2"></i> Review Verifications
                                </a>
                                <a href="#" class="rounded-pill btn btn-outline-danger px-4 py-2">
                                    <i class="fa-solid fa-flag me-2"></i> View Reports
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Pending Actions Alert -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="alert border-0 shadow-sm d-flex align-items-center justify-content-between flex-wrap gap-3 mb-0" style="background-color: #fff8e1;">
                            <div class="d-flex align-items-center gap-3">
                                <i class="fa-solid fa-triangle-exclamation fa-lg text-warning mx-2"></i>
                            
                                <span style='font-size: 0.95em;'>You have <strong> <?php echo count($listings); ?></strong> and<strong> <?php echo count($listings); ?> </strong> awaiting verification, and <strong><?php echo count($listings); ?> open reports</strong> to resolve. </span>
                                
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="#" class="btn btn-sm btn-warning px-3">
                                    Review Agents
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-warning px-3">
                                    Review Listings
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Row 1 - Users -->
                <div class="row mb-2">
                    <div class="col-12">
                        <h5 class="text-muted fw-medium" style="font-size: 0.9em; text-transform: uppercase;
                letter-spacing: 1px;">User Overview</h5>
                    </div>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="card box border-0 shadow-sm p-3 text-center">
                            <i class="fa-solid fa-users fa-2x mb-2" style="color: #1E3888;"></i>
                            <h5 class="mb-0 fw-bold">--</h5>
                            <small class="text-muted">Total Users</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card box border-0 shadow-sm p-3 text-center">
                            <i class="fa-solid fa-person fa-2x text-success mb-2"></i>
                            <h5 class="mb-0 fw-bold"><?php echo count($tenants); ?></h5>
                            <small class="text-muted">Total Tenants</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card box border-0 shadow-sm p-3 text-center">
                            <i class="fa-solid fa-user-tie fa-2x text-primary mb-2"></i>
                            <h5 class="mb-0 fw-bold"><?php echo count($agents); ?></h5>
                            <small class="text-muted">Total Agents</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card box border-0 shadow-sm p-3 text-center">
                            <i class="fa-solid fa-user-plus fa-2x text-warning mb-2"></i>
                            <h5 class="mb-0 fw-bold">---</h5>
                            <small class="text-muted">New This Week</small>
                        </div>
                    </div>
                </div>

                <!-- Stats Row 2 - Platform -->
                <div class="row mb-2">
                    <div class="col-12">
                        <h5 class="text-muted fw-medium" style="font-size: 0.9em; text-transform: uppercase; etter-spacing: 1px;">Platform Overview</h5>
                    </div>
                </div>
                <div class="row g-3 mb-5">
                    <div class="col-6 col-md-3">
                        <div class="card box border-0 shadow-sm p-3 text-center">
                            <i class="fa-solid fa-house-chimney fa-2x text-primary mb-2"></i>
                            <h5 class="mb-0 fw-bold"><?php echo count($listings); ?></h5>
                            <small class="text-muted">Total Listings</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card box border-0 shadow-sm p-3 text-center">
                            <i class="fa-solid fa-clock fa-2x text-warning mb-2"></i>
                            <h5 class="mb-0 fw-bold"><?php echo count($listings); ?></h5>
                            <small class="text-muted">Pending Approvals</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card box border-0 shadow-sm p-3 text-center">
                            <i class="fa-solid fa-flag fa-2x text-danger mb-2"></i>
                            <h5 class="mb-0 fw-bold">7</h5>
                            <small class="text-muted">Open Reports</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card box border-0 shadow-sm p-3 text-center">
                            <i class="fa-solid fa-circle-dollar-to-slot fa-2x text-success mb-2"></i>
                            <h5 class="mb-0 fw-bold">₦48.5M</h5>
                            <small class="text-muted">Total Payments</small>
                        </div>
                    </div>
                </div>


            </div>
            <!-- End Main Content -->

        </div>




    </div>


  













    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>

    </script>
</body>

</html>