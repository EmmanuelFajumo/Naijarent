<?php


session_start();
require_once "adminguard.php";
require_once "classes/Admin.php";
$prop = new Admin();
$listing_deet = $prop->fetch_property_detail($_GET['id']);

// echo "<pre>";
// print_r($listing_deet);
// echo "</pre>";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Property Details</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="single_list.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">

    

</head>

<body>

    <div class="container-fluid" style="min-height: 100vh; background: var(--bg-light);">
        <div class="row" style="min-height: 100vh;">

            <!-- Sidebar -->
            <?php include 'admin_nav.php'; ?>

            <!-- Main Content -->
            <div class="col-md-10 px-4 px-lg-5 pb-5 pt-4">

                <!-- Page Header -->
                <div class="page-header d-flex justify-content-between align-items-center mb-1">
                    <div>
                        <h2>Property Details</h2>
                        <p>Reviewing listing: <strong><?php echo $listing_deet['title']; ?></strong></p>
                    </div>
                    <a href="admin_dashboard_manage_listings.php" class="btn btn-outline-secondary px-4" style="border-radius:10px;font-size:0.85rem;">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back to Listings
                    </a>
                </div>

                <hr class="section-divider">

                <div class="row g-4">
                    <!-- Main Column -->
                    <div class="col-lg-8">

                        <!-- Gallery -->
                        <div class="mb-4">
                            <img src="../uploads/property_pictures/<?php echo $listing_deet['image1'] ?>" id="mainImage" class="gallery-main-img" alt="">
                            <div class="row g-2 mt-2">
                                <?php
                                $images = [
                                    '../uploads/property_pictures/'.$listing_deet['image1'],
                                    '../media/singleproperty02.png',
                                    '../media/singleproperty03.png',
                                    '../media/singleproperty01.png',
                                    '../media/singleproperty01.png',
                                    '../media/singleproperty01.png'
                                ];
                                foreach ($images as $idx => $img) {
                                    $active = $idx === 0 ? ' active' : '';
                                    echo '<div class="col-2"><img src="'.$img.'" class="gallery-thumb'.$active.'" onclick="document.getElementById(\'mainImage\').src=this.src;document.querySelectorAll(\'.gallery-thumb\').forEach(t=>t.classList.remove(\'active\'));this.classList.add(\'active\');" alt=""></div>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Property Top Bar -->
                        <div class="property-top-bar mb-4">
                            <span class="badge-featured"><i class="fa-regular fa-star me-1"></i> FEATURED</span>
                            <span class="badge bg-primary badge-purpose">FOR RENT</span>
                            <div class="stat-item">
                                <i class="fa-regular fa-calendar"></i>
                                <span>23 June, 2025</span>
                            </div>
                            <div class="stat-item">
                                <i class="fa-regular fa-eye"></i>
                                <span>203K Views</span>
                            </div>
                            <div class="social-links ms-auto">
                                <a href="#"><i class="fa-solid fa-share-nodes"></i></a>
                                <a href="#"><i class="fa-regular fa-heart"></i></a>
                                <a href="#"><i class="fa-regular fa-envelope"></i></a>
                            </div>
                        </div>

                        <!-- Title & Price Card -->
                        <div class="info-card mb-4">
                            <div class="row align-items-start" style='min-height:200px;'>
                                <div class="col-md-8" >
                                    <div class="info-title"><?php echo $listing_deet['title'] ?></div>
                                    <div class="info-location mt-2">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span><?php echo $listing_deet['address'].", ".$listing_deet['LGA_name'].", ".$listing_deet['state']?></span>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                    <div class="info-price">₦ <?php echo number_format($listing_deet['price']) ?></div>
                                    <small class="text-muted">Per Year</small>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="section-card mb-4">
                            <div class="section-heading"><i class="fa-regular fa-file-lines"></i> Description</div>
                            <p><?php echo $listing_deet['description'] ?></p>
                        </div>

                        <!-- Features -->
                        <div class="section-card mb-4">
                            <div class="section-heading"><i class="fa-solid fa-list-check"></i> Property Features</div>
                            <div class="row g-3">
                                <div class="col-md-4 col-sm-6">
                                    <div class="feature-item">
                                        <div class="feature-icon"><i class="fa-solid fa-tag"></i></div>
                                        <div>
                                            <div class="feature-label">Type</div>
                                            <div class="feature-value"><?php echo $listing_deet['name'] ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="feature-item">
                                        <div class="feature-icon"><i class="fa-solid fa-bed"></i></div>
                                        <div>
                                            <div class="feature-label">Bedrooms</div>
                                            <div class="feature-value"><?php echo $listing_deet['bedrooms'] ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="feature-item">
                                        <div class="feature-icon"><i class="fa-solid fa-bath"></i></div>
                                        <div>
                                            <div class="feature-label">Bathrooms</div>
                                            <div class="feature-value"><?php echo $listing_deet['bathrooms'] ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="feature-item">
                                        <div class="feature-icon"><i class="fa-solid fa-toilet"></i></div>
                                        <div>
                                            <div class="feature-label">Toilets</div>
                                            <div class="feature-value"><?php echo $listing_deet['toilet'] ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="feature-item">
                                        <div class="feature-icon"><i class="fa-solid fa-kitchen-set"></i></div>
                                        <div>
                                            <div class="feature-label">Kitchen</div>
                                            <div class="feature-value">1</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="feature-item">
                                        <div class="feature-icon"><i class="fa-solid fa-couch"></i></div>
                                        <div>
                                            <div class="feature-label">Status</div>
                                            <div class="feature-value"><?php echo $listing_deet['furnished_status'] ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="feature-item">
                                        <div class="feature-icon"><i class="fa-solid fa-car"></i></div>
                                        <div>
                                            <div class="feature-label">Parking Space</div>
                                            <div class="feature-value"><?php echo $listing_deet['parking_space'] == 1 ? 'Yes' : '−' ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="feature-item">
                                        <div class="feature-icon"><i class="fa-solid fa-bolt"></i></div>
                                        <div>
                                            <div class="feature-label">Electricity</div>
                                            <div class="feature-value"><?php echo $listing_deet['electricity_supply'] == 1 ? 'Yes' : '−' ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="feature-item">
                                        <div class="feature-icon"><i class="fa-solid fa-droplet"></i></div>
                                        <div>
                                            <div class="feature-label">Water Supply</div>
                                            <div class="feature-value"><?php echo $listing_deet['water_supply'] == 1 ? 'Yes' : '−' ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="feature-item">
                                        <div class="feature-icon"><i class="fa-solid fa-shield"></i></div>
                                        <div>
                                            <div class="feature-label">Security</div>
                                            <div class="feature-value"><?php echo $listing_deet['security'] == 1 ? 'Yes' : '−' ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="feature-item">
                                        <div class="feature-icon"><i class="fa-solid fa-star"></i></div>
                                        <div>
                                            <div class="feature-label">POP Ceiling</div>
                                            <div class="feature-value"><?php echo $listing_deet['pop_ceiling'] == 1 ? 'Yes' : '−' ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="feature-item">
                                        <div class="feature-icon"><i class="fa-solid fa-border-all"></i></div>
                                        <div>
                                            <div class="feature-label">Tiled Floor</div>
                                            <div class="feature-value"><?php echo $listing_deet['tiled_floor'] == 1 ? 'Yes' : '−' ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="feature-item">
                                        <div class="feature-icon"><i class="fa-solid fa-receipt"></i></div>
                                        <div>
                                            <div class="feature-label">Prepaid Meter</div>
                                            <div class="feature-value"><?php echo $listing_deet['prepaid_meter'] == 1 ? 'Yes' : '−' ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address & Map -->
                        <div class="section-card mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="section-heading mb-0 pb-0" style="border-bottom:none;"><i class="fa-solid fa-map"></i> Address</div>
                                <a href="#" class="btn btn-sm" style="background:var(--navy-light);color:#fff;border-radius:8px;padding:7px 16px;font-size:0.8rem;">
                                    <i class="fa-brands fa-google me-1"></i> Open on Google Maps
                                </a>
                            </div>
                            <div class="map-placeholder">
                                <i class="fa-solid fa-map-location-dot"></i>
                                <p>Map preview will appear here</p>
                            </div>
                        </div>

                        <!-- Action Bar -->
                        <div class="action-bar">
                            <button class="btn-action-approve px-4" data-bs-toggle="modal" data-bs-target="#approveModal">
                                <i class="fa-solid fa-circle-check me-2"></i> Approve
                            </button>
                            <button class="btn-action-warning-outline px-4" data-bs-toggle="modal" data-bs-target="#suspendModal">
                                <i class="fa-solid fa-circle-pause me-2"></i> Suspend
                            </button>
                            <button class="btn-action-danger-outline px-4" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="fa-solid fa-circle-xmark me-2"></i> Reject
                            </button>
                             <form action="Process_pages/delete_listing.php" method='post'>
                                <input type="number" hidden name='pro_id' value="<?php echo $listing_deet['property_id'] ?>">
                                <button class="btn btn-danger px-4" name='delete'>
                                <i class="fa-solid fa-circle-xmark me-2"></i> Delete
                                </button>
                             </form>
                        </div>

                    </div>

                    <!-- Sidebar Column -->
                    <div class="col-lg-4">
                        <div class="agent-sidebar">
                            <img src="../media/q.png" alt="Agent" class="agent-avatar-lg">
                            <div class="agent-name-lg"><?php echo $listing_deet['first_name']." ".$listing_deet['last_name'] ?></div>
                            <div class="stars">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <p class="agent-desc">Get in touch with the agent for more information about this property.</p>
                            <form action="#">
                                <textarea name="message" class="form-control" rows="3" placeholder="Type your message here..."></textarea>
                                <button type="submit" class="btn btn-send mt-2 w-100">
                                    <i class="fa-regular fa-paper-plane me-1"></i> Send Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Main Content End -->
        </div>
    </div>

    <!-- MODALS -->

    <!-- Approve Modal -->
    <div class="modal fade modal-custom-listing" id="approveModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-circle-check text-success me-2"></i> Approve Listing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-0">Are you sure you want to approve this listing? It will be published and visible to tenants immediately.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <form action="process_pages/process_update_listing_status.php" method="post">
                        <input type="number" name="property_id" value="<?php echo $listing_deet['property_id'] ?>" hidden>
                        <button name="approve" class="btn-action-approve px-4">
                            <i class="fa-solid fa-circle-check me-2"></i> Yes, Approve
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade modal-custom-listing" id="rejectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-circle-xmark text-danger me-2"></i> Reject Listing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-3">Select a reason for rejection. The agent will be notified.</p>
                    <div class="mb-3">
                        <label class="form-label" style="font-size:0.82rem;font-weight:500;color:#4b5563;">Reason for Rejection</label>
                        <select class="form-select" style="border-radius:10px;border:1.5px solid #e5e7eb;padding:10px 14px;">
                            <option selected disabled>Select a reason</option>
                            <option>Incomplete listing information</option>
                            <option>Inappropriate or misleading content</option>
                            <option>Invalid or expired documents</option>
                            <option>Duplicate listing</option>
                            <option>Other (specify below)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-size:0.82rem;font-weight:500;color:#4b5563;">Additional Notes <span class="text-muted fw-normal">(optional)</span></label>
                        <textarea class="form-control" rows="3" placeholder="Add any additional notes..." style="border-radius:10px;border:1.5px solid #e5e7eb;padding:10px 14px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <form action="process_pages/process_update_listing_status.php" method="post">
                        <input type="number"  name="property_id" value="<?php echo $listing_deet['property_id'] ?>" hidden>
                        <button name="rejected" class="btn-action-danger-outline px-4">
                            <i class="fa-solid fa-circle-xmark me-2"></i> Send Rejection
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Suspend Modal -->
    <div class="modal fade modal-custom-listing" id="suspendModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-circle-pause text-warning me-2"></i> Suspend Listing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-0">Are you sure you want to suspend this listing? It will be hidden from tenants until reinstated.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <form action="process_pages/process_update_listing_status.php" method="post">
                        <input type="number" name="property_id" value="<?php echo $listing_deet['property_id'] ?>" hidden>
                        <button name="suspend" class="btn-action-warning-outline px-4">
                            <i class="fa-solid fa-circle-pause me-2"></i> Yes, Suspend
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>