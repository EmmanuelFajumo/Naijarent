<?php
session_start();
//require_once("userguard.php");
//require_once "Agent/agentguard.php";
require_once "process_pages/classes/Site.php";
require_once("process_pages/classes/Tenant.php");

$prop = new Site();
$user = new Tenant();
$all_featured_listings = $prop->fetch_featured_properties();

// echo "<pre>";
// print_r($all_featured_listings);
// echo "</pre>";

if(isset($_SESSION['useronline'])){
    $user_deet = $user->fetch_user_detailby_id($_SESSION['useronline']);
}
if(isset($_SESSION['agent_online'])){
    $user_deet = $user->fetch_user_detailby_id($_SESSION['agent_online']);
}

$property_types = $prop->fetch_property_types();

require_once "process_pages/classes/Utilities.php";
$a = new Utilities();
$states =  $a->fetch_all_states();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <meta name="description" content="A Rental Management App" />
	<meta name="author" content="Emmanuel Fajumo" />

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="animate.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap" rel="stylesheet">


    <!-- <style>
        /* h1{
            font-size: 5em;
            font-family: "Voltaire", sans-serif;
            font-weight: bold;
        } */

        .heading{
            font-size: 50px
        }
        
        a{
            text-decoration: none;
        }


        .butt {
            width: 200px;
            height: 50px;
            background: linear-gradient(135deg, #FFD700, #FFA500); 
            border: none; 
            transition: all 0.3s ease; 
            box-shadow: 0 4px 18px rgba(255, 165, 0, 0.4); 
            white-space: nowrap;
        }

        /* ── Hero Slider ── */
        .hero-slider {
            position: relative;
            width: 100%;
            min-height: 800px;
            overflow: hidden;
        }
        .hero-slider .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: bottom center;
            opacity: 0;
            transition: opacity 1.2s ease-in-out;
            z-index: 0;
        }
        .hero-slider .slide.active {
            opacity: 1;
        }
        .hero-slider .overlay {
            position: relative;
            z-index: 2;
            background-color: rgba(0, 0, 0, 0.60) !important;
            min-height: 800px;
            padding: 120px 0px;
        }
        .slider-dots {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 5;
            display: flex;
            gap: 10px;
        }
        .slider-dots .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255,255,255,0.35);
            border: 2px solid rgba(255,255,255,0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .slider-dots .dot.active {
            background: #FFD700;
            border-color: #FFD700;
            box-shadow: 0 0 12px rgba(255,215,0,0.5);
            transform: scale(1.15);
        }
        .slider-arrows {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            z-index: 5;
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
            transform: translateY(-50%);
            pointer-events: none;
        }
        .slider-arrows button {
            pointer-events: auto;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: none;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(8px);
            color: #fff;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .slider-arrows button:hover {
            background: rgba(255,255,255,0.25);
            transform: scale(1.08);
        }
        @media (max-width: 767px) {
            .hero-slider { min-height: 600px; }
            .hero-slider .overlay { min-height: 600px; padding: 80px 0; }
            .slider-arrows button { width: 36px; height: 36px; font-size: 0.9rem; }
        }
        .service-card-simple {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.04);
        border: 1px solid #f0f0f0;
        transition: all 0.4s ease;
        cursor: default;
        }

        .service-card-simple:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.06);
            border-color: #e0e0e0;
        }

        .service-card-simple .icon-wrapper i {
            transition: all 0.4s ease;
        }

        .service-card-simple:hover .icon-wrapper i {
            transform: scale(1.1) rotate(-5deg);
            color: #0056b3;
        }

        .service-card-simple .step-label {
            font-weight: 600;
            letter-spacing: 2px;
        }

        .service-card-simple h3 {
            color: #1a2332;
        }

        .service-card-simple .text-muted {
            color: #6c757d !important;
        }


        /* ================================
            CITY CARD BASE STYLES
            ================================ */
        .city-card {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            cursor: pointer;
            display: block;
            text-decoration: none;
        }

        /* The actual image */
        .city-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.4s ease;
        }

        /* Zoom image on hover */
        .city-card:hover img {
            transform: scale(1.05);
        }

        /* Dark gradient overlay at bottom */
        .city-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60%;
            background: linear-gradient(to top,
                    rgba(0, 0, 0, 0.75) 0%,
                    rgba(0, 0, 0, 0) 100%);
            border-radius: 0 0 16px 16px;
            pointer-events: none;
        }

        /* Text overlay at bottom of card */
        .city-card .card-text {
            position: absolute;
            bottom: 20px;
            left: 20px;
            z-index: 2;
            color: white;
        }

        .city-card .card-text .tagline {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.78em;
            opacity: 0.85;
            margin-bottom: 4px;
            font-weight: 400;
        }

        .city-card .card-text .tagline i {
            font-size: 0.9em;
        }

        .city-card .card-text h3 {
            font-family: "Voltaire", sans-serif;
            font-size: 1.8em;
            font-weight: 700;
            margin: 0;
            line-height: 1;
        }

        /* Listing count pill (optional) */
        .city-card .listings-pill {
            position: absolute;
            top: 14px;
            right: 14px;
            z-index: 2;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            color: white;
            font-size: 0.75em;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 500;
            border: 1px solid rgba(255, 255, 255, 0.25);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .city-card:hover .listings-pill {
            opacity: 1;
        }

        /* ================================
           THE GRID LAYOUT
        ================================ */
        .cities-grid {
            display: grid;
            gap: 14px;

            /* 
               4 columns 
               Col 1: Lagos (tall, spans 2 rows)
               Col 2+3: Abuja top, PHC+Enugu bottom (2 sub-cols)
               Col 4: Ibadan (tall, spans 2 rows)
            */
            grid-template-columns: 1.2fr 1fr 1fr 1.2fr;
            grid-template-rows: 280px 240px 300px;
        }

        /* Lagos — tall left card, spans 2 rows */
        .city-lagos {
            grid-column: 1;
            grid-row: 1 / 3;
        }

        /* Abuja — top middle, spans 2 cols */
        .city-abuja {
            grid-column: 2 / 4;
            grid-row: 1;
        }

        /* Port Harcourt — bottom middle left */
        .city-portharcourt {
            grid-column: 2;
            grid-row: 2;
        }

        /* Enugu — bottom middle right */
        .city-enugu {
            grid-column: 3;
            grid-row: 2;
        }

        /* Ibadan — tall right card, spans 2 rows */
        .city-ibadan {
            grid-column: 4;
            grid-row: 1 / 3;
        }

        /* Kaduna — full width bottom row */
        .city-kaduna {
            grid-column: 1 / -1;
            grid-row: 3;
        }

        .city-kaduna .card-text h3 {
            font-size: 2.2em;
        }

        /* ================================
           RESPONSIVE BREAKPOINTS
        ================================ */

        /* Tablet — 2 columns */
        @media (max-width: 991px) {
            .cities-grid {
                grid-template-columns: 1fr 1fr;
                grid-template-rows: auto;
            }

            .city-lagos {
                grid-column: 1;
                grid-row: auto;
                height: 260px;
            }

            .city-abuja {
                grid-column: 2;
                grid-row: auto;
                height: 260px;
            }

            .city-portharcourt {
                grid-column: 1;
                grid-row: auto;
                height: 220px;
            }

            .city-enugu {
                grid-column: 2;
                grid-row: auto;
                height: 220px;
            }

            .city-ibadan {
                grid-column: 1;
                grid-row: auto;
                height: 220px;
            }

            .city-kaduna {
                grid-column: 1 / -1;
                grid-row: auto;
                height: 220px;
            }
        }

        /* Mobile — 1 column */
        @media (max-width: 575px) {
            .cities-grid {
                grid-template-columns: 1fr;
                grid-template-rows: auto;
            }

            .city-lagos,
            .city-abuja,
            .city-portharcourt,
            .city-enugu,
            .city-ibadan,
            .city-kaduna {
                grid-column: 1;
                grid-row: auto;
                height: 220px;
            }

            .city-card .card-text h3 {
                font-size: 1.5em;
            }
        }

        /* =========================================
           HERO SEARCH WIDGET — Modern Redesign
        ========================================= */

        /* Pill toggle tabs */
        .search-tabs {
            display: inline-flex;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 50px;
            padding: 5px;
            gap: 4px;
            margin-bottom: 0;
        }
        .search-tab-btn {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.8);
            font-family: "Inter", sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.4px;
            padding: 8px 26px;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            outline: none;
        }
        .search-tab-btn.active {
            background: #ffffff;
            color: #14213D;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.18);
        }
        .search-tab-btn:not(.active):hover {
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
        }

        /* Glassmorphism search card */
        .search-glass-card {
            background: rgba(255, 255, 255, 0.11);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 20px;
            padding: 24px 28px;
            margin-top: 0;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.25);
            transition: background 0.3s ease;
        }

        /* Field label inside card */
        .search-field-label {
            display: block;
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.65);
            margin-bottom: 6px;
        }

        /* Inputs & selects inside the search card */
        .search-glass-card .form-control,
        .search-glass-card .form-select {
            background: rgba(255, 255, 255, 0.14);
            border: 1.5px solid rgba(255, 255, 255, 0.22);
            color: #ffffff;
            border-radius: 12px;
            padding: 11px 16px;
            font-size: 0.9rem;
            height: 48px;
            transition: all 0.3s ease;
            box-shadow: none;
        }
        .search-glass-card .form-control::placeholder { color: rgba(255, 255, 255, 0.55); }
        .search-glass-card .form-select option { background: #14213D; color: #ffffff; }
        .search-glass-card .form-control:focus,
        .search-glass-card .form-select:focus {
            background: rgba(255, 255, 255, 0.22);
            border-color: rgba(255, 255, 255, 0.55);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
            color: #ffffff;
            outline: none;
        }

        /* Divider between fields */
        .search-field-divider {
            width: 1px;
            background: rgba(255, 255, 255, 0.2);
            align-self: stretch;
            margin: 0 4px;
        }

        /* Input group icon */
        .search-glass-card .input-icon-wrap {
            position: relative;
        }
        .search-glass-card .input-icon-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.55);
            font-size: 0.85rem;
            pointer-events: none;
            z-index: 2;
        }
        .search-glass-card .input-icon-wrap .form-control {
            padding-left: 36px;
        }

        /* Search CTA button */
        
        
        .btn-hero-search {
            background: linear-gradient(135deg, #FFD700, #FFA500);
            border: none;
            color: #14213D;
            font-family: "Inter", sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
            border-radius: 12px;
            height: 48px;
            width: 100%;
            padding: 0 20px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 18px rgba(255, 165, 0, 0.4);
            white-space: nowrap;
        }
        .btn-hero-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(255, 165, 0, 0.55);
            background: linear-gradient(135deg, #ffe033, #ffb520);
        }
        .btn-hero-search i { margin-right: 6px; }

        /* Stats strip below the card */
        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 36px;
            margin-top: 28px;
            flex-wrap: wrap;
        }
        .hero-stat-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.82rem;
        }
        .hero-stat-item i { color: #FFD700; font-size: 0.9rem; }
        .hero-stat-item strong { color: #ffffff; font-size: 0.9rem; }

        /* Responsive adjustments */
        @media (max-width: 767px) {
            .search-glass-card { padding: 18px 16px; }
            .search-field-divider { display: none; }
            .hero-stats { gap: 18px; }
        }

        .btn-outline-primary {
            color: #1E3888 !important;
            border-color: #1E3888 !important;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            color: #ffffff !important;
            background-color: #1E3888 !important;
        }
    </style> -->


</head>
<body>

    <!-- Navigation -->
    <?php include 'nav.php'; ?>

    <!-- Navigation -->


    <!-- Hero Section with Slider Background -->
    <div class="hero-slider" id="heroSlider">
        <!-- Slide 1 -->
        <div class="slide active" style="background-image: url('media/bg.png');"></div>
        <!-- Slide 2 -->
        <div class="slide" style="background-image: url('media/lagos_city.png');"></div>
        <!-- Slide 3 -->
        <div class="slide" style="background-image: url('media/abuja_city.png');"></div>

        <!-- Overlay + Content -->
        <div class="overlay d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2 d-flex flex-column justify-content-center align-items-center text-light">
                        <p class="text-center fs-4 mt-5">NaijaRent connects you with verified landlords and trusted agents.</p>
                        <h1 class="text-center fw-bold" style="font-size: 5em; font-weight: bold;">Find Your Next Home in Lagos <br >Without the Stress</h1>
                        <p class="text-center fs-4">No fake listings. No hidden charges. No wahala.</p>
                        
                        <!-- Search Widget -->
                        <div style="width: 100%; margin-top: 56px;">

                            <!-- Pill Tab Toggle -->
                            <div class="search-tabs mb-3">
                                <button type="button" class="search-tab-btn active" id="forRent"
                                    onclick="switchTab('rent', this)">
                                    <i class="fa-solid fa-key me-1"></i> For Rent
                                </button>
                                <button type="button" class="search-tab-btn" id="forSale"
                                    onclick="switchTab('sale', this)">
                                    <i class="fa-solid fa-house me-1"></i> For Sale
                                </button>
                            </div>

                            <!-- Glassmorphism Search Card -->
                            <div class="search-glass-card">

                                <!-- Rent Search -->
                                <div id="rentSearch">
                                    <form action="process_pages/process_search.php" method="GET">
                                        <input type="hidden" name="type" value="rent">
                                        <div class="row g-3 align-items-end">
                                            <div class="col-12 col-md-4">
                                                <span class="search-field-label">
                                                    <i class="fa-solid fa-location-dot me-1"></i>Location
                                                </span>
                                                <div class="input-icon-wrap">
                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                    <input type="text" name="address" class="form-control" placeholder="Enter a city, LGA or area...">
                                                </div>
                                            </div>
                                             <div class="col-12 col-md-3">
                                               
                                                <span class="search-field-label">
                                                    <i class="fa-solid fa-building me-1"></i>Property Type
                                                </span>
                                                <select name="property_type" class="form-select" name="property_type">
                                                    <option value="">Any type</option>
                                                      <?php 
                                                                    foreach($property_types as $type){
                                                                ?>
                                                                <option value="<?php echo $type['property_typeid']; ?>"> <?php echo $type['name']; ?></option>
                                                                <?php
                                                                    }
                                                                ?>
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                 <span class="search-field-label">
                                                    <i class="fa-solid fa-naira-sign me-1"></i>State
                                                </span>
                                                <select name="state" class="form-select" name="property_">
                                                    <option value="">Any state</option>
                                                      <?php 
                                                                    foreach($states as $state){
                                                                ?>
                                                                <option value="<?php echo $state['state_id']; ?>"> <?php echo $state['state']; ?></option>
                                                                <?php
                                                                    }
                                                                ?>
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <span class="search-field-label" style="opacity:0;user-select:none;">Search</span>
                                                <button type="submit" name="search" value="search" class="btn-hero-search">
                                                    <i class="fa-solid fa-magnifying-glass"></i> Search
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Sale Search -->
                                <div id="saleSearch" style="display:none;">
                                    <form action="" method="GET">
                                        <input type="hidden" name="type" value="sale">
                                        <div class="row g-3 align-items-end">
                                            <div class="col-12 col-md-4">
                                                <span class="search-field-label">
                                                    <i class="fa-solid fa-location-dot me-1"></i>Location
                                                </span>
                                                <div class="input-icon-wrap">
                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                    <input type="text" name="location" class="form-control" placeholder="Enter a city, LGA or area...">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <span class="search-field-label">
                                                    <i class="fa-solid fa-building me-1"></i>Property Type
                                                </span>
                                                <select name="property_type" class="form-select">
                                                    <option value="">Any type</option>
                                                    <option value="bungalow">Bungalow</option>
                                                    <option value="duplex">Duplex</option>
                                                    <option value="flat">Flat</option>
                                                    <option value="mini_flat">Mini Flat</option>
                                                    <option value="room_parlour">Room & Parlour</option>
                                                    <option value="self_con">Self-contained</option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <span class="search-field-label">
                                                    <i class="fa-solid fa-naira-sign me-1"></i>Price Range
                                                </span>
                                                <select name="price_range" class="form-select">
                                                    <option value="">Any price</option>
                                                    <option value="5M-20M">&#8358;5M &ndash; &#8358;20M</option>
                                                    <option value="20M-50M">&#8358;20M &ndash; &#8358;50M</option>
                                                    <option value="50M+">Above &#8358;50M</option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <span class="search-field-label" style="opacity:0;user-select:none;">Search</span>
                                                <button type="submit" class="btn-hero-search">
                                                    <i class="fa-solid fa-magnifying-glass"></i> Search
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div><!-- /.search-glass-card -->

                            <!-- Trust Stats Strip -->
                            <div class="hero-stats">
                                <div class="hero-stat-item">
                                    <i class="fa-solid fa-shield-halved"></i>
                                    <span><strong>1,340+</strong> Verified Agents</span>
                                </div>
                                <div class="hero-stat-item">
                                    <i class="fa-solid fa-house-circle-check"></i>
                                    <span><strong>8,000+</strong> Active Listings</span>
                                </div>
                                <div class="hero-stat-item">
                                    <i class="fa-solid fa-star"></i>
                                    <span><strong>4.8</strong> Avg. Rating</span>
                                </div>
                            </div>

                        </div><!-- /.search widget wrapper -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Slider Navigation Arrows -->
        <div class="slider-arrows">
            <button onclick="prevSlide()" aria-label="Previous slide">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button onclick="nextSlide()" aria-label="Next slide">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>

        <!-- Slider Dots -->
        <div class="slider-dots">
            <span class="dot active" onclick="goToSlide(0)"></span>
            <span class="dot" onclick="goToSlide(1)"></span>
            <span class="dot" onclick="goToSlide(2)"></span>
        </div>
    </div>
    <!-- Hero section end -->

    <!-- Featured properties -->
    <div class="container section" >

            <div class="row">
                <div class="col-md-6">
                    <p style="color: #1E3888; font-size: 0.82em;">FEATURED PROPERTIES</p>
                    <h2 class="text-left mb-4 heading" style="font-family: 'Voltaire', sans-serif; font-size: 2.2em; color: #1E3888;">Browse Properties</h2>
                    <hr class="mb-4 bg-primary" style="width: 100px; height: 3px;">
                    <p>Discover the perfect property across Nigeria's most desirable locations</p> 
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                    <a href="all_properties.php" class="btn btn-primary butt btn-lg rounded-pill" >View All Properties</a>
                </div>
            </div>


        <div class="row g-3 mb-5" style="padding-top:50px; padding-bottom:50px">

                    <!-- Property Card 1 -->
                     <?php 
                        foreach($all_featured_listings as $listing){

                        
                     ?>
                    <div class="col-md-4">
                        <div class="card box border-0 shadow-sm h-100">
                            <div style="position: relative;">
                                <img src="uploads/property_pictures/<?php echo $listing['image1'] ?>" class="card-img-top"
                                    style="height: 180px; object-fit: cover;" alt="Property">
                                <span class="badge text-bg-success position-absolute"
                                    style="top: 10px; left: 10px; font-size: 0.75em;">
                                    <i class="fa-solid fa-circle-check me-1"></i> Verified
                                </span>
                                <span class="badge text-bg-primary position-absolute"
                                    style="top: 10px; right: 10px; font-size: 0.75em;">For Rent</span>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title fw-semibold mb-1"><?php echo $listing['title'] ?></h6>
                                <p class="text-muted mb-1" style="font-size: 0.85em;">
                                    <i class="fa-solid fa-location-dot me-1 text-danger"></i>
                                    <?php echo $listing['address'] ?>
                                </p>
                                <p class="fw-bold text-primary mb-2"><?php echo $listing['price'] ?><span
                                        class="text-muted fw-normal" style="font-size: 0.8em;">/ yr</span></p>
                                <div class="d-flex gap-3 text-muted mb-3" style="font-size: 0.82em;">
                                    <span><i class="fa-solid fa-bed me-1"></i> <?php echo $listing['bedrooms'] ?> Beds</span>
                                    <span><i class="fa-solid fa-bath me-1"></i> <?php echo $listing['bathrooms'] ?> Baths</span>
                                    <span><i class="fa-solid fa-couch me-1"></i><?php echo $listing['furnished_status'] ?></span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="property_details.php?id=<?php echo $listing['property_id'] ?>" class="btn btn-outline-primary btn-sm flex-grow-1">View Details</a>
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php } ?>
        </div>

        <div class="row" >
                <div class="col-md-5 col-sm-12">
                    <p>Latest Listed Properties</p>
                    <h2 class="text-left mb-4 heading" style="font-family: 'Voltaire', sans-serif; font-size: 2.2em; color: #1E3888;">Explore By <br><span>Property Type</span></h2>
                    <hr class="mb-4 bg-primary" style="width: 100px; height: 3px;">
                </div>
                <div class="col-md-7 d-flex col-sm-12 align-items-center">
                    <div class="d-flex justify-content-center align-items-center m-auto" style="width: 100%; gap: 50px; flex-wrap: wrap;">
                        <div class="box   card rounded rounded-circle text-center  d-flex flex-column justify-content-center align-items-center" style="height: 130px; width: 130px;">
                            
                                <img src="media/duplex.png" class="icon m-2" alt="">    
                                <p>Duplex</p> 
                            
                        </div>
                        <div class=" box p-2 card rounded rounded-circle text-center  d-flex flex-column justify-content-center align-items-center" style="height: 130px; width: 130px;">
                            
                                <img src="media/home.png" class="icon m-2" alt="">     
                            <p>Bungalow</p>
                            
                        </div>
                        <div class=" box p-2 card rounded rounded-circle text-center  d-flex flex-column justify-content-center align-items-center" style="height: 130px; width: 130px;">
                            
                                <img src="media/residential.png" class="icon m-2" alt="">     
                                <p>Mini Flat</p>
                           
                        </div>
                        <div class=" box p-2 card rounded rounded-circle  text-center  d-flex flex-column justify-content-center align-items-center" style="height: 130px; width: 130px;">
                            
                                <img src="media/corridor.png" class="icon m-2" alt="">     
                                <p>Room & <br>Parlour</p>
                           
                        </div>
                    </div>
                </div>
        </div>      
    </div>

    <section style=''>
        <div class="container">
             <!--  Popular cities -->
        <div class="row">
             <!-- Section Header -->
            <div class="text-center mb-4">
                <span class="badge rounded-pill px-4 py-2 mb-2"
                    style="background-color: #e8f0fe; color: #1E3888; font-size: 0.82em;">
                    EXPLORE BY CITY
                </span>
                <h2 style="font-family: 'Voltaire', sans-serif; font-size: 2.2em; color: #1E3888;">
                    Find Homes Across Nigeria
                </h2>
                <p class="text-muted mx-auto" style="max-width: 480px; font-size: 0.95em;">
                    Verified listings in the cities that matter most to you.
                    Click a city to browse available properties.
                </p>
            </div>
    
            <!-- Cities Grid -->
            <div class="cities-grid">

                <!-- Lagos -->
                <a href="process_pages/process_search.php?search&state=25" class="city-card city-lagos">
                    <img src="media/lagos_city.png" alt="Lagos skyline">
                    <div class="listings-pill">240+ listings</div>
                    <div class="card-text">
                        <div class="tagline">
                            <i class="fa-solid fa-location-dot"></i>
                            Nigeria's commercial hub
                        </div>
                        <h3>Lagos</h3>
                    </div>
                </a>

                <!-- Abuja -->
                <a href="process_pages/process_search.php?search&state=15" class="city-card city-abuja">
                    <img src="media/abuja_city.png" alt="Abuja">
                    <div class="listings-pill">185+ listings</div>
                    <div class="card-text">
                        <div class="tagline">
                            <i class="fa-solid fa-location-dot"></i>
                            The Federal Capital
                        </div>
                        <h3>Abuja</h3>
                    </div>
                </a>

                <!-- Port Harcourt -->
                <a href="process_pages/process_search.php?search&state=33" class="city-card city-portharcourt">
                    <img src="media/port_harcourt_city.png" alt="Port Harcourt">
                    <div class="listings-pill">98+ listings</div>
                    <div class="card-text">
                        <div class="tagline">
                            <i class="fa-solid fa-location-dot"></i>
                            Garden City of Nigeria
                        </div>
                        <h3>Port Harcourt</h3>
                    </div>
                </a>

                <!-- Enugu -->
                <a href="process_pages/process_search.php?search&state=14" class="city-card city-enugu">
                    <img src="media/enugu_city.png" alt="Enugu">
                    <div class="listings-pill">64+ listings</div>
                    <div class="card-text">
                        <div class="tagline">
                            <i class="fa-solid fa-location-dot"></i>
                            Coal City State
                        </div>
                        <h3>Enugu</h3>
                    </div>
                </a>

                <!-- Ibadan -->
                <a href="process_pages/process_search.php?search&state=31" class="city-card city-ibadan">
                    <img src="media/ibadan_city.png" alt="Ibadan">
                    <div class="listings-pill">112+ listings</div>
                    <div class="card-text">
                        <div class="tagline">
                            <i class="fa-solid fa-location-dot"></i>
                            The ancient city
                        </div>
                        <h3>Ibadan</h3>
                    </div>
                </a>

                <!-- Kaduna -->
                <a href="process_pages/process_search.php?search&state=19" class="city-card city-kaduna">
                    <img src="media/kaduna_city.png" alt="Kaduna">
                    <div class="listings-pill">76+ listings</div>
                    <div class="card-text">
                        <div class="tagline">
                            <i class="fa-solid fa-location-dot"></i>
                            Centre of Learning
                        </div>
                        <h3>Kaduna</h3>
                    </div>
                </a>

            </div>

        </div>
        </div>
    </section>


    <?php 
         if(!isset($_SESSION['agent_online']) && (!isset($_SESSION['useronline'])) ){
           ?>
    <div class="container section">
        <div class="row ">
                <div class="col-md-12 py-5 text-center">
                    <p>FIND YOUR HOME IN 3 STEPS</p> 
                    <h2 class="text-left mb-4 heading" style="font-family: 'Voltaire', sans-serif; font-size: 2.2em; color: #1E3888;">Finding a Home Has <span >Never Been This Easy</span></h2> 
                    <a href="register.html" class="btn btn-outline-primary rounded ">SignUp Now</a>
                </div>
               
                <div class="col-md-4">
                    <div class="service-card-simple p-5 text-center h-100">
                        <div class="step-label text-primary fw-semibold mb-3" style="font-size: 0.8rem; letter-spacing: 2px; text-transform: uppercase;">
                            Step 01
                        </div>
                        <div class="icon-wrapper mb-4">
                            <i class="fas fa-handshake fa-3x text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-3" style="font-size: 1.6rem; line-height: 1.2;">Search</h3>
                        <p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.7;">
                            Register as an agent, submit your verification documents, and get your verified badge.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="service-card-simple p-5 text-center h-100">
                        <div class="step-label text-primary fw-semibold mb-3" style="font-size: 0.8rem; letter-spacing: 2px; text-transform: uppercase;">
                            Step 02
                        </div>
                        <div class="icon-wrapper mb-4">
                            <i class="fas fa-handshake fa-3x text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-3" style="font-size: 1.6rem; line-height: 1.2;">Inspect</h3>
                        <p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.7;">
                            View detailed photos, video walkthroughs, and full property features before committing to a visit.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="service-card-simple p-5 text-center h-100">
                        <div class="step-label text-primary fw-semibold mb-3" style="font-size: 0.8rem; letter-spacing: 2px; text-transform: uppercase;">
                            Step 03
                        </div>
                        <div class="icon-wrapper mb-4">
                            <i class="fas fa-handshake fa-3x text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-3" style="font-size: 1.6rem; line-height: 1.2;">Connect</h3>
                        <p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.7;">
                           Chat directly with verified agents, schedule a visit, and make your payment securely on the platform.
                        </p>
                    </div>
                </div>
                
        </div> 


    </div>
    <!-- Why choose us -->
    <div class="container section" style="padding: 80px 0px 100px 0px;">
        <div class="row">
            <!-- Section Header -->
            <div class="col-12 text-center mb-5">
                <span class="badge rounded-pill px-4 py-2 mb-3"
                    style="background-color: #e8f0fe; color: #1E3888; font-size: 0.82em; letter-spacing: 1px;">
                    WHY NAIJARENT
                </span>
                <h2 style="font-family: 'Voltaire', sans-serif; font-size: 2.4em; color: #14213D;">
                    Why Nigerians <span style="color: #1E3888;">Choose Us</span>
                </h2>
                <p class="text-muted mx-auto" style="max-width: 520px; font-size: 0.95em;">
                    Built for the reality of house hunting in Nigeria — transparent, verified, and hassle-free.
                </p>
            </div>
        </div>

        <div class="row g-4 align-items-stretch">
            <!-- Left Column: Highlight Card + Image -->
            <div class="col-lg-4 d-flex flex-column">
                <div class="card border-0 rounded-4 p-4 text-white flex-grow-1 d-flex flex-column justify-content-between"
                    style="background: linear-gradient(135deg, #14213D, #1E3888); min-height: 280px;">
                    <div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center"
                                style="width: 48px; height: 48px; background: rgba(255,255,255,0.12);">
                                <i class="fa-solid fa-star" style="color: #FFD700; font-size: 1.2rem;"></i>
                            </div>
                            <h5 class="mb-0" style="font-family: 'Voltaire', sans-serif; font-size: 1.3rem;">Trusted Platform</h5>
                        </div>
                        <p style="font-size: 0.9rem; line-height: 1.7; opacity: 0.9;">
                            Built for the Reality of House Hunting in Nigeria. View detailed photos, video walkthroughs, and full property features before committing to a visit. Every listing is verified so you never waste time on fake deals.
                        </p>
                    </div>
                    <a href="register.php" class="btn rounded-pill px-5 py-2 mt-3 align-self-start fw-semibold"
                        style="background: #FFD700; color: #14213D; border: none; box-shadow: 0 4px 14px rgba(255,215,0,0.3);">
                        Join Now <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>
                </div>
                <div class="rounded-4 overflow-hidden mt-3" style="height: 180px;">
                    <img src="media/chat.jpeg" alt="Happy tenant" class="w-100 h-100" style="object-fit: cover;">
                </div>
            </div>

            <!-- Middle Column: 3 Features -->
            <div class="col-lg-4 d-flex flex-column gap-3">
                <div class="card border-0 rounded-4 p-4 flex-grow-1"
                    style="background: #fff; box-shadow: 0 2px 12px rgba(0,0,0,0.04); transition: all 0.3s ease;">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 50px; height: 50px; background: rgba(30,56,136,0.08); color: #1E3888; font-size: 1.2rem;">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <h5 style="font-size: 1rem; font-weight: 600; color: #14213D; margin-bottom: 4px;">Verified Listings</h5>
                            <p style="font-size: 0.85rem; color: #6b7280; line-height: 1.6; margin-bottom: 0;">
                                Every property on NaijaRent is manually reviewed by our team. Agents must submit proof of ownership or authorization before any listing goes live.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card border-0 rounded-4 p-4 flex-grow-1"
                    style="background: #fff; box-shadow: 0 2px 12px rgba(0,0,0,0.04); transition: all 0.3s ease;">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 50px; height: 50px; background: rgba(30,56,136,0.08); color: #1E3888; font-size: 1.2rem;">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                        <div>
                            <h5 style="font-size: 1rem; font-weight: 600; color: #14213D; margin-bottom: 4px;">Trusted Agents</h5>
                            <p style="font-size: 0.85rem; color: #6b7280; line-height: 1.6; margin-bottom: 0;">
                                Every agent on our platform is identity-verified with a government-issued ID. Read real reviews from real tenants before you make a decision.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card border-0 rounded-4 p-4 flex-grow-1"
                    style="background: #fff; box-shadow: 0 2px 12px rgba(0,0,0,0.04); transition: all 0.3s ease;">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 50px; height: 50px; background: rgba(30,56,136,0.08); color: #1E3888; font-size: 1.2rem;">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <div>
                            <h5 style="font-size: 1rem; font-weight: 600; color: #14213D; margin-bottom: 4px;">Secure Payments</h5>
                            <p style="font-size: 0.85rem; color: #6b7280; line-height: 1.6; margin-bottom: 0;">
                                Pay your rent deposit or rent directly on NaijaRent via Paystack. Your payment is recorded, tracked, and receipts are always available for download.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: 2 Features -->
            <div class="col-lg-4 d-flex flex-column gap-3">
                <div class="card border-0 rounded-4 p-4 flex-grow-1"
                    style="background: #fff; box-shadow: 0 2px 12px rgba(0,0,0,0.04); transition: all 0.3s ease;">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 50px; height: 50px; background: rgba(30,56,136,0.08); color: #1E3888; font-size: 1.2rem;">
                            <i class="fa-solid fa-comments"></i>
                        </div>
                        <div>
                            <h5 style="font-size: 1rem; font-weight: 600; color: #14213D; margin-bottom: 4px;">Direct Communication</h5>
                            <p style="font-size: 0.85rem; color: #6b7280; line-height: 1.6; margin-bottom: 0;">
                                No more lost WhatsApp messages or missed calls. Chat directly with agents on the platform, tied to the specific property you are interested in.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card border-0 rounded-4 p-4 flex-grow-1"
                    style="background: linear-gradient(135deg, #721817, #a82020); box-shadow: 0 4px 16px rgba(114,24,23,0.2);">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 50px; height: 50px; background: rgba(255,255,255,0.15); color: #fff; font-size: 1.2rem;">
                            <i class="fa-solid fa-video"></i>
                        </div>
                        <div>
                            <h5 style="font-size: 1rem; font-weight: 600; color: #fff; margin-bottom: 4px;">Virtual Inspection</h5>
                            <p style="font-size: 0.85rem; color: rgba(255,255,255,0.85); line-height: 1.6; margin-bottom: 0;">
                                Tour properties from the comfort of your phone. Browse multiple room photos and video walkthroughs before scheduling a physical visit.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Why choose us -->
    <?php 
         }
    ?>

    <!-- Trending News & Real Estate Blog -->
    <div class="container section">

            <div class="row">
                <div class="col-md-6">
                    <h2 class="text-left mb-4">Trending Real Estate News</h2>
                    <hr class="mb-4 bg-primary" style="width: 100px; height: 3px;">
                    <p>Insights, market updates, and expert tips for buyers, renters, and property owners.</p>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                    <a class="rounded-pill btn btn-outline-primary mb-4 px-5 py-2" href="#">View All Articles</a>
                </div>
            </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card box h-100 shadow-sm border-0">
                    <img src="media/realestate_news_1.png" class="card-img-top" alt="Market Trends">
                    <div class="card-body">
                        <h5 class="card-title">Nigeria Property Market Trends 2026</h5>
                        <p class="card-text">Explore the latest city-by-city rental demand and pricing shifts in Nigeria's top real estate markets.</p>
                        <a href="#" class="text-primary">Read More <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card box h-100 shadow-sm border-0">
                    <img src="media/realestate_news_2.png" class="card-img-top" alt="Investment Tips">
                    <div class="card-body">
                        <h5 class="card-title">5 Smart Ways to Invest in Rental Properties</h5>
                        <p class="card-text">From location selection to financing options, get practical advice for building long-term rental income.</p>
                        <a href="#" class="text-primary">Read More <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-1">
            <div class="col-md-4">
                <div class="card box h-100 shadow-sm border-0">
                    <div class="card-body">
                        <span class="badge bg-success mb-3">Blog</span>
                        <h5 class="card-title">How to Spot Verified Listings</h5>
                        <p class="card-text">Learn the red flags of fake property ads and the verification steps that keep you safe on NaijaRent.</p>
                        <a href="#" class="text-primary">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card box h-100 shadow-sm border-0">
                    <div class="card-body">
                        <span class="badge bg-success mb-3">Advice</span>
                        <h5 class="card-title">Preparing Your Home for Rent</h5>
                        <p class="card-text">A quick landlord guide to improving property appeal and attracting higher-quality tenants fast.</p>
                        <a href="#" class="text-primary">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card box h-100 shadow-sm border-0">
                    <div class="card-body">
                        <span class="badge bg-success mb-3">Insights</span>
                        <h5 class="card-title">Top Cities for First-Time Renters</h5>
                        <p class="card-text">Compare cost, amenities, and community feel for the best cities to rent your first home in Nigeria.</p>
                        <a href="#" class="text-primary">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Trending News & Real Estate Blog -->
  


          <!-- Footer  -->
        <?php include 'footer.php'; ?>
    <!-- Footer  -->





    <script src="jquery.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://trtc.io/knocket-sdk/sdk.js?identifier=bf15a4aeb4024f52ec&v=1783467189436" async></script>
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
                            },
                            error: function(er){
                            console.log(er);
                            },
                            precessData: false,
                            contentType: false,
                            cache: false
                        })


                })

            $('#saleSearch').hide();

            $('#forRent').click(function(){
                 $('#saleSearch').hide()
                 $('#rentSearch').show()
            })
            $('#forSale').click(function(){
                 $('#saleSearch').show()
                 $('#rentSearch').hide()
            })


        });

        // ============================================
        // HERO SLIDER
        // ============================================
        let currentSlide = 0;
        const slides = document.querySelectorAll('.hero-slider .slide');
        const dots = document.querySelectorAll('.slider-dots .dot');
        const totalSlides = slides.length;
        let slideInterval;

        function showSlide(index) {
            slides.forEach((s, i) => {
                s.classList.toggle('active', i === index);
            });
            dots.forEach((d, i) => {
                d.classList.toggle('active', i === index);
            });
            currentSlide = index;
        }

        function nextSlide() {
            const next = (currentSlide + 1) % totalSlides;
            showSlide(next);
            resetAutoPlay();
        }

        function prevSlide() {
            const prev = (currentSlide - 1 + totalSlides) % totalSlides;
            showSlide(prev);
            resetAutoPlay();
        }

        function goToSlide(index) {
            showSlide(index);
            resetAutoPlay();
        }

        function startAutoPlay() {
            slideInterval = setInterval(nextSlide, 5000);
        }

        function resetAutoPlay() {
            clearInterval(slideInterval);
            startAutoPlay();
        }

        // Initialize: show first slide and start auto-play
        if (slides.length > 0) {
            showSlide(0);
            startAutoPlay();
        }

        // Pause auto-play when hovering over the slider
        const heroSlider = document.getElementById('heroSlider');
        if (heroSlider) {
            heroSlider.addEventListener('mouseenter', () => clearInterval(slideInterval));
            heroSlider.addEventListener('mouseleave', startAutoPlay);
        }
    </script>
</body>
</html>