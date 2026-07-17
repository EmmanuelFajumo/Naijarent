<?php
    session_start();
    require_once "process_pages/classes/Site.php";
    $c = new Site();

    if(!isset($_GET['id'])){
        header('location:index.php');
        exit;
    }

    if(empty($_GET['id'])){
        header("location:index.php");
        exit;
    }
    $res = $c->fetch_property_detail($_GET['id']);
    // echo "<pre>";
    // print_r($res);
    // echo "</pre>";  

    

    if(!$res){
        header("location:index.php");
    }
    require_once("process_pages/classes/Tenant.php");
    $user = new Tenant();
    if(isset($_SESSION['useronline'])){
    $user_deet = $user->fetch_user_detailby_id($_SESSION['useronline']);
    }
    if(isset($_SESSION['agent_online'])){
        $user_deet = $user->fetch_user_detailby_id($_SESSION['agent_online']);
    } 

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single Property</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="animate.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">

</head>

<body>

    <!-- Navigation -->
    <?php include 'nav.php'; ?>

    <!-- Navigation -->

    <!-- Property Details Page -->
    <div class="container section property-details-page">

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

        <!-- Gallery Section -->
        <div class="gallery-section">
            <div class="main-image-wrapper">
                <img src="uploads/property_pictures/<?php echo $res['image1'] ?>" id="pro11" class="main-image" alt="Property">
            </div>
            <div class="thumbnail-strip">
                <div class="thumb-item active" id="pro1">
                    <img src="uploads/property_pictures/<?php echo $res['image1'] ?>" alt="Thumb 1">
                </div>
                <div class="thumb-item" id="pro2">
                    <img src="media/singleproperty02.png" alt="Thumb 2">
                </div>
                <div class="thumb-item" id="pro3">
                    <img src="media/singleproperty03.png" alt="Thumb 3">
                </div>
                <div class="thumb-item" id="pro4">
                    <img src="media/singleproperty01.png" alt="Thumb 4">
                </div>
                <div class="thumb-item" id="pro5">
                    <img src="media/singleproperty01.png" alt="Thumb 5">
                </div>
                <div class="thumb-item" id="pro6">
                    <img src="media/singleproperty01.png" alt="Thumb 6">
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-lg-8">

                <!-- Property Meta Bar -->
                <div class="property-meta-bar">
                    <div class="badge-group">
                        <span class="badge-custom-featured">FEATURED</span>
                        <span class="badge-custom-rent">FOR RENT</span>
                    </div>
                    <div class="meta-stat">
                        <i class="fas fa-calendar-alt"></i>
                        <span>23 June, 2025</span>
                    </div>
                    <div class="meta-stat">
                        <i class="fas fa-eye"></i>
                        <span>203K Views</span>
                    </div>
                    <div class="action-icons">
                        <a href="#"><i class="fas fa-share-alt"></i></a>
                        <a href="#"><i class="fas fa-heart"></i></a>
                        <a href="#"><i class="fas fa-home"></i></a>
                        <a href="#"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>

                <!-- Title & Price -->
                <div class="title-price-card">
                    <h1 class="property-title"><?php echo $res['title'] ?></h1>
                    <div class="property-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?php echo $res['address'].", ".$res['LGA_name'].", ".$res['state']?></span>
                    </div>
                    <div class="property-price-lg">
                        ₦ <?php echo $res['price'] ?> <span class="price-unit">/ yr</span>
                    </div>
                </div>

                <!-- Description -->
                <div class="description-card">
                    <h3>Description</h3>
                    <p><?php echo $res['description'] ?></p>
                </div>

                <!-- Features -->
                <div class="features-card">
                    <h3>Features</h3>
                    <div class="row g-3">
                        <div class="col-md-4 col-sm-6">
                            <div class="feature-item">
                                <div class="feature-icon"><i class="fas fa-building"></i></div>
                                <div>
                                    <div class="feature-label">Type</div>
                                    <div class="feature-value"><?php echo $res['name'] ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="feature-item">
                                <div class="feature-icon"><i class="fas fa-bed"></i></div>
                                <div>
                                    <div class="feature-label">Bedrooms</div>
                                    <div class="feature-value"><?php echo $res['bedrooms'] ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="feature-item">
                                <div class="feature-icon"><i class="fas fa-bath"></i></div>
                                <div>
                                    <div class="feature-label">Bathrooms</div>
                                    <div class="feature-value"><?php echo $res['bathrooms'] ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="feature-item">
                                <div class="feature-icon"><i class="fas fa-toilet"></i></div>
                                <div>
                                    <div class="feature-label">Toilet</div>
                                    <div class="feature-value"><?php echo $res['toilet'] ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="feature-item">
                                <div class="feature-icon"><i class="fas fa-utensils"></i></div>
                                <div>
                                    <div class="feature-label">Kitchen</div>
                                    <div class="feature-value">1</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="feature-item">
                                <div class="feature-icon"><i class="fas fa-tag"></i></div>
                                <div>
                                    <div class="feature-label">Status</div>
                                    <div class="feature-value"><?php echo $res['furnished_status'] ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="feature-item">
                                <div class="feature-icon"><i class="fas fa-car"></i></div>
                                <div>
                                    <div class="feature-label">Parking Space</div>
                                    <div class="feature-value"><?php echo $res['parking_space'] == 1 ? 'Yes' : '-' ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="feature-item">
                                <div class="feature-icon"><i class="fas fa-bolt"></i></div>
                                <div>
                                    <div class="feature-label">Electricity</div>
                                    <div class="feature-value"><?php echo $res['electricity_supply'] == 1 ? 'Yes' : '-' ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="feature-item">
                                <div class="feature-icon"><i class="fas fa-tint"></i></div>
                                <div>
                                    <div class="feature-label">Water Supply</div>
                                    <div class="feature-value"><?php echo $res['water_supply'] == 1 ? 'Yes' : '-' ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="feature-item">
                                <div class="feature-icon"><i class="fas fa-shield"></i></div>
                                <div>
                                    <div class="feature-label">Security</div>
                                    <div class="feature-value"><?php echo $res['security'] == 1 ? 'Yes' : '-' ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="feature-item">
                                <div class="feature-icon"><i class="fas fa-home"></i></div>
                                <div>
                                    <div class="feature-label">Pop Ceiling</div>
                                    <div class="feature-value"><?php echo $res['pop_ceiling'] == 1 ? 'Yes' : '-' ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="feature-item">
                                <div class="feature-icon"><i class="fas fa-th"></i></div>
                                <div>
                                    <div class="feature-label">Tiled Floor</div>
                                    <div class="feature-value"><?php echo $res['tiled_floor'] == 1 ? 'Yes' : '-' ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="feature-item">
                                <div class="feature-icon"><i class="fas fa-gauge-high"></i></div>
                                <div>
                                    <div class="feature-label">Prepaid Meter</div>
                                    <div class="feature-value"><?php echo $res['prepaid_meter'] == 1 ? 'Yes' : '-' ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address / Map -->
                <div class="address-card">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h3 style="margin-bottom:0;">Address</h3>
                        <a href="register.html" class="btn-map">Open on Google Maps</a>
                    </div>
                    <div class="map-placeholder">
                        <span><i class="fas fa-map-marked-alt me-2"></i> Map will load here</span>
                    </div>
                </div>

            </div>

            <!-- Right Column - Agent Sidebar -->
            <div class="col-lg-4">
                <div class="agent-sidebar">
                    <img src="media/profile_pictures/<?php echo $res['profile_picture']; ?>" class="agent-avatar" alt="Agent Image">
                    <h4 class="agent-name"><?php echo $res['first_name']." ".$res['last_name'] ?></h4>
                    <span class="agent-verified">
                        <i class="fa-solid fa-circle-check me-1"></i> Verified
                    </span>
                    <div class="agent-stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <p class="agent-tagline">Get in touch with the agent for more information.</p>
                    <button class="btn-contact-agent mb-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                         <i class="fa-solid fa-paper-plane me-1"></i> Leave a Message
                    </button>
                    <?php 
                        if(isset($_SESSION['useronline'])){
                            $phone = $res['phone'];
                            $phone = preg_replace('/[^0-9]/', '', $phone);
                            if (substr($phone, 0, 1) === '0') {
                                $phone = '234' . substr($phone, 1);
                            } elseif (substr($phone, 0, 1) !== '234' && substr($phone, 0, 1) !== '+') {
                                $phone = '234' . $phone;
                            }
                            $wa_link = 'https://wa.me/' . $phone;

                        }
                    ?>

                    <?php if(isset($_SESSION['useronline'])){
                    ?>
                    <a href="<?= $wa_link ?>" target="_blank" class="btn-view-profile mt-3"><i class="fa-brands fa-whatsapp"></i> Chat on WhatsApp</a>

                    <?php } ?>
                    <a href="agent_profile.php?id=<?php echo $res['property_id']?>" class="btn-view-profile mt-3">View Profile</a>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer  -->
        <?php include 'footer.php'; ?>
    <!-- Footer  -->

    <!-- Chat Offcanvas -->
    <div class="offcanvas offcanvas-start chat-offcanvas" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel"><i class="fa-solid fa-comments me-2"></i>Chat with Agent</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p class="chat-property-label">Chat about <strong>Property #<?php echo $res['property_id']?></strong></p>
            <form class="col-12" method ="post" action="Process_pages/process_conversation.php" id="chat-form">
                 <input type="number" hidden id="property_id" name="property_id" value="<?php echo $res['property_id']?>">
                <input type="number" hidden id="Agent_id" name="Agent_id" value="<?php echo $res['Agent_id']; ?>">	
                <div class="col-12" id="chatbox">									
                    <div class="form-group col-12">						
                        <textarea class="input_message form-control" name='message' id='message' placeholder="Enter your message..." rows="4"></textarea>			
                    </div>						
                    <div class="form-group col-12">				
                        <input type="submit" name='send' value="Send Message" id="send" class="btn-send-chat col-12" />			
                    </div>				
                </div>	
            </form>                
        </div>
    </div>

    <script src="jquery.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script>
        $(document).ready(function(){

            $("#send").click(function(){
                var propertyId = $("#property_id").val();
                var senderId = "<?php echo isset($_SESSION['useronline']) ? $_SESSION['useronline'] : ''; ?>";
                var receiverId = $("#Agent_id").val();

                var message = $("#message").val();
                if(message === '') {
                    alert("Message cannot be empty");
                    return;
                }

                var data = {
                    message: message,
                    property_id: propertyId,
                    sender_id: senderId,
                    receiver_id: receiverId,
                    time: new Date().toLocaleTimeString()
                };
                $.ajax({
                    url: 'API/Sendmessage.php',
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        console.log('Message sent:', response);
                        alert(response);
                        $("#message").val('');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error sending message:', error);
                    }
                });
            });

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