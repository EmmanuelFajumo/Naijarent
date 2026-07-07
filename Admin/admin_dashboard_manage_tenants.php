<?php
    session_start();
    require_once "adminguard.php";
    require_once "classes/Admin.php";
    $tenants = new Admin;
    $response = $tenants->get_all_tenants();
    $sn=0;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="preconnect" href="../https://fonts.googleapis.com">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../style.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">

    <style>
        .susp{
            background-color: #fff3cd; color: #856404;
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
                <h2 class="mb-0">Manage Tenants</h2>
                <p class="text-muted mb-0">Total Tenants: <strong>11,200</strong></p>
            </div>
            <button class="btn btn-primary px-4">
                <i class="fa-solid fa-download me-2"></i> Export CSV
            </button>
        </div>
    </div>

    <hr class="my-4">

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card box p-3 text-center border-0 shadow-sm">
                <i class="fa-solid fa-users fa-2x text-primary mb-2"></i>
                <h5 class="mb-0">11,200</h5>
                <small class="text-muted">Total Tenants</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card box p-3 text-center border-0 shadow-sm">
                <i class="fa-solid fa-circle-check fa-2x text-success mb-2"></i>
                <h5 class="mb-0">9,840</h5>
                <small class="text-muted">Verified</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card box p-3 text-center border-0 shadow-sm">
                <i class="fa-solid fa-clock fa-2x text-warning mb-2"></i>
                <h5 class="mb-0">1,120</h5>
                <small class="text-muted">Unverified</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card box p-3 text-center border-0 shadow-sm">
                <i class="fa-solid fa-ban fa-2x text-danger mb-2"></i>
                <h5 class="mb-0">240</h5>
                <small class="text-muted">Banned</small>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="row g-3 mb-4 align-items-center">
        <form action="process_pages/process_filter_admin.php" method="GET" class="row g-3 align-items-center" >
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fa-solid fa-magnifying-glass text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Search by name, email or phone..." name="search" id="searchInput">
                </div>
            </div>
        <div class="col-md-4">
            <select class="form-select" name="filter" id="filterSelect">
                <option selected>Filter by Status</option>
                <option value="all">All Tenants</option>
                <option value="verified">✅ Verified</option>
                <option value="unverified">⏳ Unverified</option>
                <option value="suspended">⚠️ Suspended</option>
                <option value="banned">🚫 Banned</option>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select">
                <option selected>Sort By</option>
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
                <option value="name">Name A-Z</option>
            </select>
        </div>
        </form>
    </div>

    <!-- Tenants Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered align-middle mb-0">
                            <thead style="background-color: #f1f1f1;">
                                <tr>
                                    <th class="py-3 px-4">#</th>
                                    <th class="py-3">Tenant</th>
                                    <th class="py-3">Email</th>
                                    <th class="py-3">Phone</th>
                                    <th class="py-3">Date Joined</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                            <!-- Tenant info-->                           
                            <?php 
                                foreach($response as $user => $data){
                                    $sn++;
                            ?>
                                <tr>
                                        <td class='px-4'> <?php echo $sn; ?></td>
                                        <td>
                                            <div class='d-flex align-items-center gap-2'>
                                                <img src='../media/q.png' alt='avatar'
                                                    style='width: 38px; height: 38px; border-radius: 50%; object-fit: cover;'>
                                                <span class='fw-medium'><?php echo $response["$user"]['first_name'].' '.$response["$user"]['last_name']; ?></span>
                                            </div>
                                        </td>
                                        <td class='text-muted'> <?php echo $response["$user"]['email']; ?> </td>
                                        <td class='text-muted'><?php echo $response["$user"]['phone'] ?></td>
                                        <td class='text-muted'><?php echo $response["$user"]['date_joined']; ?></td>
                                        <td>
                                            <span class='badge rounded-pill <?php echo $response["$user"]['status']; ?> px-3 py-2'>  <i class='fa-solid fa-circle-check me-1 '></i> <?php echo $response["$user"]['is_verified']; ?> </span>
                                        </td>
                                        <td>
                                            <div class='dropdown'>
                                                <button class='btn btn-sm btn-outline-secondary dropdown-toggle'
                                                    type='button' data-bs-toggle='dropdown'>
                                                    Actions
                                                </button>
                                                <ul class='dropdown-menu shadow border-0'>
                                                    <li>
                                                        <a class='dropdown-item' href="admin_dashboard_manage_tenant.php?id=<?php echo $response["$user"]['tenant_id']; ?>"> <i class='fa-solid fa-eye me-2 text-primary'></i> View Profile </a>
                                                    </li>
                                                    <li>
                                                        <a class='dropdown-item' href='#'> <i class='fa-solid fa-check-circle me-2 text-success'></i> Verify </a>
                                                    </li>
                                                    <li>
                                                        <a class='dropdown-item' href='#'> <i class='fa-solid fa-triangle-exclamation me-2 text-warning'></i> Suspend</a>
                                                    </li>
                                                    <li><hr class='dropdown-divider'></li>
                                                    <li>
                                                        <a class='dropdown-item text-danger' href='#'><i class='fa-solid fa-ban me-2'></i> Ban Account</a>
                                                    </li>
                                                </ul>
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
            <small class="text-muted">Showing 1 - 5 of 11,200 tenants</small>
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
         <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenu">
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
        $(document).ready(function () {
            $('.verified').addClass('text-bg-success');
            $('.pending').addClass('text-bg-warning');
            $('.suspended').addClass('susp');
            $('.banned').addClass('text-bg-danger');
        })


    </script>
</body>

</html>