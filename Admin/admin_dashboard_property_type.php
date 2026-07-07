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
    <title>Property Type</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="preconnect" href="../https://fonts.googleapis.com">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">

    
    <style>
        .profile-menu a{
            text-decoration: none;
        }
    </style>


</head>

<body>
    <div class="container-fluid " style="min-height: 900px;">
        <div class="row">
            <!-- Sidebar (Profile and Navigation) -->
                <?php include 'admin_nav.php'; ?>
            <!-- Sidebar (Profile and Navigation) -->

            <!-- Main Content -->

            <div class="col-md-9 px-5 pb-5 pt-3">

                <!-- Page Header -->
                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0">Property types</h2>
                            <p class="text-muted mb-0">Manage the property types available on the platform</p>
                        </div>
                        <button type="button" class="btn btn-outline-secondary rounded" data-bs-toggle="modal" data-bs-target="#addPropertyTypeModal">
                             <i class="fa-solid fa-plus me-2"></i> Add Property Type </button>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Stats Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card box p-3 text-center border-0 shadow-sm">
                            <i class="fa-regular fa-folder-open fa-2x text-primary mb-2"></i>
                            <h5 class="mb-0">6</h5>
                            <small class="text-muted">Total Types</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card box p-3 text-center border-0 shadow-sm">
                            <i class="fa-solid fa-circle-check fa-2x text-success mb-2"></i>
                            <h5 class="mb-0">70</h5>
                            <small class="text-muted">Active</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card box p-3 text-center border-0 shadow-sm">
                            <i class="fa-solid fa-ban fa-2x text-danger mb-2"></i>
                            <h5 class="mb-0">100</h5>
                            <small class="text-muted">Total Listings</small>
                        </div>
                    </div>
                    
                </div>


                <!-- Listings Grid -->
                <div class="row ">
                    

                    <!-- Listed Properties_types -->
                    <?php
                        foreach($properties_types as $properties_type){
                    ?>
                        <div class="col-md-4 property <?php //echo $$properties_type['name']; ?> ">
                            <div class="card box border-0 shadow-sm mb-4" style="border-radius: 15px; background-color: #f8f9fa;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-start align-items-center mb-3">
                                        <i class="fa-solid fa-building  text-primary mb-2 p-2 bg-light rounded rounded-circle" ></i>
                                        <h5 class="card-title"> <?php echo $properties_type["name"]; ?></h5>
                                    </div>
                                    <!-- <p class="card-text text-muted"><?php// echo $properties_type["name"]; ?></p> -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="card-text text-muted"><?php echo $properties_type["description"]; ?></p>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-sm btn-outline-primary me-2">
                                            <i class="fa-solid fa-pen-to-square me-1"></i> Edit </button>
                                        <button data-bs-toggle="modal" data-bs-target="#deletePropertyTypeModal" class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-trash me-1"></i> Delete </button>
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


      






        <!-- Off-canvas -->

        <!-- Add property Type -->
            
        <div class="modal fade" id="addPropertyTypeModal" tabindex="-1" aria-labelledby="addPropertyTypeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addPropertyTypeModalLabel">Add Property Type</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <form action="../process_pages/process_property_type.php" method="post">
                       <div class="mb-3">
                           <label for="propertyTypeName" class="form-label">Property Type Name</label>
                           <input type="text" class="form-control" id="propertyTypeName" placeholder="Enter property type " name='propertyTypeName'>
                       </div>
                          <div class="mb-3">
                            <label for="propertyTypeDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="propertyTypeDescription" rows="3" placeholder="Enter a brief description of the property type" name='propertyTypeDescription'></textarea>
                          </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Cancel</button>
                            <button type="submit" class="btn btn-primary" name='btn'>Save Property Type</button>
                        </div>
                   </form>
                </div>
                    
                </div>
            </div>
        </div>

        <!-- Delete Property Type -->

        <div class="modal fade" id="deletePropertyTypeModal" tabindex="-1" aria-labelledby="deletePropertyTypeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <form action="../process_pages/process_delete_property_type.php" method="post">
                        <h5>Are you sure you want to <span class='text-danger'>DELETE</span> this property type?</h5>
                        <input type="number" name="property_typeid" value="<?php echo $properties_type['property_typeid']; ?>" hidden>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Cancel</button>
                            <button type="submit" class="btn btn-danger" name='deletebtn'>Yes, Delete</button>
                        </div>
                   </form>
                </div>
                    
                </div>
            </div>
        </div>





                <!-- Button trigger modal -->
                



    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // $(document).ready(function () {

        // $('.Live .ta').addClass('text-bg-success');
        // $('.Pending .ta').addClass('text-bg-secondary');
        // $('.rejected .ta').addClass('text-bg-danger');
        // $('.suspended .ta').addClass('text-bg-warning');



        //     $('.filter').click(function(){
              

        // })

        // });
    </script>
</body>

</html>