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
    <link rel="stylesheet" href="admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --navy-dark: #14213D;
            --navy-light: #1E3888;
            --bg-light: #f4f6fb;
        }
        .section-divider {
            height: 2px;
            background: linear-gradient(to right, transparent, rgba(20,33,61,0.12), transparent);
            border: none;
            margin: 16px 0 24px;
            opacity: 1;
        }

        /* ── Gallery ── */
        .gallery-main-img {
            border-radius: 16px;
            width: 100%;
            height: 420px;
            object-fit: cover;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .gallery-thumb {
            border-radius: 10px;
            width: 100%;
            height: 70px;
            object-fit: cover;
            cursor: pointer;
            transition: all 0.25s ease;
            border: 2px solid transparent;
            opacity: 0.7;
        }
        .gallery-thumb:hover {
            opacity: 1;
            border-color: var(--navy-light);
        }
        .gallery-thumb.active {
            opacity: 1;
            border-color: var(--navy-light);
            box-shadow: 0 2px 8px rgba(30,56,136,0.2);
        }

        /* ── Property Header Bar ── */
        .property-top-bar {
            background: #fff;
            border-radius: 14px;
            padding: 14px 20px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px 20px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        }
        .property-top-bar .badge-featured {
            background: rgba(30,56,136,0.1);
            color: var(--navy-light);
            border-radius: 50px;
            padding: 5px 14px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .property-top-bar .badge-purpose {
            border-radius: 50px;
            padding: 5px 14px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .property-top-bar .stat-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: #6b7280;
        }
        .property-top-bar .stat-item i {
            color: var(--navy-light);
        }
        .property-top-bar .social-links a {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: var(--bg-light);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            transition: all 0.2s ease;
        }
        .property-top-bar .social-links a:hover {
            background: var(--navy-light);
            color: #fff;
        }

        /* ── Property Info Card ── */
        .info-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            height: 100%;
        }
        .info-card .info-title {
            font-size: 1.5rem;
            color: var(--navy-dark);
            margin-bottom: 4px;
        }
        .info-card .info-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--navy-light);
        }
        .info-card .info-location {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #6b7280;
            font-size: 0.9rem;
        }
        .info-card .info-location i {
            color: #dc3545;
        }

        /* ── Section Card ── */
        .section-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        }
        .section-card .section-heading {
            font-size: 1.15rem;
            font-weight: 600;
            color: var(--navy-dark);
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 2px solid rgba(20,33,61,0.06);
        }
        .section-card .section-heading i {
            color: var(--navy-light);
            margin-right: 10px;
        }
        .section-card p {
            color: #4b5563;
            line-height: 1.7;
            font-size: 0.92rem;
        }

        /* ── Feature Items ── */
        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            background: var(--bg-light);
            border-radius: 10px;
            height: 100%;
        }
        .feature-item .feature-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(30,56,136,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--navy-light);
            font-size: 0.9rem;
            flex-shrink: 0;
        }
        .feature-item .feature-label {
            font-size: 0.78rem;
            color: #8a94a6;
            margin-bottom: 0;
        }
        .feature-item .feature-value {
            font-size: 0.88rem;
            font-weight: 600;
            color: #1f2937;
        }

        /* ── Agent Sidebar ── */
        .agent-sidebar {
            background: #fff;
            border-radius: 16px;
            padding: 28px 20px;
            text-align: center;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            position: sticky;
            top: 20px;
        }
        .agent-sidebar .agent-avatar-lg {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(30,56,136,0.1);
            margin-bottom: 12px;
        }
        .agent-sidebar .agent-name-lg {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--navy-dark);
            margin-bottom: 4px;
        }
        .agent-sidebar .stars {
            display: flex;
            justify-content: center;
            gap: 4px;
            margin-bottom: 8px;
        }
        .agent-sidebar .stars i {
            color: #f59e0b;
            font-size: 0.85rem;
        }
        .agent-sidebar .agent-desc {
            font-size: 0.85rem;
            color: #6b7280;
            margin-bottom: 16px;
        }
        .agent-sidebar textarea {
            border-radius: 10px;
            border: 1.5px solid #e5e7eb;
            padding: 10px 14px;
            font-size: 0.85rem;
            resize: none;
            transition: all 0.3s ease;
        }
        .agent-sidebar textarea:focus {
            border-color: var(--navy-light);
            box-shadow: 0 0 0 3px rgba(30,56,136,0.08);
        }
        .agent-sidebar .btn-send {
            background: linear-gradient(135deg, var(--navy-dark), var(--navy-light));
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .agent-sidebar .btn-send:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(20,33,61,0.25);
        }

        /* ── Action Buttons ── */
        .action-bar {
            background: #fff;
            border-radius: 16px;
            padding: 18px 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* ── Map Placeholder ── */
        .map-placeholder {
            background: var(--bg-light);
            border-radius: 12px;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            flex-direction: column;
            gap: 8px;
        }
        .map-placeholder i {
            font-size: 2rem;
            opacity: 0.5;
        }
        .map-placeholder p {
            font-size: 0.85rem;
            margin: 0;
        }

        /* ── Modal Overrides ── */
        .modal-custom-listing .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }
        .modal-custom-listing .modal-header {
            border-bottom: 1px solid #f3f4f6;
            padding: 18px 24px 12px;
        }
        .modal-custom-listing .modal-body {
            padding: 18px 24px;
        }
        .modal-custom-listing .modal-footer {
            border-top: 1px solid #f3f4f6;
            padding: 12px 24px 18px;
        }
        .modal-custom-listing .modal-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--navy-dark);
        }
    </style>

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
                        <input type="number" name="property_id" value="<?php echo $listing_deet['property_id'] ?>" hidden>
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