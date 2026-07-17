<?php 
    session_start();
    require_once "../process_pages/classes/Agent.php";
    require_once "agentguard.php";
    $agent = new Agent();

    $det = $agent->fetch_agent_details($_SESSION['agent_online']);

    $listings = $agent->fetch_All_listings($_SESSION['agent_online']);

    // Stats for agent dashboard
    $total_listings = $agent->count_total_listings($_SESSION['agent_online']);
    $active_listings = $agent->count_active_listings($_SESSION['agent_online']);
    $pending_listings = $agent->count_pending_listings($_SESSION['agent_online']);
            
         ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard - My Listings</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="listings.css">
    <link rel="stylesheet" href="../css/animate.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">

   

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
                                    <h5 class="mb-0 fw-bold"><?php echo $total_listings; ?></h5>
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
                                    <h5 class="mb-0 fw-bold"><?php echo $active_listings; ?></h5>
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
                                    <h5 class="mb-0 fw-bold"><?php echo $pending_listings; ?></h5>
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
                                    <h5 class="mb-0 fw-bold"><?php echo $active_listings; ?></h5>
                                    <small class="text-muted fw-medium">Active Listings</small>
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
                                        <!-- <a href="#" class="btn btn-outline-secondary btn-sm flex-grow-1">
                                            <i class="fa-solid fa-trash-can me-1"></i> Delete
                                        </a> -->
                                        <input type="number" hidden name='prop_id' class="property" value= "<?php echo $list['property_id']; ?>">
                                        <button type="button" class="btn btn-outline-secondary btn-sm flex-grow-1 delete" data-bs-toggle="modal" data-bs-target="#staticBackdrop" > Delete</button>
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







    <!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        This listing will be deleted from our databse. Are you sure you want to delete it?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <form action="../process_pages/process_delete.php" method="post">
            <input type="number" value="" hidden name="id" id="prop_id">
            <button href="#" class="btn btn-outline-danger" name='delete'>
            <i class="fa-solid fa-trash-can me-1"></i>Yes, Delete
        </button>
        </form>
      </div>
    </div>
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


            $(".delete").click(function(){
                var property_id = $(this).prev(".property").val();
                $("#prop_id").val(property_id);
            })
        });
    </script>
</body>

</html>