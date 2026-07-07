<?php


session_start();
require_once "adminguard.php";
require_once "classes/Admin.php";
$prop = new Admin();
$listing_deet = $prop->fetch_property_detail($_GET['id']);

// echo "<pre>";
// print_r($listing_deet);
// echo "</pre>";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin verification</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">

</head>

<body>
   


    <div class="container-fluid " style="min-height: 900px;">
        <div class="row">

            <!-- Sidebar (Profile and Navigation) -->
                <?php include 'admin_nav.php'; ?>
            <!-- Sidebar (Profile and Navigation) -->

            <!-- Main Content -->

            <div class="col-md-9 px-5 pb-5 pt-3" >
                    <!-- <div class="container section" style="background-color: #f1f1f1;"> -->
        <div class="row g-2 ">
            <div class="col-md-12 ">
                <img src="../uploads/property_pictures/<?php echo $listing_deet['image1'] ?>" id="pro11" class="img-fluid rounded" alt="">
                <!-- <img src="uploads/property_pictures/<?php //echo $res['image2'] ?>" id="pro12" class="img-fluid rounded" alt="">
                <img src="uploads/property_pictures/<?php //echo $res['image3'] ?>" id="pro13" class="img-fluid rounded" alt="">
                <img src="uploads/property_pictures/<?php// echo $res['image4'] ?>" id="pro14" class="img-fluid rounded" alt=""> -->
            </div>
            <div class="col-12 py-3">
                <div class="row">
                    <div class="col-sm-2">
                        <a type="botton" href="" id="pro1"> <img src="uploads/property_pictures/<?php echo $listing_deet['image1'] ?>"
                                class="img-fluid rounded" alt=""> </a>
                    </div>
                    <div class="col-md-2 ">
                        <a type="botton" href="" id="pro2"> <img src="media/singleproperty02.png"
                                class="img-fluid rounded" alt=""> </a>
                    </div>
                    <div class="col-md-2">
                        <a type="botton" href="" id="pro3"> <img src="media/singleproperty03.png"
                                class="img-fluid rounded" alt=""> </a>
                    </div>
                    <div class="col-md-2">
                        <a type="botton" href="" id="pro4"> <img src="media/singleproperty01.png"
                                class="img-fluid rounded" alt=""> </a>
                    </div>
                    <div class="col-md-2">
                        <a type="botton" href="" id="pro5"> <img src="media/singleproperty01.png"
                                class="img-fluid rounded" alt=""> </a>
                    </div>
                    <div class="col-md-2">
                        <a type="botton" href="" id="pro5"> <img src="media/singleproperty01.png"
                                class="img-fluid rounded" alt=""> </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row py-5 d-flex flex-row justify-content-between align-items-center g-5">
            <div class="col-md-8 py-3 ">
                <div class="row d-flex bg-light flex-row justify-content-between align-items-center px-3">
                    <div class="col-md-3 d-flex flex-row align-items-center g-2">
                        <span class="badge bg-info"> FEATURED</span>
                        <span class="mx-2 badge bg-primary"> FOR RENT </span>
                    </div>
                    <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center g-2 ">
                        <a href=""><i class="fas fa-calendar-alt"></i></a>
                        <p class="pt-3 px-2">23 june, 2025</p>
                    </div>
                    <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center g-2 ">
                        <a href=""><i class="fas fa-eye"></i></a>
                        <p class="pt-3 px-2">203K Views</p>
                    </div>
                    <div class="col-md-3 d-flex flex-row justify-content-between align-items-center g-2">
                        <a href=""><i class="fas fa-share-alt"></i></a>
                        <a href=""><i class="fas fa-heart"></i></a>
                        <a href=""><i class="fas fa-home"></i></a>
                        <a href=""><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
                <div class="row bg-light px-3">
                    <div class="col-12">
                        <hr class="mb-4 bg-primary" style="width: 100%; height: 3px;">
                    </div>
                    <div class="col-md-8">
                        <h2 class="label"><?php echo $listing_deet['title'] ?></h2>
                    </div>
                    <div class="col-md-4 text-left">
                        <h3 class="text-muted ms-3">₦ <?php echo $listing_deet['price'] ?></h3>
                    </div>
                    <div class="col-12 ps-2 d-flex flex-row justify-content-start align-items-center g-2">
                        <a href=""><i class="fas fa-map-marker-alt"></i></a>
                        <p class="px-3 pt-2"><?php echo $listing_deet['address'].", ".$listing_deet['LGA_name'].", ".$listing_deet['state']?></p>
                    </div>
                </div>
                <div class="row py-4 bg-light px-3">
                    <h3 class="py-3">Description</h3>
                    <p><?php echo $listing_deet['description'] ?></p>
                </div>

                <div class="row my-4 bg-light px-3">
                    <div class="col-12">
                        <h3 class="pt-3">Features</h3>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center">
                                <a href=""><i class="fas fa-bed"></i></a>
                                <p class="pt-3 ps-3">Type <br><span><?php echo $listing_deet['name'] ?></span></p>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center ">
                                <a href=""><i class="fas fa-bed"></i></a>
                                <p class="pt-3 ps-3"> Bedrooms <br><span><?php echo $listing_deet['bedrooms'] ?></span></p>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center">
                                <a href=""><i class="fas fa-bath"></i></a>
                                <p class="pt-3 ps-3">Bathrooms <br><span><?php echo $listing_deet['bathrooms'] ?></span></p>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center">
                                <a href=""><i class="fas fa-bath"></i></a>
                                <p class="pt-3 ps-3">Toilet <br><span><?php echo $listing_deet['toilet'] ?></span></p>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center">
                                <a href=""><i class="fas fa-utensils"></i></a>
                                <p class="pt-3 ps-3">Kitchen <br><span>1</span></p>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center">
                                <a href=""><i class="fas fa-utensils"></i></a>
                                <p class="pt-3 ps-3">Status <br><span><?php echo $listing_deet['furnished_status'] ?></span></p>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center ">
                                <a href=""><i class="fas fa-car"></i></a>
                                
                                    <?php 
                                        if($listing_deet['parking_space'] == 1) {

                                    ?>
                                        <p class="pt-3 ps-3">Parking Space <br><span>Yes</span></p>
                                    <?php
                                        }else{
                                    ?>
                                        <p class="pt-3 ps-3">Parking Space <br><span> - </span></p>
                                    <?php
                                        }
                                    ?>
                                
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center ">
                                <a href=""><i class="fas fa-bolt"></i></a>
                                <?php 
                                        if($listing_deet['electricity_supply'] == 1) {

                                    ?>
                                        <p class="pt-3 ps-3">Electricity Supply <br><span>Yes</span></p>
                                    <?php
                                        }else{
                                    ?>
                                        <p class="pt-3 ps-3">Electricity Supply <br><span> - </span></p>
                                    <?php
                                        }
                                    ?>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center">
                                <a href=""><i class="fas fa-tint"></i></a>
                                     <?php 
                                        if($listing_deet['water_supply'] == 1) {

                                    ?>
                                        <p class="pt-3 ps-3">Water Supply <br><span>Yes</span></p>
                                    <?php
                                        }else{
                                    ?>
                                        <p class="pt-3 ps-3">Water Supply <br><span> - </span></p>
                                    <?php
                                        }
                                    ?>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center">
                                <a href=""><i class="fas fa-tint"></i></a>
                                 <?php 
                                        if($listing_deet['security'] == 1) {

                                    ?>
                                        <p class="pt-3 ps-3">Security <br><span>Yes</span></p>
                                    <?php
                                        }else{
                                    ?>
                                        <p class="pt-3 ps-3">Security <br><span> - </span></p>
                                    <?php
                                        }
                                    ?>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center">
                                <a href=""><i class="fas fa-tint"></i></a>
                                 <?php 
                                        if($listing_deet['pop_ceiling'] == 1) {

                                    ?>
                                        <p class="pt-3 ps-3">Pop Ceiling <br><span>Yes</span></p>
                                    <?php
                                        }else{
                                    ?>
                                        <p class="pt-3 ps-3">Pop Ceiling<br><span> - </span></p>
                                    <?php
                                        }
                                    ?>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center">
                                <a href=""><i class="fas fa-tint"></i></a>
                                 <?php 
                                        if($listing_deet['tiled_floor'] == 1) {

                                    ?>
                                        <p class="pt-3 ps-3">Tiled Floor<br><span>Yes</span></p>
                                    <?php
                                        }else{
                                    ?>
                                        <p class="pt-3 ps-3">Tiled Floor<br><span> - </span></p>
                                    <?php
                                        }
                                    ?>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center">
                                <a href=""><i class="fas fa-tint"></i></a>
                                 <?php 
                                        if($listing_deet['prepaid_meter'] == 1) {

                                    ?>
                                        <p class="pt-3 ps-3">Prepaid Meter<br><span>Yes</span></p>
                                    <?php
                                        }else{
                                    ?>
                                        <p class="pt-3 ps-3">Prepaid Meter<br><span> - </span></p>
                                    <?php
                                        }
                                    ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row my-4 bg-light p-3">
                    <div class="col-md-6 ">
                        <h3>Address</h3>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="register.html" class="btn btn-primary">Open on Google Maps</a>
                        
                    </div>
                    <div class="col-md-12 text-end">
                        <iframe src="" frameborder="0"></iframe>
                    </div>
                    
                </div>

                <div class="row my-4 bg-light p-3 d-flex gap-1 justify-content-start">
                    <!-- Action Buttons -->
                     <div class="col">
                        <button class="btn btn-success px-4" data-bs-toggle="modal"
                        data-bs-target="#approveAgentModal">
                        <i class="fa-solid fa-circle-check me-2"></i> Approve
                    </button>
                     </div>
                     <div class="col">
                        <button class="btn btn-outline-warning px-4" data-bs-toggle="modal"
                        data-bs-target="#suspendAgentModal">
                        <i class="fa-solid fa-circle-check me-2"></i> Suspend
                    </button>
                     </div>
                     <div class="col">
                        <button class="btn btn-outline-danger px-4" data-bs-toggle="modal"
                        data-bs-target="#rejectAgentModal">
                        <i class="fa-solid fa-circle-xmark me-2"></i> Reject
                    </button>
                     </div>   
                </div>
            </div>
            <div class="col-md-3 bg-light text-center py-5 agnt" >
                <img src="media/q.png" class="img-fluid rounded rounded-circle" alt="Agent Image" style="width: 100px; height: 100px; object-fit: cover;">
                <h4 class="p-1"><?php echo $listing_deet['first_name']." ".$listing_deet['last_name'] ?></h4>
                <div class="review d-flex flex-row align-items-center justify-content-center g-2">
                    <a href="" class="text-primary p-1"><i class="fa-solid fa-star"></i></i></a>
                    <a href="" class="text-primary p-1"><i class="fa-solid fa-star"></i></i></a>
                    <a href="" class="text-primary p-1"><i class="fa-solid fa-star"></i></i></a>
                    <a href="" class="text-primary p-1"><i class="fa-solid fa-star"></i></i></a>
                    <a href="" class="text-primary p-1"><i class="fa-solid fa-star"></i></i></a>
                </div>
                <p>Get in touch with the agent for more information.</p>
                <form action="#">
                    <textarea name="message" id="" class="form-control" placeholder="Type your message here..."></textarea>
                    <button type="submit" class="btn btn-primary mt-2 col-12">Send Message</button>
                </form>
            </div>
        </div>

    <!-- </div> -->
            </div>
           <!-- Main Content -->
        </div>
    </div>















    <!-- MODALS  -->
                    <!-- Approve Agent Modal -->
                    <div class="modal fade" id="approveAgentModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-semibold">
                                        <i class="fa-solid fa-circle-check text-success me-2"></i>
                                        Approve Agent
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-muted">Are you sure you want to approve this agent? They will receive
                                        a
                                        <strong>Verified Badge</strong> and will be able to post listings immediately.
                                    </p>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-outline-secondary px-4"
                                        data-bs-dismiss="modal">Cancel</button>
                                   <form action="process_pages/process_update_listing_status.php" method="post">
                                        <input type="number" name="property_id" value="<?php echo $listing_deet['property_id'] ?>" hidden>
                                         <button name='approve' class="btn btn-success px-4">
                                            <i class="fa-solid fa-circle-check me-2"></i> Yes, Approve
                                        </button>
                                   </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reject Agent Modal -->
                    <div class="modal fade" id="rejectAgentModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-semibold">
                                        <i class="fa-solid fa-circle-xmark text-danger me-2"></i>
                                        Reject Listing Verification
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-muted mb-3">Select a reason for rejection. The agent will be
                                        notified and can resubmit their documents.</p>
                                    <div class="mb-3">
                                        <label class="form-label fw-medium">Reason for Rejection</label>
                                        <select class="form-select">
                                            <option selected disabled>Select a reason</option>
                                            <option>ID document is unclear or unreadable</option>
                                            <option>Selfie does not match ID photo</option>
                                            <option>CAC document is invalid or expired</option>
                                            <option>Documents appear to be forged</option>
                                            <option>Other (specify below)</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-medium">Additional Notes <span
                                                class="text-muted fw-normal">(optional)</span></label>
                                        <textarea class="form-control" rows="3"
                                            placeholder="Add any additional notes for the agent..."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-outline-secondary px-4"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <form action="process_pages/process_update_listing_status.php" method="post">
                                        <input type="number" name="property_id" value="<?php echo $listing_deet['property_id'] ?>" hidden>
                                        <button name="rejected" class="btn btn-danger px-4">
                                        <i class="fa-solid fa-circle-xmark me-2"></i> Send Rejection
                                    </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>



                     <!-- Suspend Agent Modal -->
                    <div class="modal fade" id="suspendAgentModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-semibold">
                                        <i class="fa-solid fa-circle-check text-success me-2"></i>
                                        Suspend Listing
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-muted">Are you sure you want to suspend this agent? They will receive
                                        a
                                        <strong>Suspended Badge</strong> and will not be able to post listings.
                                    </p>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-outline-secondary px-4"
                                        data-bs-dismiss="modal">Cancel</button>
                                   <form action="process_pages/process_update_listing_status.php" method="post">
                                        <input type="number" name="agent_id" value="<?php echo $listing_deet['property_id'] ?>" hidden>
                                         <button name='suspend' class="btn btn-warning px-4">
                                            <i class="fa-solid fa-circle-check me-2"></i> Yes, Suspend
                                        </button>
                                   </form>
                                </div>
                            </div>
                        </div>
                    </div>











    <!-- Off-canvas -->
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="mobileMenu"
        aria-labelledby="mobileMenu">
        <div class="offcanvas-header">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="profile-box d-flex flex-column justify-content-center align-items-center"
                        style="padding: 20px;">
                        <div class="profile-pic d-flex justify-content-center align-items-center"
                            style="width: 110px; height: 110px; background-color: white; border-radius: 50%;   margin-top: 30px;">
                            <img src="media/q.png" alt="Profile Picture" class="box"
                                style="width: 100px; height: 100px; border-radius: 50%;">
                        </div>
                        <h5 class="text-center mt-3 card box p-1">Samson Johnson</h5>
                        <p class="text-center label ">Scout</p>
                        <div class="profile-menu mt-4">
                            <a href="tenant_dashbord.html" class="d-block py-2 px-3 text-dark">Dashboard</a>
                            <a href="#" class="d-block py-2 px-3 text-dark">Browse Listings</a>
                            <a href="#" class="d-block py-2 px-3 text-dark">Messages</a>
                            <a href="#" class="d-block py-2 px-3 text-dark">Settings</a>
                            <a href="#" class="d-block py-2 px-3 text-dark">My Profile </a>
                            <a href="#" class="d-block py-2 px-3 text-dark">Logout</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>




    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        

    </script>
</body>

</html>