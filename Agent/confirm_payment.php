<?php
    session_start();
    require_once "agentguard.php";
    require_once "../process_pages/classes/Agent.php";

    $agent = new Agent();
    $det = $agent->fetch_agent_details($_SESSION['agent_online']);

    require_once "../process_pages/classes/Site.php";
    $c = new Site();

    if(!isset($_GET['property_id'])){
        header('location:agent_dashboard_listings.php');
        exit;
    }

    if(empty($_GET['property_id'])){
        header("location:agent_dashboard_listings.php");
        exit;
    }

    $property_id = intval($_GET['property_id']);
    $res = $c->fetch_property_detail($property_id);

    if(!$res){
        header("location:index.php");
    }
    
//     echo "<pre>";
//     print_r($res);
//     echo "</pre>";
// ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">


        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f4f6fa;
            }
            .payment-card {
                background: #ffffff;
                border-radius: 16px;
                border: none;
                box-shadow: 0 10px 30px rgba(20, 33, 61, 0.05);
                transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
                overflow: hidden;
            }
            .payment-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 15px 35px rgba(20, 33, 61, 0.1);
            }
            .featured-badge {
                background: linear-gradient(135deg, #FFD700, #FFA500);
                color: #14213D;
                font-weight: 700;
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 1.5px;
                padding: 6px 16px;
                border-radius: 30px;
                display: inline-flex;
                align-items: center;
                box-shadow: 0 4px 10px rgba(255, 165, 0, 0.2);
            }
            .benefit-item {
                display: flex;
                align-items: flex-start;
                margin-bottom: 20px;
            }
            .benefit-icon {
                background: linear-gradient(135deg, rgba(30, 56, 136, 0.1), rgba(20, 33, 61, 0.05));
                color: #1E3888;
                width: 38px;
                height: 38px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 15px;
                flex-shrink: 0;
                font-size: 1.1rem;
            }
            .btn-pay {
                background: linear-gradient(135deg, #1E3888, #14213D);
                color: white;
                border: none;
                font-weight: 600;
                padding: 14px 28px;
                border-radius: 12px;
                transition: all 0.3s ease;
                letter-spacing: 0.5px;
            }
            .btn-pay:hover {
                background: linear-gradient(135deg, #14213D, #1E3888);
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(30, 56, 136, 0.3);
            }
            .btn-cancel {
                border: 1px solid #e2e8f0;
                background: #ffffff;
                color: #64748b;
                font-weight: 600;
                padding: 14px 28px;
                border-radius: 12px;
                transition: all 0.3s;
            }
            .btn-cancel:hover {
                background: #f8fafc;
                color: #334155;
                border-color: #cbd5e1;
            }
            .checkout-summary {
                background: #f8fafc;
                border-radius: 12px;
                padding: 20px;
                border: 1px solid #f1f5f9;
            }
            .premium-alert {
                background-color: rgba(30, 56, 136, 0.03);
                border-left: 4px solid #1E3888;
                border-radius: 0 12px 12px 0;
                padding: 16px;
                color: #334155;
            }
            .property-img-container {
                position: relative;
                overflow: hidden;
                border-radius: 12px;
                height: 200px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            }
            .property-img-container img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.5s ease;
            }
            .property-card-hover:hover .property-img-container img {
                transform: scale(1.05);
            }
        </style>
    

</head>

<body>
    <!-- Navigation -->
     <?php // require_once 'nav.php'; ?>

     <div class="container-fluid" style="min-height: 900px;">
        <div class="row">

            <!-- Sidebar (Profile and Navigation) -->
            <?php include 'agent_nav.php'; ?>
            <div class="col-md-10 px-5 pb-5 pt-4">
                <div class="container-fluid py-2">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <h2 class="fw-bold" style="color: #14213D; font-family: 'Voltaire', sans-serif; letter-spacing: 0.5px;">Feature Property Listing</h2>
                            <p class="text-muted mb-0">Feature your listing on the home page to gain maximum visibility and attract clients faster.</p>
                        </div>
                        <div>
                            <a href="agent_dashboard_listings.php" class="btn btn-sm btn-cancel px-3 py-2"><i class="fas fa-arrow-left me-2"></i>Back to Listings</a>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- Left Column: Details & Benefits -->
                        <div class="col-lg-7">
                            <!-- Property Preview Card -->
                            <div class="card payment-card p-3 mb-4 property-card-hover">
                                <h5 class="fw-bold mb-3" style="color: #14213D;"><i class="fas fa-building text-primary me-2"></i>Selected Property</h5>
                                <div class="row g-3">
                                    <div class="col-md-5">
                                        <div class="property-img-container">
                                            <?php if (!empty($res['image1']) && file_exists("../uploads/property_pictures/".$res['image1'])): ?>
                                                <img src="../uploads/property_pictures/<?php echo $res['image1']; ?>" alt="<?php echo htmlspecialchars($res['title']); ?>">
                                            <?php else: ?>
                                                <div class="h-100 w-100 bg-secondary d-flex align-items-center justify-content-center text-white">
                                                    <i class="fas fa-image fa-3x"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-7 d-flex flex-column justify-content-between">
                                        <div>
                                            <span class="badge mb-2" style="background-color: rgba(30, 56, 136, 0.1); color: #1E3888; font-weight: 600; font-size: 0.8rem;"><?php echo htmlspecialchars($res['name']); ?></span>
                                            <h4 class="fw-bold mb-2" style="color: #14213D;"><?php echo htmlspecialchars($res['title']); ?></h4>
                                            <p class="text-muted mb-3" style="font-size: 0.9rem;"><i class="fas fa-map-marker-alt text-danger me-2"></i><?php echo htmlspecialchars($res['address'].", ".$res['LGA_name'].", ".$res['state']); ?></p>
                                        </div>
                                        <p class="text-secondary small mb-0 text-truncate-3" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5;"><?php echo htmlspecialchars($res['description']); ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Benefits List -->
                            <div class="card payment-card p-4">
                                <h5 class="fw-bold mb-4" style="color: #14213D;"><i class="fas fa-chart-line text-primary me-2"></i>Why Feature Your Listing?</h5>
                                
                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="fas fa-eye text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1" style="color: #14213D;">Maximum Visibility</h6>
                                        <p class="text-muted small mb-0">Featured listings are pinned to the top of the homepage, getting up to 10x more clicks and views from active house hunters.</p>
                                    </div>
                                </div>
                                
                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="fas fa-award text-warning"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1" style="color: #14213D;">Premium Badging</h6>
                                        <p class="text-muted small mb-0">A visually striking "Featured" badge is placed on your listing, building trust and attracting serious leads immediately.</p>
                                    </div>
                                </div>
                                
                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="fas fa-rocket text-success"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1" style="color: #14213D;">Faster Placement</h6>
                                        <p class="text-muted small mb-0">Properties featured on the homepage close up to 3 times faster than standard listings because of high lead generation.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Checkout Summary & Form -->
                        <div class="col-lg-5">
                            <div class="card payment-card p-4 h-100 d-flex flex-column justify-content-between" style="border-top: 4px solid #1E3888 !important;">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="featured-badge"><i class="fas fa-star me-2 animate__animated animate__pulse animate__infinite"></i>Featured Listing</span>
                                        <span class="text-muted small">ID: #<?php echo $res['property_id']; ?></span>
                                    </div>
                                    <h4 class="fw-bold mb-4" style="color: #14213D;">Checkout Summary</h4>
                                    
                                    <div class="checkout-summary mb-4">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted small">Service</span>
                                            <span class="fw-semibold small" style="color: #14213D;">Home Page Promotion</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted small">Duration</span>
                                            <span class="fw-semibold small text-success">Until Deactivated</span>
                                        </div>
                                        <hr class="my-2" style="border-top: 1px dashed #cbd5e1;">
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <span class="fw-bold" style="color: #14213D;">Total Amount:</span>
                                            <div class="text-end">
                                                <h3 class="fw-bold mb-0 text-primary" style="letter-spacing: -0.5px;">₦ 30,000.00</h3>
                                                <span class="text-muted small" style="font-size: 0.75rem;">(VAT Inclusive)</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="premium-alert mb-4">
                                        <div class="d-flex gap-2">
                                            <i class="fas fa-shield-alt text-primary mt-1"></i>
                                            <div>
                                                <h6 class="fw-bold mb-1" style="color: #14213D; font-size: 0.9rem;">Payment Confirmation</h6>
                                                <p class="small text-secondary mb-0">Please confirm that you are about to pay <strong>₦ 30,000</strong> to feature your listing on the home page.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-auto">
                                    <form action="../Process_pages/payment_process.php" method="get" class="mb-2">
                                        <input type="hidden" name="property_id" value="<?php echo $res['property_id'] ?>">
                                        <button type="submit" class="btn btn-pay w-100 py-3" name="confirm" value="confirmPayment">
                                            <i class="fas fa-lock me-2"></i>Yes, Confirm and Pay ₦30,000
                                        </button>
                                    </form>
                                    <a href="agent_dashboard_listings.php" class="btn btn-cancel w-100 py-3 d-block text-center text-decoration-none">
                                        Cancel & Go Back
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <!-- Main Content End-->
        </div> 
    </div>

        

    <!-- Footer  -->
        <?php //include 'footer.php'; ?>
    <!-- Footer  -->

    <script src="jquery.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
       $(document).ready(function(){
        $('#pro12').hide();
        $('#pro13').hide();
        $('#pro14').hide();

        $('#pro1').click(function(){  
            $('#pro12').hide();
            $('#pro13').hide();
            $('#pro14').hide();
            $('#pro11').show().addClass('animate__animated animate__fadeIn');
        })

        $('#pro2').click(function(){        
            $('#pro11').hide();
            $('#pro13').hide();
            $('#pro14').hide();
            $('#pro12').show().addClass('animate__animated animate__fadeIn');
        })

         $('#pro3').click(function(){
            $('#pro11').hide();
            $('#pro12').hide();
            $('#pro14').hide();
             $('#pro13').show().addClass('animate__animated animate__fadeIn');
        })

         $('#pro4').click(function(){
           
            $('#pro11').hide();
            $('#pro12').hide();
            $('#pro13').hide();
             $('#pro14').show().addClass('animate__animated animate__fadeIn');
        })

       })


    </script>
</body>

</html>