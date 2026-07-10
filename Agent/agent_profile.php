<?php
    session_start();
    require_once "../process_pages/classes/Agent.php";
    $agent = new Agent();
    $det = $agent->fetch_agent_details($_SESSION['agent_online']);
?>

<!DOCTYPE html>
<html lang="en"> 

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Profile</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --navy-dark: #14213D;
            --navy-light: #1E3888;
            --gold: #FFD700;
            --gold-hover: #FFA500;
            --bg-light: #f8f9fc;
        }

        .section-divider {
            height: 2px;
            background: linear-gradient(to right, transparent, rgba(20, 33, 61, 0.12), transparent);
            border: none;
            margin: 16px 0 24px;
            opacity: 1;
        }

        /* ── Profile Card (Left) ── */
        .profile-sidebar-card {
            border-radius: 16px;
            border: none;
            background: #fff;
            overflow: hidden;
        }
        .profile-avatar-wrap {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            position: relative;
            overflow: hidden;
            border: 4px solid rgba(30, 56, 136, 0.15);
            flex-shrink: 0;
        }
        .profile-avatar-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .profile-avatar-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.5);
            padding: 6px 0;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            opacity: 0;
        }
        .profile-avatar-wrap:hover .profile-avatar-overlay {
            opacity: 1;
        }
        .profile-avatar-overlay small {
            color: #fff;
            font-size: 0.75rem;
        }

        .profile-tab-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            border-radius: 12px;
            color: #495057;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.25s ease;
            cursor: pointer;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
        }
        .profile-tab-link:hover {
            background: rgba(30, 56, 136, 0.06);
            color: var(--navy-dark);
        }
        .profile-tab-link.active {
            background: linear-gradient(135deg, var(--navy-dark), var(--navy-light));
            color: #fff;
            box-shadow: 0 4px 12px rgba(20, 33, 61, 0.2);
        }
        .profile-tab-link i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }

        /* ── Form Card (Right) ── */
        .form-section-card {
            border-radius: 16px;
            border: none;
            background: #fff;
            padding: 28px;
        }
        .form-section-card h2 {
            font-size: 1.35rem;
            color: var(--navy-dark);
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 2px solid rgba(20, 33, 61, 0.08);
        }

        .form-input {
            border-radius: 12px;
            height: 48px;
            background: var(--bg-light);
            border: 1.5px solid #e9ecef;
            padding: 10px 16px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        .form-input:focus {
            border-color: var(--navy-light);
            box-shadow: 0 0 0 3px rgba(30, 56, 136, 0.08);
            background: #fff;
        }
        textarea.form-input {
            height: auto;
            min-height: 100px;
        }
        .form-label {
            font-size: 0.82rem;
            font-weight: 500;
            color: #6c757d;
            margin-bottom: 6px;
        }

        .btn-navy {
            background: linear-gradient(135deg, var(--navy-dark), var(--navy-light));
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 10px 24px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(20, 33, 61, 0.2);
        }
        .btn-navy:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(20, 33, 61, 0.3);
            color: #fff;
        }
        .btn-navy-outline {
            background: transparent;
            color: var(--navy-dark);
            border: 2px solid var(--navy-dark);
            border-radius: 12px;
            padding: 8px 24px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-navy-outline:hover {
            background: linear-gradient(135deg, var(--navy-dark), var(--navy-light));
            color: #fff;
            border-color: transparent;
        }

        .alert-custom {
            border-radius: 12px;
            border-left: 4px solid;
        }
        .alert-custom.alert-success {
            border-left-color: #198754;
        }
        .alert-custom.alert-danger {
            border-left-color: #dc3545;
        }

        .form-section-card {
            display: none;
        }
        .form-section-card.active {
            display: block;
            animation: fadeSlideIn 0.35s ease;
        }

        @keyframes fadeSlideIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .upload-hint {
            font-size: 0.78rem;
            color: #adb5bd;
            margin-top: 4px;
        }
    </style>

</head>

<body>

    <div class="container-fluid" style="min-height: 100vh; background: var(--bg-light);">
        <div class="row">

            <!-- Sidebar -->
            <?PHP include 'agent_nav.php'; ?>

            <!-- Main Content -->
            <div class="col-md-10 px-4 px-lg-5 pb-5 pt-4">

                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <div>
                        <h2 class="mb-1" style="font-size: 1.75rem; color: var(--navy-dark);">My Profile</h2>
                        <p class="text-muted mb-0" style="font-size: 0.95rem;">
                            <i class="fa-regular fa-user me-2 opacity-50"></i>
                            Manage your personal and professional details
                        </p>
                    </div>
                </div>

                <hr class="section-divider">

                <!-- Alert Messages -->
                <?php if(isset($_SESSION['errormsg'])){ ?>
                    <div class="alert alert-danger alert-dismissible fade show alert-custom" role="alert">
                        <i class="fa-solid fa-circle-exclamation me-2"></i>
                        <?php echo $_SESSION['errormsg']; unset($_SESSION['errormsg']);?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <?php if(isset($_SESSION['successmsg'])){ ?>
                    <div class="alert alert-success alert-dismissible fade show alert-custom" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i>
                        <?php echo $_SESSION['successmsg']; unset($_SESSION['successmsg']);?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <div class="row g-4">
                    <!-- Left Column: Profile Card & Tab Navigation -->
                    <div class="col-lg-4">
                        <div class="card profile-sidebar-card shadow-sm p-4">
                            <div class="d-flex flex-column align-items-center">
                                <!-- Avatar -->
                                <div class="profile-avatar-wrap">
                                    <img src="../media/profile_pictures/<?php echo $det['profile_picture']; ?>" alt="Profile Picture" id="profileImagePreview">
                                    <div class="profile-avatar-overlay" onclick="document.getElementById('profilePictureInput').click();">
                                        <small><i class="fas fa-camera me-1"></i> Change</small>
                                    </div>
                                </div>
                                <form id="profilePictureForm" action="../process_pages/process_agent_profile_picture.php" method="post" enctype="multipart/form-data">
                                    <input type="file" id="profilePictureInput" name="profile_picture" accept="image/png, image/jpg, image/jpeg" style="display: none;">
                                </form>
                                <p id="profilePictureMessage" class="small text-center mt-2 mb-0"></p>

                                <h5 class="mt-3 mb-0" style="color: var(--navy-dark);"><?php echo $det['first_name'] . ' ' . $det['last_name']; ?></h5>
                                <small class="text-muted"><?php echo $det['email']; ?></small>

                                <!-- Tab Navigation -->
                                <div class="w-100 mt-4 d-flex flex-column gap-2">
                                    <button class="profile-tab-link active" data-section="personal_info">
                                        <i class="fa-solid fa-house-user"></i> Personal Information
                                    </button>
                                    <button class="profile-tab-link" data-section="professional_info">
                                        <i class="fa-solid fa-briefcase"></i> Professional Information
                                    </button>
                                    <button class="profile-tab-link" data-section="identity_info">
                                        <i class="fa-solid fa-id-card"></i> Identity Verification
                                    </button>
                                    <button class="profile-tab-link" data-section="licence_info">
                                        <i class="fa-solid fa-certificate"></i> License Verification
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Form Sections -->
                    <div class="col-lg-8">
                        <form action="../process_pages/process_agent_profile_update.php" method="post" id="profileForm" enctype="multipart/form-data">

                            <!-- Personal Information -->
                            <div class="card form-section-card shadow-sm active" id="section-personal_info">
                                <h2><i class="fa-solid fa-house-user me-2 opacity-75"></i>Personal Information</h2>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control form-input" name="firstname" value="<?php echo $det['first_name']; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control form-input" name="lastname" value="<?php echo $det['last_name']; ?>">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Bio</label>
                                        <textarea class="form-control form-input" rows="4" name="bio"><?php echo $det['agent_bio']; ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" class="form-control form-input" value="<?php echo $det['email']; ?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control form-input" name="phone" value="+234 801 234 5678">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control form-input" value="123 Main St" name="address">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control form-input" value="1990-01-01" name="dob">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Location</label>
                                        <input type="text" class="form-control form-input" value="Lagos, Nigeria" name="location">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Postal Code</label>
                                        <input type="text" class="form-control form-input" value="100001" name="postal_code">
                                    </div>
                                </div>
                                <div class="d-flex gap-3 mt-4 pt-3 border-top">
                                    <button type="button" class="btn btn-navy-outline w-50" onclick="resetForm()">Discard Changes</button>
                                    <button type="button" class="btn btn-navy w-50 next-section" data-next="professional_info">Save & Continue</button>
                                </div>
                            </div>

                            <!-- Professional Information -->
                            <div class="card form-section-card shadow-sm" id="section-professional_info">
                                <h2><i class="fa-solid fa-briefcase me-2 opacity-75"></i>Professional Information</h2>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Agency Name</label>
                                        <input type="text" class="form-control form-input" name="agency_name" value="ABC Real Estate Agency">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Years of Experience</label>
                                        <input type="number" class="form-control form-input" name="years_of_experience" value="10">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">About Agency</label>
                                        <textarea class="form-control form-input" rows="4" name="about_agency">Experienced real estate agent with a passion for helping clients find their dream homes. With over 10 years in the industry, I specialize in residential properties and have a deep understanding of the local market.</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Agency Address</label>
                                        <input type="text" class="form-control form-input" name="agency_address" value="123 Main St">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Agency Location</label>
                                        <input type="text" class="form-control form-input" name="agency_location" value="Lagos, Nigeria">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Agency Postal Code</label>
                                        <input type="text" class="form-control form-input" name="agency_postal_code" value="100001">
                                    </div>
                                </div>
                                <div class="d-flex gap-3 mt-4 pt-3 border-top">
                                    <button type="button" class="btn btn-navy-outline w-50 prev-section" data-prev="personal_info">Previous</button>
                                    <button type="button" class="btn btn-navy w-50 next-section" data-next="identity_info">Save & Continue</button>
                                </div>
                            </div>

                            <!-- Identity Verification -->
                            <div class="card form-section-card shadow-sm" id="section-identity_info">
                                <h2><i class="fa-solid fa-id-card me-2 opacity-75"></i>Identity Verification</h2>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Government-issued ID</label>
                                        <select name="id_type" class="form-select form-input">
                                            <option value="">Select ID Type</option>
                                            <option value="passport">Passport</option>
                                            <option value="driver_license">Driver's License</option>
                                            <option value="national_id">National ID</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Upload Government-issued ID</label>
                                        <input type="file" name="id_file" class="form-control form-input" accept="image/png, image/jpg, image/jpeg, .pdf,.doc,.docx">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Proof of Address Type</label>
                                        <select name="proof_of_address" class="form-select form-input">
                                            <option value="">Select Document Type</option>
                                            <option value="utility_bill">Utility Bill</option>
                                            <option value="bank_statement">Bank Statement</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Upload Proof of Address</label>
                                        <input type="file" name="proof_of_address_file" class="form-control form-input" accept="image/png, image/jpg, image/jpeg, .pdf,.doc,.docx">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Selfie Verification</label>
                                        <input type="file" class="form-control form-input" name="selfie_verification" accept="image/png, image/jpg, image/jpeg">
                                        <div class="upload-hint">Upload a clear photo of your face for identity verification</div>
                                    </div>
                                </div>
                                <div class="d-flex gap-3 mt-4 pt-3 border-top">
                                    <button type="button" class="btn btn-navy-outline w-50 prev-section" data-prev="professional_info">Previous</button>
                                    <button type="button" class="btn btn-navy w-50 next-section" data-next="licence_info">Save & Continue</button>
                                </div>
                            </div>

                            <!-- License Verification -->
                            <div class="card form-section-card shadow-sm" id="section-licence_info">
                                <h2><i class="fa-solid fa-certificate me-2 opacity-75"></i>License Verification</h2>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">CAC Registration Number</label>
                                        <input type="text" name="cac" class="form-control form-input">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">CAC Certificate of Registration</label>
                                        <input type="file" name="cac_file" class="form-control form-input">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">ESVARBON Registration Number</label>
                                        <input type="text" name="ESVARBON_number" class="form-control form-input">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">ESVARBON Certificate</label>
                                        <input type="file" name="ESVARBON" class="form-control form-input">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">NIESV Membership Number</label>
                                        <input type="text" class="form-control form-input">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">NIESV Membership Certificate</label>
                                        <input type="file" class="form-control form-input">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">NAEAN Membership Number</label>
                                        <input type="text" class="form-control form-input">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">NAEAN Membership Certificate</label>
                                        <input type="file" class="form-control form-input">
                                    </div>
                                </div>
                                <div class="d-flex gap-3 mt-4 pt-3 border-top">
                                    <button type="button" class="btn btn-navy-outline w-50 prev-section" data-prev="identity_info">Previous</button>
                                    <button type="submit" class="btn btn-navy w-50" name="update_profile">
                                        <i class="fa-regular fa-floppy-disk me-1"></i> Save All Changes
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
            <!-- Main Content End -->

        </div>
    </div>

    <!-- footer -->
    <?php // include '../footer.php'; ?>

    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // ============================================
        // PROFILE IMAGE UPLOAD
        // ============================================
        function previewProfileImage(event) {
            const file = event.target.files[0];
            if (!file) return;

            if (file.size > 5 * 1024 * 1024) {
                $('#profilePictureMessage').text('File size must be less than 5MB.').css('color', 'red');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                $('#profileImagePreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);

            uploadProfilePicture(file);
        }

        function uploadProfilePicture(file) {
            const formData = new FormData();
            formData.append('profile_picture', file);

            $('#profilePictureMessage').text('Uploading...').css('color', '#6c757d');

            $.ajax({
                url: '../process_pages/process_agent_profile_picture.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#profilePictureMessage').text('Profile picture updated successfully!').css('color', 'green');
                    setTimeout(() => location.reload(), 1500);
                },
                error: function(xhr) {
                    $('#profilePictureMessage').text('Error updating profile picture.').css('color', 'red');
                    console.error('Upload error:', xhr.responseText);
                }
            });
        }

        // ============================================
        // TAB NAVIGATION
        // ============================================
        function switchToSection(sectionId) {
            // Hide all sections
            $('.form-section-card').removeClass('active');

            // Show target section
            $('#section-' + sectionId).addClass('active');

            // Update tab links
            $('.profile-tab-link').removeClass('active');
            $('.profile-tab-link[data-section="' + sectionId + '"]').addClass('active');

            // Scroll to top of form
            $('html, body').animate({ scrollTop: $('#profileForm').offset().top - 100 }, 300);
        }

        $(document).ready(function() {
            // Profile picture input change
            $('#profilePictureInput').on('change', function(e) {
                previewProfileImage(e);
            });

            // Tab link clicks
            $('.profile-tab-link').on('click', function() {
                const section = $(this).data('section');
                switchToSection(section);
            });

            // Next section buttons
            $('.next-section').on('click', function() {
                const next = $(this).data('next');
                switchToSection(next);
            });

            // Previous section buttons
            $('.prev-section').on('click', function() {
                const prev = $(this).data('prev');
                switchToSection(prev);
            });
        });

        function resetForm() {
            $('#profileForm')[0].reset();
        }
    </script>
</body>

</html>