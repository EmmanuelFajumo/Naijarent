
<div class="col-md-2 shadow-sm" style="background-color: #f1f1f1; background: linear-gradient(135deg, #14213D, #1E3888);">
                <div class="profile-box d-flex flex-column justify-content-center align-items-center"
                    style="padding: 20px;">
                    <div class="profile-pic d-flex justify-content-center align-items-center"
                        style="width: 50px; height: 50px; background-color: white; border-radius: 50%;   margin-top: 30px;">
                        <img src="../media/profile_pictures/<?php echo $det['profile_picture']; ?>" alt="Profile Picture" class="box"
                            style="width: 50px; height: 50px; border-radius: 50%;">
                    </div>
                    <h5 class="text-center mt-3 card box py-1 px-3"><?php echo $det['first_name']; ?></h5>
                    <p class="text-center label text-success"><?php echo $det['verification_status']; ?><i class="fas fa-check-circle"></i></p>
                    <div class="profile-menu mt-4">
                        <a href="agent_dashboard.php" class="d-block py-3 px-5 text-light box "><i class="px-2 fa-solid fa-house-user"></i> Dashboard</a>
                        <a href="agent_dashboard_listings.php" class="d-block py-3 px-5 text-light box "> <i class="px-2 fa-solid fa-list"></i> My Listings</a>
                        <a href="agent_dashboard_messages.php" class="d-block py-3 px-5 text-light box "><i class="px-2 fa-regular fa-envelope"></i> Messages</a>
                        <a href="agent_payments.php" class="d-block py-3 px-5 text-light box "><i class="px-2 fa-solid fa-circle-dollar-to-slot"></i> Payments</a>
                        <a href="agent_settings.php" class="d-block py-3 px-5 text-light box "><i class="px-2 fa-solid fa-gear"></i> Settings</a>
                        <a href="agent_profile.php" class="d-block py-3 px-5 text-light box "><i class="px-2 fa-solid fa-user"></i> My Profile </a>
                        <a href="../process_pages/agent_logout.php" class="d-block py-3 px-5 text-light box "><i class="px-2 fa-solid fa-right-from-bracket"></i> Logout</a>
                    </div>
                </div>
</div>