<?php
session_start();
require_once "process_pages/classes/Site.php";
require_once "process_pages/classes/Tenant.php";
require_once "process_pages/classes/Utilities.php";



$prop = new Site();
$user = new Tenant();
$a = new Utilities();

if(isset($_SESSION['useronline'])){
    $user_deet = $user->fetch_user_detailby_id($_SESSION['useronline']);
}
if(isset($_SESSION['agent_online'])){
    $user_deet = $user->fetch_user_detailby_id($_SESSION['agent_online']);
}

    // Fetch all agents
    $all_agents = $a->get_all_agents();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Agents - NaijaRent</title>
    <meta name="description" content="Discover and browse verified real estate agents in Lagos on NaijaRent" />
    <meta name="author" content="Emmanuel Fajumo" />

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="animate.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap" rel="stylesheet">

    <style>
        /* Headings Font Override */
        h1, h2, h3, h4, h5, h6 {
            font-family: "Voltaire", sans-serif;
        }
        
        body {
            font-family: "Inter", sans-serif;
            background-color: #f8f9fa;
        }

        /* Page Header Custom Styling */
        .agent-header-section {
            background: linear-gradient(135deg, #14213D, #1E3888);
            padding: 70px 0;
            color: #ffffff;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
        }

        /* Responsive Filter Bar styling */
        .filter-bar {
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #eef2f7;
            margin-top: -40px;
            position: relative;
            z-index: 20;
            padding: 24px;
        }

        /* Premium Agent Card design */
        .agent-card {
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            border: 1px solid #f0f0f0;
            background-color: #ffffff;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        /* Gold "Top Rated" Ribbon style */
        .top-rated-ribbon {
            position: absolute;
            top: 18px;
            right: -32px;
            background: linear-gradient(135deg, #FFD700, #FFA500);
            color: #1a1a1a;
            font-weight: 800;
            font-size: 0.65rem;
            padding: 5px 32px;
            transform: rotate(45deg);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            z-index: 10;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        /* Agent Profile Image wrapper */
        .agent-img-wrapper {
            width: 105px;
            height: 105px;
            margin: 10px auto 18px auto;
            position: relative;
        }

        .agent-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #f0f2f5;
            transition: border-color 0.3s ease;
        }

        .agent-card:hover .agent-img {
            border-color: #1E3888;
        }

        /* Rating Stars Color */
        .star-rating i {
            color: #FFD700;
        }

        /* Consistent Platform Brand Colors */
        .text-primary-deep {
            color: #1E3888;
        }

        .btn-primary {
            background-color: #1E3888 !important;
            border-color: #1E3888 !important;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #14213D !important;
            border-color: #14213D !important;
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

        /* Empty State */
        .empty-state-icon {
            font-size: 4.5rem;
            color: #cbd5e1;
        }

        /* Card Specialization Meta block */
        .spec-meta-block {
            border-top: 1px solid #f1f3f5;
            border-bottom: 1px solid #f1f3f5;
            padding: 12px 0;
            margin: 12px 0;
            text-align: left;
        }

        /* Ellipsis truncation for Bio */
        .agent-bio-trunc {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.5;
            min-height: 45px;
        }

        /* Form elements rounded-pill */
        .form-select, .form-control {
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.9rem;
            border: 1px solid #ced4da;
        }

        .form-select:focus, .form-control:focus {
            border-color: #1E3888;
            box-shadow: 0 0 0 0.25rem rgba(30, 56, 136, 0.25);
        }

        /* Pagination custom page-item styling */
        .page-item.active .page-link {
            background-color: #1E3888 !important;
            border-color: #1E3888 !important;
        }
        .page-link {
            color: #1E3888;
            border-radius: 6px;
            margin: 0 3px;
        }
        .page-link:hover {
            color: #14213D;
            background-color: #eef2f7;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <?php include 'nav.php'; ?>

    <!-- Page Header Section -->
    <div class="container-fluid agent-header-section text-center animate__animated animate__fadeIn">
        <div class="container">
            <h1 class="display-4 fw-bold">Find a Trusted Agent in Lagos</h1>
            <p class="lead mb-4 opacity-90 mx-auto" style="max-width: 750px;">All agents on NaijaRent are identity-verified. Browse profiles, read real reviews, and connect directly.</p>
            <span class="badge text-bg-light px-4 py-2 rounded-pill fs-6 fw-semibold shadow-sm" id="agent-count-badge">1,340 verified agents</span>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container pb-5 mb-5">
        
        <!-- Search & Filter Bar -->
        <div class="filter-bar animate__animated animate__fadeInUp">
            <form id="filterForm" onsubmit="event.preventDefault(); applyFilters();">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-muted mb-1">Search</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                            <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Search by agent name or agency...">
                        </div>
                    </div>
                    
                    <div class="col-md-3 col-lg-2.5">
                        <label class="form-label small fw-semibold text-muted mb-1">LGA</label>
                        <select id="lgaSelect" class="form-select">
                            <option value="">All LGAs</option>
                            <option value="Lekki">Lekki</option>
                            <option value="Ikeja">Ikeja</option>
                            <option value="Yaba">Yaba</option>
                            <option value="Surulere">Surulere</option>
                            <option value="Ajah">Ajah</option>
                            <option value="Gbagada">Gbagada</option>
                            <option value="Maryland">Maryland</option>
                            <option value="Ikoyi">Ikoyi</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 col-lg-2.5">
                        <label class="form-label small fw-semibold text-muted mb-1">Property Type</label>
                        <select id="typeSelect" class="form-select">
                            <option value="">All Types</option>
                            <option value="Flat">Flat</option>
                            <option value="Duplex">Duplex</option>
                            <option value="Self-contained">Self-contained</option>
                            <option value="Mini Flat">Mini Flat</option>
                            <option value="Bungalow">Bungalow</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 col-lg-2.5">
                        <label class="form-label small fw-semibold text-muted mb-1">Sort By</label>
                        <select id="sortSelect" class="form-select">
                            <option value="listings">Most Listings</option>
                            <option value="rating">Highest Rated</option>
                            <option value="newest">Newest</option>
                        </select>
                    </div>
                    
                    <div class="col-md-12 col-lg-1.5 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 py-2.5 fw-semibold"><i class="fa-solid fa-sliders me-1"></i> Search</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Agent Cards Grid -->
        <div class="row g-4 mt-3" id="agentGrid">
            <!-- Dynamically populated by JS -->
             <?php 
                foreach($all_agents as $agent){
             ?>
             <div class="col-sm-12 col-md-6 col-lg-4 d-flex animate__animated animate__fadeIn">
                        <div class="card box border-0 shadow-sm w-100 agent-card p-4 text-center">
                            <div class="agent-img-wrapper">
                                <img src="media/profile_pictures/<?php echo $agent['profile_picture']; ?>" class="agent-img" alt="">
                            </div>
                            <h4 class="fw-bold mb-1 fs-3" style="color: #14213D;"><?php echo $agent['first_name'].' '.$agent['last_name']; ?></h4>
                            <p class="text-muted small mb-2 fw-semibold"><?php echo $agent['agency']; ?></p>
                            
                            <div class="d-flex justify-content-center align-items-center mb-2">
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 rounded" style="font-size: 0.72rem;">
                                    <i class="fa-solid fa-circle-check me-1"></i><?php echo $agent['verification_status']; ?> Agent
                                </span>
                            </div>

                            <div class="star-rating d-flex justify-content-center align-items-center gap-1 mb-2">
                                <span class="text-muted small ms-1">(5.0 reviews)</span>
                            </div>

                            <div class="spec-meta-block">
                                <div class="small mb-1.5"><span class="fw-semibold text-muted">Active Listings:</span> <span class="badge bg-primary px-2 text-white">5 active</span></div>
                                <div class="small text-truncate"><span class="fw-semibold text-muted">Specialises in:</span> Lekki, Ikeja, Yaba</div>
                            </div>

                            <p class="text-muted small mt-1 text-start flex-grow-1 agent-bio-trunc">
                                <?php echo $agent['agent_bio']; ?>
                            </p>

                            <div class="d-flex gap-2 mt-3 w-100">
                                <a href="#" class="btn btn-outline-primary btn-sm flex-grow-1 py-2 fw-semibold">View Profile</a>
                                <a href="#" class="btn btn-primary btn-sm flex-grow-1 py-2 fw-semibold text-light">Message Agent</a>
                            </div>
                        </div>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
       

        <!-- Empty State (hidden by default) -->
        <div id="emptyState" class="text-center py-5 my-5 d-none animate__animated animate__fadeIn">
            <div class="mb-3">
                <i class="fa-regular fa-face-frown-open empty-state-icon"></i>
            </div>
            <h3 class="fw-bold" style="font-family: 'Voltaire', sans-serif; font-size: 2.2rem;">No Agents Match Your Search</h3>
            <p class="text-muted mb-4 max-width-500 mx-auto">We couldn't find any registered agents matching your filters. Try clearing your search query or selecting a different LGA.</p>
            <button onclick="clearFilters()" class="btn btn-primary px-5 py-2.5 rounded-pill fw-semibold shadow-sm text-light">Clear All Filters</button>
        </div>

        <!-- Pagination Section -->
        <div id="paginationSection" class="mt-5 d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
            <div class="text-muted small" id="paginationInfo">
                <!-- Rendered dynamically -->
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination mb-0" id="paginationLinks">
                    <!-- Rendered dynamically -->
                </ul>
            </nav>
        </div>

    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script src="jquery.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        
    </script>
</body>
</html>
