<?php
    session_start();
    require_once "process_pages/classes/Site.php";
    require_once "process_pages/classes/Agent.php";
    require_once "process_pages/classes/Tenant.php";
    require_once "process_pages/classes/Utilities.php";

    $c = new Site();
    $agentObj = new Agent();
    $user = new Tenant();
    $util = new Utilities();

    if(!isset($_GET['id']) || empty($_GET['id'])){
        header('location:browse_agents.php');
        exit;
    }

    $agent_id = intval($_GET['id']);
    $agent_profile = $agentObj->fetch_agent_details($agent_id);

    if(!$agent_profile){
        header("location:browse_agents.php");
        exit;
    }

    // Fetch agent's listings
    $agent_listings = $agentObj->fetch_All_listings($agent_id);
    $total_listings = $agentObj->count_total_listings($agent_id);
    $active_listings = $agentObj->count_active_listings($agent_id);

    if(isset($_SESSION['useronline'])){
        $user_deet = $user->fetch_user_detailby_id($_SESSION['useronline']);
    }
    if(isset($_SESSION['agent_online'])){
        $user_deet = $user->fetch_user_detailby_id($_SESSION['agent_online']);
    }

    // Build WhatsApp link
    $phone = $agent_profile['phone'] ?? '';
    $phone = preg_replace('/[^0-9]/', '', $phone);
    if (substr($phone, 0, 1) === '0') {
        $phone = '234' . substr($phone, 1);
    } elseif (substr($phone, 0, 1) !== '234' && substr($phone, 0, 1) !== '+') {
        $phone = '234' . $phone;
    }
    $wa_link = 'https://wa.me/' . $phone;

    $states = $util->fetch_all_states();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($agent_profile['first_name'].' '.$agent_profile['last_name']); ?> - Agent Profile | NaijaRent</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="animate.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="agent_det.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap" rel="stylesheet">

