<?php
session_start();
require_once "Process_pages/classes/Site.php";
require_once "Process_pages/classes/Utilities.php";
require_once "Process_pages/classes/Tenant.php";
require_once "process_pages/classes/Agent.php";

$site = new Site();
$util = new Utilities();
$states = $util->fetch_all_states();

$agent = new Agent();
$property_types = $agent->fetch_property_types();

if(isset($_SESSION['useronline'])){
    $user = new Tenant;
    $user_deet = $user->fetch_user_detailby_id($_SESSION['useronline']);
}
if(isset($_SESSION['agent_online'])){
    $user = new Tenant;
    $user_deet = $user->fetch_user_detailby_id($_SESSION['agent_online']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Properties</title>
    <meta name="description" content="Search for rental properties by type, state, and LGA" />
    <meta name="author" content="Emmanuel Fajumo" />

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="animate.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap" rel="stylesheet">

    <style>
        .search-section {
            background: linear-gradient(135deg, #1E3888 0%, #2a4aad 100%);
            padding: 60px 0;
        }
        .search-section h1 {
            color: #fff;
            font-family: "Voltaire", sans-serif;
            font-size: 2.5em;
        }
        .search-section p {
            color: rgba(255,255,255,0.8);
        }
        .search-card {
            background: #fff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            margin-top: -40px;
            position: relative;
            z-index: 10;
        }
        .search-card .form-label {
            font-weight: 600;
            color: #333;
            font-size: 0.9em;
        }
        .search-card .form-select, .search-card .form-control {
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            padding: 10px 14px;
            font-size: 0.95em;
        }
        .search-card .form-select:focus, .search-card .form-control:focus {
            border-color: #1E3888;
            box-shadow: 0 0 0 3px rgba(30,56,136,0.1);
        }
        .btn-search {
            background: #1E3888;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-search:hover {
            background: #152a66;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30,56,136,0.3);
        }
        .result-count {
            font-size: 1.1em;
            color: #666;
            margin-bottom: 20px;
        }
        .result-count strong {
            color: #1E3888;
        }
        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        .no-results i {
            font-size: 4em;
            color: #ddd;
            margin-bottom: 20px;
        }
        .no-results h4 {
            color: #666;
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <?php include 'nav.php'; ?>

    <!-- Search Header -->
    <div class="search-section">
        <div class="container text-center">
            <h1 class="animate__animated animate__fadeInDown">Find Your Perfect Property</h1>
            <p class="animate__animated animate__fadeInUp">Search by property type, state, and local government area</p>
        </div>
    </div>

    <!-- Search Form Card -->
    <div class="container">
        <div class="search-card animate__animated animate__fadeInUp">
            <form action="Process_pages/process_search_properties.php" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="property_type" class="form-label">Property Type</label>
                        <select name="property_type" id="property_type" class="form-select">
                            <option value="">All Property Types</option>
                            <?php foreach($property_types as $pt): ?>
                                <option value="<?php echo $pt['property_typeid']; ?>"><?php echo $pt['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="state" class="form-label">State</label>
                        <select name="state" id="state" class="form-select">
                            <option value="">All States</option>
                            <?php foreach($states as $st): ?>
                                <option value="<?php echo $st['state_id']; ?>"><?php echo $st['state']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="lga" class="form-label">LGA</label>
                        <select name="lga" id="lga" class="form-select">
                            <option value="">All LGAs</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-search w-100">
                            <i class="fa-solid fa-search me-2"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Search Results -->
    <div class="container section">
        <?php if(isset($_GET['results'])): ?>
            <?php 
                $results_json = urldecode($_GET['results']);
                $search_results = json_decode($results_json, true);
                $result_count = count($search_results);
            ?>
            <div class="result-count">
                <strong><?php echo $result_count; ?></strong> property(ies) found
            </div>

            <?php if($result_count > 0): ?>
                <div class="row g-3 mb-5">
                    <?php foreach($search_results as $listing): ?>
                        <div class="col-md-4">
                            <div class="card box border-0 shadow-sm h-100">
                                <div style="position: relative;">
                                    <img src="uploads/property_pictures/<?php echo $listing['image1']; ?>" class="card-img-top"
                                        style="height: 180px; object-fit: cover;" alt="Property">
                                    <span class="badge text-bg-success position-absolute"
                                        style="top: 10px; left: 10px; font-size: 0.75em;">
                                        <i class="fa-solid fa-circle-check me-1"></i> Verified
                                    </span>
                                    <span class="badge text-bg-primary position-absolute"
                                        style="top: 10px; right: 10px; font-size: 0.75em;">For Rent</span>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title fw-semibold mb-1"><?php echo $listing['title']; ?></h6>
                                    <p class="text-muted mb-1" style="font-size: 0.85em;">
                                        <i class="fa-solid fa-location-dot me-1 text-danger"></i>
                                        <?php echo $listing['address']; ?>
                                    </p>
                                    <p class="fw-bold text-primary mb-2">₦<?php echo number_format($listing['price']); ?><span
                                            class="text-muted fw-normal" style="font-size: 0.8em;">/ yr</span></p>
                                    <div class="d-flex gap-3 text-muted mb-3" style="font-size: 0.82em;">
                                        <span><i class="fa-solid fa-bed me-1"></i> <?php echo $listing['bedrooms']; ?> Beds</span>
                                        <span><i class="fa-solid fa-bath me-1"></i> <?php echo $listing['bathrooms']; ?> Baths</span>
                                        <span><i class="fa-solid fa-couch me-1"></i> <?php echo $listing['furnished_status']; ?></span>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="property_details.php?id=<?php echo $listing['property_id']; ?>" class="btn btn-outline-primary btn-sm flex-grow-1">View Details</a>
                                        <button class="btn btn-outline-secondary btn-sm">
                                            <i class="fa-regular fa-bookmark"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-results">
                    <i class="fa-solid fa-house-circle-exclamation"></i>
                    <h4>No properties found</h4>
                    <p>Try adjusting your search criteria to find more results.</p>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fa-solid fa-search fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Search for properties</h4>
                <p class="text-muted">Select your preferred property type, state, and LGA above to find available properties.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script src="jquery.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
            // Load LGAs when state changes
            $('#state').change(function(){
                var state_id = $(this).val();
                if(state_id){
                    $.ajax({
                        url: 'Process_pages/process_state_lga.php',
                        type: 'GET',
                        data: {state_id: state_id},
                        success: function(data){
                            $('#lga').html('<option value="">All LGAs</option>' + data);
                        }
                    });
                } else {
                    $('#lga').html('<option value="">All LGAs</option>');
                }
            });
        });
    </script>
</body>
</html>