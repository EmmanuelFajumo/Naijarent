<?php
session_start();
require_once "adminguard.php";
require_once "../process_pages/classes/Agent.php";


$agent_detail = new Agent();

$id = $_GET['agent_id'];
$agent_profile = $agent_detail->fetch_agent_details($id);
// echo "<pre>";
// print_r($agent_profile);
// echo "</pre>";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Agent Profile</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">

    <style>
        .modal-custom-profile .form-select,
        .modal-custom-profile .form-control {
            border-radius: 10px;
            border: 1.5px solid #e5e7eb;
            padding: 10px 14px;
            font-size: 0.88rem;
            transition: all 0.3s ease;
        }
        .modal-custom-profile .form-select:focus,
        .modal-custom-profile .form-control:focus {
            border-color: #1E3888;
            box-shadow: 0 0 0 3px rgba(30,56,136,0.1);
        }
        .modal-custom-profile .form-label {
            font-size: 0.82rem;
            font-weight: 500;
            color: #4b5563;
            margin-bottom: 6px;
        }
    </style>

</head>

<body>

    <div class="container-fluid" style="min-height: 100vh; background: #f4f6fb;">
        <div class="row" style="min-height: 100vh;">

            <!-- Sidebar -->
            <?php include 'admin_nav.php'; ?>

            <!-- Main Content -->
            <div class="col-md-10 px-4 px-lg-5 pb-5 pt-4">

                <!-- Page Header -->
                <div class="page-header d-flex justify-content-between align-items-center mb-1">
                    <div>
                        <h2>Agent Profile</h2>
                        <p>Review and manage <strong><?php echo $agent_profile['first_name']." ".$agent_profile['last_name'] ?></strong>'s verification details</p>
                    </div>
                </div>

                <hr class="section-divider" style="height:2px;background:linear-gradient(to right,transparent,rgba(20,33,61,0.12),transparent);border:none;margin:16px 0 24px;opacity:1;">

                <!-- Agent Header Card -->
                <div class="profile-section-card agent-header-card mb-4">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <img src="../../media/profile_pictures/<?php echo $agent_profile['profile_picture'] ?>" alt="avatar" class="agent-avatar">
                                <div>
                                    <div class="agent-name"><?php echo $agent_profile['first_name']." ".$agent_profile['last_name'] ?></div>
                                    <div class="agent-email"><?php echo $agent_profile['email'] ?> · <?php echo $agent_profile['phone'] ?></div>
                                    <div class="agent-location mt-1">
                                        <i class="fa-solid fa-location-dot me-1" style="color:#dc3545;font-size:0.75rem;"></i> Lagos, Nigeria
                                    </div>
                                </div>
                            </div>
                            <div class="text-start text-md-end">
                                <span class="verification-badge pending">
                                    <i class="fa-solid fa-clock me-1"></i> <?php echo $agent_profile['verification_status'] ?>
                                </span>
                                <div class="submitted-date">Submitted: <?php echo $agent_profile['updated_at'] ?></div>
                            </div>
                        </div>
                        <hr class="section-divider-inner">
                        <div class="agent-bio-label"><i class="fa-regular fa-file-lines me-1"></i>Bio</div>
                        <div class="agent-bio-text"><?php echo $agent_profile['agent_bio']; ?></div>
                    </div>
                </div>

                <!-- Agency Card -->
                <div class="profile-section-card agency-card mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="section-title-icon" style="background:#eef1fa;color:#1E3888;">
                                <i class="fa-solid fa-building"></i>
                            </div>
                            <div>
                                <div class="section-title">Agency Details</div>
                                <div class="section-subtitle">Professional information about the agent's agency</div>
                            </div>
                        </div>
                        <hr class="section-divider-inner">
                        <div class="agency-name">Agency: <?php echo $agent_profile['agency'] ?></div>
                        <div class="agency-location"><i class="fa-solid fa-location-dot me-1" style="color:#dc3545;"></i> <?php echo $agent_profile['agency_Location'] ?></div>
                        <div class="agency-about"><?php echo $agent_profile['about_agency'] ?></div>
                    </div>
                </div>

                <!-- Identity Verification Card -->
                <div class="profile-section-card mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="section-title-icon" style="background:#eef1fa;color:#1E3888;">
                                <i class="fa-solid fa-id-card"></i>
                            </div>
                            <div>
                                <div class="section-title">Identity Verification</div>
                                <div class="section-subtitle">Submitted identification documents</div>
                            </div>
                        </div>
                        <hr class="section-divider-inner">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="doc-card-item">
                                    <div class="doc-icon-box"><i class="fa-solid fa-id-card"></i></div>
                                    <div>
                                        <div class="doc-label"><?php echo $agent_profile['ID_type'] ?></div>
                                        <a href="#" class="doc-view-link"><i class="fa-solid fa-eye me-1"></i> View Document</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="doc-card-item">
                                    <div class="doc-icon-box"><i class="fa-solid fa-camera"></i></div>
                                    <div>
                                        <div class="doc-label">Selfie Photo</div>
                                        <a href="#" class="doc-view-link"><i class="fa-solid fa-eye me-1"></i> View Photo</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="doc-card-item">
                                    <div class="doc-icon-box"><i class="fa-solid fa-file-lines"></i></div>
                                    <div>
                                        <div class="doc-label">Proof of Address</div>
                                        <a href="#" class="doc-view-link"><i class="fa-solid fa-eye me-1"></i> View Document</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- License Verification Card -->
                <div class="profile-section-card mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="section-title-icon" style="background:#eef1fa;color:#1E3888;">
                                <i class="fa-solid fa-certificate"></i>
                            </div>
                            <div>
                                <div class="section-title">License Verification</div>
                                <div class="section-subtitle">Professional licenses and certifications</div>
                            </div>
                        </div>
                        <hr class="section-divider-inner">
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="doc-card-item">
                                    <div class="doc-icon-box"><i class="fa-solid fa-building-columns"></i></div>
                                    <div>
                                        <div class="doc-label">CAC Registration</div>
                                        <div class="doc-value"><?php echo $agent_profile['cac_number'] ?></div>
                                        <a href="#" class="doc-view-link"><i class="fa-solid fa-eye me-1"></i> View Certificate</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="doc-card-item">
                                    <div class="doc-icon-box"><i class="fa-solid fa-scroll"></i></div>
                                    <div>
                                        <div class="doc-label">ESVARBON</div>
                                        <div class="doc-value"><?php echo $agent_profile['ESVARBON_number'] ?></div>
                                        <a href="#" class="doc-view-link"><i class="fa-solid fa-eye me-1"></i> View Certificate</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="doc-card-item">
                                    <div class="doc-icon-box"><i class="fa-solid fa-award"></i></div>
                                    <div>
                                        <div class="doc-label">NIESV Membership</div>
                                        <div class="doc-value">---</div>
                                        <a href="#" class="doc-view-link"><i class="fa-solid fa-eye me-1"></i> View Certificate</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <hr class="section-divider-inner">
                        <div class="d-flex gap-2 flex-wrap">
                            <button class="btn-action-approve px-4" data-bs-toggle="modal" data-bs-target="#approveAgentModal">
                                <i class="fa-solid fa-circle-check me-2"></i> Approve Agent
                            </button>
                            <button class="btn-action-warning-outline px-4" data-bs-toggle="modal" data-bs-target="#suspendAgentModal">
                                <i class="fa-solid fa-circle-pause me-2"></i> Suspend
                            </button>
                            <button class="btn-action-danger-outline px-4" data-bs-toggle="modal" data-bs-target="#rejectAgentModal">
                                <i class="fa-solid fa-circle-xmark me-2"></i> Reject
                            </button>
                        </div>
                    </div>
                </div>

                <!-- MODALS -->
                <!-- Approve Agent Modal -->
                <div class="modal fade modal-custom-profile" id="approveAgentModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <i class="fa-solid fa-circle-check text-success me-2"></i>
                                    Approve Agent
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-muted mb-0">Are you sure you want to approve this agent? They will receive a <strong>Verified Badge</strong> and will be able to post listings immediately.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                                <form action="../Process_pages/process_update_agent_status.php" method="POST">
                                    <input type="number" name="agent_id" value="<?php echo $agent_profile['Agent_id'] ?>" hidden>
                                    <button name="verify" class="btn-action-approve px-4">
                                        <i class="fa-solid fa-circle-check me-2"></i> Yes, Approve
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reject Agent Modal -->
                <div class="modal fade modal-custom-profile" id="rejectAgentModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <i class="fa-solid fa-circle-xmark text-danger me-2"></i>
                                    Reject Agent Verification
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-muted mb-3">Select a reason for rejection. The agent will be notified and can resubmit their documents.</p>
                                <div class="mb-3">
                                    <label class="form-label">Reason for Rejection</label>
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
                                    <label class="form-label">Additional Notes <span class="text-muted fw-normal">(optional)</span></label>
                                    <textarea class="form-control" rows="3" placeholder="Add any additional notes for the agent..."></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                                <form action="../process_pages/process_update_agent_status.php" method="post">
                                    <input type="number" name="agent_id" value="<?php echo $agent_profile['Agent_id'] ?>" hidden>
                                    <button name="banned" class="btn-action-danger-outline px-4">
                                        <i class="fa-solid fa-circle-xmark me-2"></i> Send Rejection
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Suspend Agent Modal -->
                <div class="modal fade modal-custom-profile" id="suspendAgentModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <i class="fa-solid fa-circle-pause text-warning me-2"></i>
                                    Suspend Agent
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-muted mb-0">Are you sure you want to suspend this agent? They will receive a <strong>Suspended Badge</strong> and will not be able to post listings.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                                <form action="../process_pages/process_update_agent_status.php" method="post">
                                    <input type="number" name="agent_id" value="<?php echo $agent_profile['Agent_id'] ?>" hidden>
                                    <button name="suspend" class="btn-action-warning-outline px-4">
                                        <i class="fa-solid fa-circle-pause me-2"></i> Yes, Suspend
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Main Content End -->
        </div>
    </div>

    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>