</head>
<body>

    <!-- Navigation -->
    <?php include 'nav.php'; ?>

    <!-- ===== HERO / PROFILE HEADER ===== -->
    <section class="agent-hero">
        <div class="container position-relative">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="browse_agents.php">Agents</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($agent_profile['first_name'].' '.$agent_profile['last_name']); ?></li>
                </ol>
            </nav>

            <div class="row align-items-center g-4 mt-2">
                <!-- Avatar Column -->
                <div class="col-md-auto text-center text-md-start">
                    <img src="media/profile_pictures/<?php echo htmlspecialchars($agent_profile['profile_picture'] ?? 'default.png'); ?>" 
                         alt="<?php echo htmlspecialchars($agent_profile['first_name']); ?>" 
                         class="agent-hero-avatar">
                </div>
                <!-- Info Column -->
                <div class="col-md">
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-1">
                        <h1 class="agent-hero-name mb-0"><?php echo htmlspecialchars($agent_profile['first_name'].' '.$agent_profile['last_name']); ?></h1>
                        <span class="verified-badge">
                            <i class="fa-solid fa-circle-check"></i> 
                            <?php echo htmlspecialchars(ucfirst($agent_profile['verification_status'] ?? 'Unverified')); ?> Agent
                        </span>
                    </div>
                    <p class="agent-hero-agency mb-2">
                        <i class="fa-solid fa-building me-1"></i> 
                        <?php echo htmlspecialchars($agent_profile['agency'] ?? 'Independent Agent'); ?>
                        <?php if(!empty($agent_profile['agency_Location'])): ?>
                            &middot; <i class="fa-solid fa-location-dot me-1"></i> <?php echo htmlspecialchars($agent_profile['agency_Location']); ?>
                        <?php endif; ?>
                    </p>
                    <div class="star-rating mb-2">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <span class="ms-2" style="opacity:0.8;font-size:0.85rem;">(5.0 Rating)</span>
                    </div>

                    <!-- Stats -->
                    <div class="hero-stats">
                        <div class="hero-stat-item">
                            <div class="stat-number"><?php echo $total_listings; ?></div>
                            <div class="stat-label">Total Listings</div>
                        </div>
                        <div class="hero-stat-item">
                            <div class="stat-number"><?php echo $active_listings; ?></div>
                            <div class="stat-label">Active</div>
                        </div>
                        <div class="hero-stat-item">
                            <div class="stat-number"><?php echo !empty($agent_profile['years_of_experience']) ? $agent_profile['years_of_experience'] : 'N/A'; ?></div>
                            <div class="stat-label">Years Exp.</div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="hero-action-buttons">
                        <?php if(isset($_SESSION['useronline']) || isset($_SESSION['agent_online'])): ?>
                            <a href="<?php echo $wa_link; ?>" target="_blank" class="btn btn-whatsapp">
                                <i class="fa-brands fa-whatsapp me-1"></i> WhatsApp
                            </a>
                            <button class="btn btn-message" type="button" data-bs-toggle="offcanvas" data-bs-target="#chatOffcanvas">
                                <i class="fa-solid fa-paper-plane me-1"></i> Send Message
                            </button>
                        <?php endif; ?>
                        <a href="tel:<?php echo htmlspecialchars($agent_profile['phone']); ?>" class="btn btn-call">
                            <i class="fa-solid fa-phone me-1"></i> Call
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="container py-4">

        <!-- Alert Messages -->
        <?php if(isset($_SESSION['errormsg'])){ ?>
            <div class="alert-custom alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i>
                <?php echo $_SESSION['errormsg']; unset($_SESSION['errormsg']);?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
        <?php if(isset($_SESSION['successmsg'])){ ?>
            <div class="alert-custom alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>
                <?php echo $_SESSION['successmsg']; unset($_SESSION['successmsg']);?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>

        <div class="row g-4">
            <!-- ===== LEFT COLUMN ===== -->
            <div class="col-lg-8">

                <!-- About / Bio -->
                <div class="section-card">
                    <div class="card-title">
                        <i class="fa-solid fa-user"></i> About <?php echo htmlspecialchars($agent_profile['first_name']); ?>
                    </div>
                    <p class="agent-bio-text">
                        <?php echo !empty($agent_profile['agent_bio']) ? nl2br(htmlspecialchars($agent_profile['agent_bio'])) : 'No bio provided yet.'; ?>
                    </p>
                </div>

                <!-- Agency Details -->
                <?php if(!empty($agent_profile['agency']) || !empty($agent_profile['about_agency'])): ?>
                <div class="section-card">
                    <div class="card-title">
                        <i class="fa-solid fa-building"></i> Agency Details
                    </div>
                    <div class="info-grid">
                        <?php if(!empty($agent_profile['agency'])): ?>
                        <div class="info-item">
                            <div class="info-icon"><i class="fa-solid fa-briefcase"></i></div>
                            <div>
                                <div class="info-label">Agency</div>
                                <div class="info-value"><?php echo htmlspecialchars($agent_profile['agency']); ?></div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($agent_profile['agency_Location'])): ?>
                        <div class="info-item">
                            <div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
                            <div>
                                <div class="info-label">Location</div>
                                <div class="info-value"><?php echo htmlspecialchars($agent_profile['agency_Location']); ?></div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($agent_profile['years_of_experience'])): ?>
                        <div class="info-item">
                            <div class="info-icon"><i class="fa-solid fa-calendar-check"></i></div>
                            <div>
                                <div class="info-label">Experience</div>
                                <div class="info-value"><?php echo htmlspecialchars($agent_profile['years_of_experience']); ?> Years</div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php if(!empty($agent_profile['about_agency'])): ?>
                    <div class="mt-3">
                        <p class="agent-bio-text mb-0"><?php echo nl2br(htmlspecialchars($agent_profile['about_agency'])); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Agent's Property Listings -->
                <div class="section-card">
                    <div class="card-title">
                        <i class="fa-solid fa-list"></i> Property Listings
                        <span class="badge bg-primary ms-2 rounded-pill"><?php echo $total_listings; ?></span>
                    </div>

                    <?php if(!empty($agent_listings) && count($agent_listings) > 0): ?>
                        <div class="listings-grid">
                            <?php foreach($agent_listings as $listing): ?>
                                <div class="listing-card">
                                    <div class="img-wrapper">
                                        <img src="uploads/property_pictures/<?php echo htmlspecialchars($listing['image1'] ?? 'default.jpg'); ?>" 
                                             alt="<?php echo htmlspecialchars($listing['title']); ?>" 
                                             class="listing-img"
                                             onerror="this.src='media/home.png'">
                                        <span class="listing-status status-<?php echo htmlspecialchars($listing['verification_status'] ?? 'pending'); ?>">
                                            <?php echo htmlspecialchars(ucfirst($listing['verification_status'] ?? 'Pending')); ?>
                                        </span>
                                    </div>
                                    <div class="listing-body">
                                        <div class="listing-title"><?php echo htmlspecialchars($listing['title']); ?></div>
                                        <div class="listing-location">
                                            <i class="fa-solid fa-map-marker-alt"></i> 
                                            <?php echo htmlspecialchars($listing['address'] ?? ''); ?>
                                        </div>
                                        <div class="listing-price">
                                            ₦ <?php echo number_format($listing['price']); ?> 
                                            <span class="price-unit">/ yr</span>
                                        </div>
                                        <div class="listing-meta">
                                            <span><i class="fa-solid fa-bed"></i> <?php echo $listing['bedrooms']; ?> Beds</span>
                                            <span><i class="fa-solid fa-bath"></i> <?php echo $listing['bathrooms']; ?> Baths</span>
                                            <span><i class="fa-solid fa-toilet"></i> <?php echo $listing['toilet']; ?> Toilets</span>
                                        </div>
                                        <a href="property_details.php?id=<?php echo $listing['property_id']; ?>" class="btn btn-outline-primary btn-sm w-100 mt-3 rounded-pill fw-semibold">
                                            View Details <i class="fa-solid fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fa-regular fa-building"></i>
                            <h4>No Listings Yet</h4>
                            <p class="text-muted">This agent hasn't posted any property listings yet.</p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

            <!-- ===== RIGHT SIDEBAR ===== -->
            <div class="col-lg-4">

                <!-- Quick Info Card -->
                <div class="section-card">
                    <div class="card-title" style="font-size:1.1rem;">
                        <i class="fa-solid fa-circle-info"></i> Quick Info
                    </div>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between py-2 border-bottom border-light">
                            <span class="text-muted">Status</span>
                            <span class="fw-semibold">
                                <?php if(($agent_profile['verification_status'] ?? '') === 'verified'): ?>
                                    <span class="text-success"><i class="fa-solid fa-circle-check me-1"></i> Verified</span>
                                <?php else: ?>
                                    <span class="text-warning"><i class="fa-solid fa-clock me-1"></i> <?php echo ucfirst($agent_profile['verification_status'] ?? 'Pending'); ?></span>
                                <?php endif; ?>
                            </span>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom border-light">
                            <span class="text-muted">Total Listings</span>
                            <span class="fw-semibold"><?php echo $total_listings; ?></span>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom border-light">
                            <span class="text-muted">Active Listings</span>
                            <span class="fw-semibold text-success"><?php echo $active_listings; ?></span>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom border-light">
                            <span class="text-muted">Phone</span>
                            <span class="fw-semibold"><?php echo htmlspecialchars($agent_profile['phone'] ?? 'N/A'); ?></span>
                        </li>
                        <li class="d-flex justify-content-between py-2">
                            <span class="text-muted">Email</span>
                            <span class="fw-semibold small"><?php echo htmlspecialchars($agent_profile['email'] ?? 'N/A'); ?></span>
                        </li>
                    </ul>
                </div>

                <!-- CTA Card -->
                <div class="section-card text-center" style="background: linear-gradient(135deg, var(--primary-dark), var(--primary)); color: #fff; border: none;">
                    <div class="py-2">
                        <i class="fa-solid fa-handshake" style="font-size: 2.5rem; opacity: 0.8; margin-bottom: 12px;"></i>
                        <h5 style="color: #fff; font-size: 1.2rem;">Work With <?php echo htmlspecialchars($agent_profile['first_name']); ?></h5>
                        <p style="opacity: 0.8; font-size: 0.85rem;">Get in touch to find your perfect property or list your property for rent.</p>
                        <?php if(isset($_SESSION['useronline']) || isset($_SESSION['agent_online'])): ?>
                            <a href="<?php echo $wa_link; ?>" target="_blank" class="btn btn-whatsapp w-100 mb-2">
                                <i class="fa-brands fa-whatsapp me-1"></i> Chat on WhatsApp
                            </a>
                            <button class="btn btn-message w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#chatOffcanvas" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); color: #fff;">
                                <i class="fa-solid fa-paper-plane me-1"></i> Send a Message
                            </button>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-light w-100 fw-semibold" style="color: var(--primary);">
                                <i class="fa-solid fa-right-to-bracket me-1"></i> Login to Contact
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- ===== CHAT OFF-CANVAS ===== -->
    <div class="offcanvas offcanvas-start chat-offcanvas" tabindex="-1" id="chatOffcanvas" aria-labelledby="chatOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="chatOffcanvasLabel">
                <i class="fa-solid fa-comments me-2"></i>Chat with <?php echo htmlspecialchars($agent_profile['first_name']); ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p class="chat-property-label">
                <i class="fa-solid fa-user me-1"></i> Send a message to <strong><?php echo htmlspecialchars($agent_profile['first_name'].' '.$agent_profile['last_name']); ?></strong>
            </p>
            <form method="post" action="Process_pages/process_conversation.php" id="chat-form">
                <input type="number" hidden name="Agent_id" value="<?php echo $agent_id; ?>">
                <div class="col-12" id="chatbox">
                    <div class="form-group col-12">
                        <textarea class="input_message form-control" name="message" id="message" placeholder="Enter your message..." rows="4"></textarea>
                    </div>
                    <div class="form-group col-12">
                        <input type="submit" name="send" value="Send Message" id="send" class="btn-send-chat col-12" />
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="jquery.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script>
        $(document).ready(function(){
            $("#send").click(function(e){
                var message = $("#message").val();
                if(message.trim() === '') {
                    alert("Message cannot be empty");
                    e.preventDefault();
                    return;
                }
            });
        });
    </script>
</body>
</html>