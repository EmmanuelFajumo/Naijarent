<?php 
    session_start();
    require_once "adminguard.php";
    require_once "classes/Admin.php";
    $pt = new Admin;
    $properties_types = ($pt->fetch_property_types());
    
    $all_pending_listings = $pt->get_all_listing_bystatus("pending");

    $all_pending_agents = $pt-> get_agents_byid('pending');
    // echo "<pre>";
    // print_r($all_pending_agents);
    // echo "</pre>";
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin verification</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">

</head>

<body>
    <div class="container-fluid " style="min-height: 900px;">
        <div class="row">

            <!-- Sidebar (Profile and Navigation) -->
                <?php include 'admin_nav.php'; ?>
            <!-- Sidebar (Profile and Navigation) -->

            <!-- Main Content -->

            <div class="col-md-9 px-5 pb-5 pt-3">
                    <!-- Page Header -->
                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="mb-0">Verifications</h2>
                                <p class="text-muted mb-0">Review and approve pending agent and listing verifications
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Stats Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="card box p-3 text-center border-0 shadow-sm">
                                <i class="fa-solid fa-clock fa-2x text-warning mb-2"></i>
                                <h5 class="mb-0">6</h5>
                                <small class="text-muted">Pending Agents</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card box p-3 text-center border-0 shadow-sm">
                                <i class="fa-solid fa-house-chimney fa-2x text-primary mb-2"></i>
                                <h5 class="mb-0">18</h5>
                                <small class="text-muted">Pending Listings</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card box p-3 text-center border-0 shadow-sm">
                                <i class="fa-solid fa-circle-check fa-2x text-success mb-2"></i>
                                <h5 class="mb-0">1,240</h5>
                                <small class="text-muted">Total Approved</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card box p-3 text-center border-0 shadow-sm">
                                <i class="fa-solid fa-circle-xmark fa-2x text-danger mb-2"></i>
                                <h5 class="mb-0">84</h5>
                                <small class="text-muted">Total Rejected</small>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <ul class="nav nav-tabs mb-4" id="verificationTabs">
                        <li class="nav-item">
                            <a class="nav-link active fw-medium" id="agents-tab" data-bs-toggle="tab"
                                href="#agentVerifications">
                                <i class="fa-solid fa-user-tie me-2"></i> Agent Verifications
                                <span class="badge text-bg-warning ms-1">6</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" id="listings-tab" data-bs-toggle="tab"
                                href="#listingVerifications">
                                <i class="fa-solid fa-house-chimney me-2"></i> Listing Verifications
                                <span class="badge text-bg-warning ms-1"><?php echo count($all_pending_listings);?></span>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="verificationTabContent">

                        <!-- AGENT VERIFICATIONS TAB  -->
                       
                        <div class="tab-pane fade show active" id="agentVerifications">

                            <!-- Filter -->
                            <div class="row g-3 mb-4 align-items-center">
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="fa-solid fa-magnifying-glass text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0"
                                            placeholder="Search by agent name or email...">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select">
                                        <option selected>Filter by Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="approved"> Approved</option>
                                        <option value="rejected"> Rejected</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Agent Verification Cards -->
                            <?php foreach($all_pending_agents as $pa){ ?>
                            <!-- Card 1 - Pending -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="media/q.png" alt="avatar"
                                                style="width: 55px; height: 55px; border-radius: 50%; object-fit: cover;">
                                            <div>
                                                <h5 class="mb-0 fw-semibold"><?php echo $pa['first_name']." ".$pa['last_name'] ?></h5>
                                                <small class="text-muted"><?php echo $pa['email']." . ".$pa['phone'] ?></small>
                                                <div class="mt-1">
                                                    <small class="text-muted"><?php echo $pa['agency']?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge rounded-pill text-bg-warning px-3 py-2">
                                                <i class="fa-solid fa-clock me-1"></i> Pending
                                            </span>
                                            <div class="mt-1">
                                                <small class="text-muted">Submitted: <?php echo date("F j, Y", strtotime($pa['joined_at'])); ?></small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Documents -->
                                    <p class="fw-medium mb-2">Submitted Documents:</p>
                                    <div class="row g-2 mb-4">
                                        <div class="col-md-4">
                                            <div class="card border-0 p-3 d-flex flex-row align-items-center gap-2"
                                                style="background-color: #f8f9fa;">
                                                <i class="fa-solid fa-id-card fa-lg text-primary"></i>
                                                <div>
                                                    <small class="fw-medium d-block">National ID</small>
                                                    <a href="#" class="text-primary" style="font-size: 0.8em;">
                                                        <i class="fa-solid fa-eye me-1"></i> View Document
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card border-0 p-3 d-flex flex-row align-items-center gap-2"
                                                style="background-color: #f8f9fa;">
                                                <i class="fa-solid fa-camera fa-lg text-primary"></i>
                                                <div>
                                                    <small class="fw-medium d-block">Selfie Photo</small>
                                                    <a href="#" class="text-primary" style="font-size: 0.8em;">
                                                        <i class="fa-solid fa-eye me-1"></i> View Photo
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card border-0 p-3 d-flex flex-row align-items-center gap-2"
                                                style="background-color: #f8f9fa;">
                                                <i class="fa-solid fa-building fa-lg text-primary"></i>
                                                <div>
                                                    <small class="fw-medium d-block">CAC Certificate</small>
                                                    <a href="#" class="text-primary" style="font-size: 0.8em;">
                                                        <i class="fa-solid fa-eye me-1"></i> View Document
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-success px-4" data-bs-toggle="modal"
                                            data-bs-target="#approveListingtModal">
                                            <i class="fa-solid fa-circle-check me-2"></i> Approve Agent
                                        </button>
                                        <button class="btn btn-outline-danger px-4" data-bs-toggle="modal"
                                            data-bs-target="#rejectListingModal">
                                            <i class="fa-solid fa-circle-xmark me-2"></i> Reject
                                        </button>
                                        <div>
                                            <form action="../process_pages/process_update_agent_status.php" method="post" class="">
                                                <input type="number" name='agent_id' value='<?php echo $pa['Agent_id']; ?>' id='agent_id' hidden>
                                                <button name="view" class='btn btn-outline-secondary px-4'><i class="fa-solid fa-user-check me-2 text-success" id="verify_agent"></i> View Profile</button> 
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <!-- END AGENT VERIFICATIONS TAB -->


                     
                        <!-- LISTING VERIFICATIONS TAB  -->
                       
                        <div class="tab-pane fade" id="listingVerifications">

                            <!-- Filter -->
                            <div class="row g-3 mb-4 align-items-center">
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="fa-solid fa-magnifying-glass text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0"
                                            placeholder="Search by title, location or agent...">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select">
                                        <option selected>Filter by Status</option>
                                        <option value="pending"> Pending</option>
                                        <option value="approved"> Approved</option>
                                        <option value="rejected"> Rejected</option>
                                    </select>
                                </div>
                            </div>
                            <?php foreach($all_pending_listings as $pl){ ?>
                            <!-- Listing Verification Card 1 -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body p-4">

                                    <!-- Header -->
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="mb-0 fw-semibold"><?php echo $pl['title'] ?></h5>
                                            <small class="text-muted">
                                                <i class="fa-solid fa-location-dot me-1"></i>
                                                <?php echo $pl['address'] ?>
                                            </small>
                                        </div>
                                        <span class="badge rounded-pill text-bg-warning px-3 py-2">
                                            <i class="fa-solid fa-clock me-1"></i> Pending
                                        </span>
                                    </div>

                                    <!-- Listing Details Row -->
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-8">
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Agent</small>
                                                    <span class="fw-medium">
                                                        <img src="media/q.png" alt=""
                                                            style="width: 22px; height: 22px; border-radius: 50%; object-fit: cover;">
                                                        Emeka Okonkwo
                                                        <span class="badge text-bg-success ms-1"
                                                            style="font-size: 0.7em;">
                                                            <i class="fa-solid fa-circle-check"></i> Verified
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Property Type</small>
                                                    <span class="fw-medium">Flat</span>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Price</small>
                                                    <span class="fw-medium text-primary"><?php echo $pl['price'] ?> / yr</span>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Payment</small>
                                                    <span class="fw-medium"><?php echo $pl['payment_flexibility'] ?></span>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Bedrooms</small>
                                                    <span class="fw-medium"><?php echo $pl['bedrooms'] ?></span>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Submitted</small>
                                                    <span class="fw-medium"><?php echo $pl['date_added'] ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Property Photos Thumbnails -->
                                        <div class="col-md-4">
                                            <small class="text-muted d-block mb-2">Property Photos</small>
                                            <div class="d-flex gap-2 flex-wrap">
                                                <img src="../uploads/property_pictures/<?php echo $pl['image1'] ?>" alt="property"
                                                    style="width: 65px; height: 55px; object-fit: cover; border-radius: 8px;">
                                                <img src="media/q.png" alt="property"
                                                    style="width: 65px; height: 55px; object-fit: cover; border-radius: 8px;">
                                                <img src="media/q.png" alt="property"
                                                    style="width: 65px; height: 55px; object-fit: cover; border-radius: 8px;">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submitted Documents -->
                                    <p class="fw-medium mb-2">Submitted Documents:</p>
                                    <div class="row g-2 mb-4">
                                        <div class="col-md-4">
                                            <div class="card border-0 p-3 d-flex flex-row align-items-center gap-2"
                                                style="background-color: #f8f9fa;">
                                                <i class="fa-solid fa-file-contract fa-lg text-primary"></i>
                                                <div>
                                                    <small class="fw-medium d-block">Certificate of Occupancy</small>
                                                    <a href="#" class="text-primary" style="font-size: 0.8em;">
                                                        <i class="fa-solid fa-eye me-1"></i> View Document
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card border-0 p-3 d-flex flex-row align-items-center gap-2"
                                                style="background-color: #f8f9fa;">
                                                <i class="fa-solid fa-file-signature fa-lg text-primary"></i>
                                                <div>
                                                    <small class="fw-medium d-block">Authorization Letter</small>
                                                    <a href="#" class="text-primary" style="font-size: 0.8em;">
                                                        <i class="fa-solid fa-eye me-1"></i> View Document
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Map Link -->
                                    <div class="mb-4">
                                        <a href="#" class="btn btn-outline-secondary btn-sm">
                                            <i class="fa-solid fa-location-dot me-2 text-danger"></i>
                                            Verify Address on Google Maps
                                        </a>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex gap-2">
                                        <a class="btn btn-outline-secondary px-4" href="single_listing.php?id=<?php echo $pl['property_id'] ?>">
                                            <i class="fa-solid fa-house me-2"></i> View Full Listing
                                    </a>
                                    </div>

                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <!-- END LISTING VERIFICATIONS TAB -->

                    </div>
                    <!-- End Tab Content -->


                   
                    <!-- MODALS  -->
                  

                    <!-- Approve Agent Modal -->
                    <div class="modal fade" id="approveAgentModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-semibold">
                                        <i class="fa-solid fa-circle-check text-success me-2"></i>
                                        Approve Agent
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-muted">Are you sure you want to approve this agent? They will receive
                                        a
                                        <strong>Verified Badge</strong> and will be able to post listings immediately.
                                    </p>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-outline-secondary px-4"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-success px-4">
                                        <i class="fa-solid fa-circle-check me-2"></i> Yes, Approve
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reject Agent Modal -->
                    <div class="modal fade" id="rejectAgentModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-semibold">
                                        <i class="fa-solid fa-circle-xmark text-danger me-2"></i>
                                        Reject Agent Verification
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-muted mb-3">Select a reason for rejection. The agent will be
                                        notified and can resubmit their documents.</p>
                                    <div class="mb-3">
                                        <label class="form-label fw-medium">Reason for Rejection</label>
                                        <select class="form-select">
                                            <option selected disabled>Select a reason</option>
                                            <option>ID document is unclear or unreadable</option>
                                            <option>Selfie does not match ID photo</option>
                                            <option>CAC document is invalid or expired</option>
                                            <option>Documents appear to be forged</option>
                                            <option>Other (specify below)</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-medium">Additional Notes <span
                                                class="text-muted fw-normal">(optional)</span></label>
                                        <textarea class="form-control" rows="3"
                                            placeholder="Add any additional notes for the agent..."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-outline-secondary px-4"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-danger px-4">
                                        <i class="fa-solid fa-circle-xmark me-2"></i> Send Rejection
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <!-- Main Content -->
        </div>




    </div>


















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
                            style="width: 110px; height: 110px; background-color: white; border-radius: 50%;   margin-top: 30px;">
                            <img src="media/q.png" alt="Profile Picture" class="box"
                                style="width: 100px; height: 100px; border-radius: 50%;">
                        </div>
                        <h5 class="text-center mt-3 card box p-1">Samson Johnson</h5>
                        <p class="text-center label ">Scout</p>
                        <div class="profile-menu mt-4">
                            <a href="tenant_dashbord.html" class="d-block py-2 px-3 text-dark">Dashboard</a>
                            <a href="#" class="d-block py-2 px-3 text-dark">Browse Listings</a>
                            <a href="#" class="d-block py-2 px-3 text-dark">Messages</a>
                            <a href="#" class="d-block py-2 px-3 text-dark">Settings</a>
                            <a href="#" class="d-block py-2 px-3 text-dark">My Profile </a>
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
        

    </script>
</body>

</html>