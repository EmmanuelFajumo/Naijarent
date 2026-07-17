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
require_once "process_pages/classes/Article.php";
$article = new Article();
$published_articles = $article->fetch_articles_by_status('Published');
if (is_string($published_articles)) {
    $published_articles = [];
}
$a = new Utilities();
$states =  $a->fetch_all_states();
$all_agents = $a->get_all_agents();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <meta name="description" content="A Rental Management App" />
	<meta name="author" content="Emmanuel Fajumo" />
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="animate.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap" rel="stylesheet">

<style>
   
.agent-carousel-section {
    padding: 60px 0;
}
.agent-carousel-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    gap: 12px;
}
.agent-carousel-track-container {
    overflow: hidden;
    width: 100%;
    border-radius: 16px;
}
.agent-carousel-track {
    display: flex;
    transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    gap: 20px;
    padding: 10px 0;
}
.agent-carousel-card {
    min-width: calc(25% - 15px);
    flex-shrink: 0;
}
.agent-carousel-card-inner {
    background: #ffffff;
    border-radius: 16px;
    padding: 30px 20px 25px;
    text-align: center;
    border: 1px solid #f0f0f0;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.04);
    transition: all 0.4s ease;
    height: 100%;
}
.agent-carousel-card-inner:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
    border-color: #e0e0e0;
}
.agent-carousel-img-wrapper {
    width: 90px;
    height: 90px;
    margin: 0 auto;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid #f0f2f5;
    transition: border-color 0.3s ease;
}
.agent-carousel-card-inner:hover .agent-carousel-img-wrapper {
    border-color: #1E3888;
}
.agent-carousel-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.agent-carousel-bio {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.5;
    min-height: 48px;
}
.agent-carousel-btn {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: 1px solid #e0e0e0;
    background: #ffffff;
    color: #1E3888;
    font-size: 1rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    z-index: 2;
}
.agent-carousel-btn:hover {
    background: #1E3888;
    color: #ffffff;
    border-color: #1E3888;
    box-shadow: 0 4px 14px rgba(30, 56, 136, 0.3);
    transform: scale(1.05);
}
.agent-carousel-dots {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 24px;
}
.agent-carousel-dots .dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #d0d5dd;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0;
}
.agent-carousel-dots .dot.active {
    background: #1E3888;
    width: 28px;
    border-radius: 5px;
}
@media (max-width: 991px) {
    .agent-carousel-card { min-width: calc(33.333% - 14px); }
}
@media (max-width: 767px) {
    .agent-carousel-card { min-width: calc(50% - 10px); }
    .agent-carousel-btn { width: 36px; height: 36px; font-size: 0.85rem; }
}
@media (max-width: 480px) {
    .agent-carousel-card { min-width: calc(100% - 0px); }
}
</style>

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
        </div> 

        <!-- AGENTS CAROUSEL SECTION -->
        <div class="agent-carousel-section">
            <div class="text-center mb-4">
                <span class="badge rounded-pill px-4 py-2 mb-2"
                    style="background-color: #e8f0fe; color: #1E3888; font-size: 0.82em;">
                    MEET OUR AGENTS
                </span>
                <h2 style="font-family: 'Voltaire', sans-serif; font-size: 2.2em; color: #1E3888;">
                    Work With Trusted Professionals
                </h2>
                <p class="text-muted mx-auto" style="max-width: 480px; font-size: 0.95em;">
                    Our verified agents are ready to help you find the perfect home.
                </p>
            </div>

            <div class="agent-carousel-wrapper">
                <button class="agent-carousel-btn agent-carousel-prev" onclick="slideAgents('prev')" aria-label="Previous agents">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>

                <div class="agent-carousel-track-container">
                    <div class="agent-carousel-track" id="agentCarouselTrack">
                        <?php if (!empty($all_agents)): ?>
                            <?php foreach ($all_agents as $agent): ?>
                                <div class="agent-carousel-card">
                                    <div class="agent-carousel-card-inner">
                                        <div class="agent-carousel-img-wrapper">
                                            <img src="media/profile_pictures/<?php echo !empty($agent['profile_picture']) ? htmlspecialchars($agent['profile_picture']) : 'default.png'; ?>"
                                                 alt="<?php echo htmlspecialchars($agent['first_name'] . ' ' . $agent['last_name']); ?>"
                                                 onerror="this.src='media/agent.png'">
                                        </div>
                                        <h5 class="fw-bold mt-3 mb-1" style="color: #14213D;">
                                            <?php echo htmlspecialchars($agent['first_name'] . ' ' . $agent['last_name']); ?>
                                        </h5>
                                        <p class="text-muted small mb-2">
                                            <?php echo !empty($agent['agency']) ? htmlspecialchars($agent['agency']) : 'Independent Agent'; ?>
                                        </p>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1.5 rounded-pill" style="font-size: 0.7rem;">
                                            <i class="fa-solid fa-circle-check me-1"></i><?php echo htmlspecialchars($agent['verification_status'] ?? 'Verified'); ?>
                                        </span>
                                        <p class="text-muted small mt-3 agent-carousel-bio">
                                            <?php echo !empty($agent['agent_bio']) ? htmlspecialchars(substr($agent['agent_bio'], 0, 100)) . (strlen($agent['agent_bio']) > 100 ? '...' : '') : 'Experienced real estate agent dedicated to helping you find your dream home.'; ?>
                                        </p>
                                        <a href="browse_agents.php" class="btn btn-outline-primary btn-sm mt-2 px-4 rounded-pill">
                                            View Profile
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-4 w-100">
                                <p class="text-muted">No agents available at the moment. Check back soon.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <button class="agent-carousel-btn agent-carousel-next" onclick="slideAgents('next')" aria-label="Next agents">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>

            <div class="agent-carousel-dots" id="agentCarouselDots"></div>
        </div>
        <!-- END AGENTS CAROUSEL SECTION -->

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

        <?php if (empty($published_articles)): ?>
            <div class="text-center py-5">
                <p class="text-muted">No articles published yet. Check back soon for insights and updates.</p>
            </div>
        <?php else: ?>
            <!-- First row: first 2 articles with featured images -->
            <div class="row g-4">
                <?php foreach (array_slice($published_articles, 0, 2) as $article_item): 
                    $rawPath = $article_item['featured_image'] ?? '';
                    // Normalize path: if stored path starts with ./.., extract just the filename portion
                    if (!empty($rawPath)) {
                        $imgSrc = 'media/blog_images/' . basename($rawPath);
                    } else {
                        $imgSrc = 'media/home.png';
                    }
                    $imgSrc = htmlspecialchars($imgSrc);
                    $artTitle = htmlspecialchars($article_item['title'] ?? '');
                    $artExcerpt = htmlspecialchars($article_item['excerpt'] ?? '');
                    $artCategory = htmlspecialchars($article_item['category'] ?? 'Uncategorized');
                    $artDate = !empty($article_item['created_at']) ? date('M j, Y', strtotime($article_item['created_at'])) : '';
                ?>
                <div class="col-md-6">
                    <div class="card box h-100 shadow-sm border-0">
                        <img src="<?php echo $imgSrc; ?>" class="card-img-top" alt="<?php echo $artTitle; ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2"><?php echo $artCategory; ?></span>
                            <h5 class="card-title"><?php echo $artTitle; ?></h5>
                            <p class="card-text"><?php echo $artExcerpt; ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted"><i class="fa-regular fa-calendar me-1"></i><?php echo $artDate; ?></small>
                                <a href="single_article.php?id=<?php echo $article_item['id'] ?>" class="text-primary">Read More <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Second row: remaining articles as text cards -->
            <?php $remaining = array_slice($published_articles, 2); ?>
            <?php if (!empty($remaining)): ?>
            <div class="row g-4 mt-1">
                <?php foreach ($remaining as $article_item): 
                    $artTitle = htmlspecialchars($article_item['title'] ?? '');
                    $artExcerpt = htmlspecialchars($article_item['excerpt'] ?? '');
                    $artCategory = htmlspecialchars($article_item['category'] ?? 'Uncategorized');
                ?>
                <div class="col-md-4">
                    <div class="card box h-100 shadow-sm border-0">
                        <div class="card-body">
                            <span class="badge bg-success mb-3"><?php echo $artCategory; ?></span>
                            <h5 class="card-title"><?php echo $artTitle; ?></h5>
                            <p class="card-text"><?php echo $artExcerpt; ?></p>
                            <a href="single_article.php?id=<?php echo $article_item['id'] ?>" class="text-primary">Read More</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        <?php endif; ?>
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

        // AGENT CAROUSEL
        (function() {
            const track = document.getElementById('agentCarouselTrack');
            if (!track) return;

            const cards = track.querySelectorAll('.agent-carousel-card');
            if (cards.length === 0) return;

            let currentAgentIndex = 0;
            let cardsPerView = 4;
            const gap = 20;

            function getCardsPerView() {
                const w = window.innerWidth;
                if (w <= 480) return 1;
                if (w <= 767) return 2;
                if (w <= 991) return 3;
                return 4;
            }

            function getCardWidth() {
                const container = track.parentElement;
                const containerWidth = container.offsetWidth;
                cardsPerView = getCardsPerView();
                const totalGap = gap * (cardsPerView - 1);
                return (containerWidth - totalGap) / cardsPerView;
            }

            function updateTrack() {
                const cardWidth = getCardWidth();
                // Set card widths
                cards.forEach(c => {
                    c.style.minWidth = cardWidth + 'px';
                });
                const offset = currentAgentIndex * (cardWidth + gap);
                track.style.transform = 'translateX(-' + offset + 'px)';
                updateDots();
            }

            function updateDots() {
                const maxIndex = Math.max(0, cards.length - cardsPerView);
                const dotsContainer = document.getElementById('agentCarouselDots');
                if (!dotsContainer) return;
                
                const totalDots = Math.ceil(cards.length / cardsPerView);
                dotsContainer.innerHTML = '';
                
                for (let i = 0; i < totalDots; i++) {
                    const dot = document.createElement('button');
                    dot.className = 'dot' + (i === Math.floor(currentAgentIndex / cardsPerView) ? ' active' : '');
                    dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
                    dot.onclick = function() {
                        currentAgentIndex = i * cardsPerView;
                        if (currentAgentIndex > maxIndex) currentAgentIndex = maxIndex;
                        updateTrack();
                    };
                    dotsContainer.appendChild(dot);
                }
            }

            // Expose slideAgents globally
            window.slideAgents = function(direction) {
                const cardWidth = getCardWidth();
                const maxIndex = Math.max(0, cards.length - cardsPerView);
                
                if (direction === 'prev') {
                    currentAgentIndex = Math.max(0, currentAgentIndex - cardsPerView);
                } else {
                    currentAgentIndex = Math.min(maxIndex, currentAgentIndex + cardsPerView);
                }
                updateTrack();
            };

            // Handle resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    cardsPerView = getCardsPerView();
                    // Reset index if out of bounds
                    const maxIndex = Math.max(0, cards.length - cardsPerView);
                    if (currentAgentIndex > maxIndex) currentAgentIndex = maxIndex;
                    updateTrack();
                }, 200);
            });

            // Initialize
            cardsPerView = getCardsPerView();
            // Wait a tick for layout to settle
            setTimeout(updateTrack, 100);
        })();
    </script>
</body>
</html>