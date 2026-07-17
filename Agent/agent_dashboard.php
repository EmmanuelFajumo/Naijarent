<?php
session_start();
require_once "agentguard.php";
require_once "../process_pages/classes/Agent.php";
$agent = new Agent();
$det = $agent->fetch_agent_details($_SESSION['agent_online']);

$agent_id = $_SESSION['agent_online'];
$total_listings  = $agent->count_total_listings($agent_id);
$active_listings = $agent->count_active_listings($agent_id);
$total_inquiries = $agent->count_conversations($agent_id);

// Fetch recent listings for this agent
$all_listings = $agent->fetch_All_listings($agent_id);
$recent_listings = array_slice($all_listings, 0, 3);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">

   
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
                                Welcome back, <?php echo htmlspecialchars($det['first_name']); ?>! 👋
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
                    <div class="col-6 col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon"
                                style="background:#eff6ff;">
                                <i class="fa-solid fa-building"
                                    style="color:#1E3888;"></i>
                            </div>
                            <div class="stat-number"><?php echo $total_listings; ?></div>
                            <div class="stat-label">Total Listings</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon"
                                style="background:#f0fdf4;">
                                <i class="fa-solid fa-circle-check"
                                    style="color:#16a34a;"></i>
                            </div>
                            <div class="stat-number"><?php echo $active_listings; ?></div>
                            <div class="stat-label">Active Listings</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon"
                                style="background:#fff7ed;">
                                <i class="fa-solid fa-message"
                                    style="color:#ea580c;"></i>
                            </div>
                            <div class="stat-number"><?php echo $total_inquiries; ?></div>
                            <div class="stat-label">Inquiries</div>
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
                        <a href="agent_dashboard_messages.php" class="quick-action">
                            <div class="quick-action-icon"
                                style="background:#fff7ed;">
                                <i class="fa-solid fa-comments"
                                    style="color:#ea580c;"></i>
                            </div>
                            <div class="quick-action-label">Messages</div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="agent_dashboard_listings.php" class="quick-action">
                            <div class="quick-action-icon"
                                style="background:#f0fdf4;">
                                <i class="fa-solid fa-list"
                                    style="color:#16a34a;"></i>
                            </div>
                            <div class="quick-action-label">My Listings</div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="agent_profile.php"
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
                    <a href="agent_dashboard_listings.php"
                        class="btn btn-sm btn-outline-primary rounded-pill px-4"
                        style="font-size:0.82em;">
                        View All
                        <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="row g-3 mb-5">
                    <?php if (empty($recent_listings)): ?>
                        <div class="col-12">
                            <div class="text-center py-5" style="color: #9ca3af;">
                                <i class="fa-solid fa-building-circle-exclamation" style="font-size: 2.5em; opacity: 0.4; margin-bottom: 12px;"></i>
                                <p class="mb-0">You haven't listed any properties yet.</p>
                                <a href="agent_dashboard_create_listing.php" class="btn btn-primary btn-sm mt-2 rounded-pill px-4">
                                    Create Your First Listing
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($recent_listings as $property): 
                            $payment_label = '';
                            switch ($property['payment_flexibility']) {
                                case 'yearly': $payment_label = '/ yr'; break;
                                case 'monthly': $payment_label = '/ mth'; break;
                                case 'quarterly': $payment_label = '/ qtr'; break;
                                default: $payment_label = '';
                            }
                            $status_badge = '';
                            $status_color = '';
                            switch ($property['verification_status']) {
                                case 'approved':
                                    $status_badge = '<span class="badge-verified"><i class="fa-solid fa-circle-check"></i> Verified</span>';
                                    break;
                                case 'pending':
                                    $status_badge = '<span class="badge bg-warning text-dark" style="font-size:0.72em; border-radius:20px; padding:4px 10px; font-weight:600;">Pending</span>';
                                    break;
                                case 'rejected':
                                    $status_badge = '<span class="badge bg-danger" style="font-size:0.72em; border-radius:20px; padding:4px 10px; font-weight:600;">Rejected</span>';
                                    break;
                                default:
                                    $status_badge = '<span class="badge bg-secondary" style="font-size:0.72em; border-radius:20px; padding:4px 10px; font-weight:600;">' . ucfirst($property['verification_status']) . '</span>';
                                    break;
                            }
                            $img_src = !empty($property['image1']) ? '../' . $property['image1'] : '../media/singleproperty3.png';
                        ?>
                        <div class="col-md-4">
                            <div class="property-card">
                                <div class="card-img-wrap">
                                    <img src="<?php echo $img_src; ?>"
                                        class="card-img-top" alt="<?php echo htmlspecialchars($property['title']); ?>">
                                    <div class="position-absolute d-flex gap-2"
                                        style="top:12px; left:12px;">
                                        <?php echo $status_badge; ?>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title"><?php echo htmlspecialchars($property['title']); ?></h6>
                                    <div class="card-location">
                                        <i class="fa-solid fa-location-dot text-danger"></i>
                                        <?php echo htmlspecialchars($property['address']); ?>
                                    </div>
                                    <div class="card-price">
                                        ₦<?php echo number_format($property['price']); ?> <span><?php echo $payment_label; ?></span>
                                    </div>
                                    <div class="card-meta">
                                        <span><i class="fa-solid fa-bed"></i> <?php echo $property['bedrooms']; ?> Beds</span>
                                        <span><i class="fa-solid fa-bath"></i> <?php echo $property['bathrooms']; ?> Bath</span>
                                        <span><i class="fa-solid fa-couch"></i> <?php echo ucfirst($property['furnished_status']); ?></span>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="../property_details.php?id=<?php echo $property['property_id']; ?>" class="btn-view btn">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
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