<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap" rel="stylesheet">


    <style>
        /* font-family: "Voltaire", sans-serif; */
        /* font-family: "Inter", sans-serif; */
        h1, h2, h3, h4, h5, h6  {
            font-family: "Voltaire", sans-serif;
        }
            body {
                font-family: "Inter", sans-serif;
            }

        .nlink{
            margin-left:10px;
             font-family: "Inter", sans-serif;
            text-transform: uppercase;
            font-size: 1em;
        }

        .label{
            font-family: "Inter", sans-serif;
            font-size: 0.8em;
            font-weight: 400;
        }
        .footer-section {
            background: linear-gradient(135deg, #14213D, #1E3888);
            border-top-left-radius: 30px;
            border-top-right-radius: 30px;
        }

        .footer-title {
            font-weight: 600;
            margin-bottom: 20px;
            color: #ffffff;
        }

        .footer-text {
            color: rgba(255, 255, 255, 0.75);
            max-width: 500px;
            margin: auto;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            text-decoration: none;
            color: rgba(255, 255, 255, 0.75);
            transition: 0.3s ease;
        }

        .footer-links a:hover {
            color: #ffffff;
            padding-left: 5px;
        }

        .footer-line {
            border-color: rgba(255, 255, 255, 0.15);
        }

        .footer-section p {
            color: rgba(255, 255, 255, 0.75);
        }
    </style>

</head>
<body>
    <!-- Navigation -->
    <?php include 'nav.php'; ?> 

    
    <section style="background: #fff; padding:100px 0px">
        <div class="container">
            <div class="row text-light section" >
                <div class="col-md-12 text-center" >
                    <p class="text-left mb-4 " style="">ARE YOU A REGISTERED AGENT</p>
                    <h2 class="text-left mb-4 heading" style="color: #0f2557;">Reach Serious <span class='text-primary'>People</span>. Close Faster.</h2>
                    <!-- <a href="agent/agent_register.php" class="btn btn-light">Register Now - as an Agent</a> -->
                </div>
                
                <!-- <div class="col-md-12">
                    <img src="media/agentandten.png" class="img-fluid bg-light rounded rounded-circle" alt="">
                </div> -->

                <div class="col-md-4">
                    <div class=" p-5 text-center h-100 rounded " style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 20px; ">
                        <div class="step-label text-primary fw-semibold mb-3" style="font-size: 0.8rem; letter-spacing: 2px; text-transform: uppercase;">
                            Create Profile  
                        </div>
                        <div class="icon-wrapper mb-4">
                            <i class="fas fa-user fa-3x text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-3" style="font-size: 1.6rem; line-height: 1.2;"> Create Your Profile</h3>
                        <p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.7;">
                           Register as an agent, submit your verification documents, and get your verified badge.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-5 text-center h-100 rounded" style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 20px; ">
                        <div class="step-label text-primary fw-semibold mb-3" style="font-size: 0.8rem; letter-spacing: 2px; text-transform: uppercase;">
                            List Property
                        </div>
                        <div class="icon-wrapper mb-4">
                            <i class="fas fa-building fa-3x text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-3" style="font-size: 1.6rem; line-height: 1.2;">List Your Properties</h3>
                        <p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.7;">
                           Upload your properties with photos, videos, and documents. We review and approve within 48 hours.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-5 text-center h-100 rounded" style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 20px; ">
                        <div class="step-label text-primary fw-semibold mb-3" style="font-size: 0.8rem; letter-spacing: 2px; text-transform: uppercase;">
                            Earn from your Property
                        </div>
                        <div class="icon-wrapper mb-4">
                            <i class="fas fa-wallet fa-3x text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-3" style="font-size: 1.6rem; line-height: 1.2;">Earn from your Property</h3>
                        <p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.7;">
                           Receive inquiries, chat with tenants, and collect rent payments — all in one place.
                        </p>
                    </div>
                </div>

            </div>
            <!-- Plans Cards -->
            <div class="row g-4 justify-content-center py-5 section" style="padding-bottom: 30px;">
                <div class="col-md-4" style="">
                    <div class="card h-100 border-0 shadow"
                        style="border-radius: 20px; background-color: #0f2557;;
                            backdrop-filter: blur(10px);">
                        <div class="card-body p-4 d-flex flex-column">

                            <!-- Badge & Name -->
                            <div class="mb-4">
                                <span class="badge rounded-pill px-3 py-2 mb-3"
                                    style="background-color: rgba(255,255,255,0.15);
                                        font-size: 0.78em; letter-spacing: 0.5px;">
                                    FREE FOREVER
                                </span>
                                <h3 class="text-light fw-bold mb-1"
                                    style="font-family: 'Voltaire', sans-serif;">
                                    Starter
                                </h3>
                                <p style="opacity: 0.7; font-size: 0.88em; color: white;">
                                    Perfect for landlords listing their first property
                                </p>
                            </div>

                            <!-- Price --> 
                            <div class="mb-4 pb-4 border-bottom"
                                style="border-color: rgba(255,255,255,0.15) !important;">
                                <div class="d-flex align-items-end gap-1">
                                    <span class="fw-bold text-light"
                                        style="font-size: 2.8em; line-height: 1;">
                                        ₦0
                                    </span>
                                    <span style="opacity: 0.6; font-size: 0.9em;
                                                color: white; margin-bottom: 6px;">
                                        / month
                                    </span>
                                </div>
                                <small style="opacity: 0.6; color: white;">
                                    No credit card required
                                </small>
                            </div>

                            <!-- Features -->
                            <ul class="list-unstyled mb-4 flex-grow-1" style="font-size: 0.9em;">
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-check mt-1 flex-shrink-0"
                                        style="color: #69db7c;"></i>
                                    <span class="text-light">1 active listing at a time</span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-check mt-1 flex-shrink-0"
                                        style="color: #69db7c;"></i>
                                    <span class="text-light">Up to 5 photos per listing</span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-check mt-1 flex-shrink-0"
                                        style="color: #69db7c;"></i>
                                    <span class="text-light">In-app messaging with tenants</span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-check mt-1 flex-shrink-0"
                                        style="color: #69db7c;"></i>
                                    <span class="text-light">NaijaRent verified badge</span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-check mt-1 flex-shrink-0"
                                        style="color: #69db7c;"></i>
                                    <span class="text-light">Basic agent profile page</span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-xmark mt-1 flex-shrink-0"
                                        style="color: rgba(255,255,255,0.2);"></i>
                                    <span style="opacity: 0.35; color: white;">Video walkthrough upload</span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-xmark mt-1 flex-shrink-0"
                                        style="color: rgba(255,255,255,0.2);"></i>
                                    <span style="opacity: 0.35; color: white;">Analytics & performance</span>
                                </li>
                                <li class="d-flex align-items-start gap-2">
                                    <i class="fa-solid fa-circle-xmark mt-1 flex-shrink-0"
                                        style="color: rgba(255,255,255,0.2);"></i>
                                    <span style="opacity: 0.35; color: white;">Payment collection</span>
                                </li>
                            </ul>

                            <!-- CTA -->
                            <div>
                                <a href="agent_register.php"
                                    class="btn btn-outline-light w-100 rounded-pill py-3 fw-medium">
                                    Get Started Free
                                    <i class="fa-solid fa-arrow-right ms-2"></i>
                                </a>
                                <p class="text-center mt-2 mb-0"
                                    style="font-size: 0.78em; opacity: 0.5; color: white;">
                                    No credit card required
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
                
                <div class="col-md-4" style="margin-top: -16px;">
                    <div class="card h-100 border-0 shadow-lg position-relative"
                        style="border-radius: 20px; background-color: white;">

                        <!-- Most Popular Badge -->
                        <div class="position-absolute w-100 text-center" style="top: -14px; z-index: 1;">
                            <span class="badge rounded-pill px-4 py-2 shadow"
                                style="background-color: #f59f00; color: #212529;
                                    font-size: 0.82em; font-weight: 600;">
                                ⭐ Most Popular
                            </span>
                        </div>

                        <div class="card-body p-4 d-flex flex-column">

                            <!-- Badge & Name -->
                            <div class="mb-4 mt-2">
                                <span class="badge rounded-pill px-3 py-2 mb-3"
                                    style="background-color: #e8f0fe; color: #1E3888;
                                        font-size: 0.78em; letter-spacing: 0.5px;">
                                    PRO PLAN
                                </span>
                                <h3 class="fw-bold mb-1"
                                    style="font-family: 'Voltaire', sans-serif; color: #1E3888;">
                                    Pro
                                </h3>
                                <p class="text-muted mb-0" style="font-size: 0.88em;">
                                    For serious agents who want more listings and more reach
                                </p>
                            </div>

                            <!-- Price -->
                            <div class="mb-4 pb-4 border-bottom">
                                <div class="d-flex align-items-end gap-1">
                                    <span class="fw-bold" id="proPrice"
                                        style="font-size: 2.8em; line-height: 1; color: #1E3888;">
                                        ₦5,000
                                    </span>
                                    <span class="text-muted mb-2" style="font-size: 0.9em;"
                                        id="proPeriod">
                                        / month
                                    </span>
                                </div>
                                <small class="text-success fw-medium d-block" id="proSavings"></small>
                            </div>

                            <!-- Features -->
                            <ul class="list-unstyled mb-4 flex-grow-1"
                                style="font-size: 0.9em; color: #444;">
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-check mt-1 text-success flex-shrink-0"></i>
                                    <span>Up to <strong>10 active listings</strong></span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-check mt-1 text-success flex-shrink-0"></i>
                                    <span>Up to <strong>15 photos</strong> per listing</span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-check mt-1 text-success flex-shrink-0"></i>
                                    <span><strong>Video walkthrough</strong> (2 per listing)</span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-check mt-1 text-success flex-shrink-0"></i>
                                    <span>In-app messaging with tenants</span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-check mt-1 text-success flex-shrink-0"></i>
                                    <span><strong>Full analytics</strong> dashboard</span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-check mt-1 text-success flex-shrink-0"></i>
                                    <span>Priority verification <strong>(24hrs)</strong></span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-check mt-1 text-success flex-shrink-0"></i>
                                    <span><strong>Paystack</strong> payment collection</span>
                                </li>
                                <li class="d-flex align-items-start gap-2">
                                    <i class="fa-solid fa-circle-check mt-1 text-success flex-shrink-0"></i>
                                    <span>Promote listings <strong>(2x per month)</strong></span>
                                </li>
                            </ul>

                            <!-- CTA -->
                            <div>
                                <a href="register_agent.php?plan=pro"
                                    class="btn w-100 rounded-pill py-3 fw-medium text-light"
                                    style="background-color: #1E3888;">
                                    Start Pro Plan
                                    <i class="fa-solid fa-arrow-right ms-2"></i>
                                </a>
                                <p class="text-center mt-2 mb-0 text-muted"
                                    style="font-size: 0.78em;">
                                    7-day free trial · Cancel anytime
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow"
                        style="border-radius: 20px; background-color: #0f2557;">
                        <div class="card-body p-4 d-flex flex-column">

                            <!-- Badge & Name -->
                            <div class="mb-4">
                                <span class="badge rounded-pill px-3 py-2 mb-3"
                                    style="background-color: rgba(255,215,0,0.2);
                                        color: #ffd700; font-size: 0.78em; letter-spacing: 0.5px;">
                                    🏆 BEST VALUE
                                </span>
                                <h3 class="text-light fw-bold mb-1"
                                    style="font-family: 'Voltaire', sans-serif;">
                                    Agency
                                </h3>
                                <p style="opacity: 0.7; font-size: 0.88em; color: white;">
                                    For agencies and landlords with large portfolios
                                </p>
                            </div>

                            <!-- Price -->
                            <div class="mb-4 pb-4 border-bottom"
                                style="border-color: rgba(255,255,255,0.15) !important;">
                                <div class="d-flex align-items-end gap-1">
                                    <span class="fw-bold text-light" id="agencyPrice"
                                        style="font-size: 2.8em; line-height: 1;">
                                        ₦15,000
                                    </span>
                                    <span style="opacity: 0.6; font-size: 0.9em;
                                                color: white; margin-bottom: 6px;"
                                        id="agencyPeriod">
                                        / month
                                    </span>
                                </div>
                                <small style="color: #69db7c; font-weight: 500;"
                                    id="agencySavings"></small>
                            </div>

                            <!-- Features -->
                            <ul class="list-unstyled mb-4 flex-grow-1" style="font-size: 0.9em;">
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-check mt-1 flex-shrink-0"
                                        style="color: #ffd700;"></i>
                                    <span class="text-light"><strong>Unlimited</strong> active listings</span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-check mt-1 flex-shrink-0"
                                        style="color: #ffd700;"></i>
                                    <span class="text-light">Up to <strong>30 photos</strong> per listing</span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-check mt-1 flex-shrink-0"
                                        style="color: #ffd700;"></i>
                                    <span class="text-light"><strong>Unlimited</strong> video walkthroughs</span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-check mt-1 flex-shrink-0"
                                        style="color: #ffd700;"></i>
                                    <span class="text-light">Advanced analytics & revenue tracking</span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-check mt-1 flex-shrink-0"
                                        style="color: #ffd700;"></i>
                                    <span class="text-light">Fastest verification <strong>(6hrs)</strong></span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-check mt-1 flex-shrink-0"
                                        style="color: #ffd700;"></i>
                                    <span class="text-light"><strong>Featured</strong> on NaijaRent homepage</span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-check mt-1 flex-shrink-0"
                                        style="color: #ffd700;"></i>
                                    <span class="text-light">Bulk listing upload via CSV</span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fa-solid fa-circle-check mt-1 flex-shrink-0"
                                        style="color: #ffd700;"></i>
                                    <span class="text-light">Multiple <strong>team members</strong></span>
                                </li>
                                <li class="d-flex align-items-start gap-2">
                                    <i class="fa-solid fa-circle-check mt-1 flex-shrink-0"
                                        style="color: #ffd700;"></i>
                                    <span class="text-light">Dedicated <strong>account manager</strong></span>
                                </li>
                            </ul>

                            <!-- CTA -->
                            <div>
                                <a href="register_agent.php?plan=agency"
                                    class="btn w-100 rounded-pill py-3 fw-medium"
                                    style="background-color: #ffd700; color: #0f2557;">
                                    Start Agency Plan
                                    <i class="fa-solid fa-arrow-right ms-2"></i>
                                </a>
                                <p class="text-center mt-2 mb-0"
                                    style="font-size: 0.78em; opacity: 0.55; color: white;">
                                    Includes onboarding call with our team
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
    
        </div>
    </section>

     <!-- Footer  -->
     <?php include '../footer.php'; ?>

    <!-- Footer  -->








    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    
</body>
</html>