<?php
session_start();
require_once "../process_pages/classes/Agent.php";
require_once "agentguard.php";
$agent = new Agent();
$det = $agent->fetch_agent_details($_SESSION['agent_online']);
$property_types = $agent->fetch_property_types();
require_once "../process_pages/classes/Utilities.php";
$a = new Utilities();
$states = $a->fetch_all_states();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Listing — NaijaRent</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: "Inter", sans-serif;
            background-color: #f5f6fa;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: "Voltaire", sans-serif;
        }

        /* ================================
           PROGRESS STEPPER
        ================================ */
        .progress_bar {
            width: 44px;
            height: 44px;
            background-color: #1E3888;
            border: 2px solid #1E3888;
            color: white;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .step {
            width: 44px;
            height: 44px;
            background-color: #f1f3f9;
            border: 2px solid #dee2e6;
            color: #adb5bd;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .step-label-active {
            color: #1E3888;
            font-weight: 600;
        }

        .step-label-inactive {
            color: #adb5bd;
        }

        .progress-line-track {
            position: absolute;
            top: 22px;
            left: 10%;
            right: 10%;
            height: 2px;
            background-color: #e9ecef;
            z-index: 0;
        }

        .progress-line-fill {
            position: absolute;
            top: 22px;
            left: 10%;
            height: 2px;
            background: linear-gradient(90deg, #1E3888, #2d52b5);
            z-index: 1;
            transition: width 0.4s ease;
        }

        /* ================================
           CARDS
        ================================ */
        .listing-card {
            background: white;
            border-radius: 20px;
            border: none;
            box-shadow: 0 2px 16px rgba(0,0,0,0.06);
            padding: 32px;
            margin-bottom: 20px;
        }

        .step-header {
            display: flex;
            align-items: center;
            gap: 16px;
            padding-bottom: 20px;
            margin-bottom: 24px;
            border-bottom: 1px solid #f1f3f9;
        }

        .step-badge {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .step-badge-1 { background: #e8f0fe; color: #1E3888; }
        .step-badge-2 { background: #d1e7dd; color: #0a3622; }
        .step-badge-3 { background: #fff3cd; color: #664d03; }
        .step-badge-4 { background: #e8d5f5; color: #3c1361; }
        .step-badge-5 { background: #d1e7dd; color: #0a3622; }

        .step-header-title {
            font-size: 1.1em;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 2px;
        }

        .step-header-sub {
            font-size: 0.82em;
            color: #9ca3af;
            margin: 0;
        }

        /* ================================
           FORM ELEMENTS
        ================================ */
        .form-label {
            font-size: 0.83em;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 1.5px solid #e5e7eb;
            padding: 10px 14px;
            font-size: 0.9em;
            color: #374151;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #1E3888;
            box-shadow: 0 0 0 3px rgba(30,56,136,0.08);
        }

        .input-group-text {
            border-radius: 10px 0 0 10px;
            border: 1.5px solid #e5e7eb;
            background: #f9fafb;
            color: #6b7280;
            font-weight: 600;
        }

        .input-group .form-control {
            border-radius: 0 10px 10px 0;
            border-left: none;
        }

        /* ================================
           COUNTER BUTTONS
        ================================ */
        .counter-group {
            display: flex;
            align-items: center;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
        }

        .counter-btn {
            width: 42px;
            height: 44px;
            border: none;
            background: #f9fafb;
            color: #374151;
            font-size: 18px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .counter-btn:hover {
            background: #e8f0fe;
            color: #1E3888;
        }

        .counter-input {
            flex: 1;
            border: none;
            border-left: 1.5px solid #e5e7eb;
            border-right: 1.5px solid #e5e7eb;
            text-align: center;
            font-size: 0.95em;
            font-weight: 600;
            color: #1a1a2e;
            padding: 10px 0;
            outline: none;
        }

        /* ================================
           FURNISHING RADIO BUTTONS
        ================================ */
        .furnish-option {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 10px;
            border: 1.5px solid #e5e7eb;
            cursor: pointer;
            font-size: 0.88em;
            font-weight: 500;
            color: #374151;
            transition: all 0.2s;
            background: white;
        }

        .furnish-option:has(input:checked) {
            border-color: #1E3888;
            background: #e8f0fe;
            color: #1E3888;
        }

        .furnish-option input {
            accent-color: #1E3888;
        }

        /* ================================
           AMENITY CHECKBOXES
        ================================ */
        .amenity-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 10px;
            border: 1.5px solid #e5e7eb;
            cursor: pointer;
            font-size: 0.83em;
            font-weight: 500;
            color: #6b7280;
            transition: all 0.2s;
            background: white;
            height: 100%;
        }

        .amenity-item:has(input:checked) {
            border-color: #1E3888;
            background: #e8f0fe;
            color: #1E3888;
        }

        .amenity-item i {
            font-size: 15px;
            width: 18px;
            text-align: center;
        }

        .amenity-item input {
            accent-color: #1E3888;
            flex-shrink: 0;
        }

        /* ================================
           UPLOAD ZONES
        ================================ */
        .upload-zone {
            border: 2px dashed #d1d5db;
            border-radius: 14px;
            padding: 32px 20px;
            text-align: center;
            background: #fafafa;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
        }

        .upload-zone:hover {
            border-color: #1E3888;
            background: #f0f4ff;
        }

        .upload-zone-icon {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
            font-size: 20px;
        }

        .upload-zone p {
            font-size: 0.9em;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .upload-zone small {
            font-size: 0.78em;
            color: #adb5bd;
        }

        .upload-zone .form-control {
            margin-top: 14px;
            font-size: 0.82em;
        }

        /* ================================
           DOCUMENT ITEMS
        ================================ */
        .doc-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1.5px solid #e5e7eb;
            background: #fafafa;
            margin-bottom: 10px;
        }

        .doc-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .doc-name {
            font-size: 0.9em;
            font-weight: 600;
            color: #374151;
            margin-bottom: 2px;
        }

        .doc-desc {
            font-size: 0.78em;
            color: #9ca3af;
            margin: 0;
        }

        /* ================================
           REVIEW SUMMARY
        ================================ */
        .review-box {
            background: #f9fafb;
            border-radius: 14px;
            padding: 18px;
        }

        .review-box-label {
            font-size: 0.72em;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #adb5bd;
            margin-bottom: 12px;
        }

        .review-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
            font-size: 0.85em;
        }

        .review-row:last-child {
            border-bottom: none;
        }

        .review-row .key {
            color: #9ca3af;
        }

        .review-row .val {
            font-weight: 600;
            color: #1a1a2e;
        }

        /* ================================
           BUTTONS
        ================================ */
        .btn-next {
            background: linear-gradient(135deg, #1E3888, #2d52b5);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 36px;
            font-size: 0.9em;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-next:hover {
            background: linear-gradient(135deg, #162d70, #1E3888);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(30,56,136,0.3);
        }

        .btn-prev {
            background: white;
            color: #6b7280;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 28px;
            font-size: 0.9em;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-prev:hover {
            background: #f9fafb;
            color: #374151;
            border-color: #d1d5db;
        }

        .btn-submit {
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 36px;
            font-size: 0.9em;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(22,163,74,0.3);
            color: white;
        }

        /* ================================
           NOTICE BOX
        ================================ */
        .notice-box {
            background: #f0fdf4;
            border: 1.5px solid #bbf7d0;
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 0.88em;
            color: #166534;
        }

        .notice-box i {
            color: #16a34a;
            font-size: 16px;
            margin-top: 1px;
            flex-shrink: 0;
        }

        /* ================================
           TOP BAR
        ================================ */
        .page-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            padding-top: 8px;
        }

        .page-topbar h2 {
            font-size: 1.6em;
            color: #1a1a2e;
            margin-bottom: 4px;
        }

        .page-topbar p {
            font-size: 0.85em;
            color: #9ca3af;
            margin: 0;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            color: #6b7280;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 0.85em;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background: #f9fafb;
            color: #374151;
            border-color: #d1d5db;
        }

        /* ================================
           ALERTS
        ================================ */
        .alert {
            border-radius: 12px;
            border: none;
            font-size: 0.88em;
        }
        .alert-danger  { background: #fef2f2; color: #991b1b; }
        .alert-success { background: #f0fdf4; color: #166534; }

        /* ================================
           AMENITIES — fallback for older
           browsers without :has()
        ================================ */
        .amenity-item.checked {
            border-color: #1E3888;
            background: #e8f0fe;
            color: #1E3888;
        }

        .amenity-item.checked i {
            color: #1E3888;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row" style="min-height: 100vh;">

            <!-- Sidebar -->
            <?php include 'agent_nav.php'; ?>

            <!-- Main Content -->
            <div class="col-md-9 px-4 px-lg-5 py-4">

                <!-- Mobile Toggle -->
                <div class="d-md-none mb-3">
                    <a class="btn btn-primary w-100" type="button"
                        data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                        <i class="fa-solid fa-bars me-2"></i> Menu
                    </a>
                </div>

                <!-- Alerts -->
                <?php if (isset($_SESSION['errormsg'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show mb-3">
                        <i class="fa-solid fa-circle-exclamation me-2"></i>
                        <?php echo $_SESSION['errormsg']; unset($_SESSION['errormsg']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['successmsg'])): ?>
                    <div class="alert alert-success alert-dismissible fade show mb-3">
                        <i class="fa-solid fa-circle-check me-2"></i>
                        <?php echo $_SESSION['successmsg']; unset($_SESSION['successmsg']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Top Bar -->
                <div class="page-topbar">
                    <div>
                        <h2>Create New Listing</h2>
                        <p>Fill in the details below to list your property on NaijaRent</p>
                    </div>
                    <a href="agent_dashboard_listings.php" class="btn-back">
                        <i class="fa-solid fa-arrow-left"></i> Back to Listings
                    </a>
                </div>

                <!-- PROGRESS STEPPER -->
                <div class="listing-card mb-4">
                    <div class="d-flex justify-content-between align-items-start position-relative" style="padding: 0 10px;">
                        <div class="progress-line-track"></div>
                        <div class="progress-line-fill progress" id="progressFill" style="width: 0%;"></div>

                        <!-- Step 1 -->
                        <div class="d-flex flex-column align-items-center" style="z-index:2; width:20%;">
                            <div class="rounded-circle d-flex justify-content-center align-items-center fw-medium mb-2 progress_bar" id="step1-circle">1</div>
                            <small class="text-center step-label-active" style="font-size:0.75em;" id="label1">Basic Info</small>
                        </div>

                        <!-- Step 2 -->
                        <div class="d-flex flex-column align-items-center" style="z-index:2; width:20%;">
                            <div class="rounded-circle d-flex justify-content-center align-items-center fw-medium mb-2 step" id="step2-circle">2</div>
                            <small class="text-center step-label-inactive" style="font-size:0.75em;" id="label2">Features</small>
                        </div>

                        <!-- Step 3 -->
                        <div class="d-flex flex-column align-items-center" style="z-index:2; width:20%;">
                            <div class="rounded-circle d-flex justify-content-center align-items-center fw-medium mb-2 step" id="step3-circle">3</div>
                            <small class="text-center step-label-inactive" style="font-size:0.75em;" id="label3">Photos & Video</small>
                        </div>

                        <!-- Step 4 -->
                        <div class="d-flex flex-column align-items-center" style="z-index:2; width:20%;">
                            <div class="rounded-circle d-flex justify-content-center align-items-center fw-medium mb-2 step" id="step4-circle">4</div>
                            <small class="text-center step-label-inactive" style="font-size:0.75em;" id="label4">Documents</small>
                        </div>

                        <!-- Step 5 -->
                        <div class="d-flex flex-column align-items-center" style="z-index:2; width:20%;">
                            <div class="rounded-circle d-flex justify-content-center align-items-center fw-medium mb-2 step" id="step5-circle">5</div>
                            <small class="text-center step-label-inactive" style="font-size:0.75em;" id="label5">Review & Submit</small>
                        </div>
                    </div>
                </div>

                <!-- FORM -->
                <div class="row">
                    <div class="col-md-12">
                        <form action="../process_pages/process_new_listing.php" method="POST" enctype="multipart/form-data">

                            <!-- STEP 1 — BASIC INFO      -->
                            <div id="step1" class="step-content">
                                <div class="listing-card">
                                    <div class="step-header">
                                        <div class="step-badge step-badge-1">1</div>
                                        <div>
                                            <div class="step-header-title">Basic Information</div>
                                            <p class="step-header-sub">Tell us the key details about your property</p>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">Property Title</label>
                                            <input type="text" class="form-control"
                                                placeholder="e.g. Spacious 3-bedroom flat in Lekki Phase 1"
                                                name="title" id="title">
                                            <input type="number" class="form-control" name="Agentid" hidden
                                                value="<?php echo $det['Agent_id']; ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Property Type</label>
                                            <select class="form-select" name="property_type" id="type">
                                                <option disabled selected>Select property type</option>
                                                <?php foreach ($property_types as $pt): ?>
                                                    <option value="<?php echo $pt['property_typeid']; ?>">
                                                        <?php echo $pt['name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Listing Purpose</label>
                                            <select class="form-select" name="listing_purpose">
                                                <option disabled selected>Select listing purpose</option>
                                                <option value="For_Rent">For Rent</option>
                                                <option value="For_Sale">For Sale</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Price (₦)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">₦</span>
                                                <input type="number" class="form-control"
                                                    placeholder="e.g. 1500000" name="price" id="price">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Payment Flexibility</label>
                                            <select class="form-select" name="payment_flexibility" id="payment">
                                                <option disabled selected>Select payment terms</option>
                                                <option value="yearly">Yearly</option>
                                                <option value="quarterly">Quarterly</option>
                                                <option value="monthly">Monthly</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Full Address</label>
                                            <input type="text" class="form-control"
                                                name="full_address"
                                                placeholder="e.g. 14 Admiralty Way, Lekki Phase 1">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">State</label>
                                            <select class="form-select" name="state" id="state">
                                                <option value="">Select state</option>
                                                <?php foreach ($states as $state): ?>
                                                    <option value="<?php echo $state['state_id']; ?>">
                                                        <?php echo $state['state']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">LGA</label>
                                            <select class="form-select" name="lga" id="lga">
                                                <option value="">Select LGA</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" name="description" rows="4"
                                                placeholder="Describe the property — location advantages, nearby landmarks, key selling points..."></textarea>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-4">
                                        <button class="btn-next btn" id="nextStep2" type="button">
                                            Next: Property Features
                                            <i class="fa-solid fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 2 — FEATURES        -->
                            <div id="step2" class="step-content d-none">
                                <div class="listing-card">
                                    <div class="step-header">
                                        <div class="step-badge step-badge-2">2</div>
                                        <div>
                                            <div class="step-header-title">Property Features</div>
                                            <p class="step-header-sub">Specify the physical details and available amenities</p>
                                        </div>
                                    </div>

                                    <!-- Room Counts -->
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label">Bedrooms</label>
                                            <div class="counter-group">
                                                <button class="counter-btn" type="button"
                                                    onclick="changeCount('bedrooms', -1)">−</button>
                                                <input type="number" class="counter-input"
                                                    id="bedrooms" value="3" min="0" max="20" name="bedrooms">
                                                <button class="counter-btn" type="button"
                                                    onclick="changeCount('bedrooms', 1)">+</button>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Bathrooms</label>
                                            <div class="counter-group">
                                                <button class="counter-btn" type="button"
                                                    onclick="changeCount('bathrooms', -1)">−</button>
                                                <input type="number" class="counter-input"
                                                    id="bathrooms" value="2" min="0" max="20" name="bathrooms">
                                                <button class="counter-btn" type="button"
                                                    onclick="changeCount('bathrooms', 1)">+</button>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Toilets</label>
                                            <div class="counter-group">
                                                <button class="counter-btn" type="button"
                                                    onclick="changeCount('toilets', -1)">−</button>
                                                <input type="number" class="counter-input"
                                                    id="toilets" value="3" min="0" max="20" name="toilets">
                                                <button class="counter-btn" type="button"
                                                    onclick="changeCount('toilets', 1)">+</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Furnishing & Floor -->
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label">Furnishing Status</label>
                                            <div class="d-flex gap-2 flex-wrap">
                                                <label class="furnish-option">
                                                    <input type="radio" name="furnishing"
                                                        id="furnished" value="furnished" checked>
                                                    Furnished
                                                </label>
                                                <label class="furnish-option">
                                                    <input type="radio" name="furnishing"
                                                        id="semi" value="semi-furnished">
                                                    Semi-Furnished
                                                </label>
                                                <label class="furnish-option">
                                                    <input type="radio" name="furnishing"
                                                        id="unfurnished" value="unfurnished">
                                                    Unfurnished
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Floor Level</label>
                                            <select class="form-select" name="floor_level" id="floor">
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
                                            <label class="amenity-item checked w-100">
                                                <input type="checkbox" id="parking" name="parking_space" value="1" checked>
                                                <i class="fa-solid fa-car text-primary"></i> Parking Space
                                            </label>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <label class="amenity-item checked w-100">
                                                <input type="checkbox" id="electricity" name="electricity_supply" value="1" checked>
                                                <i class="fa-solid fa-bolt text-primary"></i> Electricity
                                            </label>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <label class="amenity-item checked w-100">
                                                <input type="checkbox" id="water" name="water_supply" value="1" checked>
                                                <i class="fa-solid fa-droplet text-primary"></i> Water Supply
                                            </label>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <label class="amenity-item checked w-100">
                                                <input type="checkbox" id="security" name="security" value="1" checked>
                                                <i class="fa-solid fa-shield text-primary"></i> Security
                                            </label>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <label class="amenity-item w-100">
                                                <input type="checkbox" id="pool" name="pool" value="1">
                                                <i class="fa-solid fa-water-ladder"></i> Swimming Pool
                                            </label>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <label class="amenity-item w-100">
                                                <input type="checkbox" id="gym" name="gym" value="1">
                                                <i class="fa-solid fa-dumbbell"></i> Gym
                                            </label>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <label class="amenity-item checked w-100">
                                                <input type="checkbox" id="wifi" name="wifi" value="1" checked>
                                                <i class="fa-solid fa-wifi text-primary"></i> WiFi Ready
                                            </label>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <label class="amenity-item w-100">
                                                <input type="checkbox" id="ac" name="ac" value="1">
                                                <i class="fa-solid fa-wind"></i> Air Conditioning
                                            </label>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <label class="amenity-item checked w-100">
                                                <input type="checkbox" id="bq" name="bq" value="1" checked>
                                                <i class="fa-solid fa-house text-primary"></i> Boys Quarter
                                            </label>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <label class="amenity-item checked w-100">
                                                <input type="checkbox" id="prepaid" name="prepaid_meter" value="1" checked>
                                                <i class="fa-solid fa-receipt text-primary"></i> Prepaid Meter
                                            </label>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <label class="amenity-item w-100">
                                                <input type="checkbox" id="pop" name="pop_ceiling" value="1">
                                                <i class="fa-solid fa-star"></i> POP Ceiling
                                            </label>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <label class="amenity-item checked w-100">
                                                <input type="checkbox" id="tiled" name="tiled_floor" value="1" checked>
                                                <i class="fa-solid fa-border-all text-primary"></i> Tiled Floors
                                            </label>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-2">
                                        <button class="btn-prev btn" id="prevStep1" type="button">
                                            <i class="fa-solid fa-arrow-left me-2"></i> Previous
                                        </button>
                                        <button class="btn-next btn" id="nextStep3" type="button">
                                            Next: Photos & Video
                                            <i class="fa-solid fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 3 — MEDIA UPLOAD    -->
                            <div id="step3" class="step-content d-none">
                                <div class="listing-card">
                                    <div class="step-header">
                                        <div class="step-badge step-badge-3">3</div>
                                        <div>
                                            <div class="step-header-title">Photos & Video</div>
                                            <p class="step-header-sub">Upload clear photos of every room. A video walkthrough is optional but recommended.</p>
                                        </div>
                                    </div>

                                    <!-- Photos -->
                                    <label class="form-label mb-2">
                                        Property Photos <span class="text-danger">*</span>
                                    </label>
                                    <div class="upload-zone mb-4">
                                        <div class="upload-zone-icon" style="background:#e8f0fe;">
                                            <i class="fa-solid fa-cloud-arrow-up text-primary"></i>
                                        </div>
                                        <p>
                                            <strong class="text-primary">Click to upload photos</strong>
                                            or drag and drop here
                                        </p>
                                        <small>JPG, PNG — up to 10 photos. Max 5MB each.</small>
                                        <input type="file" class="form-control mt-3"
                                            name="property_photo1" multiple>
                                    </div>

                                    <hr class="my-4" style="border-color: #f1f3f9;">

                                    <!-- Video -->
                                    <label class="form-label mb-2">
                                        Video Walkthrough
                                        <span class="text-muted fw-normal">(Optional)</span>
                                    </label>
                                    <div class="upload-zone">
                                        <div class="upload-zone-icon" style="background:#fff3cd;">
                                            <i class="fa-solid fa-video text-warning"></i>
                                        </div>
                                        <p>
                                            <strong>Upload a video</strong> walkthrough of the property
                                        </p>
                                        <small>MP4 — Max 100MB. Tenants love seeing the actual space.</small>
                                        <input type="file" class="form-control mt-3"
                                            id="uploadBtn" name="walkthrough_videos"
                                            multiple accept="video/*">
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button class="btn-prev btn" id="prevStep2" type="button">
                                            <i class="fa-solid fa-arrow-left me-2"></i> Previous
                                        </button>
                                        <button class="btn-next btn" id="nextStep4" type="button">
                                            Next: Documents
                                            <i class="fa-solid fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 4 — DOCUMENTS       -->
                            <div id="step4" class="step-content d-none">
                                <div class="listing-card">
                                    <div class="step-header">
                                        <div class="step-badge step-badge-4">4</div>
                                        <div>
                                            <div class="step-header-title">Ownership Documents</div>
                                            <p class="step-header-sub">Upload proof that you own or are authorised to list this property</p>
                                        </div>
                                    </div>

                                    <!-- Document items (placeholders — add your file inputs here) -->
                                    <div class="doc-item">
                                        <div class="doc-icon" style="background:#e8f0fe;">
                                            <i class="fa-solid fa-file-certificate text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="doc-name">Certificate of Occupancy (C of O)</div>
                                            <p class="doc-desc">Primary proof of ownership. Required for landlords.</p>
                                        </div>
                                        <span class="badge rounded-pill px-3 py-2"
                                            style="background:#f0fdf4; color:#16a34a; font-size:0.78em;">
                                            <i class="fa-solid fa-circle-check me-1"></i> Required
                                        </span>
                                    </div>

                                    <div class="doc-item">
                                        <div class="doc-icon" style="background:#fdf4ff;">
                                            <i class="fa-solid fa-file-lines" style="color:#9333ea;"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="doc-name">Deed of Assignment</div>
                                            <p class="doc-desc">Alternative proof of ownership. Upload if you don't have C of O.</p>
                                        </div>
                                        <span class="badge rounded-pill px-3 py-2"
                                            style="background:#f9fafb; color:#9ca3af; font-size:0.78em;">
                                            Optional
                                        </span>
                                    </div>

                                    <div class="doc-item">
                                        <div class="doc-icon" style="background:#fff7ed;">
                                            <i class="fa-solid fa-file-signature" style="color:#ea580c;"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="doc-name">Authorization Letter</div>
                                            <p class="doc-desc">Required only for agents listing on behalf of a landlord.</p>
                                        </div>
                                        <span class="badge rounded-pill px-3 py-2"
                                            style="background:#f9fafb; color:#9ca3af; font-size:0.78em;">
                                            If applicable
                                        </span>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button class="btn-prev btn" id="prevStep3" type="button">
                                            <i class="fa-solid fa-arrow-left me-2"></i> Previous
                                        </button>
                                        <button class="btn-next btn" id="nextStep5" type="button">
                                            Next: Review & Submit
                                            <i class="fa-solid fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 5 — REVIEW & SUBMIT -->
                            <div id="step5" class="step-content d-none">
                                <div class="listing-card">
                                    <div class="step-header">
                                        <div class="step-badge step-badge-5">5</div>
                                        <div>
                                            <div class="step-header-title">Review & Submit</div>
                                            <p class="step-header-sub">Double-check everything before submitting for admin review</p>
                                        </div>
                                    </div>
     
                                    <div class="row g-3 mb-4">

                                        <!-- Basic Info -->
                                        <div class="col-md-6">
                                            <div class="review-box">
                                                <div class="review-box-label">Basic Info</div>
                                                <div class="review-row">
                                                    <span class="key">Title</span>
                                                    <span class="val" id="rTitle">—</span>
                                                </div>
                                                <div class="review-row">
                                                    <span class="key">Type</span>
                                                    <span class="val" id="rType">—</span>
                                                </div>
                                                <div class="review-row">
                                                    <span class="key">Price</span>
                                                    <span class="val text-primary" id="rPrice">—</span>
                                                </div>
                                                <div class="review-row">
                                                    <span class="key">Payment</span>
                                                    <span class="val" id="rPayment">—</span>
                                                </div>
                                                <div class="review-row">
                                                    <span class="key">LGA</span>
                                                    <span class="val" id="rLga">—</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Features -->
                                        <div class="col-md-6">
                                            <div class="review-box">
                                                <div class="review-box-label">Property Features</div>
                                                <div class="review-row">
                                                    <span class="key">Bedrooms</span>
                                                    <span class="val" id="rBedroom">—</span>
                                                </div>
                                                <div class="review-row">
                                                    <span class="key">Bathrooms</span>
                                                    <span class="val" id="rBathroom">—</span>
                                                </div>
                                                <div class="review-row">
                                                    <span class="key">Toilets</span>
                                                    <span class="val" id="rToilet">—</span>
                                                </div>
                                                <div class="review-row">
                                                    <span class="key">Furnishing</span>
                                                    <span class="val" id="rFurnished">—</span>
                                                </div>
                                                <div class="review-row">
                                                    <span class="key">Floor</span>
                                                    <span class="val" id="rFloor">—</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Media -->
                                        <div class="col-md-6">
                                            <div class="review-box">
                                                <div class="review-box-label">Media</div>
                                                <div class="review-row">
                                                    <span class="key">Photos</span>
                                                    <span class="val text-success">3 uploaded</span>
                                                </div>
                                                <div class="review-row">
                                                    <span class="key">Video</span>
                                                    <span class="val" style="color:#adb5bd;">Not uploaded</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Documents -->
                                        <div class="col-md-6">
                                            <div class="review-box">
                                                <div class="review-box-label">Documents</div>
                                                <div class="review-row">
                                                    <span class="key">C of O</span>
                                                    <span class="val text-success">Uploaded</span>
                                                </div>
                                                <div class="review-row">
                                                    <span class="key">Deed</span>
                                                    <span class="val" style="color:#adb5bd;">Not uploaded</span>
                                                </div>
                                                <div class="review-row">
                                                    <span class="key">Auth Letter</span>
                                                    <span class="val" style="color:#adb5bd;">Not required</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Notice -->
                                    <div class="notice-box mb-4">
                                        <i class="fa-solid fa-circle-info"></i>
                                        <p class="mb-0">
                                            Once submitted, your listing will be reviewed by our admin team within
                                            <strong>24 to 48 hours.</strong> You will be notified by email once it is
                                            approved or if any corrections are needed.
                                        </p>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button class="btn-prev btn" type="button">
                                            <i class="fa-solid fa-arrow-left me-2"></i> Previous
                                        </button>
                                        <button class="btn-submit btn" name="create" type="submit" value="submit">
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
    <?php //include '../footer.php'; ?>

    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {

            // STATE → LGA AJAX
            $('#state').change(function () {
                var state_id = $('#state').val();
                $.ajax({
                    url: "../process_pages/process_state_lga.php",
                    method: "get",
                    dataType: "text",
                    data: { state_id },
                    success: function (res) {
                        console.log(res);
                        $('#lga').append(res);
                    },
                    error: function (er) {
                        console.log(er);
                    },
                    precessData: false,
                    contentType: false,
                    cache: false
                });
            });

            // STEP NAVIGATION 
            var stepNumber = 1;

            $('#nextStep2').click(function () {
                $("#step1").addClass("d-none");
                $("#step2").addClass("d-block").removeClass('d-none');
                $('.progress').css("width", (stepNumber) * 20 + "%");
                $('#step' + (stepNumber + 1) + '-circle').addClass('progress_bar').removeClass('step');
            });

            $('#nextStep3').click(function () {
                $("#step1").addClass("d-none");
                $("#step2").addClass("d-none");
                $("#step3").addClass("d-block").removeClass('d-none');
                $('.progress').css("width", (stepNumber + 1) * 20 + "%");
                $('#step' + (stepNumber + 2) + '-circle').addClass('progress_bar').removeClass('step');
            });

            $('#nextStep4').click(function () {
                $("#step1").addClass("d-none");
                $("#step2").addClass("d-none");
                $("#step3").addClass("d-none");
                $("#step4").addClass("d-block").removeClass('d-none');
                $('.progress').css("width", (stepNumber + 2) * 20 + "%");
                $('#step' + (stepNumber + 3) + '-circle').addClass('progress_bar').removeClass('step');
                $("#rTitle").html($('#title').val());
                $("#rType").html($('#type').val());
                $("#rPrice").html('₦' + parseInt($('#price').val()).toLocaleString());
                $("#rPayment").html($('#payment').val());
                $("#rBedroom").html($('#bedrooms').val());
                $("#rBathroom").html($('#bathrooms').val());
                $("#rFurnished").html($('input[name="furnishing"]:checked').val());
                $("#rFloor").html($('#floor').val());
                $("#rToilet").html($('#toilets').val());
                $("#rLga").html($('#lga option:selected').text());
            });

            $('#nextStep5').click(function () {
                $("#step1").addClass("d-none");
                $("#step2").addClass("d-none");
                $("#step3").addClass("d-none");
                $("#step4").addClass("d-none").removeClass('d-block');
                $("#step5").addClass("d-block").removeClass('d-none');
                $('.progress').css("width", (stepNumber + 3) * 20 + "%");
                $('#step' + (stepNumber + 4) + '-circle').addClass('progress_bar').removeClass('step');
            });

            $('#prevStep1').click(function () {
                $("#step1").addClass("d-block").removeClass('d-none');
                $("#step2").addClass("d-none");
                $("#step3").addClass("d-none");
                $('.progress').css("width", 0 + "%");
                $('#step' + (stepNumber + 1) + '-circle').removeClass('progress_bar').addClass('step');
            });

            $('#prevStep2').click(function () {
                $("#step1").addClass("d-none");
                $("#step2").addClass("d-block").removeClass('d-none');
                $("#step3").addClass("d-none");
                $('.progress').css("width", (stepNumber) * 20 + "%");
                $('#step' + (stepNumber + 1) + '-circle').addClass('progress_bar').removeClass('step');
                $('#step' + (stepNumber + 2) + '-circle').removeClass('progress_bar').addClass('step');
            });

            $('#prevStep3').click(function () {
                $("#step1").addClass("d-none");
                $("#step2").addClass("d-none");
                $("#step3").addClass("d-block").removeClass('d-none');
                $("#step4").addClass("d-none").removeClass('d-block');
                $('.progress').css("width", (stepNumber + 1) * 20 + "%");
                $('#step' + (stepNumber + 1) + '-circle').addClass('progress_bar').removeClass('step');
                $('#step' + (stepNumber + 2) + '-circle').addClass('progress_bar').removeClass('step');
                $('#step' + (stepNumber + 3) + '-circle').removeClass('progress_bar').addClass('step');
            });

            // ============================================
            // AMENITY TOGGLE — fallback for :has()
            // ============================================
            $('.amenity-item').click(function () {
                $(this).toggleClass('checked');
            });

        });

        // ============================================
        // COUNTER BUTTONS
        // ============================================
        function changeCount(field, delta) {
            const input = document.getElementById(field);
            const newVal = parseInt(input.value) + delta;
            if (newVal >= 0 && newVal <= 20) input.value = newVal;
        }
    </script>
</body>
</html>