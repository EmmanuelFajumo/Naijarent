<?php
session_start();
$id = $_SESSION["agent_id"];
require_once "../../process_pages/classes/Agent.php";
$agent_detail = new Agent();
$agent_profile = $agent_detail->fetch_agent_details($id);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin verification</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../animate.min.css">
    <link rel="stylesheet" href="../../style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">

</head>

<body>
    <!-- Navigation -->



    <div class="container-fluid " style="min-height: 900px;">
        <div class="row" style="min-height: 900px;">

            <!-- Sidebar (Profile and Navigation) -->
                <?php include '../admin_nav.php'; ?>
            <!-- Sidebar (Profile and Navigation) -->

            <!-- Main Content -->

            <div class="col-md-9 px-5 pb-5 pt-3">
                    <!-- Page Header -->
                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="mb-0">Personal Information</h2>
                                <p class="text-muted mb-0">Review and approve pending agent
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    

                    <!-- Tab Content -->
                    <div class="tab-content" id="verificationTabContent">

                        <!-- AGENT VERIFICATIONS TAB  -->
                       
                        <div class="tab-pane fade show active" id="agentVerifications">

                            <!-- User Verification Cards -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="../../media/profile_pictures/<?php echo $agent_profile['profile_picture'] ?>" alt="avatar"
                                                style="width: 55px; height: 55px; border-radius: 50%; object-fit: cover;">
                                            <div>
                                                <h5 class="mb-0 fw-semibold"><?php echo $agent_profile['first_name']." ".$agent_profile['last_name'] ?></h5>
                                                <small class="text-muted"><?php echo $agent_profile['email'] ?> · <?php echo $agent_profile['phone'] ?></small>
                                                <div class="mt-1">
                                                    <small class="text-muted">Lagos, Nigeria</small>
                                                </div>
                                                 <span class="pt-4 "><small >Bio</small></span> <br>
                                                <small class="text-muted pe-5"><?php echo $agent_profile['agent_bio']; ?></small>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge rounded-pill text-bg-warning px-3 py-2">
                                                <i class="fa-solid fa-clock me-1"></i> <?php echo $agent_profile['verification_status'] ?>
                                            </span>
                                            <div class="mt-1">
                                                <small class="text-muted">Submitted: <?php echo $agent_profile['updated_at'] ?></small>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div>
                                                <h5 class="mb-0 fw-semibold">Agency: <?php echo $agent_profile['agency'] ?></h5>
                                                <div class="mt-1">
                                                    <small class="text-muted"> <?php echo $agent_profile['agency_Location'] ?></small>
                                                </div>
                                                <small class="text-muted pe-5"><?php echo $agent_profile['about_agency'] ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                             <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div>
                                                <h5 class="mb-0 fw-semibold">Identity Verification</h5>
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
                                                    <small class="fw-medium d-block"><?php echo $agent_profile['ID_type'] ?></small>
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
                                                    <small class="fw-medium d-block">Proof of Address</small>
                                                    <a href="#" class="text-primary" style="font-size: 0.8em;">
                                                        <i class="fa-solid fa-eye me-1"></i> View Document
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div>
                                                <h5 class="mb-0 fw-semibold">Licence Verification</h5>
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
                                                    <small class="fw-medium d-block">CAC Registration Number</small>
                                                    <small class="fw-medium d-block"><?php echo $agent_profile['cac_number'] ?></small>
                                                    <a href="#" class="text-primary" style="font-size: 0.8em;">
                                                        <i class="fa-solid fa-eye me-1"></i> View Certificate
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card border-0 p-3 d-flex flex-row align-items-center gap-2"
                                                style="background-color: #f8f9fa;">
                                                <i class="fa-solid fa-camera fa-lg text-primary"></i>
                                                <div>
                                                    <small class="fw-medium d-block">ESVARBON Registration Number</small>
                                                    <small class="fw-medium d-block"><?php echo $agent_profile['ESVARBON_number'] ?></small>
                                                    <a href="#" class="text-primary" style="font-size: 0.8em;">
                                                        <i class="fa-solid fa-eye me-1"></i> View Certificate
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card border-0 p-3 d-flex flex-row align-items-center gap-2"
                                                style="background-color: #f8f9fa;">
                                                <i class="fa-solid fa-building fa-lg text-primary"></i>
                                                <div>
                                                    <small class="fw-medium d-block">NIESV Membership Membership Number</small>
                                                    <small class="fw-medium d-block">---</small>
                                                    <a href="#" class="text-primary" style="font-size: 0.8em;">
                                                        <i class="fa-solid fa-eye me-1"></i> View Certificate
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-success px-4" data-bs-toggle="modal"
                                            data-bs-target="#approveAgentModal">
                                            <i class="fa-solid fa-circle-check me-2"></i> Approve Agent
                                        </button>
                                        <button class="btn btn-outline-warning px-4" data-bs-toggle="modal"
                                            data-bs-target="#suspendAgentModal">
                                            <i class="fa-solid fa-circle-check me-2"></i> Suspend
                                        </button>
                                        <button class="btn btn-outline-danger px-4" data-bs-toggle="modal"
                                            data-bs-target="#rejectAgentModal">
                                            <i class="fa-solid fa-circle-xmark me-2"></i> Reject
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- END AGENT VERIFICATIONS TAB -->

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
                                   <form action="../../process_pages/process_update_agent_status.php" method="post">
                                        <input type="number" name="agent_id" value="<?php echo $agent_profile['Agent_id'] ?>" hidden>
                                         <button name='verify' class="btn btn-success px-4">
                                            <i class="fa-solid fa-circle-check me-2"></i> Yes, Approve
                                        </button>
                                   </form>
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
                                    <form action="../../process_pages/process_update_agent_status.php" method="post">
                                        <input type="number" name="agent_id" value="<?php echo $agent_profile['Agent_id'] ?>" hidden>
                                        <button name="banned" class="btn btn-danger px-4">
                                        <i class="fa-solid fa-circle-xmark me-2"></i> Send Rejection
                                    </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>



                     <!-- Suspend Agent Modal -->
                    <div class="modal fade" id="suspendAgentModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-semibold">
                                        <i class="fa-solid fa-circle-check text-success me-2"></i>
                                        Suspend Agent
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-muted">Are you sure you want to suspend this agent? They will receive
                                        a
                                        <strong>Suspended Badge</strong> and will not be able to post listings.
                                    </p>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-outline-secondary px-4"
                                        data-bs-dismiss="modal">Cancel</button>
                                   <form action="../../process_pages/process_update_agent_status.php" method="post">
                                        <input type="number" name="agent_id" value="<?php echo $agent_profile['Agent_id'] ?>" hidden>
                                         <button name='suspend' class="btn btn-warning px-4">
                                            <i class="fa-solid fa-circle-check me-2"></i> Yes, Suspend
                                        </button>
                                   </form>
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




    <script src="../../jquery.js"></script>
    <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        

    </script>
</body>

</html>