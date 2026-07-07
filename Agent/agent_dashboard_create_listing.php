<?php
session_start();
require_once "../process_pages/classes/Agent.php";
require_once "agentguard.php";
$agent = new Agent();
$det = $agent->fetch_agent_details($_SESSION['agent_online']);

$property_types = $agent->fetch_property_types();



require_once "../process_pages/classes/Utilities.php";
$a = new Utilities();
        $states =  $a->fetch_all_states();
        // echo "<pre>";
        //      print_r($states);
        // echo "</pre>";
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard</title>
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
            .progress_bar{
                width: 40px;
                height: 40px; 
                background-color: #cfe2ff; 
                border: 2px solid #0d6efd; 
                color: #084298; 
                font-size: 14px;
            }

            .step{
                width: 40px; 
                height: 40px; 
                background-color: #f1f1f1; 
                border: 2px solid #dee2e6; 
                color: #adb5bd; 
                font-size: 14px;
            }

            .amenities{
                background-color: #cfe2ff;
                 color: #084298; 
                 font-size:0.8em;
            }
        </style>
    

</head>

<body>
    <!-- Navigation -->
     <?php //require_once 'nav.php'; ?>



    <div class="container-fluid " >
        <div class="row" style="min-height: 900px;">

            <!-- Sidebar (Profile and Navigation) -->
            <?php include 'agent_nav.php'; ?>
            <!-- Sidebar (Profile and Navigation) -->

            <!-- Main Content -->
            <div class="col-md-9 px-5 pb-5 pt-3">

                <!-- Mobile Menu Toggle -->
                <div class="row mb-2">
                    <a class="btn btn-primary d-md-none mt-2" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#mobileMenu" aria-controls="mobileMenu">
                        <i class="fa-solid fa-bars"></i>
                    </a>
                </div>

                <!-- Top Bar -->
                <div class="row mt-4 mb-4">
                    <div class="col-12 d-flex justify-content-between align-items-start">
                        <div>
                            <h2 class="mb-1">Create New Listing</h2>
                            <p class="text-muted mb-0" style="font-size: 0.9em;">Fill in the details below to list
                                your property on NaijaRent</p>
                        </div>
                        <a href="agent_dashboard_listings.php" class="btn btn-outline-secondary px-4">
                            <i class="fa-solid fa-arrow-left me-2"></i> Back to Listings
                        </a>
                    </div>
                </div>
              
                <!-- PROGRESS INDICATOR    -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm p-4">
                            <div class="d-flex justify-content-between align-items-start position-relative">

                                <!-- Progress Line -->
                                <div class="position-absolute"
                                    style="top: 20px; left: 10%; right: 10%; height: 2px; background-color: #dee2e6; z-index: 0;"></div>
                                <div class="position-absolute progress"
                                    style="top: 20px; left: 10%; width: 0%; height: 2px; background-color: #0d6efd; z-index: 1;"
                                    id="progressFill"></div>

                                <!-- Step 1 -->
                                <div class="d-flex flex-column align-items-center" style="z-index: 2; width: 20%;">
                                    <div class="rounded-circle d-flex justify-content-center align-items-center fw-medium mb-2 progress_bar" id="step1-circle">1</div>
                                    <small class="text-center fw-medium" style="color: #0d6efd; font-size: 0.78em;">Basic
                                        Info</small>
                                </div>

                                <!-- Step 2 -->
                                <div class="d-flex flex-column align-items-center" style="z-index: 2; width: 20%;">
                                    <div class="rounded-circle d-flex justify-content-center align-items-center fw-medium mb-2 step" id="step2-circle">2</div>
                                    <small class="text-center text-muted" style="font-size: 0.78em;">Features</small>
                                </div>

                                <!-- Step 3 -->
                                <div class="d-flex flex-column align-items-center" style="z-index: 2; width: 20%;">
                                    <div class="rounded-circle d-flex justify-content-center align-items-center fw-medium mb-2 step" id="step3-circle">3</div>
                                    <small class="text-center text-muted" style="font-size: 0.78em;">Photos &
                                        Video</small>
                                </div>

                                <!-- Step 4 -->
                                <div class="d-flex flex-column align-items-center" style="z-index: 2; width: 20%;">
                                    <div class="rounded-circle d-flex justify-content-center align-items-center fw-medium mb-2 step" id="step4-circle">4</div>
                                    <small class="text-center text-muted" style="font-size: 0.78em;">Documents</small>
                                </div>

                                <!-- Step 5 -->
                                <div class="d-flex flex-column align-items-center" style="z-index: 2; width: 20%;">
                                    <div class="rounded-circle d-flex justify-content-center align-items-center fw-medium mb-2 step" id="step5-circle">5</div>
                                    <small class="text-center text-muted" style="font-size: 0.78em;">Review &
                                        Submit</small>
                                </div> 

                            </div>
                             <?php
                                if(isset($_SESSION['errormsg'])){   
                            ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo $_SESSION['errormsg'];  unset($_SESSION['errormsg']);?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php
                                }
                            ?>
                                <?php
                                    if(isset($_SESSION['successmsg'])){
                                ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?php echo $_SESSION['successmsg']; unset($_SESSION['successmsg']); ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php
                                    }
                                ?>

                        </div>
                    </div>
                </div>
           
               <div class="row">
                    <div class="com-md-12">
                        <form action="../process_pages/process_new_listing.php" method="POST" enctype="multipart/form-data">
                              <!-- STEP 1 — BASIC INFO   -->
                             <div id="step1" class="step-content">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card border-0 shadow-sm p-4 mb-4">
                                            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                                                <div class="rounded-circle d-flex justify-content-center align-items-center fw-medium flex-shrink-0"
                                                    style="width: 36px; height: 36px; background-color: #cfe2ff; color: #084298; font-size: 14px;">
                                                    1
                                                </div>
                                                <div>
                                                    <h5 class="mb-0">Basic Information</h5>
                                                    <small class="text-muted">Tell us the key details about your property</small>
                                                </div>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label class="form-label fw-medium" style="font-size: 0.85em;">Property Title</label>
                                                    <input type="text" class="form-control" placeholder="e.g. Spacious 3-bedroom flat in Lekki Phase 1" name="title" id='title'>
                                                    <input type="number" class="form-control"  name="Agentid" hidden value="<?php $det["Agent_id"]; ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-medium" style="font-size: 0.85em;">Property Type</label>
                                                    <select class="form-select" name="property_type" id="type">
                                                        <option disabled selected>Select property type</option>
                                                        <?php
                                                            foreach($property_types as $pt){

                                                            
                                                        ?>
                                                            <option value="<?php echo $pt['property_typeid'] ?>"> <?php echo $pt['name'];?></option>
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-medium" style="font-size: 0.85em;">Listing
                                                        Purpose</label>
                                                    <select class="form-select" name="listing_purpose">
                                                        <option disabled selected>Select listing purpose</option>
                                                        <option value="For_Rent">For Rent</option>
                                                        <option value="For_Sale">For Sale</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-medium" style="font-size: 0.85em;">Price
                                                        (₦)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">₦</span>
                                                        <input type="number" class="form-control" placeholder="e.g. 1500000" name="price" id='price'>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-medium" style="font-size: 0.85em;">Payment
                                                        Flexibility</label>
                                                    <select class="form-select" name="payment_flexibility" id='payment'>
                                                        <option disabled selected>Select payment terms</option>
                                                        <option value="yearly">Yearly</option>
                                                        <option value="quarterly">Quarterly</option>
                                                        <option value="monthly">Monthly</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-medium" style="font-size: 0.85em;">Full
                                                        Address</label>
                                                    <input type="text" class="form-control" name="full_address" placeholder="e.g. 14 Admiralty Way, Lekki Phase 1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-medium" style="font-size: 0.85em;">State</label>
                                                    <select class="form-select" name="state" id='state'>
                                                        <option value="">Select state</option>
                                                        <?php 
                                                            foreach($states as $state){
                                                        ?>
                                                        <option value="<?php echo $state['state_id']; ?>"> <?php echo $state['state']; ?></option>
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-medium"
                                                        style="font-size: 0.85em;">LGA</label>
                                                    <select class="form-select" name="lga" id="lga">
                                                        <option value=""> select LGA</option>
                                                        
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-medium"
                                                        style="font-size: 0.85em;">Description</label>
                                                    <textarea class="form-control" name="description" rows="4"
                                                        placeholder="Describe the property — location advantages, nearby landmarks, key selling points..."></textarea>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-end mt-4">
                                                <button class="btn btn-primary px-5" id='nextStep2' type="button">
                                                    Next: Property Features <i class="fa-solid fa-arrow-right ms-2"></i>
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                            </div>
                             </div>
                        
                            <!-- STEP 2 — PROPERTY FEATURES -->
                            <div id="step2" class="step-content d-none">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card border-0 shadow-sm p-4 mb-4">
                                            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                                                <div class="rounded-circle d-flex justify-content-center align-items-center fw-medium flex-shrink-0"
                                                    style="width: 36px; height: 36px; background-color: #d1e7dd; color: #0a3622; font-size: 14px;">
                                                    2
                                                </div>
                                                <div>
                                                    <h5 class="mb-0">Property Features</h5>
                                                    <small class="text-muted">Specify the physical details and available
                                                        amenities</small>
                                                </div>
                                            </div>

                                            <!-- Room Counts -->
                                            <div class="row g-4 mb-4">
                                                <div class="col-md-4">
                                                    <label class="form-label fw-medium"
                                                        style="font-size: 0.85em;">Bedrooms</label>
                                                    <div class="input-group">
                                                        <button class="btn btn-outline-secondary" type="button">−</button>
                                                        <input type="number" class="form-control text-center fw-medium"
                                                            id="bedrooms" value="3" min="0" max="20" name="bedrooms">
                                                        <button class="btn btn-outline-secondary" type="button">+</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-medium"
                                                        style="font-size: 0.85em;">Bathrooms</label>
                                                    <div class="input-group">
                                                        <button class="btn btn-outline-secondary" type="button">−</button>
                                                        <input type="number" class="form-control text-center fw-medium"
                                                            id="bathrooms" value="2" min="0" max="20" name="bathrooms">
                                                        <button class="btn btn-outline-secondary" type="button">+</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-medium"
                                                        style="font-size: 0.85em;">Toilets</label>
                                                    <div class="input-group">
                                                        <button class="btn btn-outline-secondary" type="button">−</button>
                                                        <input type="number" class="form-control text-center fw-medium"
                                                            id="toilets" value="3" min="0" max="20" name="toilets">
                                                        <button class="btn btn-outline-secondary" type="button">+</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Furnishing & Floor -->
                                            <div class="row g-3 mb-4">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-medium" style="font-size: 0.85em;">Furnishing
                                                        Status</label>
                                                    <div class="d-flex gap-2 flex-wrap">
                                                        <div class="form-check form-check-inline border rounded p-2 px-3"
                                                            style="cursor:pointer; background-color: #cfe2ff; border-color: #0d6efd !important;">
                                                            <input class="form-check-input" type="radio" name="furnishing" 
                                                                id="furnished" value="furnished" checked>
                                                            <label class="form-check-label fw-medium" style="font-size:0.85em; cursor:pointer;" for="furnished">Furnished</label>
                                                        </div>
                                                        <div class="form-check form-check-inline border rounded p-2 px-3"
                                                            style="cursor:pointer;">
                                                            <input class="form-check-input" type="radio" name="furnishing"
                                                                id="semi" value="semi-furnished">
                                                            <label class="form-check-label" style="font-size:0.85em; cursor:pointer;"
                                                                for="semi">Semi-Furnished</label>
                                                        </div>
                                                        <div class="form-check form-check-inline border rounded p-2 px-3"
                                                            style="cursor:pointer;">
                                                            <input class="form-check-input" type="radio" name="furnishing"
                                                                id="unfurnished" value="unfurnished">
                                                            <label class="form-check-label" style="font-size:0.85em; cursor:pointer;"
                                                                for="unfurnished">Unfurnished</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-medium" style="font-size: 0.85em;">Floor
                                                        Level</label>
                                                    <select class="form-select" name='floor_level' id='floor'>
                                                        <option value="ground">Ground Floor</option>
                                                        <option value="first">1st Floor</option>
                                                        <option value="second">2nd Floor</option>
                                                        <option value="top">Top Floor</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Amenities -->
                                            <label class="form-label fw-medium mb-3"
                                                style="font-size: 0.85em;">Available Amenities</label>
                                            <div class="row g-2 mb-4">
                                                <div class="col-6 col-md-4">
                                                    <div class="form-check border rounded p-2 px-3 amenity-check"
                                                        style="cursor:pointer; background-color: #cfe2ff; border-color: #0d6efd !important;">
                                                        <input class="form-check-input" type="checkbox" id="parking" checked>
                                                        <label class="form-check-label" style="font-size:0.85em; cursor:pointer;"
                                                            for="parking">
                                                            <i class="fa-solid fa-car me-1 text-primary"></i> Parking Space
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <div class="form-check border rounded p-2 px-3 amenity-check"
                                                        style="cursor:pointer; background-color: #cfe2ff; border-color: #0d6efd !important;">
                                                        <input class="form-check-input" type="checkbox" id="electricity" checked name="electricity_supply">
                                                        <label class="form-check-label" style="font-size:0.85em; cursor:pointer;"
                                                            for="electricity">
                                                            <i class="fa-solid fa-bolt me-1 text-primary"></i> Electricity
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <div class="form-check border rounded p-2 px-3 amenity-check"
                                                        style="cursor:pointer; background-color: #cfe2ff; border-color: #0d6efd !important;">
                                                        <input class="form-check-input" type="checkbox" id="water" checked name="water_supply" value='1'>
                                                        <label class="form-check-label" style="font-size:0.85em; cursor:pointer;"
                                                            for="water">
                                                            <i class="fa-solid fa-droplet me-1 text-primary"></i> Water Supply
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <div class="form-check border rounded p-2 px-3 amenity-check"
                                                        style="cursor:pointer; background-color: #cfe2ff; border-color: #0d6efd !important;">
                                                        <input class="form-check-input" type="checkbox" id="security" checked name="security" value='1'>
                                                        <label class="form-check-label" style="font-size:0.85em; cursor:pointer;"
                                                            for="security">
                                                            <i class="fa-solid fa-shield me-1 text-primary"></i> Security
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <div class="form-check border rounded p-2 px-3 amenity-check"
                                                        style="cursor:pointer;">
                                                        <input class="form-check-input" type="checkbox" id="pool" name="pool" value='1'>
                                                        <label class="form-check-label" style="font-size:0.85em; cursor:pointer;"
                                                            for="pool">
                                                            <i class="fa-solid fa-water-ladder me-1 text-muted"></i> Swimming Pool
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <div class="form-check border rounded p-2 px-3 amenity-check"
                                                        style="cursor:pointer;">
                                                        <input class="form-check-input" type="checkbox" id="gym" name="gym" value='1'>
                                                        <label class="form-check-label" style="font-size:0.85em; cursor:pointer;"
                                                            for="gym">
                                                            <i class="fa-solid fa-dumbbell me-1 text-muted"></i> Gym
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <div class="form-check border rounded p-2 px-3 amenity-check"
                                                        style="cursor:pointer; background-color: #cfe2ff; border-color: #0d6efd !important;">
                                                        <input class="form-check-input" type="checkbox" id="wifi" checked name="wifi" value='1'>
                                                        <label class="form-check-label" style="font-size:0.85em; cursor:pointer;"
                                                            for="wifi">
                                                            <i class="fa-solid fa-wifi me-1 text-primary"></i> WiFi Ready
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <div class="form-check border rounded p-2 px-3 amenity-check"
                                                        style="cursor:pointer;">
                                                        <input class="form-check-input" type="checkbox" id="ac" name="ac" value='1'>
                                                        <label class="form-check-label" style="font-size:0.85em; cursor:pointer;"
                                                            for="ac">
                                                            <i class="fa-solid fa-wind me-1 text-muted"></i> Air Conditioning
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <div class="form-check border rounded p-2 px-3 amenity-check"
                                                        style="cursor:pointer; background-color: #cfe2ff; border-color: #0d6efd !important;">
                                                        <input class="form-check-input" type="checkbox" id="bq" checked name="bq" value='1'>
                                                        <label class="form-check-label" style="font-size:0.85em; cursor:pointer;"
                                                            for="bq">
                                                            <i class="fa-solid fa-house me-1 text-primary"></i> Boys Quarter
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <div class="form-check border rounded p-2 px-3 amenity-check"
                                                        style="cursor:pointer; background-color: #cfe2ff; border-color: #0d6efd !important;">
                                                        <input class="form-check-input" type="checkbox" id="prepaid" checked name="prepaid_meter" value='1'>
                                                        <label class="form-check-label" style="font-size:0.85em; cursor:pointer;"
                                                            for="prepaid">
                                                            <i class="fa-solid fa-receipt me-1 text-primary"></i> Prepaid Meter
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <div class="form-check border rounded p-2 px-3 amenity-check"
                                                        style="cursor:pointer;">
                                                        <input class="form-check-input" type="checkbox" id="pop" name="pop_ceiling" value='1'>
                                                        <label class="form-check-label" style="font-size:0.85em; cursor:pointer;"
                                                            for="pop">
                                                            <i class="fa-solid fa-star me-1 text-muted"></i> POP Ceiling
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <div class="form-check border rounded p-2 px-3 amenity-check"
                                                        style="cursor:pointer; background-color: #cfe2ff; border-color: #0d6efd !important;">
                                                        <input class="form-check-input" type="checkbox" id="tiled" checked name="tiled_floor" value='1'>
                                                        <label class="form-check-label" style="font-size:0.85em; cursor:pointer;"
                                                            for="tiled">
                                                            <i class="fa-solid fa-border-all me-1 text-primary"></i> Tiled Floors
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between mt-2">
                                                <button class="btn btn-outline-secondary px-4" id="prevStep1" type="button">
                                                    <i class="fa-solid fa-arrow-left me-2"></i> Previous
                                                </button>
                                                <button class="btn btn-primary px-5" id="nextStep3" type="button" >
                                                    Next: Photos & Video <i class="fa-solid fa-arrow-right ms-2"></i>
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 3 — MEDIA UPLOAD     -->
                            <div id="step3" class="step-content d-none" id="step3">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card border-0 shadow-sm p-4 mb-4">
                                            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                                                <div class="rounded-circle d-flex justify-content-center align-items-center fw-medium flex-shrink-0"
                                                    style="width: 36px; height: 36px; background-color: #fff3cd; color: #664d03; font-size: 14px;">
                                                    3
                                                </div>
                                                <div>
                                                    <h5 class="mb-0">Photos & Video</h5>
                                                    <small class="text-muted">Upload clear photos of every room. A video
                                                        walkthrough is optional but recommended.</small>
                                                </div>
                                            </div>

                                            <!-- Photo Upload -->
                                            <label class="form-label fw-medium mb-3" style="font-size: 0.85em;">Property
                                                Photos <span class="text-danger">*</span></label>
                                            <div class="border rounded-3 p-5 text-center mb-3" style="border-style: dashed; background-color: #f8f9fa; cursor: pointer;">
                                                <div class="rounded-circle d-flex justify-content-center align-items-center mx-auto mb-3"
                                                    style="width: 52px; height: 52px; background-color: #cfe2ff;">
                                                    <i class="fa-solid fa-cloud-arrow-up fa-lg text-primary"></i>
                                                </div>
                                                <p class="mb-1" style="font-size: 0.9em;">
                                                    <strong class="text-primary">Click to upload photos</strong> or drag and
                                                    drop here
                                                </p>
                                                <small class="text-muted">JPG, PNG — up to 10 photos. Max 5MB each.</small>
                                                <br>
                                                <input type="file" class="form-control mt-3 px-4" value="Choose Files" name='property_photo1' multiple>
                                                <input type="file" id="photoInput" multiple accept="image/*" class="d-none">
                                            </div>

                                            <hr class="my-4">

                                            <!-- Video Upload -->
                                            <label class="form-label fw-medium mb-2" style="font-size: 0.85em;">Video Walkthrough <span class="text-muted fw-normal">(Optional)</span> </label>
                                            <div class="border rounded-3 p-4 text-center" style="border-style: dashed !important; background-color: #f8f9fa; cursor: pointer;">
                                                <div class="rounded-circle d-flex justify-content-center align-items-center mx-auto mb-2"  style="width: 48px; height: 48px; background-color: #fff3cd;">
                                                    <i class="fa-solid fa-video text-warning"></i>
                                                </div>
                                                <p class="mb-1" style="font-size: 0.9em;"> <strong>Upload a video</strong> walkthrough of the property </p>
                                                <small class="text-muted">MP4 — Max 100MB. Tenants love seeing the actualspace.</small>
                                                <input type="file" class="form-control mt-3 px-4" id="uploadBtn" value="Choose Files" name='walkthrough_videos' multiple accept="video/*">
                                            </div>

                                            <div class="d-flex justify-content-between mt-4">
                                                <button class="btn btn-outline-secondary px-4" id="prevStep2" type="button">
                                                    <i class="fa-solid fa-arrow-left me-2"></i> Previous
                                                </button>
                                                <button class="btn btn-primary px-5" id='nextStep4'type='button'>
                                                    Next: Documents <i class="fa-solid fa-arrow-right ms-2"></i>
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 4 — DOCUMENTS        -->
                            <div id="step4" class="step-content d-none" id='step4'>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card border-0 shadow-sm p-4 mb-4">
                                            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                                                <div class="rounded-circle d-flex justify-content-center align-items-center fw-medium flex-shrink-0"
                                                    style="width: 36px; height: 36px; background-color: #e8d5f5; color: #3c1361; font-size: 14px;">
                                                    4
                                                </div>
                                                <div>
                                                    <h5 class="mb-0">Ownership Documents</h5>
                                                    <small class="text-muted">Upload proof that you own or are authorised to
                                                        list this property</small>
                                                </div>
                                            </div>

                                            <!-- Agent or Landlord -->
                                            <!-- <label class="form-label fw-medium mb-3"
                                                style="font-size: 0.85em;">I am listing this property as</label>
                                            <div class="d-flex gap-3 flex-wrap mb-4">
                                                <div class="form-check border rounded p-2 px-3"
                                                    style="cursor:pointer; background-color: #cfe2ff; border-color: #0d6efd !important;">
                                                    <input class="form-check-input" type="radio" name="ownerType"
                                                        id="landlord" checked>
                                                    <label class="form-check-label fw-medium"
                                                        style="font-size:0.85em; cursor:pointer;" for="landlord">
                                                        <i class="fa-solid fa-house me-1 text-primary"></i> Landlord (I own
                                                        this property)
                                                    </label>
                                                </div>
                                                <div class="form-check border rounded p-2 px-3" style="cursor:pointer;">
                                                    <input class="form-check-input" type="radio" name="ownerType" id="agent">
                                                    <label class="form-check-label" style="font-size:0.85em; cursor:pointer;"
                                                        for="agent">
                                                        <i class="fa-solid fa-user-tie me-1 text-muted"></i> Agent (I have
                                                        owner's authorisation)
                                                    </label>
                                                </div>
                                            </div> -->

                                            <!-- Document List -->
                                            <!-- <div class="d-flex flex-column gap-3"> -->

                                                 <!-- Doc 1 - Uploaded -->
                                                <!-- <div class="d-flex align-items-center gap-3 p-3 rounded-3"
                                                    style="background-color: #f8f9fa; border: 1px solid #dee2e6;">
                                                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                                                        style="width: 42px; height: 42px; background-color: #cfe2ff;">
                                                        <i class="fa-solid fa-file-certificate text-primary"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <p class="fw-medium mb-0" style="font-size: 0.9em;">Certificate of
                                                            Occupancy (C of O)</p>
                                                        <small class="text-muted">Primary proof of ownership. Required for
                                                            landlords.</small>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-1 text-success"
                                                        style="font-size: 0.85em; white-space: nowrap;">
                                                        <i class="fa-solid fa-circle-check"></i> Uploaded
                                                    </div>
                                                </div> -->

                                                <!-- Doc 2 - Pending Upload -->
                                                

                                                <!-- Doc 3 - Pending Upload -->
                                                /

                                                <!-- Doc 4 - Not Required -->
                                                

                                            <!-- </div> -->

                                            <div class="d-flex justify-content-between mt-4">
                                                <button class="btn btn-outline-secondary px-4" type="button" id='prevStep3'>
                                                    <i class="fa-solid fa-arrow-left me-2"></i> Previous
                                                </button>
                                                <button class="btn btn-primary px-5" id='nextStep5' type='button'>
                                                    Next: Review & Submit <i class="fa-solid fa-arrow-right ms-2"></i>
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 5 — REVIEW & SUBMIT  -->
                            <div id="step5" class="step-content d-none" id="step5">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card border-0 shadow-sm p-4 mb-4">
                                            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                                                <div class="rounded-circle d-flex justify-content-center align-items-center fw-medium flex-shrink-0"
                                                    style="width: 36px; height: 36px; background-color: #d1e7dd; color: #0a3622; font-size: 14px;">
                                                    5
                                                </div>
                                                <div>
                                                    <h5 class="mb-0">Review & Submit</h5>
                                                    <small class="text-muted">Double-check everything before submitting for
                                                        admin review</small>
                                                </div>
                                            </div>

                                            <!-- Review Summary Grid -->
                                            <div class="row g-3 mb-4">

                                                <!-- Basic Info Summary -->
                                                <div class="col-md-6">
                                                    <div class="rounded-3 p-3" style="background-color: #f8f9fa;">
                                                        <p class="fw-medium mb-3"
                                                            style="font-size: 0.75em; text-transform: uppercase; letter-spacing: 1px; color: #adb5bd;">
                                                            Basic Info</p>
                                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                                            <span class="text-muted" style="font-size:0.85em;">Title</span>
                                                            <span class="fw-medium"
                                                                style="font-size:0.85em;" id="rTitle"></span>
                                                        </div>
                                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                                            <span class="text-muted" style="font-size:0.85em;">Type</span>
                                                            <span class="fw-medium" style="font-size:0.85em;" id="rType">Flat</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                                            <span class="text-muted" style="font-size:0.85em;">Price</span>
                                                            <span class="fw-medium text-primary"
                                                                style="font-size:0.85em;" id="rPrice">₦1,500,000 / yr</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                                            <span class="text-muted" style="font-size:0.85em;">Payment</span>
                                                            <span class="fw-medium" style="font-size:0.85em;" id="rPayment">Yearly</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between py-2">
                                                            <span class="text-muted" style="font-size:0.85em;" id="rLga">LGA</span>
                                                            <span class="fw-medium" style="font-size:0.85em;">Eti-Osa
                                                                (Lekki)</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Features Summary -->
                                                <div class="col-md-6">
                                                    <div class="rounded-3 p-3" style="background-color: #f8f9fa;">
                                                        <p class="fw-medium mb-3"
                                                            style="font-size: 0.75em; text-transform: uppercase; letter-spacing: 1px; color: #adb5bd;">
                                                            Property Features</p>
                                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                                            <span class="text-muted"
                                                                style="font-size:0.85em;">Bedrooms</span>
                                                            <span class="fw-medium" style="font-size:0.85em;" id="rBedroom">3</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                                            <span class="text-muted"
                                                                style="font-size:0.85em;">Bathrooms</span>
                                                            <span class="fw-medium" style="font-size:0.85em;" id="rBathroom">2</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                                            <span class="text-muted" style="font-size:0.85em;" id='rToilets'>Toilets</span>
                                                            <span class="fw-medium" style="font-size:0.85em;" id='rToilet'>3</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                                            <span class="text-muted"
                                                                style="font-size:0.85em;">Furnishing</span>
                                                            <span class="fw-medium" style="font-size:0.85em;" id="rFurnished">Furnished</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between py-2">
                                                            <span class="text-muted" style="font-size:0.85em;">Floor</span>
                                                            <span class="fw-medium"
                                                                style="font-size:0.85em;" id="rFloor">Ground Floor</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Media Summary -->
                                                <div class="col-md-6">
                                                    <div class="rounded-3 p-3" style="background-color: #f8f9fa;">
                                                        <p class="fw-medium mb-3"
                                                            style="font-size: 0.75em; text-transform: uppercase; letter-spacing: 1px; color: #adb5bd;">
                                                            Media</p>
                                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                                            <span class="text-muted" style="font-size:0.85em;">Photos</span>
                                                            <span class="fw-medium text-success"
                                                                style="font-size:0.85em;">3 uploaded</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between py-2">
                                                            <span class="text-muted" style="font-size:0.85em;">Video</span>
                                                            <span class="fw-medium text-muted"
                                                                style="font-size:0.85em;">Not uploaded</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Documents Summary -->
                                                <div class="col-md-6">
                                                    <div class="rounded-3 p-3" style="background-color: #f8f9fa;">
                                                        <p class="fw-medium mb-3"
                                                            style="font-size: 0.75em; text-transform: uppercase; letter-spacing: 1px; color: #adb5bd;">
                                                            Documents</p>
                                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                                            <span class="text-muted" style="font-size:0.85em;">C of O</span>
                                                            <span class="fw-medium text-success"
                                                                style="font-size:0.85em;">Uploaded</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                                            <span class="text-muted" style="font-size:0.85em;">Deed</span>
                                                            <span class="fw-medium text-muted"
                                                                style="font-size:0.85em;">Not uploaded</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between py-2">
                                                            <span class="text-muted" style="font-size:0.85em;">Auth
                                                                Letter</span>
                                                            <span class="fw-medium text-muted"
                                                                style="font-size:0.85em;">Not required</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Amenities Tags -->
                                            <!-- <div class="mb-4">
                                                <p class="fw-medium mb-2"
                                                    style="font-size: 0.75em; text-transform: uppercase; letter-spacing: 1px; color: #adb5bd;">
                                                    Amenities Selected</p>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <span class="badge rounded-pill px-3 py-2 amenities" >
                                                        <i class="fa-solid fa-car me-1"></i> Parking
                                                    </span>
                                                    <span class="badge rounded-pill px-3 py-2 amenities"
                                                        >
                                                        <i class="fa-solid fa-bolt me-1"></i> Electricity
                                                    </span>
                                                    <span class="badge rounded-pill px-3 py-2 amenities"
                                                        >
                                                        <i class="fa-solid fa-droplet me-1"></i> Water Supply
                                                    </span>
                                                    <span class="badge rounded-pill px-3 py-2 amenities"
                                                       >
                                                        <i class="fa-solid fa-shield me-1"></i> Security
                                                    </span>
                                                    <span class="badge rounded-pill px-3 py-2 amenities"
                                                       >
                                                        <i class="fa-solid fa-wifi me-1"></i> WiFi Ready
                                                    </span>
                                                    <span class="badge rounded-pill px-3 py-2 amenities">
                                                        <i class="fa-solid fa-house me-1"></i> Boys Quarter
                                                    </span>
                                                    <span class="badge rounded-pill px-3 py-2 amenities"
                                                        >
                                                        <i class="fa-solid fa-receipt me-1"></i> Prepaid Meter
                                                    </span>
                                                    <span class="badge rounded-pill px-3 py-2 amenities"
                                                        >
                                                        <i class="fa-solid fa-border-all me-1"></i> Tiled Floors
                                                     </span>
                                                </div>
                                            </div> -->

                                            <!-- Submission Notice -->
                                            <div class="rounded-3 p-3 d-flex align-items-start gap-3 mb-4"
                                                style="background-color: #d1e7dd; border: 1px solid #a3cfbb;">
                                                <i class="fa-solid fa-circle-info text-success mt-1"></i>
                                                <p class="mb-0" style="font-size: 0.88em; color: #0a3622;">
                                                    Once submitted, your listing will be reviewed by our admin team within
                                                    <strong>24 to 48 hours.</strong> You will be notified by email once it is
                                                    approved or if any corrections are needed.
                                                </p>
                                            </div>

                                            <div class="d-flex justify-content-between">
                                                <button class="btn btn-outline-secondary px-4" type='button'>
                                                    <i class="fa-solid fa-arrow-left me-2"></i> Previous
                                                </button>
                                                <button class="btn btn-success px-5 py-2" name="create" type="submit" value="submit">
                                                    <i class="fa-solid fa-paper-plane me-2"></i> Submit Listing for Review
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
               </div>
            </div>
             <!-- Main Content End-->
        </div> 
    </div>

    <!-- Footer  -->
     <?php //include '../footer.php'; ?>
    <!-- Footer  -->
    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        
            $(document).ready(function(){
            
                $('#state').change(function(){
                    var state_id = $('#state').val();

                        $.ajax({
                            url:"../process_pages/process_state_lga.php",
                            method: "get",
                            dataType: "text",
                            data: {state_id},
                            success: function(res){
                                console.log(res)
                                $('#lga').append(res);
                                //alert(res);
                            },
                            error: function(er){
                            console.log(er);
                            },
                            precessData: false,
                            contentType: false,
                            cache: false
                        })


                })



                var stepNumber = 1;
                $('#nextStep2').click(function(){
                    $("#step1").addClass("d-none");
                    $("#step2").addClass("d-block").removeClass('d-none');
                    $('.progress').css("width", (stepNumber) * 20 + "%");
                    $('#step'+(stepNumber+1)+'-circle').addClass('progress_bar').removeClass('step');
                })

                $('#nextStep3').click(function(){
                    $("#step1").addClass("d-none");
                    $("#step2").addClass("d-none")
                    $("#step3").addClass("d-block").removeClass('d-none');
                    $('.progress').css("width", (stepNumber + 1) * 20 + "%");
                    $('#step'+(stepNumber+2)+'-circle').addClass('progress_bar').removeClass('step');
                })

                $('#nextStep4').click(function(){
                    $("#step1").addClass("d-none");
                    $("#step2").addClass("d-none")
                    $("#step3").addClass("d-none")
                    $("#step4").addClass("d-block").removeClass('d-none');
                    $('.progress').css("width", (stepNumber + 2) * 20 + "%");
                    $('#step'+(stepNumber+3)+'-circle').addClass('progress_bar').removeClass('step');
                     $("#rTitle").html( $('#title').val());
                     $("#rType").html( $('#type').val());
                     $("#rPrice").html( $('#price').val());
                     $("#rPayment").html( $('#payment').val());
                     $("#rBedroom").html( $('#bedrooms').val());
                     $("#rBathroom").html( $('#bathrooms').val());
                     $("#rFurnished").html( $('#furnished').val());
                     $("#rFloor").html( $('#floor').val());
                     $("#rToilets").html( $('#toilets').val());

                })

                $('#nextStep5').click(function(){
                    $("#step1").addClass("d-none");
                    $("#step2").addClass("d-none")
                    $("#step3").addClass("d-none")
                    $("#step4").addClass("d-none").removeClass('d-block');
                    $("#step5").addClass("d-block").removeClass('d-none');
                    $('.progress').css("width", (stepNumber + 3) * 20 + "%");
                    $('#step'+(stepNumber+4)+'-circle').addClass('progress_bar').removeClass('step');
                })









                 $('#prevStep1').click(function(){
                    $("#step1").addClass("d-block").removeClass('d-none');
                    $("#step2").addClass("d-none")
                    $("#step3").addClass("d-none");
                    $('.progress').css("width", (0) * 20 + "%");
                    $('#step'+(stepNumber+1)+'-circle').removeClass('progress_bar').addClass('step');
                })

                 $('#prevStep2').click(function(){
                    $("#step1").addClass("d-none");
                    $("#step2").addClass("d-block").removeClass('d-none');
                    $("#step3").addClass("d-none");
                    $('.progress').css("width", (stepNumber) * 20 + "%");
                    $('#step'+(stepNumber+1)+'-circle').addClass('progress_bar').removeClass('step');
                    $('#step'+(stepNumber+2)+'-circle').removeClass('progress_bar').addClass('step');
                })

                 $('#prevStep3').click(function(){
                    $("#step1").addClass("d-none");
                    $("#step2").addClass("d-none");
                    $("#step3").addClass("d-block").removeClass('d-none');
                    $("#step4").addClass("d-none").removeClass('d-block');
                    $('.progress').css("width", (stepNumber+1 ) * 20 + "%");
                    $('#step'+(stepNumber+1)+'-circle').addClass('progress_bar').removeClass('step');
                    $('#step'+(stepNumber+2)+'-circle').addClass('progress_bar').removeClass('step');
                    $('#step'+(stepNumber+3)+'-circle').removeClass('progress_bar').addClass('step');
                })



            })

    </script>
</body>

</html>