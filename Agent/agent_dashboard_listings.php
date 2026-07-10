<?php 
    session_start();
    require_once "../process_pages/classes/Agent.php";
    require_once "agentguard.php";
    $agent = new Agent();

    $det = $agent->fetch_agent_details($_SESSION['agent_online']);

    $listings = $agent->fetch_All_listings($_SESSION['agent_online']);
    // foreach($listings as $l){
    //     echo $l['description'];
    // }
    //     echo "<pre>";
    //  print_r($listings);
    // echo "</pre>";            
         ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard - My Listings</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../css/animate.min.css">
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
        }

        .stat-card {
            border-radius: 12px;
            border: none;
            background: #ffffff;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            border-radius: 12px 0 0 12px;
        }
        .stat-card.card-primary::before { background: #0d6efd; }
        .stat-card.card-success::before { background: #198754; }
        .stat-card.card-warning::before { background: #ffc107; }
        .stat-card.card-danger::before { background: #dc3545; }
        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
        .stat-card .stat-icon.bg-primary-soft { background: rgba(13, 110, 253, 0.1); color: #0d6efd; }
        .stat-card .stat-icon.bg-success-soft { background: rgba(25, 135, 84, 0.1); color: #198754; }
        .stat-card .stat-icon.bg-warning-soft { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
        .stat-card .stat-icon.bg-danger-soft { background: rgba(220, 53, 69, 0.1); color: #dc3545; }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .filter-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .filter-tab {
            padding: 8px 18px;
            border-radius: 50px;
            border: 1.5px solid #dee2e6;
            background: #fff;
            color: #6c757d;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.25s ease;
        }
        .filter-tab:hover {
            border-color: var(--navy-light);
            color: var(--navy-dark);
            background: rgba(30, 56, 136, 0.05);
        }
        .filter-tab.active {
            background: linear-gradient(135deg, var(--navy-dark), var(--navy-light));
            color: #fff;
            border-color: transparent;
            box-shadow: 0 4px 12px rgba(20, 33, 61, 0.3);
        }

        .property-card {
            border-radius: 12px;
            border: none;
            background: #fff;
            transition: all 0.3s ease;
            overflow: hidden;
        }
        .property-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12) !important;
        }
        .property-card .card-img-top {
            height: 200px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .property-card:hover .card-img-top {
            transform: scale(1.05);
        }
        .property-card .img-wrapper {
            overflow: hidden;
            position: relative;
        }
        .property-card .status-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.72rem;
            font-weight: 600;
            backdrop-filter: blur(4px);
            z-index: 2;
        }
        .property-card .status-badge.status-live {
            background: rgba(25, 135, 84, 0.9);
            color: #fff;
        }
        .property-card .status-badge.status-pending {
            background: rgba(255, 193, 7, 0.9);
            color: #212529;
        }
        .property-card .status-badge.status-rejected {
            background: rgba(220, 53, 69, 0.9);
            color: #fff;
        }
        .property-card .status-badge.status-suspended {
            background: rgba(108, 117, 125, 0.9);
            color: #fff;
        }

        .btn-gradient {
            background: linear-gradient(135deg, var(--navy-dark), var(--navy-light));
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 24px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(20, 33, 61, 0.25);
        }
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(20, 33, 61, 0.35);
            color: #fff;
        }
        .btn-gradient-outline {
            background: transparent;
            color: var(--navy-dark);
            border: 2px solid var(--navy-dark);
            border-radius: 10px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-gradient-outline:hover {
            background: linear-gradient(135deg, var(--navy-dark), var(--navy-light));
            color: #fff;
            border-color: transparent;
        }

        .search-box {
            border-radius: 12px;
            border: 1.5px solid #e9ecef;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }
        .search-box:focus-within {
            border-color: var(--navy-light);
            box-shadow: 0 0 0 3px rgba(30, 56, 136, 0.1);
        }
        .search-box input {
            border: none;
            background: transparent;
            padding: 6px 0;
        }
        .search-box input:focus {
            outline: none;
            box-shadow: none;
        }

        .form-select-custom {
            border-radius: 10px;
            border: 1.5px solid #e9ecef;
            padding: 10px 16px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .form-select-custom:focus {
            border-color: var(--navy-light);
            box-shadow: 0 0 0 3px rgba(30, 56, 136, 0.1);
        }

        .pagination-custom .page-link {
            border-radius: 8px;
            margin: 0 3px;
            border: 1.5px solid #e9ecef;
            color: var(--navy-dark);
            font-weight: 500;
            padding: 8px 14px;
            transition: all 0.25s ease;
        }
        .pagination-custom .page-link:hover {
            background: rgba(30, 56, 136, 0.05);
            border-color: var(--navy-light);
            color: var(--navy-dark);
        }
        .pagination-custom .page-item.active .page-link {
            background: linear-gradient(135deg, var(--navy-dark), var(--navy-light));
            border-color: transparent;
            color: #fff;
            box-shadow: 0 4px 12px rgba(20, 33, 61, 0.25);
        }
        .pagination-custom .page-item.disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .section-divider {
            height: 2px;
            background: linear-gradient(to right, transparent, rgba(20, 33, 61, 0.15), transparent);
            border: none;
            margin: 20px 0;
            opacity: 1;
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
    </style>

</head>

<body>
    <!-- Navigation -->
    <div class="container-fluid" style="min-height: 100vh; background: #f8f9fc;">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'agent_nav.php'; ?>
            
            <!-- Main Content -->
            <div class="col-md-10 px-4 px-lg-5 pb-5 pt-4">
                <!-- Page Header -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4">
                    <div>
                        <h2 class="mb-1" style="font-size: 1.75rem; color: var(--navy-dark);">My Listings</h2>
                        <p class="text-muted mb-0" style="font-size: 0.95rem;">
                            <i class="fa-solid fa-layer-group me-2 opacity-50"></i>
                            Manage all your property listings in one place
                        </p>
                    </div>
                    <a class="btn btn-gradient mt-3 mt-sm-0" href="agent_dashboard_create_listing.php">
                        <i class="fa-solid fa-plus me-2"></i> Create New Listing
                    </a>
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

                <!-- Stats Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="card stat-card card-primary shadow-sm p-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon bg-primary-soft">
                                    <i class="fa-solid fa-building"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold">20</h5>
                                    <small class="text-muted fw-medium">Total Listings</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card stat-card card-success shadow-sm p-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon bg-success-soft">
                                    <i class="fa-solid fa-circle-check"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold">19</h5>
                                    <small class="text-muted fw-medium">Live</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card stat-card card-warning shadow-sm p-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon bg-warning-soft">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold">1</h5>
                                    <small class="text-muted fw-medium">Pending</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card stat-card card-danger shadow-sm p-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon bg-danger-soft">
                                    <i class="fa-solid fa-eye"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold">1,000</h5>
                                    <small class="text-muted fw-medium">Total Views</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter Controls -->
                <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-4">
                            <label class="form-label fw-medium text-muted small mb-1">Search</label>
                            <div class="search-box d-flex align-items-center">
                                <i class="fa-solid fa-magnifying-glass text-muted me-2"></i>
                                <input type="text" class="form-control" placeholder="Search by title, location...">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label fw-medium text-muted small mb-1">Property Type</label>
                            <select class="form-select form-select-custom">
                                <option selected>All property types</option>
                                <option value="all">All property types</option>
                                <option value="flat">Flat</option>
                                <option value="self-contained">Self-contained</option>
                                <option value="miniflat">Mini flat</option>
                                <option value="duplex">Duplex</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label fw-medium text-muted small mb-1">Location</label>
                            <select class="form-select form-select-custom">
                                <option selected>All locations</option>
                                <option value="all">All locations</option>
                                <option value="abia">Abia</option>
                                <option value="adamawa">Adamawa</option>
                                <option value="akwa-Ibom">Akwa Ibom</option>
                                <option value="anambra">Anambra</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label fw-medium text-muted small mb-1">Sort By</label>
                            <select class="form-select form-select-custom">
                                <option selected>Sort By</option>
                                <option value="lowest">Price: low to high</option>
                                <option value="highest">Price: high to low</option>
                                <option value="reported">Most reported</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Filter Tabs -->
                <div class="filter-tabs mb-4">
                    <button class="filter-tab active" data-filter="all">All <span class="opacity-75">(100)</span></button>
                    <button class="filter-tab" data-filter="live">Live <span class="opacity-75">(70)</span></button>
                    <button class="filter-tab" data-filter="pending">Pending <span class="opacity-75">(20)</span></button>
                    <button class="filter-tab" data-filter="rejected">Rejected <span class="opacity-75">(10)</span></button>
                    <button class="filter-tab" data-filter="suspended">Suspended <span class="opacity-75">(7)</span></button>
                </div>

                <!-- Listings Grid -->
                <div class="row g-4">
                    <?php
                        foreach($listings as $list){
                    ?>
                        <div class="col-xl-4 col-md-6 property">
                            <div class="card property-card shadow-sm h-100">
                                <div class="img-wrapper">
                                    <img src="../uploads/property_pictures/<?php echo $list['image1']; ?>" class="card-img-top" alt="<?php echo $list['title']; ?>">
                                    <span class="status-badge status-live">
                                        <i class="fa-solid fa-circle-check me-1"></i> Active
                                    </span>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title fw-semibold mb-1" style="font-size: 1rem;">
                                        <?php echo $list['title']; ?>
                                    </h6>
                                    <p class="text-muted mb-2" style="font-size: 0.82em;">
                                        <i class="fa-solid fa-location-dot me-1" style="color: #dc3545;"></i>
                                        <?php echo $list['LGA']." ".$list['state']; ?>
                                    </p>
                                    <p class="fw-bold mb-2" style="color: var(--navy-dark); font-size: 1.1rem;">
                                        ₦<?php echo number_format($list['price']); ?> 
                                        <span class="text-muted fw-normal" style="font-size: 0.7em;">/ yr</span>
                                    </p>
                                    <div class="d-flex gap-3 text-muted mb-3" style="font-size: 0.8em;">
                                        <span class="d-flex align-items-center">
                                            <i class="fa-solid fa-bed me-1" style="color: #6c757d;"></i> 
                                            <?php echo $list["bedrooms"]; ?> Beds
                                        </span>
                                        <span class="d-flex align-items-center">
                                            <i class="fa-solid fa-bath me-1" style="color: #6c757d;"></i> 
                                            <?php echo $list["bathrooms"]; ?> Baths
                                        </span>
                                        <span class="d-flex align-items-center">
                                            <i class="fa-solid fa-couch me-1" style="color: #6c757d;"></i> 
                                            <?php echo $list["furnished_status"]; ?>
                                        </span>
                                    </div>
                                    <div class="mt-auto d-flex gap-2">
                                        <a href="agent_dashboard_edit_listing.php?property_id=<?php echo $list['property_id']; ?>" 
                                           class="btn btn-gradient-outline btn-sm flex-grow-1">
                                            <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                        </a>
                                        <a href="#" class="btn btn-outline-secondary btn-sm flex-grow-1">
                                            <i class="fa-solid fa-trash-can me-1"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
                </div>

                <!-- Pagination -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-5 pt-2">
                    <small class="text-muted mb-3 mb-md-0">
                        <i class="fa-solid fa-list me-1 opacity-50"></i>
                        Showing 1 – 5 of 11,200 listings
                    </small>
                    <nav>
                        <ul class="pagination pagination-custom mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#">
                                    <i class="fa-solid fa-chevron-left"></i>
                                </a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Main Content End -->
        </div> 
    </div>

    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script>
        // Filter tabs functionality
        $(document).ready(function() {
            $('.filter-tab').on('click', function() {
                $('.filter-tab').removeClass('active');
                $(this).addClass('active');
            });
        });
    </script>
</body>

</html>