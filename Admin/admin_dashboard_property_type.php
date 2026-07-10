<?php 
    session_start();
    require_once "adminguard.php";
    require_once "classes/Admin.php";
     $pt = new Admin;
    $properties_types = ($pt->fetch_property_types());
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Property Types</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="preconnect" href="../https://fonts.googleapis.com">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="admin.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">

    <style>
        .profile-menu a { text-decoration: none; }
    </style>

</head>

<body>
    <div class="container-fluid" style="min-height: 100vh;">
        <div class="row" style="min-height: 100vh;">
            <!-- Sidebar -->
            <?php include 'admin_nav.php'; ?>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 px-4 px-lg-5 pb-5 pt-3" style="background:#f4f6fb;">

                <!-- Mobile Menu Toggle -->
                <div class="row mb-3">
                    <div class="col-12 d-md-none">
                        <button class="mobile-menu-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                            <i class="fa-solid fa-bars me-2"></i> Menu
                        </button>
                    </div>
                </div>

                <!-- Page Header -->
                <div class="row mt-3 mb-4">
                    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="page-header">
                            <h2 class="mb-1">Property Types</h2>
                            <p class="mb-0">Manage the property types available on the platform</p>
                        </div>
                        <button type="button" class="btn-add" data-bs-toggle="modal" data-bs-target="#addPropertyTypeModal">
                            <i class="fa-solid fa-plus me-2"></i> Add Property Type
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="stat-card primary text-center">
                            <div class="stat-icon mx-auto"><i class="fa-regular fa-folder-open"></i></div>
                            <div class="stat-value"><?php echo count($properties_types); ?></div>
                            <div class="stat-label">Total Types</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card success text-center">
                            <div class="stat-icon mx-auto"><i class="fa-solid fa-circle-check"></i></div>
                            <div class="stat-value">70</div>
                            <div class="stat-label">Active Listings</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card danger text-center">
                            <div class="stat-icon mx-auto"><i class="fa-solid fa-ban"></i></div>
                            <div class="stat-value">100</div>
                            <div class="stat-label">Total Listings</div>
                        </div>
                    </div>
                </div>

                <!-- Property Types Grid -->
                <div class="row g-4">
                    <?php
                        foreach($properties_types as $properties_type){
                    ?>
                        <div class="col-md-4">
                            <div class="type-card">
                                <div class="card-body">
                                    <div class="type-icon">
                                        <i class="fa-solid fa-building"></i>
                                    </div>
                                    <h5 class="type-name"><?php echo $properties_type["name"]; ?></h5>
                                    <p class="type-desc"><?php echo $properties_type["description"]; ?></p>
                                    <div class="type-actions">
                                        <button class="btn-edit">
                                            <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                        </button>
                                        <button data-bs-toggle="modal" data-bs-target="#deletePropertyTypeModal" class="btn-delete">
                                            <i class="fa-solid fa-trash me-1"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
                </div>

            </div>
        </div>
    </div>

    <!-- Add Property Type Modal -->
    <div class="modal fade modal-custom" id="addPropertyTypeModal" tabindex="-1" aria-labelledby="addPropertyTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="addPropertyTypeModalLabel">
                        <i class="fa-solid fa-plus-circle me-2" style="color:#1E3888;"></i> Add Property Type
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <form action="../process_pages/process_property_type.php" method="post">
                       <div class="mb-3">
                           <label for="propertyTypeName" class="form-label fw-medium">Property Type Name</label>
                           <input type="text" class="form-control" id="propertyTypeName" placeholder="e.g. Duplex, Flat, Bungalow" name='propertyTypeName' style="border-radius:10px;border:1px solid #e5e7eb;padding:10px 14px;">
                       </div>
                       <div class="mb-3">
                           <label for="propertyTypeDescription" class="form-label fw-medium">Description</label>
                           <textarea class="form-control" id="propertyTypeDescription" rows="3" placeholder="Enter a brief description of the property type" name='propertyTypeDescription' style="border-radius:10px;border:1px solid #e5e7eb;padding:10px 14px;"></textarea>
                       </div>
                        <div class="d-flex gap-2 justify-content-end pt-2">
                            <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" style="border-radius:10px;">Cancel</button>
                            <button type="submit" class="btn btn-primary px-4" name='btn' style="background:#1E3888;border:none;border-radius:10px;">Save Property Type</button>
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Property Type Modal -->
    <div class="modal fade modal-custom" id="deletePropertyTypeModal" tabindex="-1" aria-labelledby="deletePropertyTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold text-danger">
                        <i class="fa-solid fa-trash me-2"></i> Delete Property Type
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <form action="../process_pages/process_delete_property_type.php" method="post">
                        <p class="mb-3">Are you sure you want to <strong class="text-danger">DELETE</strong> this property type? This action cannot be undone.</p>
                        <input type="number" name="property_typeid" value="<?php echo $properties_type['property_typeid']; ?>" hidden>
                        <div class="d-flex gap-2 justify-content-end pt-2">
                            <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" style="border-radius:10px;">Cancel</button>
                            <button type="submit" class="btn btn-danger px-4" name='deletebtn' style="border-radius:10px;">Yes, Delete</button>
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </div>


    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>