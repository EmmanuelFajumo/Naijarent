<div class="div container-fluid py-2" style="background: linear-gradient(135deg, #14213D, #1E3888);">
        <div class="row">
            <div class="col">
                <nav class="navbar navbar-expand-lg">
                    <div class="container">
                        <a class="navbar-brand text-light" href="index.php">NaijaRent</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex justify-content-end" style="width: 70%;">
                            <li class="nav-item gx-4">
                            <a class="nav-link text-light nlink" aria-current="page" href="#">For Sale</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link text-light nlink" aria-current="page" href="#">For Rent</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link text-light nlink" aria-current="page" href="#">View All  Properties</a>
                            </li>
                            <li class="nav-item">
                                <div class="dropdown">
                                    <a class="nav-link text-light nlink dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Agents
                                    </a>
                                    <ul class="dropdown-menu px-3">
                                    <li><a href="browse_agents.php" class=" nav-link textnlink">Browse Agents </a></li>
                                        <li><a href="agent/agent_plans.php" class="nav-link textnlink "></i>Join as an Agent </a></li>
                                    </ul>
                                </div>
                            </li>
                            
                            <?php 
                                if(isset($_SESSION['agent_online']) ){
                            ?>
                            <li class="nav-item">
                            <a class="btn btn-primary text-light nlink"  href="agent/agent_dashboard.php">Back to Dashboard</a>
                            </li>
                            <?php } ?>
                        </ul>
                            <?php 
                                if(!isset($_SESSION['agent_online']) && !isset($_SESSION['useronline']) ){
                            ?>
                            <div class="d-flex justify-content-end " style="width: 30%; gap: 15px;">
                                <a class=" btn rounded-pil btn-outline-light btn rounded" href="register.php">Register</a>
                                <a class="btn rounded" href="login.php" style="background: linear-gradient(135deg, #FFD700, #FFA500); border: none; transition: all 0.3s ease; box-shadow: 0 4px 18px rgba(255, 165, 0, 0.4); white-space: nowrap;">Sign In</a>
                                <!-- <button type="submit" class="btn-hero-search">
                                            <i class="fa-solid fa-magnifying-glass"></i> Search
                                        </button> -->
                            </div>
                            <?php } ?>

                             <?php 
                                if(!isset($_SESSION['agent_online']) && isset($_SESSION['useronline']) ){
                            ?>
                           <div class="profile-menu mt-4 d-flex flex-row justify-content-center align-items-center">
                            <div class="dropdown">
                                <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                   Hi, <?php if(isset($_SESSION['useronline'])) { echo $user_deet['first_name']; } else{echo "Login";} ?>
                                </button>
                                <ul class="dropdown-menu px-3">
                                   <li><a href="tenant_dashboard.php" class="text-secondary">  Dashboard </a></li>
                                   <li><a href="#" class="text-secondary">Browse Listings</a></li>
                                    <li><a href="#" class="text-secondary ">My Profile </a></li>
                                    <li><a href="user_logout.php" class="text-secondary"> Logout</a></li>
                                </ul>
                            </div>
                         </div>
                            <?php } ?>
                        </div>
                    </div>
                </nav>
             </div>
        </div>
    </div>