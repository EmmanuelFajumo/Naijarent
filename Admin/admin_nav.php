<!-- Desktop Sidebar - visible on md and up -->
<div class="col-md-2 shadow-sm d-none d-md-flex flex-column sidebar-desktop" style="background: linear-gradient(135deg, #14213D, #1E3888); min-height: 100vh;">
    <div class="d-flex flex-column flex-grow-1 py-3">
        
        <!-- Profile Card -->
        <div class="sidebar-profile-card text-center">
            <div class="avatar-placeholder">A</div>
            <h6 class="text-white mb-0" style="font-family:'Voltaire',sans-serif;font-size:1.1em;">Admin</h6>
            <p class="text-white-50 mb-0" style="font-size:0.75em;opacity:0.7;">IT Support</p>
        </div>

        <!-- Navigation -->
        <div class="sidebar-nav flex-grow-1 mt-2">
            <a href="admin_dashboard.php" class="d-block text-light box"><i class="fa-solid fa-gauge"></i> Dashboard</a>
            <a href="admin_dashboard_manage_tenants.php" class="d-block text-light box"><i class="fa-solid fa-users"></i> Manage Tenants</a>
            <a href="admin_dashboard_manage_agents.php" class="d-block text-light box"><i class="fa-solid fa-user-tie"></i> Manage Agents</a>
            <a href="admin_dashboard_manage_listings.php" class="d-block text-light box"><i class="fa-solid fa-house-chimney"></i> Manage Listings</a>
            <a href="admin_dashboard_verifications.php" class="d-block text-light box"><i class="fa-solid fa-check-double"></i> Verifications</a>
            <a href="#" class="d-block text-light box"><i class="fa-solid fa-flag"></i> Reports</a>
            <a href="#" class="d-block text-light box"><i class="fa-solid fa-circle-dollar-to-slot"></i> Payments</a>
            <a href="admin_dashboard_property_type.php" class="d-block text-light box"><i class="fa-solid fa-tags"></i> Property Types</a>
            <a href="admin_dashboard_blog.php" class="d-block text-light box"><i class="fa-solid fa-tags"></i> Blogs</a>
            <a href="#" class="d-block text-light box"><i class="fa-solid fa-gear"></i> Settings</a>
        </div>

        <!-- Logout at bottom -->
        <div class="sidebar-nav mt-auto pt-3" style="border-top:1px solid rgba(255,255,255,0.08);">
            <a href="admin_logout.php" class="d-block text-light box"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>

    </div>
</div>

<!-- Mobile Offcanvas Sidebar - visible on smaller screens -->
<div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel" style="background: linear-gradient(135deg, #14213D, #1E3888); width: 280px;">
    <div class="offcanvas-header border-bottom border-white border-opacity-10">
        <div class="d-flex align-items-center gap-3">
            <div class="avatar-placeholder" style="width: 40px; height: 40px; font-size: 1em; margin: 0;">A</div>
            <div>
                <h6 class="text-white mb-0" style="font-family:'Voltaire',sans-serif;font-size:1em;">Admin</h6>
                <p class="text-white-50 mb-0" style="font-size:0.7em;opacity:0.7;">IT Support</p>
            </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0 d-flex flex-column">
        <div class="sidebar-nav flex-grow-1 mt-3">
            <a href="admin_dashboard.php" class="d-block text-light box"><i class="fa-solid fa-gauge"></i> Dashboard</a>
            <a href="admin_dashboard_manage_tenants.php" class="d-block text-light box"><i class="fa-solid fa-users"></i> Manage Tenants</a>
            <a href="admin_dashboard_manage_agents.php" class="d-block text-light box"><i class="fa-solid fa-user-tie"></i> Manage Agents</a>
            <a href="admin_dashboard_manage_listings.php" class="d-block text-light box"><i class="fa-solid fa-house-chimney"></i> Manage Listings</a>
            <a href="admin_dashboard_verifications.php" class="d-block text-light box"><i class="fa-solid fa-check-double"></i> Verifications</a>
            <a href="#" class="d-block text-light box"><i class="fa-solid fa-flag"></i> Reports</a>
            <a href="#" class="d-block text-light box"><i class="fa-solid fa-circle-dollar-to-slot"></i> Payments</a>
            <a href="admin_dashboard_property_type.php" class="d-block text-light box"><i class="fa-solid fa-tags"></i> Property Types</a>
            <a href="admin_dashboard_blog.php" class="d-block text-light box"><i class="fa-solid fa-tags"></i> Blogs</a>
            <a href="#" class="d-block text-light box"><i class="fa-solid fa-gear"></i> Settings</a>
        </div>
        <div class="sidebar-nav pt-3 px-3 pb-4" style="border-top:1px solid rgba(255,255,255,0.08);">
            <a href="admin_logout.php" class="d-block text-light box"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
    </div>
</div>
