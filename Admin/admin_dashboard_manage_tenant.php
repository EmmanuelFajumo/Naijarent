<?php
    session_start();
    require_once "adminguard.php";
    require_once "classes/Admin.php";
    $user_id = $_GET['id'];
    $user = new Admin();
    $response = $user->get_user($user_id);
    
    // Determine status label classes
    $status = $response['is_verified'] ?? 0;
    if ($status == 1) {
        $status_label = 'Verified';
        $status_badge = 'verified';
    } elseif ($status == 2) {
        $status_label = 'Suspended';
        $status_badge = 'suspended';
    } elseif ($status == 3) {
        $status_label = 'Banned';
        $status_badge = 'banned';
    } else {
        $status_label = 'Pending';
        $status_badge = 'pending';
    }

    // Determine role (if field exists - fallback)
    $role = $response['role'] ?? 'Tenant';
    
    // Get initials for avatar
    $first_initial = strtoupper(substr($response['first_name'] ?? 'T', 0, 1));
    $last_initial = strtoupper(substr($response['last_name'] ?? 'T', 0, 1));
    $initials = $first_initial . $last_initial;
    
    // Format date
    $date_joined = !empty($response['date_joined']) ? date('F j, Y', strtotime($response['date_joined'])) : 'N/A';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tenant - <?php echo htmlspecialchars($response['first_name']." ".$response['last_name']); ?></title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap" rel="stylesheet">

    <style>
        /* Additional page-specific styles */
        .tenant-header-card {
            background: linear-gradient(135deg, #14213D, #1E3888);
            border-radius: 20px;
            padding: 32px 36px;
            position: relative;
            overflow: hidden;
        }
        .tenant-header-card::after {
            content: '';
            position: absolute;
            top: -40%;
            right: -10%;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: rgba(255,255,255,0.03);
        }
        .tenant-header-card::before {
            content: '';
            position: absolute;
            bottom: -30%;
            left: 30%;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: rgba(255,215,0,0.04);
        }
        .tenant-avatar-lg {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FFD700, #FFA500);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2em;
            font-weight: 700;
            color: #14213D;
            box-shadow: 0 4px 20px rgba(255,165,0,0.3);
            position: relative;
            z-index: 1;
            flex-shrink: 0;
        }
        .tenant-header-card .tenant-name {
            font-family: 'Voltaire', sans-serif;
            font-size: 1.8em;
            color: #ffffff;
            margin-bottom: 2px;
            position: relative;
            z-index: 1;
        }
        .tenant-header-card .tenant-email {
            color: rgba(255,255,255,0.7);
            font-size: 0.9em;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }
        .tenant-header-card .btn-action-gold {
            background: #FFD700;
            border: none;
            color: #14213D;
            font-weight: 600;
            border-radius: 10px;
            padding: 8px 20px;
            font-size: 0.82em;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(255,215,0,0.3);
        }
        .tenant-header-card .btn-action-gold:hover {
            background: #ffe033;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(255,215,0,0.4);
            color: #14213D;
        }
        .tenant-header-card .btn-action-outline-light {
            background: transparent;
            border: 1.5px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.85);
            font-weight: 500;
            border-radius: 10px;
            padding: 8px 20px;
            font-size: 0.82em;
            transition: all 0.3s ease;
        }
        .tenant-header-card .btn-action-outline-light:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.4);
            color: #ffffff;
            transform: translateY(-2px);
        }
        .tenant-header-card .btn-action-outline-danger {
            background: transparent;
            border: 1.5px solid rgba(239, 68, 68, 0.5);
            color: #fca5a5;
            font-weight: 500;
            border-radius: 10px;
            padding: 8px 20px;
            font-size: 0.82em;
            transition: all 0.3s ease;
        }
        .tenant-header-card .btn-action-outline-danger:hover {
            background: rgba(239, 68, 68, 0.15);
            border-color: #ef4444;
            color: #ffffff;
            transform: translateY(-2px);
        }
        .info-row {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 12px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-row .info-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9em;
            flex-shrink: 0;
        }
        .info-row .info-label {
            font-size: 0.78em;
            color: #9ca3af;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1px;
        }
        .info-row .info-value {
            font-size: 0.92em;
            color: #1f2937;
            font-weight: 500;
        }
        .stat-icon-inline {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1em;
            flex-shrink: 0;
        }
    </style>
</head>

