<?php
    session_start();
    require_once "adminguard.php";
    require_once "classes/Admin.php";
    $admin = new Admin();
    $tenants  = $admin->get_all_tenants();
    $agents   = $admin->get_all_agents();
    $listings = $admin->fetch_All_listings();
    $pending_listings = $admin->get_all_listing_bystatus('pending');
    $pending_agents   = $admin->get_agents_byid('pending');
    $new_this_week    = $admin->get_new_users_this_week();
    $total_users      = count($tenants) + count($agents);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard · NaijaRent</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="preconnect" href="../https://fonts.googleapis.com">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="admin_dashboard.css">


</head>

<body>
    
    <div class="container-fluid" style="min-height: 100vh;">
        <div class="row" style="min-height: 100vh;">
            <!-- Sidebar -->
            <?php include 'admin_nav.php'; ?>

            <!-- Main Content -->
            <div class="col-12 col-md-9 col-lg-10 px-3 px-md-4 px-lg-5 pb-5 pt-3" style="background:#f4f6fb;">

                <!-- Mobile Menu Toggle -->
                <div class="row mb-3">
                    <div class="col-12 d-md-none">
                        <button class="mobile-menu-btn" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#mobileMenu" aria-controls="mobileMenu">
                            <i class="fa-solid fa-bars me-2"></i> Menu
                        </button>
                    </div>
                </div>

                <!-- Dashboard Banner -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="dashboard-banner">
                            <div class="banner-icon-box">
                                <i class="fa-solid fa-gauge-high"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h1>Admin Dashboard</h1>
                                <p>Welcome back, Admin. Here's what's happening on NaijaRent today.</p>
                            </div>
                            <div class="d-flex gap-2 flex-wrap flex-shrink-0">
                                <a href="admin_dashboard_verifications.php" class="btn-banner-primary">
                                    <i class="fa-solid fa-check-double"></i> Review Verifications
                                </a>
                                <a href="#" class="btn-banner-outline">
                                    <i class="fa-solid fa-flag"></i> View Reports
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Actions Alert -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="alert-card">
                            <div class="d-flex align-items-center gap-3">
                                <div class="alert-icon-box">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </div>
                                <span class="alert-text">
                                    You have <strong><?php echo count($pending_listings); ?></strong> listings and <strong><?php echo count($pending_agents); ?></strong> agents awaiting verification, and <strong>7 open reports</strong> to resolve.
                                </span>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="#" class="btn-alert-sm">Review Agents</a>
                                <a href="#" class="btn-alert-sm">Review Listings</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Row 1 - User Overview -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="section-header">User Overview</div>
                    </div>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="stat-card text-center">
                            <div class="stat-icon mx-auto"><i class="fa-solid fa-users"></i></div>
                            <div class="stat-value"><?php echo $total_users; ?></div>
                            <div class="stat-label">Total Users</div>
                            <div class="stat-trend text-muted"><i class="fa-regular fa-circle me-1"></i> All time</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card text-center">
                            <div class="stat-icon mx-auto"><i class="fa-solid fa-person"></i></div>
                            <div class="stat-value"><?php echo count($tenants); ?></div>
                            <div class="stat-label">Total Tenants</div>
                            <div class="stat-trend text-muted"><i class="fa-solid fa-arrow-up me-1"></i> Active</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card text-center">
                            <div class="stat-icon mx-auto"><i class="fa-solid fa-user-tie"></i></div>
                            <div class="stat-value"><?php echo count($agents); ?></div>
                            <div class="stat-label">Total Agents</div>
                            <div class="stat-trend text-muted"><i class="fa-solid fa-arrow-up me-1"></i> Active</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card text-center">
                            <div class="stat-icon mx-auto"><i class="fa-solid fa-user-plus"></i></div>
                            <div class="stat-value"><?php echo $new_this_week; ?></div>
                            <div class="stat-label">New This Week</div>
                            <div class="stat-trend text-muted"><i class="fa-regular fa-clock me-1"></i> This week</div>
                        </div>
                    </div>
                </div>

                <!-- Stats Row 2 - Platform Overview -->
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="section-header">Platform Overview</div>
                    </div>
                </div>
                <div class="row g-3 mb-5">
                    <div class="col-6 col-md-3">
                        <div class="stat-card text-center">
                            <div class="stat-icon mx-auto"><i class="fa-solid fa-house-chimney"></i></div>
                            <div class="stat-value"><?php echo count($listings); ?></div>
                            <div class="stat-label">Total Listings</div>
                            <div class="stat-trend text-muted"><i class="fa-regular fa-building me-1"></i> Properties</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card text-center">
                            <div class="stat-icon mx-auto"><i class="fa-solid fa-clock"></i></div>
                            <div class="stat-value"><?php echo count($pending_listings); ?></div>
                            <div class="stat-label">Pending Approvals</div>
                            <div class="stat-trend text-muted"><i class="fa-regular fa-hourglass-half me-1"></i> Needs review</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card text-center">
                            <div class="stat-icon mx-auto"><i class="fa-solid fa-flag"></i></div>
                            <div class="stat-value">7</div>
                            <div class="stat-label">Open Reports</div>
                            <div class="stat-trend text-muted"><i class="fa-solid fa-exclamation me-1"></i> Requires action</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card text-center">
                            <div class="stat-icon mx-auto"><i class="fa-solid fa-circle-dollar-to-slot"></i></div>
                            <div class="stat-value">₦48.5M</div>
                            <div class="stat-label">Total Payments</div>
                            <div class="stat-trend text-muted"><i class="fa-solid fa-arrow-up me-1"></i> +12% vs last month</div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions + Recent Activity Row -->
                <div class="row g-4 mb-5">
                    <!-- Quick Actions -->
                    <div class="col-md-5">
                        <div class="section-header mt-2">Quick Actions</div>
                        <div class="row g-3">
                            <div class="col-6">
                                <a href="admin_dashboard_manage_listings.php" class="quick-action-card">
                                    <div class="qa-icon" style="background:#eef1fa;color:#1E3888;"><i class="fa-solid fa-plus"></i></div>
                                    <div class="qa-title">New Listing</div>
                                    <div class="qa-sub">Add a property</div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="admin_dashboard_manage_agents.php" class="quick-action-card">
                                    <div class="qa-icon" style="background:#eef1fa;color:#1E3888;"><i class="fa-solid fa-user-plus"></i></div>
                                    <div class="qa-title">Add Agent</div>
                                    <div class="qa-sub">Register agent</div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="admin_dashboard_property_type.php" class="quick-action-card">
                                    <div class="qa-icon" style="background:#eef1fa;color:#1E3888;"><i class="fa-solid fa-tags"></i></div>
                                    <div class="qa-title">Property Types</div>
                                    <div class="qa-sub">Manage categories</div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="admin_dashboard_verifications.php" class="quick-action-card">
                                    <div class="qa-icon" style="background:#eef1fa;color:#1E3888;"><i class="fa-solid fa-check-double"></i></div>
                                    <div class="qa-title">Verifications</div>
                                    <div class="qa-sub">Review pending</div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="col-md-7">
                        <div class="section-header mt-2">Recent Activity</div>
                        <div class="activity-card">
                            <div class="card-heading">
                                <h6><i class="fa-regular fa-clock" style="color:#1E3888;"></i> Latest Updates</h6>
                                <a href="#">View All <i class="fa-solid fa-arrow-right ms-1" style="font-size:0.7em;"></i></a>
                            </div>
                            <div class="activity-item">
                                <span class="activity-dot green"></span>
                                <span class="activity-text"><strong>John Doe</strong> registered as a new tenant</span>
                                <span class="activity-time">2 min ago</span>
                            </div>
                            <div class="activity-item">
                                <span class="activity-dot blue"></span>
                                <span class="activity-text"><strong>Luxury Villa</strong> listing was approved</span>
                                <span class="activity-time">15 min ago</span>
                            </div>
                            <div class="activity-item">
                                <span class="activity-dot yellow"></span>
                                <span class="activity-text"><strong>Jane Smith</strong> submitted a verification request</span>
                                <span class="activity-time">1 hr ago</span>
                            </div>
                            <div class="activity-item">
                                <span class="activity-dot red"></span>
                                <span class="activity-text"><strong>Property #204</strong> was flagged for review</span>
                                <span class="activity-time">3 hrs ago</span>
                            </div>
                            <div class="activity-item">
                                <span class="activity-dot green"></span>
                                <span class="activity-text"><strong>Payment</strong> of ₦2,500,000 was received</span>
                                <span class="activity-time">5 hrs ago</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Main Content -->

        </div>

    </div>

    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>