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

    <style>
        body {
            font-family: "Inter", sans-serif;
            background-color: #f5f6fa;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: "Voltaire", sans-serif;
        }

        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, #1E3888 0%, #2d52b5 100%);
            border-radius: 20px;
            padding: 32px 36px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }

        .welcome-banner::after {
            content: '';
            position: absolute;
            bottom: -60px;
            right: 80px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }

        .welcome-banner h1 {
            font-size: 1.9em;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .welcome-banner p {
            opacity: 0.8;
            font-size: 0.92em;
            margin-bottom: 0;
        }

        .complete-profile-btn {
            background: rgba(255,255,255,0.15);
            border: 1.5px solid rgba(255,255,255,0.35);
            color: white;
            border-radius: 50px;
            padding: 10px 28px;
            font-size: 0.88em;
            font-weight: 500;
            transition: all 0.3s;
            backdrop-filter: blur(4px);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .complete-profile-btn:hover {
            background: rgba(255,255,255,0.25);
            color: white;
            transform: translateY(-1px);
        }

        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 20px 22px;
            border: none;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            transition: transform 0.2s, box-shadow 0.2s;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 14px;
            flex-shrink: 0;
        }

        .stat-number {
            font-size: 1.75em;
            font-weight: 700;
            color: #1a1a2e;
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 0.8em;
            color: #9ca3af;
            font-weight: 500;
        }

        /* Section heading */
        .section-heading {
            font-size: 1.1em;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 0;
        }

        .section-subheading {
            font-size: 0.82em;
            color: #9ca3af;
            margin-bottom: 0;
        }

        /* Property Cards */
        .property-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            border: none;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            transition: transform 0.25s, box-shadow 0.25s;
            height: 100%;
        }

        .property-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 28px rgba(0,0,0,0.12);
        }

        .property-card .card-img-wrap {
            position: relative;
            overflow: hidden;
        }

        .property-card .card-img-top {
            height: 190px;
            object-fit: cover;
            width: 100%;
            transition: transform 0.4s ease;
        }

        .property-card:hover .card-img-top {
            transform: scale(1.04);
        }

        .property-card .card-body {
            padding: 16px 18px 18px;
        }

        .property-card .card-title {
            font-size: 0.95em;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 5px;
        }

        .property-card .card-location {
            font-size: 0.8em;
            color: #9ca3af;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .property-card .card-price {
            font-size: 1.05em;
            font-weight: 700;
            color: #1E3888;
            margin-bottom: 10px;
        }

        .property-card .card-price span {
            font-size: 0.75em;
            color: #9ca3af;
            font-weight: 400;
        }

        .property-card .card-meta {
            display: flex;
            gap: 12px;
            font-size: 0.78em;
            color: #6b7280;
            margin-bottom: 14px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f3f4f6;
        }

        .property-card .card-meta span {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .badge-verified {
            background: #ecfdf5;
            color: #059669;
            border-radius: 20px;
            padding: 4px 10px;
            font-size: 0.72em;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .badge-rent {
            background: #eff6ff;
            color: #1E3888;
            border-radius: 20px;
            padding: 4px 10px;
            font-size: 0.72em;
            font-weight: 600;
        }

        .btn-view {
            background: #f0f4ff;
            color: #1E3888;
            border: none;
            border-radius: 10px;
            font-size: 0.82em;
            font-weight: 600;
            padding: 8px 0;
            transition: all 0.2s;
            flex: 1;
        }

        .btn-view:hover {
            background: #1E3888;
            color: white;
        }

        .btn-save {
            background: #f9fafb;
            color: #6b7280;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .btn-save:hover {
            background: #fff0f0;
            color: #ef4444;
            border-color: #fecaca;
        }

        /* Quick Action Buttons */
        .quick-action {
            background: white;
            border-radius: 14px;
            padding: 18px 16px;
            text-align: center;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border: 1.5px solid transparent;
            cursor: pointer;
            transition: all 0.25s;
            text-decoration: none;
            display: block;
            color: inherit;
        }

        .quick-action:hover {
            border-color: #1E3888;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30,56,136,0.12);
            color: inherit;
        }

        .quick-action-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin: 0 auto 10px;
        }

        .quick-action-label {
            font-size: 0.82em;
            font-weight: 600;
            color: #374151;
        }

        /* Divider with label */
        .section-divider {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        /* Alert overrides */
        .alert {
            border-radius: 12px;
            border: none;
            font-size: 0.9em;
        }

        .alert-danger  { background: #fef2f2; color: #991b1b; }
        .alert-success { background: #f0fdf4; color: #166534; }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row" style="min-height: 100vh;">

            <!-- Sidebar -->
            <?php include 'agent_nav.php'; ?>

            <!-- Main Content -->
            <div class="col-md-10 px-4 px-lg-5 py-4">

                <!-- Alerts -->
                <?php if (isset($_SESSION['errormsg'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <i class="fa-solid fa-circle-exclamation me-2"></i>
                        <?php echo $_SESSION['errormsg']; unset($_SESSION['errormsg']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['successmsg'])): ?>
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i>
                        <?php echo $_SESSION['successmsg']; unset($_SESSION['successmsg']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Welcome Banner -->
                <div class="welcome-banner mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <p style="opacity:0.7; font-size:0.82em; margin-bottom:4px; letter-spacing:0.5px;">
                                AGENT DASHBOARD
                            </p>
                            <h1 class="mb-2">
                                Welcome back, <?php echo $det['first_name']; ?>! 👋
                            </h1>
                            <p class="mb-4">
                                Here's an overview of your listings and account activity.
                            </p>
                            <a class="complete-profile-btn"
                                href="agent_profile.php"
                                >
                                Complete Your Profile
                                <i class="fa-solid fa-arrow-right-long"></i>
                            </a>
                        </div>
                        <div class="col-md-4 d-none d-md-flex justify-content-end">
                            <i class="fa-solid fa-house-chimney-window"
                                style="font-size: 6em; opacity: 0.08;"></i>
                        </div>
                    </div>
                </div>

                <!-- Stats Row -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon"
                                style="background:#eff6ff;">
                                <i class="fa-solid fa-building"
                                    style="color:#1E3888;"></i>
                            </div>
                            <div class="stat-number">12</div>
                            <div class="stat-label">Total Listings</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon"
                                style="background:#f0fdf4;">
                                <i class="fa-solid fa-circle-check"
                                    style="color:#16a34a;"></i>
                            </div>
                            <div class="stat-number">8</div>
                            <div class="stat-label">Active Listings</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon"
                                style="background:#fff7ed;">
                                <i class="fa-solid fa-message"
                                    style="color:#ea580c;"></i>
                            </div>
                            <div class="stat-number">5</div>
                            <div class="stat-label">New Inquiries</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon"
                                style="background:#fdf4ff;">
                                <i class="fa-solid fa-eye"
                                    style="color:#9333ea;"></i>
                            </div>
                            <div class="stat-number">1.2k</div>
                            <div class="stat-label">Total Views</div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <p class="section-heading mb-3">Quick Actions</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="agent_dashboard_create_listing.php" class="quick-action">
                            <div class="quick-action-icon"
                                style="background:#eff6ff;">
                                <i class="fa-solid fa-plus"
                                    style="color:#1E3888;"></i>
                            </div>
                            <div class="quick-action-label">New Listing</div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="messages.php" class="quick-action">
                            <div class="quick-action-icon"
                                style="background:#fff7ed;">
                                <i class="fa-solid fa-comments"
                                    style="color:#ea580c;"></i>
                            </div>
                            <div class="quick-action-label">Messages</div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="payments.php" class="quick-action">
                            <div class="quick-action-icon"
                                style="background:#f0fdf4;">
                                <i class="fa-solid fa-circle-dollar-to-slot"
                                    style="color:#16a34a;"></i>
                            </div>
                            <div class="quick-action-label">Payments</div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="agent_profile.php"
                            data-bs-target="#exampleModalToggle"
                            data-bs-toggle="modal"
                            class="quick-action">
                            <div class="quick-action-icon"
                                style="background:#fdf4ff;">
                                <i class="fa-solid fa-user-pen"
                                    style="color:#9333ea;"></i>
                            </div>
                            <div class="quick-action-label">Edit Profile</div>
                        </a>
                    </div>
                </div>

                <!-- My Listings -->
                <div class="section-divider">
                    <div>
                        <p class="section-heading">My Listings</p>
                        <p class="section-subheading">Your recently listed properties</p>
                    </div>
                    <a href="my_listings.php"
                        class="btn btn-sm btn-outline-primary rounded-pill px-4"
                        style="font-size:0.82em;">
                        View All
                        <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="row g-3 mb-5">

                    <!-- Property Card 1 -->
                    

                    <!-- Property Card 2 -->
                    

                    <!-- Property Card 3 -->
                    <div class="col-md-4">
                        <div class="property-card">
                            <div class="card-img-wrap">
                                <img src="../media/singleproperty3.png"
                                    class="card-img-top" alt="Property">
                                <div class="position-absolute d-flex gap-2"
                                    style="top:12px; left:12px;">
                                    <span class="badge-verified">
                                        <i class="fa-solid fa-circle-check"></i> Verified
                                    </span>
                                </div>
                                <div class="position-absolute"
                                    style="top:12px; right:12px;">
                                    <span class="badge-rent">For Rent</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">2-Bedroom Flat, Ikeja</h6>
                                <div class="card-location">
                                    <i class="fa-solid fa-location-dot text-danger"></i>
                                    Allen Avenue, Ikeja
                                </div>
                                <div class="card-price">
                                    ₦750,000 <span>/ yr</span>
                                </div>
                                <div class="card-meta">
                                    <span><i class="fa-solid fa-bed"></i> 2 Beds</span>
                                    <span><i class="fa-solid fa-bath"></i> 1 Bath</span>
                                    <span><i class="fa-solid fa-couch"></i> Semi-Furnished</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn-view btn">View Details</a>
                                    <button class="btn-save btn">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- Main Content End -->

        </div>
    </div>

    <!-- Footer -->
    <?php // include '../footer.php'; ?>

    <script src="jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>