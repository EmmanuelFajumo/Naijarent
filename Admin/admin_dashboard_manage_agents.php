<?php
session_start();
require_once "adminguard.php";
    require_once "classes/Admin.php";
$agents = new Admin();
$res = $agents->get_all_agents();
$sn = 1;

$total_agents = count($res);

?>

<!DOCTYPE html> 
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Manage Agents </title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">

</head>

<body>
    <!-- Navigation -->

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
                                <h2 class="mb-0">Manage Agents</h2>
                                <p class="text-muted mb-0">Total Agents: <strong><?php echo $total_agents; ?></strong></p>
                            </div>
                            <button class="btn btn-primary px-4">
                                <i class="fa-solid fa-download me-2"></i> Export CSV
                            </button>
                        </div>
                        <hr class="my-4">
                    </div>


                    <!-- Stats Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="card box p-3 text-center border-0 shadow-sm">
                                <i class="fa-solid fa-user-tie fa-2x text-primary mb-2"></i>
                                <h5 class="mb-0"><?php echo $total_agents; ?></h5>
                                <small class="text-muted">Total Agents</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card box p-3 text-center border-0 shadow-sm">
                                <i class="fa-solid fa-badge-check fa-2x text-success mb-2"></i>
                                <h5 class="mb-0">980</h5>
                                <small class="text-muted">Verified</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card box p-3 text-center border-0 shadow-sm">
                                <i class="fa-solid fa-clock fa-2x text-warning mb-2"></i>
                                <h5 class="mb-0">245</h5>
                                <small class="text-muted">Pending</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card box p-3 text-center border-0 shadow-sm">
                                <i class="fa-solid fa-ban fa-2x text-danger mb-2"></i>
                                <h5 class="mb-0">115</h5>
                                <small class="text-muted">Banned</small>
                            </div>
                        </div>
                    </div>

                    <!-- Search and Filter -->
                    <div class="row g-3 mb-4 align-items-center">
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fa-solid fa-magnifying-glass text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0"
                                    placeholder="Search by name, agency or email...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select">
                                <option selected>Filter by Status</option>
                                <option value="all">All Agents</option>
                                <option value="verified"> Verified</option>
                                <option value="pending">Pending</option>
                                <option value="rejected"> Rejected</option>
                                <option value="suspended"> Suspended</option>
                                <option value="banned"> Banned</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select">
                                <option selected>Sort By</option>
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                                <option value="listings">Most Listings</option>
                                <option value="rating">Highest Rated</option>
                                <option value="name">Name A-Z</option>
                            </select>
                        </div>
                    </div>

                    <!-- Agents Table -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead style="background-color: #f1f1f1;">
                                                <tr>
                                                    <th class="py-3 px-4">#</th>
                                                    <th class="py-3">Agent</th>
                                                    <th class="py-3">Agency</th>
                                                    <th class="py-3">Email</th>
                                                    <th class="py-3">Listings</th>
                                                    <th class="py-3">Phone Nuber</th>
                                                    <th class="py-3">Status</th>
                                                    <th class="py-3">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                                foreach($res as $agent){
                                            ?>

                                                <!-- Row 1 - Verified -->
                                                <tr>
                                                    <td class="px-4"><?php echo $sn++; ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <img src="../media/profile_pictures/<?php echo $agent['profile_picture']; ?>" alt="avatar"
                                                                style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover;">
                                                            <div>
                                                                <span class="fw-medium d-block"><?php echo $agent['first_name']." ".$agent['last_name']; ?></span>
                                                                <small class="text-muted"><?php echo $agent['phone']; ?></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-muted"><?php echo $agent['agency']; ?></td>
                                                    <td class="text-muted"><?php echo $agent['email']; ?></td>
                                                    <td>
                                                        <!-- <span class="fw-medium">12</span>
                                                        <small class="text-muted d-block">listings</small> -->
                                                    </td>
                                                    <td class="text-muted"><?php echo $agent['phone']; ?></td>
                                                    <td>
                                                        <?php
                                                            if($agent['verification_status'] == "pending"){

                                                        ?>
                                                        <span class="badge rounded-pill px-3 py-2  <?php echo $agent['Agent_id']; ?>" id="" style='background-color: #f8d7da; color: #721c24;'  >
                                                            <i class="fa-solid fa-circle-check me-1"></i> <?php echo $agent['verification_status']; ?>
                                                        </span>

                                                        

                                                        <?php
                                                            }elseif($agent['verification_status'] == "verified"){
                                                        ?>
                                                        <span class="badge rounded-pill px-3 py-2  <?php echo $agent['Agent_id']; ?>" id="" style='background-color: #d4edda; color: #155724;'  >
                                                            <i class="fa-solid fa-circle-check me-1"></i> <?php echo $agent['verification_status']; ?>
                                                        </span>

                                                        <?php
                                                            }elseif($agent['verification_status'] == "suspended"){
                                                        ?>
                                                        <span class="badge rounded-pill px-3 py-2  <?php echo $agent['Agent_id']; ?>" id="" style='background-color: #fff3cd; color: #856404;'>
                                                            <i class="fa-solid fa-pause me-1"></i> <?php echo $agent['verification_status']; ?>
                                                        </span>

                                                        <?php
                                                            }else{
                                                        ?>
                                                        <span class="badge  rounded-pill px-3 py-2  <?php echo $agent['Agent_id']; ?>" id="" style='background-color: #f8d7da; color: #721c24;'  >
                                                            <i class="fa-solid fa-circle-check me-1"></i> <?php echo $agent['verification_status']; ?>
                                                        </span>

                                                        <?php }?>
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            
                                                                <form action="../process_pages/process_update_agent_status.php" method="post" class="">
                                                                    <input type="number" name='agent_id' value='<?php echo $agent['Agent_id']; ?>' id='agent_id' hidden>
                                                                    <button name="view" class='btn btn-success rounded-pill' style='padding: 5px 10px; font-size: 12px;'><i class="fa-solid fa-eye me-2" id="verify_agent"></i> View Profile</button> 
                                                                </form>
                                                        
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                                    }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <small class="text-muted">Showing 1 - 5 of 1,340 agents</small>
                            <nav>
                                <ul class="pagination mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#">Previous</a>
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
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
            </div>
            <!-- Main Content -->
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
        $(document).ready(function(){

            if($('#status').text() ==  'pending'){
                $(this).addClass("text-bg-warning");
            }

            $('#loginForm').hide();
            $('#login').click(function (e) {
                e.preventDefault();
                $('#loginForm').show().addClass('animate__animated animate__fadeIn');
                $('#registerForm').hide();
            })

            $('#register').click(function (e) {
                e.preventDefault();
                $('#registerForm').show().addClass('animate__animated animate__fadeIn');
                $('#loginForm').hide();
            })

            $('.action').change(function(){
                
            });


        })


    </script>
</body>

</html>