<body>

    <div class="container-fluid" style="min-height: 900px;">
        <div class="row" style="min-height: 900px;">

            <!-- Sidebar -->
            <?php include 'admin_nav.php'; ?>

            <!-- Main Content -->
            <div class="col-md-10 px-4 pb-5 pt-4">

                <!-- Breadcrumb -->
                <div class="d-flex align-items-center gap-2 mb-4" style="font-size:0.85em;color:#8a94a6;">
                    <a href="admin_dashboard.php" class="text-decoration-none" style="color:#8a94a6;">Dashboard</a>
                    <span>›</span>
                    <a href="admin_dashboard_manage_tenants.php" class="text-decoration-none" style="color:#8a94a6;">Tenants</a>
                    <span>›</span>
                    <span class="fw-semibold" style="color:#1f2937;"><?php echo htmlspecialchars($response['first_name']." ".$response['last_name']); ?></span>
                </div>

                <!-- Header Profile Card -->
                <div class="tenant-header-card mb-4">
                    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-4">
                        <div class="tenant-avatar-lg">
                            <?php echo $initials; ?>
                        </div>
                        <div class="flex-grow-1">
                            <h1 class="tenant-name"><?php echo htmlspecialchars($response['first_name']." ".$response['last_name']); ?></h1>
                            <p class="tenant-email mb-0">
                                <i class="fa-regular fa-envelope me-1"></i> <?php echo htmlspecialchars($response['email']); ?>
                            </p>
                        </div>
                        <div class="d-flex flex-wrap gap-2 position-relative" style="z-index:1;">
                            <button class="btn-action-gold" title="Verify this tenant">
                                <i class="fa-solid fa-check me-1"></i> Verify
                            </button>
                            <button class="btn-action-outline-light" title="Suspend this tenant">
                                <i class="fa-solid fa-pause me-1"></i> Suspend
                            </button>
                            <button class="btn-action-outline-danger" title="Delete this tenant account">
                                <i class="fa-solid fa-trash-can me-1"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Two Column Layout -->
                <div class="row g-4">

                    <!-- Personal Information -->
                    <div class="col-md-7">
                        <div class="profile-section-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="section-title-icon" style="background:#eef1fa;color:#1E3888;">
                                        <i class="fa-regular fa-user"></i>
                                    </div>
                                    <div>
                                        <h5 class="section-title mb-0">Personal Information</h5>
                                        <p class="section-subtitle">Contact and identity details</p>
                                    </div>
                                </div>
                                <hr class="section-divider-inner">

                                <div class="info-row">
                                    <div class="info-icon" style="background:#eef1fa;color:#1E3888;">
                                        <i class="fa-regular fa-envelope"></i>
                                    </div>
                                    <div>
                                        <div class="info-label">Email Address</div>
                                        <div class="info-value"><?php echo htmlspecialchars($response['email']); ?></div>
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-icon" style="background:#ecfdf5;color:#10b981;">
                                        <i class="fa-solid fa-phone"></i>
                                    </div>
                                    <div>
                                        <div class="info-label">Phone Number</div>
                                        <div class="info-value"><?php echo htmlspecialchars($response['phone'] ?? 'Not provided'); ?></div>
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-icon" style="background:#fffbeb;color:#f59e0b;">
                                        <i class="fa-regular fa-id-card"></i>
                                    </div>
                                    <div>
                                        <div class="info-label">Tenant ID</div>
                                        <div class="info-value" style="font-family:monospace;font-size:0.85em;">#<?php echo str_pad($response['tenant_id'], 5, '0', STR_PAD_LEFT); ?></div>
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-icon" style="background:#fef2f2;color:#ef4444;">
                                        <i class="fa-regular fa-address-book"></i>
                                    </div>
                                    <div>
                                        <div class="info-label">Full Name</div>
                                        <div class="info-value"><?php echo htmlspecialchars($response['first_name']." ".$response['last_name']); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Details -->
                    <div class="col-md-5">
                        <div class="profile-section-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="section-title-icon" style="background:#fffbeb;color:#f59e0b;">
                                        <i class="fa-solid fa-shield-halved"></i>
                                    </div>
                                    <div>
                                        <h5 class="section-title mb-0">Account Details</h5>
                                        <p class="section-subtitle">Status and security info</p>
                                    </div>
                                </div>
                                <hr class="section-divider-inner">

                                <div class="info-row">
                                    <div class="info-icon" style="background:#eef1fa;color:#1E3888;">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </div>
                                    <div>
                                        <div class="info-label">Verification Status</div>
                                        <div class="info-value">
                                            <span class="status-badge <?php echo $status_badge; ?>">
                                                <i class="fa-solid fa-circle" style="font-size:0.5em;vertical-align:middle;"></i>
                                                <?php echo $status_label; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-icon" style="background:#ecfdf5;color:#10b981;">
                                        <i class="fa-solid fa-user-tag"></i>
                                    </div>
                                    <div>
                                        <div class="info-label">Account Role</div>
                                        <div class="info-value">
                                            <span class="status-badge" style="background:#eef1fa;color:#1E3888;">
                                                <i class="fa-regular fa-user"></i> <?php echo $role; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-icon" style="background:#fef2f2;color:#ef4444;">
                                        <i class="fa-regular fa-clock"></i>
                                    </div>
                                    <div>
                                        <div class="info-label">Date Joined</div>
                                        <div class="info-value"><?php echo $date_joined; ?></div>
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-icon" style="background:#fffbeb;color:#f59e0b;">
                                        <i class="fa-solid fa-fingerprint"></i>
                                    </div>
                                    <div>
                                        <div class="info-label">Account Status</div>
                                        <div class="info-value">
                                            <?php if ($status == 1): ?>
                                                <span class="text-success fw-semibold"><i class="fa-solid fa-check-circle"></i> Active</span>
                                            <?php elseif ($status == 2): ?>
                                                <span class="text-warning fw-semibold"><i class="fa-solid fa-pause-circle"></i> Suspended</span>
                                            <?php elseif ($status == 3): ?>
                                                <span class="text-danger fw-semibold"><i class="fa-solid fa-ban"></i> Banned</span>
                                            <?php else: ?>
                                                <span class="text-secondary fw-semibold"><i class="fa-solid fa-hourglass-half"></i> Pending</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Recently Viewed Properties Section -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="section-header-custom">
                            <i class="fa-regular fa-clock"></i> Recent Activity
                        </div>
                        <div class="activity-card">
                            <div class="card-header-custom">
                                <h6><i class="fa-regular fa-rectangle-list me-2" style="color:#1E3888;"></i> Recent Activity</h6>
                                <a href="#" class="text-decoration-none">View All <i class="fa-solid fa-arrow-right ms-1"></i></a>
                            </div>
                            <div class="text-center py-4" style="color:#9ca3af;font-size:0.88em;">
                                <i class="fa-regular fa-circle-question me-1"></i> No recent activity recorded.
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Main Content -->

        </div>
    </div>

    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>