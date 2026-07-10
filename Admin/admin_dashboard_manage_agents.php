<?php
session_start();
require_once "adminguard.php";
require_once "classes/Admin.php";
$agents = new Admin();
$res = $agents->get_all_agents();
$sn = 1;
// echo "<pre>";
// print_r($res);
// echo "</pre>";

$total_agents = count($res);

?>

<!DOCTYPE html> 
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Manage Agents</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
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
                            <h2 class="mb-1">Manage Agents</h2>
                            <p class="mb-0">Total Agents: <strong><?php echo $total_agents; ?></strong></p>
                        </div>
                        <button class="btn-export">
                            <i class="fa-solid fa-download me-2"></i> Export CSV
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row g-3 mb-4">
                     <!-- Alert Messages -->
                <?php if(isset($_SESSION['errormsg'])){ ?>
                    <div class="alert-custom alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-exclamation me-2"></i>
                        <?php echo $_SESSION['errormsg']; unset($_SESSION['errormsg']);?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <?php if(isset($_SESSION['successmsg'])){ ?>
                    <div class="alert-custom alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i>
                        <?php echo $_SESSION['successmsg']; unset($_SESSION['successmsg']);?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
                    <div class="col-6 col-md-3">
                        <div class="stat-card primary text-center">
                            <div class="stat-icon mx-auto"><i class="fa-solid fa-user-tie"></i></div>
                            <div class="stat-value"><?php echo $total_agents; ?></div>
                            <div class="stat-label">Total Agents</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card success text-center">
                            <div class="stat-icon mx-auto"><i class="fa-solid fa-badge-check"></i></div>
                            <div class="stat-value">980</div>
                            <div class="stat-label">Verified</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card warning text-center">
                            <div class="stat-icon mx-auto"><i class="fa-solid fa-clock"></i></div>
                            <div class="stat-value">245</div>
                            <div class="stat-label">Pending</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card danger text-center">
                            <div class="stat-icon mx-auto"><i class="fa-solid fa-ban"></i></div>
                            <div class="stat-value">115</div>
                            <div class="stat-label">Banned</div>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="row g-3 mb-4 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group filter-input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search by name, agency or email...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select form-select-custom">
                            <option selected>Filter by Status</option>
                            <option value="all">All Agents</option>
                            <option value="verified">✅ Verified</option>
                            <option value="pending">⏳ Pending</option>
                            <option value="rejected">❌ Rejected</option>
                            <option value="suspended">⚠️ Suspended</option>
                            <option value="banned">🚫 Banned</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select form-select-custom">
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
                        <div class="table-card">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="py-3 px-4">#</th>
                                            <th class="py-3">Agent</th>
                                            <th class="py-3">Agency</th>
                                            <th class="py-3">Email</th>
                                            <th class="py-3">Phone</th>
                                            <th class="py-3">Status</th>
                                            <th class="py-3 text-end pe-4">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                        foreach($res as $agent){
                                    ?>

                                        <tr>
                                            <td class="px-4 fw-medium text-muted"><?php echo $sn++; ?></td>
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
                                            <td class="text-muted"><?php echo $agent['phone']; ?></td>
                                            <td>
                                                <?php
                                                    $vstatus = $agent['verification_status'];
                                                    $class = $vstatus == 'verified' ? 'verified' : ($vstatus == 'pending' ? 'pending' : ($vstatus == 'suspended' ? 'suspended' : 'banned'));
                                                ?>
                                                <span class="status-badge <?php echo $class; ?>">
                                                    <i class="fa-solid fa-circle-check"></i> <?php echo ucfirst($vstatus); ?>
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                
                                                    <a name="view" class="btn btn-sm px-3" style="border:1px solid #e5e7eb;border-radius:8px;color:#4b5563;background:#fff;" href="agent_profile.php?agent_id=<?php echo $agent['Agent_id']; ?>">
                                                        <i class="fa-solid fa-eye me-1 text-primary"></i> View Profile
                                                    </a>
                                                <!-- </form> -->
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

                <!-- Pagination -->
                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <small class="text-muted">Showing 1 - <?php echo $total_agents; ?> of <?php echo $total_agents; ?> agents</small>
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
            <!-- End Main Content -->
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
                            style="width: 110px; height: 110px; background-color: white; border-radius: 50%; margin-top: 30px;">
                            <img src="media/q.png" alt="Profile Picture" class="box"
                                style="width: 100px; height: 100px; border-radius: 50%;">
                        </div>
                        <h5 class="text-center mt-3 card box p-1">Samson Johnson</h5>
                        <p class="text-center label">Scout</p>
                        <div class="profile-menu mt-4">
                            <a href="tenant_dashbord.html" class="d-block py-2 px-3 text-dark">Dashboard</a>
                            <a href="#" class="d-block py-2 px-3 text-dark">Browse Listings</a>
                            <a href="#" class="d-block py-2 px-3 text-dark">Messages</a>
                            <a href="#" class="d-block py-2 px-3 text-dark">Settings</a>
                            <a href="#" class="d-block py-2 px-3 text-dark">My Profile</a>
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
        })
    </script>
</body>

</html>