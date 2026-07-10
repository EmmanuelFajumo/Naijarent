<?php
session_start();
require_once "agentguard.php";
require_once "../process_pages/classes/Agent.php";
require_once "../process_pages/classes/Utilities.php";
require_once "../process_pages/classes/Site.php";



if(!isset($_GET['property_id'])){
    header("location:agent_dashboard.php");
    exit;
}


$agent = new Agent();
$det = $agent->fetch_agent_details($_SESSION['agent_online']);

$property_types = $agent->fetch_property_types();


$a = new Utilities();
        $states =  $a->fetch_all_states();
 
$c = new Site();
$property_id = $_GET['property_id'];
$res = $c->fetch_property_detail($property_id);


// echo "<pre>";
// print_r($res);
// echo "</pre>";


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard - Edit Listing</title>
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
        :root {
            --navy-dark: #14213D;
            --navy-light: #1E3888;
            --gold: #FFD700;
            --gold-hover: #FFA500;
            --bg-light: #f8f9fc;
        }

        .section-divider {
            height: 2px;
            background: linear-gradient(to right, transparent, rgba(20, 33, 61, 0.12), transparent);
            border: none;
            margin: 16px 0 24px;
            opacity: 1;
        }

        /* ── Progress Steps ── */
        .progress-steps {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            position: relative;
            padding: 0 0;
        }
        .progress-steps::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 10%;
            right: 10%;
            height: 2px;
            background: #dee2e6;
            z-index: 0;
        }
        .progress-steps .progress-fill {
            position: absolute;
            top: 20px;
            left: 10%;
            width: 0%;
            height: 2px;
            background: linear-gradient(90deg, var(--navy-dark), var(--navy-light));
            z-index: 1;
            transition: width 0.5s ease;
        }
        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            z-index: 2;
            width: 20%;
        }
        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 6px;
            transition: all 0.4s ease;
        }
        .step-circle.active {
            background: linear-gradient(135deg, var(--navy-dark), var(--navy-light));
            color: #fff;
            border: 2px solid transparent;
            box-shadow: 0 4px 12px rgba(20, 33, 61, 0.25);
        }
        .step-circle.inactive {
            background: #f1f1f1;
            color: #adb5bd;
            border: 2px solid #dee2e6;
        }
        .step-label {
            font-size: 0.72rem;
            text-align: center;
            font-weight: 500;
        }
        .step-label.active {
            color: var(--navy-dark);
        }
        .step-label.inactive {
            color: #adb5bd;
        }

        /* ── Form Cards ── */
        .form-card {
            border-radius: 16px;
            border: none;
            background: #fff;
            padding: 28px;
        }
        .form-card .section-head {
            display: flex;
            align-items: center;
            gap: 14px;
            padding-bottom: 16px;
            margin-bottom: 24px;
            border-bottom: 2px solid rgba(20, 33, 61, 0.08);
        }
        .form-card .section-head .step-num {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
            flex-shrink: 0;
        }
        .form-card .section-head h5 {
            margin: 0;
            font-size: 1.05rem;
            color: var(--navy-dark);
        }
        .form-card .section-head small {
            color: #6c757d;
            font-size: 0.8rem;
        }

        .form-input {
            border-radius: 10px;
            height: 46px;
            background: var(--bg-light);
            border: 1.5px solid #e9ecef;
            padding: 10px 14px;
            font-size: 0.88rem;
            transition: all 0.3s ease;
        }
        .form-input:focus {
            border-color: var(--navy-light);
            box-shadow: 0 0 0 3px rgba(30, 56, 136, 0.08);
            background: #fff;
        }
        textarea.form-input {
            height: auto;
            min-height: 100px;
        }
        .form-label {
            font-size: 0.82rem;
            font-weight: 500;
            color: #495057;
            margin-bottom: 6px;
        }

        .btn-navy {
            background: linear-gradient(135deg, var(--navy-dark), var(--navy-light));
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 28px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(20, 33, 61, 0.2);
        }
        .btn-navy:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(20, 33, 61, 0.3);
            color: #fff;
        }
        .btn-navy-outline {
            background: transparent;
            color: var(--navy-dark);
            border: 2px solid var(--navy-dark);
            border-radius: 10px;
            padding: 8px 24px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-navy-outline:hover {
            background: linear-gradient(135deg, var(--navy-dark), var(--navy-light));
            color: #fff;
            border-color: transparent;
        }

        .step-content {
            display: none;
            animation: fadeSlideIn 0.35s ease;
        }
        .step-content.active {
            display: block;
        }

        @keyframes fadeSlideIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── Amenity Check ── */
        .amenity-check {
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1.5px solid #dee2e6;
            border-radius: 10px;
            padding: 8px 14px;
        }
        .amenity-check:hover {
            border-color: var(--navy-light);
            background: rgba(30, 56, 136, 0.03);
        }
        .amenity-check.checked {
            background: rgba(30, 56, 136, 0.06);
            border-color: var(--navy-light);
        }
        .amenity-check .form-check-input:checked {
            background-color: var(--navy-light);
            border-color: var(--navy-light);
        }

        /* ── Furnishing Radio ── */
        .furnish-option {
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1.5px solid #dee2e6;
            border-radius: 10px;
            padding: 8px 18px;
        }
        .furnish-option:hover {
            border-color: var(--navy-light);
        }
        .furnish-option.selected {
            background: rgba(30, 56, 136, 0.06);
            border-color: var(--navy-light);
        }
        .furnish-option .form-check-input:checked {
            background-color: var(--navy-light);
            border-color: var(--navy-light);
        }

        /* ── Upload Zone ── */
        .upload-zone {
            border: 2px dashed #dee2e6;
            border-radius: 16px;
            padding: 40px 20px;
            text-align: center;
            background: var(--bg-light);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .upload-zone:hover {
            border-color: var(--navy-light);
            background: rgba(30, 56, 136, 0.03);
        }
        .upload-zone .upload-icon {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            background: rgba(30, 56, 136, 0.08);
            color: var(--navy-light);
            font-size: 1.3rem;
        }

        /* ── Review Summary ── */
        .review-box {
            background: var(--bg-light);
            border-radius: 12px;
            padding: 16px;
        }
        .review-box .review-label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #adb5bd;
            font-weight: 600;
            margin-bottom: 12px;
        }
        .review-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
            font-size: 0.85rem;
        }
        .review-row:last-child {
            border-bottom: none;
        }
        .review-row .label {
            color: #6c757d;
        }
        .review-row .value {
            font-weight: 600;
            color: var(--navy-dark);
        }

        .info-notice {
            background: #d1e7dd;
            border: 1px solid #a3cfbb;
            border-radius: 12px;
            padding: 14px 18px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 0.88rem;
            color: #0a3622;
        }

        .alert-custom {
            border-radius: 12px;
            border-left: 4px solid;
        }
        .alert-custom.alert-success {
            border-left-color: #198754;
        }
        .alert-custom.alert-danger {
            border-left-color: #dc3545;
        }

        .counter-btn {
            border-radius: 8px;
            border: 1.5px solid #dee2e6;
            background: #fff;
            padding: 6px 14px;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .counter-btn:hover {
            border-color: var(--navy-light);
            background: rgba(30, 56, 136, 0.04);
        }
    </style>

</head>

<body>

    <div class="container-fluid" style="min-height: 100vh; background: var(--bg-light);">
        <div class="row">

            <!-- Sidebar -->
            <?php include 'agent_nav.php'; ?>

            <!-- Main Content -->
            <div class="col-md-10 px-4 px-lg-5 pb-5 pt-4">

                <!-- Page Header -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-1">
                    <div>
                        <h2 class="mb-1" style="font-size: 1.75rem; color: var(--navy-dark);">Edit Property</h2>
                        <p class="text-muted mb-0" style="font-size: 0.95rem;">
                            <i class="fa-regular fa-pen-to-square me-2 opacity-50"></i>
                            Update the details of your property listing
                        </p>
                    </div>
                    <div class="d-flex gap-2 mt-3 mt-md-0">
                        <a href="agent_dashboard_listings.php" class="btn btn-navy-outline">
                            <i class="fa-solid fa-arrow-left me-1"></i> Back to Listings
                        </a>
                        <a href="confirm_payment.php?property_id=<?php echo $property_id; ?>" class="btn btn-navy">
                            <i class="fa-solid fa-cash me-1"></i> Promote This Listing
                        </a>
                    </div>
                </div>

                <hr class="section-divider">

                <!-- Alert Messages -->
                <?php if(isset($_SESSION['errormsg'])){ ?>
                    <div class="alert alert-danger alert-dismissible fade show alert-custom" role="alert">
                        <i class="fa-solid fa-circle-exclamation me-2"></i>
                        <?php echo $_SESSION['errormsg']; unset($_SESSION['errormsg']);?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
                <?php if(isset($_SESSION['successmsg'])){ ?>
                    <div class="alert alert-success alert-dismissible fade show alert-custom" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i>
                        <?php echo $_SESSION['successmsg']; unset($_SESSION['successmsg']);?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <!-- Progress Steps -->
                <div class="card form-card shadow-sm mb-4">
                    <div class="progress-steps">
                        <div class="progress-fill" id="progressFill"></div>
                        <div class="step-item">
                            <div class="step-circle active" id="step1-circle">1</div>
                            <span class="step-label active" id="step1-label">Basic Info</span>
                        </div>
                        <div class="step-item">
                            <div class="step-circle inactive" id="step2-circle">2</div>
                            <span class="step-label inactive" id="step2-label">Features</span>
                        </div>
                        <div class="step-item">
                            <div class="step-circle inactive" id="step3-circle">3</div>
                            <span class="step-label inactive" id="step3-label">Photos & Video</span>
                        </div>
                        <div class="step-item">
                            <div class="step-circle inactive" id="step4-circle">4</div>
                            <span class="step-label inactive" id="step4-label">Documents</span>
                        </div>
                        <div class="step-item">
                            <div class="step-circle inactive" id="step5-circle">5</div>
                            <span class="step-label inactive" id="step5-label">Review & Submit</span>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div class="row">
                    <div class="col-12">
                        <form action="../process_pages/process_update_listing.php" method="POST" enctype="multipart/form-data">

                            <!-- STEP 1 — BASIC INFO -->
                            <div id="step1" class="step-content active">
                                <div class="card form-card shadow-sm">
                                    <div class="section-head">
                                        <div class="step-num" style="background: rgba(30,56,136,0.1); color: var(--navy-light);">1</div>
                                        <div>
                                            <h5>Basic Information</h5>
                                            <small class="text-muted">Tell us the key details about your property</small>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">Property Title</label>
                                            <input type="text" class="form-control form-input" placeholder="e.g. Spacious 3-bedroom flat in Lekki Phase 1" name="title" id="title" value="<?php echo $res['title'] ?>">
                                            <input type="hidden" name="property_id" value="<?php echo (int)$property_id; ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Property Type</label>
                                            <select class="form-select form-input" name="property_type" id="type">
                                                <option disabled selected>Select property type</option>
                                                <?php foreach($property_types as $pt){ ?>
                                                    <option value="<?php echo $pt['property_typeid'] ?>"><?php echo $pt['name'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Listing Purpose</label>
                                            <select class="form-select form-input" name="listing_purpose">
                                                <option disabled selected>Select listing purpose</option>
                                                <option value="For_Rent">For Rent</option>
                                                <option value="For_Sale">For Sale</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Price (₦)</label>
                                            <div class="input-group">
                                                <span class="input-group-text" style="border-radius:10px 0 0 10px; border:1.5px solid #e9ecef; background:var(--bg-light);">₦</span>
                                                <input type="number" class="form-control form-input" name="price" id="price" value="<?php echo $res['price'] ?>" style="border-radius:0 10px 10px 0;">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Payment Flexibility</label>
                                            <select class="form-select form-input" name="payment_flexibility" id="payment">
                                                <option disabled selected>Select payment terms</option>
                                                <option value="yearly">Yearly</option>
                                                <option value="quarterly">Quarterly</option>
                                                <option value="monthly">Monthly</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Full Address</label>
                                            <input type="text" class="form-control form-input" name="full_address" placeholder="e.g. 14 Admiralty Way, Lekki Phase 1">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">State</label>
                                            <select class="form-select form-input" name="state" id="state">
                                                <option value="">Select state</option>
                                                <?php foreach($states as $state){ ?>
                                                    <option value="<?php echo $state['state_id']; ?>"><?php echo $state['state']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">LGA</label>
                                            <select class="form-select form-input" name="lga" id="lga">
                                                <option value="">Select LGA</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control form-input" name="description" rows="4"><?php echo $res['description'] ?></textarea>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                        <button class="btn btn-navy px-5" id="nextStep2" type="button">
                                            Next: Property Features <i class="fa-solid fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 2 — PROPERTY FEATURES -->
                            <div id="step2" class="step-content">
                                <div class="card form-card shadow-sm">
                                    <div class="section-head">
                                        <div class="step-num" style="background:rgba(25,135,84,0.1); color:#198754;">2</div>
                                        <div>
                                            <h5>Property Features</h5>
                                            <small class="text-muted">Specify the physical details and available amenities</small>
                                        </div>
                                    </div>

                                    <!-- Room Counts -->
                                    <div class="row g-4 mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label">Bedrooms</label>
                                            <div class="input-group">
                                                <button class="counter-btn" type="button" onclick="adjustValue('bedrooms', -1)">−</button>
                                                <input type="number" class="form-control form-input text-center fw-medium" id="bedrooms" value="<?php echo $res['bedrooms'] ?>" min="0" max="20" name="bedrooms" style="border-radius:0;">
                                                <button class="counter-btn" type="button" onclick="adjustValue('bedrooms', 1)">+</button>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Bathrooms</label>
                                            <div class="input-group">
                                                <button class="counter-btn" type="button" onclick="adjustValue('bathrooms', -1)">−</button>
                                                <input type="number" class="form-control form-input text-center fw-medium" id="bathrooms" value="<?php echo $res['bathrooms'] ?>" min="0" max="20" name="bathrooms" style="border-radius:0;">
                                                <button class="counter-btn" type="button" onclick="adjustValue('bathrooms', 1)">+</button>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Toilets</label>
                                            <div class="input-group">
                                                <button class="counter-btn" type="button" onclick="adjustValue('toilets', -1)">−</button>
                                                <input type="number" class="form-control form-input text-center fw-medium" id="toilets" value="<?php echo $res['toilet'] ?>" min="0" max="20" name="toilets" style="border-radius:0;">
                                                <button class="counter-btn" type="button" onclick="adjustValue('toilets', 1)">+</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Furnishing & Floor -->
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label">Furnishing Status</label>
                                            <div class="d-flex gap-2 flex-wrap">
                                                <div class="furnish-option selected">
                                                    <input class="form-check-input" type="radio" name="furnishing" id="furnished" value="furnished" checked>
                                                    <label class="form-check-label" style="font-size:0.85em;cursor:pointer;" for="furnished">Furnished</label>
                                                </div>
                                                <div class="furnish-option">
                                                    <input class="form-check-input" type="radio" name="furnishing" id="semi" value="semi-furnished">
                                                    <label class="form-check-label" style="font-size:0.85em;cursor:pointer;" for="semi">Semi-Furnished</label>
                                                </div>
                                                <div class="furnish-option">
                                                    <input class="form-check-input" type="radio" name="furnishing" id="unfurnished" value="unfurnished">
                                                    <label class="form-check-label" style="font-size:0.85em;cursor:pointer;" for="unfurnished">Unfurnished</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Floor Level</label>
                                            <select class="form-select form-input" name="floor_level" id="floor">
                                                <option value="ground">Ground Floor</option>
                                                <option value="first">1st Floor</option>
                                                <option value="second">2nd Floor</option>
                                                <option value="top">Top Floor</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Amenities -->
                                    <label class="form-label mb-3">Available Amenities</label>
                                    <div class="row g-2 mb-4">
                                        <div class="col-6 col-md-4">
                                            <div class="amenity-check checked">
                                                <input class="form-check-input" type="checkbox" id="parking" checked>
                                                <label class="form-check-label" style="font-size:0.85em;cursor:pointer;" for="parking">
                                                    <i class="fa-solid fa-car me-1" style="color:var(--navy-light);"></i> Parking Space
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <div class="amenity-check checked">
                                                <input class="form-check-input" type="checkbox" id="electricity" checked name="electricity_supply">
                                                <label class="form-check-label" style="font-size:0.85em;cursor:pointer;" for="electricity">
                                                    <i class="fa-solid fa-bolt me-1" style="color:var(--navy-light);"></i> Electricity
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <div class="amenity-check checked">
                                                <input class="form-check-input" type="checkbox" id="water" checked name="water_supply" value="1">
                                                <label class="form-check-label" style="font-size:0.85em;cursor:pointer;" for="water">
                                                    <i class="fa-solid fa-droplet me-1" style="color:var(--navy-light);"></i> Water Supply
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <div class="amenity-check checked">
                                                <input class="form-check-input" type="checkbox" id="security" checked name="security" value="1">
                                                <label class="form-check-label" style="font-size:0.85em;cursor:pointer;" for="security">
                                                    <i class="fa-solid fa-shield me-1" style="color:var(--navy-light);"></i> Security
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <div class="amenity-check">
                                                <input class="form-check-input" type="checkbox" id="pool" name="pool" value="1">
                                                <label class="form-check-label" style="font-size:0.85em;cursor:pointer;" for="pool">
                                                    <i class="fa-solid fa-water-ladder me-1 text-muted"></i> Swimming Pool
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <div class="amenity-check">
                                                <input class="form-check-input" type="checkbox" id="gym" name="gym" value="1">
                                                <label class="form-check-label" style="font-size:0.85em;cursor:pointer;" for="gym">
                                                    <i class="fa-solid fa-dumbbell me-1 text-muted"></i> Gym
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <div class="amenity-check checked">
                                                <input class="form-check-input" type="checkbox" id="wifi" checked name="wifi" value="1">
                                                <label class="form-check-label" style="font-size:0.85em;cursor:pointer;" for="wifi">
                                                    <i class="fa-solid fa-wifi me-1" style="color:var(--navy-light);"></i> WiFi Ready
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <div class="amenity-check">
                                                <input class="form-check-input" type="checkbox" id="ac" name="ac" value="1">
                                                <label class="form-check-label" style="font-size:0.85em;cursor:pointer;" for="ac">
                                                    <i class="fa-solid fa-wind me-1 text-muted"></i> Air Conditioning
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <div class="amenity-check checked">
                                                <input class="form-check-input" type="checkbox" id="bq" checked name="bq" value="1">
                                                <label class="form-check-label" style="font-size:0.85em;cursor:pointer;" for="bq">
                                                    <i class="fa-solid fa-house me-1" style="color:var(--navy-light);"></i> Boys Quarter
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <div class="amenity-check checked">
                                                <input class="form-check-input" type="checkbox" id="prepaid" checked name="prepaid_meter" value="1">
                                                <label class="form-check-label" style="font-size:0.85em;cursor:pointer;" for="prepaid">
                                                    <i class="fa-solid fa-receipt me-1" style="color:var(--navy-light);"></i> Prepaid Meter
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <div class="amenity-check">
                                                <input class="form-check-input" type="checkbox" id="pop" name="pop_ceiling" value="1">
                                                <label class="form-check-label" style="font-size:0.85em;cursor:pointer;" for="pop">
                                                    <i class="fa-solid fa-star me-1 text-muted"></i> POP Ceiling
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <div class="amenity-check checked">
                                                <input class="form-check-input" type="checkbox" id="tiled" checked name="tiled_floor" value="1">
                                                <label class="form-check-label" style="font-size:0.85em;cursor:pointer;" for="tiled">
                                                    <i class="fa-solid fa-border-all me-1" style="color:var(--navy-light);"></i> Tiled Floors
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-2 pt-3 border-top">
                                        <button class="btn btn-navy-outline px-4" id="prevStep1" type="button">
                                            <i class="fa-solid fa-arrow-left me-2"></i> Previous
                                        </button>
                                        <button class="btn btn-navy px-5" id="nextStep3" type="button">
                                            Next: Photos & Video <i class="fa-solid fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 3 — MEDIA UPLOAD -->
                            <div id="step3" class="step-content">
                                <div class="card form-card shadow-sm">
                                    <div class="section-head">
                                        <div class="step-num" style="background:rgba(255,193,7,0.15); color:#856404;">3</div>
                                        <div>
                                            <h5>Photos & Video</h5>
                                            <small class="text-muted">Upload clear photos of every room. A video walkthrough is optional but recommended.</small>
                                        </div>
                                    </div>

                                    <label class="form-label mb-3">Property Photos <span class="text-danger">*</span></label>
                                    <div class="upload-zone mb-3" onclick="document.getElementById('photoInput').click()">
                                        <div class="upload-icon">
                                            <i class="fa-solid fa-cloud-arrow-up"></i>
                                        </div>
                                        <p class="mb-1" style="font-size:0.9em;">
                                            <strong style="color:var(--navy-light);">Click to upload photos</strong> or drag and drop here
                                        </p>
                                        <small class="text-muted">JPG, PNG — up to 10 photos. Max 5MB each.</small>
                                        <input type="file" class="form-control mt-3 px-4" name="property_photo1" multiple style="display:none;" id="photoInput">
                                    </div>

                                    <hr class="my-4">

                                    <label class="form-label mb-2">Video Walkthrough <span class="text-muted fw-normal">(Optional)</span></label>
                                    <div class="upload-zone" onclick="document.getElementById('videoInput').click()">
                                        <div class="upload-icon" style="background:rgba(255,193,7,0.15); color:#856404;">
                                            <i class="fa-solid fa-video"></i>
                                        </div>
                                        <p class="mb-1" style="font-size:0.9em;">
                                            <strong style="color:var(--navy-light);">Upload a video</strong> walkthrough of the property
                                        </p>
                                        <small class="text-muted">MP4 — Max 100MB. Tenants love seeing the actual space.</small>
                                        <input type="file" class="form-control mt-3 px-4" name="walkthrough_videos" multiple accept="video/*" style="display:none;" id="videoInput">
                                    </div>

                                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                        <button class="btn btn-navy-outline px-4" id="prevStep2" type="button">
                                            <i class="fa-solid fa-arrow-left me-2"></i> Previous
                                        </button>
                                        <button class="btn btn-navy px-5" id="nextStep4" type="button">
                                            Next: Documents <i class="fa-solid fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 4 — DOCUMENTS -->
                            <div id="step4" class="step-content">
                                <div class="card form-card shadow-sm">
                                    <div class="section-head">
                                        <div class="step-num" style="background:rgba(111,66,193,0.1); color:#6f42c1;">4</div>
                                        <div>
                                            <h5>Ownership Documents</h5>
                                            <small class="text-muted">Upload proof that you own or are authorised to list this property</small>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-2 pt-3 border-top">
                                        <button class="btn btn-navy-outline px-4" id="prevStep3" type="button">
                                            <i class="fa-solid fa-arrow-left me-2"></i> Previous
                                        </button>
                                        <button class="btn btn-navy px-5" id="nextStep5" type="button">
                                            Next: Review & Submit <i class="fa-solid fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 5 — REVIEW & SUBMIT -->
                            <div id="step5" class="step-content">
                                <div class="card form-card shadow-sm">
                                    <div class="section-head">
                                        <div class="step-num" style="background:rgba(25,135,84,0.1); color:#198754;">5</div>
                                        <div>
                                            <h5>Review & Submit</h5>
                                            <small class="text-muted">Double-check everything before submitting for admin review</small>
                                        </div>
                                    </div>

                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <div class="review-box">
                                                <div class="review-label">Basic Info</div>
                                                <div class="review-row"><span class="label">Title</span><span class="value" id="rTitle"></span></div>
                                                <div class="review-row"><span class="label">Type</span><span class="value" id="rType">Flat</span></div>
                                                <div class="review-row"><span class="label">Price</span><span class="value" id="rPrice">₦1,500,000 / yr</span></div>
                                                <div class="review-row"><span class="label">Payment</span><span class="value" id="rPayment">Yearly</span></div>
                                                <div class="review-row"><span class="label">LGA</span><span class="value" id="rLga">Eti-Osa (Lekki)</span></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="review-box">
                                                <div class="review-label">Property Features</div>
                                                <div class="review-row"><span class="label">Bedrooms</span><span class="value" id="rBedroom">3</span></div>
                                                <div class="review-row"><span class="label">Bathrooms</span><span class="value" id="rBathroom">2</span></div>
                                                <div class="review-row"><span class="label">Toilets</span><span class="value" id="rToilet">3</span></div>
                                                <div class="review-row"><span class="label">Furnishing</span><span class="value" id="rFurnished">Furnished</span></div>
                                                <div class="review-row"><span class="label">Floor</span><span class="value" id="rFloor">Ground Floor</span></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="review-box">
                                                <div class="review-label">Media</div>
                                                <div class="review-row"><span class="label">Photos</span><span class="value text-success">3 uploaded</span></div>
                                                <div class="review-row"><span class="label">Video</span><span class="value text-muted">Not uploaded</span></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="review-box">
                                                <div class="review-label">Documents</div>
                                                <div class="review-row"><span class="label">C of O</span><span class="value text-success">Uploaded</span></div>
                                                <div class="review-row"><span class="label">Deed</span><span class="value text-muted">Not uploaded</span></div>
                                                <div class="review-row"><span class="label">Auth Letter</span><span class="value text-muted">Not required</span></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="info-notice mb-4">
                                        <i class="fa-solid fa-circle-info text-success mt-1"></i>
                                        <p class="mb-0">
                                            Once updated, your listing will be reviewed by our admin team within
                                            <strong>24 to 48 hours.</strong> You will be notified by email once it is
                                            approved or if any corrections are needed.
                                        </p>
                                    </div>

                                    <div class="d-flex justify-content-between pt-3 border-top">
                                        <button class="btn btn-navy-outline px-4" type="button" id="prevStep4">
                                            <i class="fa-solid fa-arrow-left me-2"></i> Previous
                                        </button>
                                        <button class="btn btn-navy px-5 py-2" name="update" type="submit" value="submit">
                                            <i class="fa-solid fa-paper-plane me-2"></i> Submit Listing for Review
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
            <!-- Main Content End -->
        </div> 
    </div>

    <!-- Footer -->
    <?php // include '../footer.php'; ?>

    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // ============================================
        // STATE → LGA LOADER
        // ============================================
        $(document).ready(function() {
            $('#state').change(function() {
                var state_id = $('#state').val();
                $.ajax({
                    url: "../process_pages/process_state_lga.php",
                    method: "get",
                    dataType: "text",
                    data: { state_id },
                    success: function(res) {
                        $('#lga').html(res);
                    },
                    error: function(er) {
                        console.log(er);
                    }
                });
            });
        });

        // ============================================
        // STEP NAVIGATION
        // ============================================
        let currentStep = 1;
        const totalSteps = 5;

        function goToStep(step) {
            // Hide all steps
            $('.step-content').removeClass('active');

            // Show target step
            $('#step' + step).addClass('active');

            // Update circles
            for (let i = 1; i <= totalSteps; i++) {
                const $circle = $('#step' + i + '-circle');
                const $label = $('#step' + i + '-label');
                if (i <= step) {
                    $circle.removeClass('inactive').addClass('active');
                    $label.removeClass('inactive').addClass('active');
                } else {
                    $circle.removeClass('active').addClass('inactive');
                    $label.removeClass('active').addClass('inactive');
                }
            }

            // Update progress bar width
            const pct = ((step - 1) / (totalSteps - 1)) * 100;
            $('#progressFill').css('width', pct + '%');

            currentStep = step;

            // If we reached step 4 (review), populate review data
            if (step === 4) {
                populateReview();
            }

            // Scroll to top of form
            $('html, body').animate({ scrollTop: $('form').offset().top - 120 }, 300);
        }

        function populateReview() {
            $('#rTitle').text($('#title').val() || '—');
            $('#rType').text($('#type option:selected').text() || '—');
            $('#rPrice').text('₦' + ($('#price').val() || '0'));
            $('#rPayment').text($('#payment option:selected').text() || '—');
            $('#rBedroom').text($('#bedrooms').val() || '0');
            $('#rBathroom').text($('#bathrooms').val() || '0');
            $('#rToilet').text($('#toilets').val() || '0');
            $('#rFurnished').text($('input[name="furnishing"]:checked').val() || '—');
            $('#rFloor').text($('#floor option:selected').text() || '—');
        }

        // ============================================
        // COUNTER BUTTONS
        // ============================================
        function adjustValue(id, delta) {
            const $input = $('#' + id);
            let val = parseInt($input.val()) || 0;
            val = Math.max(0, Math.min(20, val + delta));
            $input.val(val);
        }

        // ============================================
        // EVENT BINDINGS
        // ============================================
        $(document).ready(function() {
            // Next buttons
            $('#nextStep2').click(function() { goToStep(2); });
            $('#nextStep3').click(function() { goToStep(3); });
            $('#nextStep4').click(function() { goToStep(4); });
            $('#nextStep5').click(function() { goToStep(5); });

            // Previous buttons
            $('#prevStep1').click(function() { goToStep(1); });
            $('#prevStep2').click(function() { goToStep(2); });
            $('#prevStep3').click(function() { goToStep(3); });
            $('#prevStep4').click(function() { goToStep(4); });

            // Amenity toggle visual
            $('.amenity-check').on('click', function(e) {
                if ($(e.target).is('input')) return;
                const $checkbox = $(this).find('.form-check-input');
                $checkbox.prop('checked', !$checkbox.prop('checked'));
                $(this).toggleClass('checked', $checkbox.prop('checked'));
            });

            // Furnishing toggle visual
            $('.furnish-option').on('click', function(e) {
                if ($(e.target).is('input')) return;
                const $radio = $(this).find('.form-check-input');
                $radio.prop('checked', true);
                $('.furnish-option').removeClass('selected');
                $(this).addClass('selected');
            });
        });
    </script>
</body>

</html>