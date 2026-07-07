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

    require_once "process_pages/classes/ChatService.php";
    require_once "process_pages/classes/config.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single Property</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="animate.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">


    <style>
        /* font-family: "Voltaire", sans-serif; */
        /* font-family: "Inter", sans-serif; */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Voltaire", sans-serif;
        }

        body {
            font-family: "Inter", sans-serif;
        }

        body {
            background-color: #f1f1f1;
        }

        .nlink {
            margin-left: 10px;
            font-family: "Inter", sans-serif;
            text-transform: uppercase;
            font-size: 1em;
        }

        .hero {
            background-image: url("media/bg.png");
            background-size: cover;
            background-position: bottom center;
            min-height: 800px;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.4);
            min-height: inherit;
            padding: 120px 0px;
        }

        .select {
            border-radius: 0%;
        }

        .section {
            padding: 20px 0px;
        }

        .box:hover {
            background-color: white;
            transform: scale(1.02);
            transition: 0.5s;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        .icon {
            width: 20px;
            object-fit: cover;
        }

        .agent {
            background-color: #000000;
            border-radius: 30px;
            padding: 60px 40px;
        }

        .abox:hover {
            background-color: rgba(244, 245, 244, 0.2);
            transform: scale(1.02);
            transition: 0.5s;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
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


         #chat-box {
            width: 400px;
            height: 300px;
            border: 1px solid #ccc;
            overflow-y: scroll;
            padding: 10px;
            margin-bottom: 10px;
        }
        .message {
            margin: 5px 0;
            padding: 5px 10px;
            background: #f0f0f0;
            border-radius: 5px;
        }
        .message strong {
            color: #333;
        }
        .message .time {
            font-size: 11px;
            color: #888;
            margin-left: 10px;
        }
        input, button {
            padding: 8px;
            font-size: 14px;
        }
        input {
            width: 300px;
        }



        @media (max-width: 576px) {

            .agnt {
                background-color: #000000;
                border-radius: 30px;
                padding: 60px 40px;
                position: static;
                margin-top: 20px;

            }
        }
    </style>

</head>

<body>

    <!-- Navigation -->
    <?php include 'nav.php'; ?>

    <!-- Navigation -->

    <!-- Featured properties -->
    <div class="container section" style="background-color: #f1f1f1;">
        <div class="row g-2 ">
            <div class="col-md-12 ">
                <img src="uploads/property_pictures/<?php echo $res['image1'] ?>" id="pro11" class="img-fluid rounded" alt="">
                <!-- <img src="uploads/property_pictures/<?php //echo $res['image2'] ?>" id="pro12" class="img-fluid rounded" alt="">
                <img src="uploads/property_pictures/<?php //echo $res['image3'] ?>" id="pro13" class="img-fluid rounded" alt="">
                <img src="uploads/property_pictures/<?php// echo $res['image4'] ?>" id="pro14" class="img-fluid rounded" alt=""> -->
            </div>
            <div class="col-12 py-3">
                <div class="row">
                    <div class="col-sm-2">
                        <a type="botton" href="" id="pro1"> <img src="uploads/property_pictures/<?php echo $res['image1'] ?>"
                                class="img-fluid rounded" alt=""> </a>
                    </div>
                    <div class="col-md-2 ">
                        <a type="botton" href="" id="pro2"> <img src="media/singleproperty02.png"
                                class="img-fluid rounded" alt=""> </a>
                    </div>
                    <div class="col-md-2">
                        <a type="botton" href="" id="pro3"> <img src="media/singleproperty03.png"
                                class="img-fluid rounded" alt=""> </a>
                    </div>
                    <div class="col-md-2">
                        <a type="botton" href="" id="pro4"> <img src="media/singleproperty01.png"
                                class="img-fluid rounded" alt=""> </a>
                    </div>
                    <div class="col-md-2">
                        <a type="botton" href="" id="pro5"> <img src="media/singleproperty01.png"
                                class="img-fluid rounded" alt=""> </a>
                    </div>
                    <div class="col-md-2">
                        <a type="botton" href="" id="pro5"> <img src="media/singleproperty01.png"
                                class="img-fluid rounded" alt=""> </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row py-5 d-flex flex-row justify-content-between align-items-center g-5">
            <div class="col-md-8 py-3 ">
                <div class="row d-flex bg-light flex-row justify-content-between align-items-center px-3">
                    <div class="col-md-3 d-flex flex-row align-items-center g-2">
                        <span class="badge bg-info"> FEATURED</span>
                        <span class="mx-2 badge bg-primary"> FOR RENT </span>
                    </div>
                    <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center g-2 ">
                        <a href=""><i class="fas fa-calendar-alt"></i></a>
                        <p class="pt-3 px-2">23 june, 2025</p>
                    </div>
                    <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center g-2 ">
                        <a href=""><i class="fas fa-eye"></i></a>
                        <p class="pt-3 px-2">203K Views</p>
                    </div>
                    <div class="col-md-3 d-flex flex-row justify-content-between align-items-center g-2">
                        <a href=""><i class="fas fa-share-alt"></i></a>
                        <a href=""><i class="fas fa-heart"></i></a>
                        <a href=""><i class="fas fa-home"></i></a>
                        <a href=""><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
                <div class="row bg-light px-3">
                    <div class="col-12">
                        <hr class="mb-4 bg-primary" style="width: 100%; height: 3px;">
                    </div>
                    <div class="col-md-8">
                        <h2 class="label"><?php echo $res['title'] ?></h2>
                    </div>
                    <div class="col-md-4 text-left">
                        <h3 class="text-muted ms-3">₦ <?php echo $res['price'] ?></h3>
                    </div>
                    <div class="col-12 ps-2 d-flex flex-row justify-content-start align-items-center g-2">
                        <a href=""><i class="fas fa-map-marker-alt"></i></a>
                        <p class="px-3 pt-2"><?php echo $res['address'].", ".$res['LGA_name'].", ".$res['state']?></p>
                    </div>
                </div>
                <div class="row py-4 bg-light px-3">
                    <h3 class="py-3">Description</h3>
                    <p><?php echo $res['description'] ?></p>
                </div>

                <div class="row my-4 bg-light px-3">
                    <div class="col-12">
                        <h3 class="pt-3">Features</h3>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center">
                                <a href=""><i class="fas fa-bed"></i></a>
                                <p class="pt-3 ps-3">Type <br><span><?php echo $res['name'] ?></span></p>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center ">
                                <a href=""><i class="fas fa-bed"></i></a>
                                <p class="pt-3 ps-3"> Bedrooms <br><span><?php echo $res['bedrooms'] ?></span></p>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center">
                                <a href=""><i class="fas fa-bath"></i></a>
                                <p class="pt-3 ps-3">Bathrooms <br><span><?php echo $res['bathrooms'] ?></span></p>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center">
                                <a href=""><i class="fas fa-bath"></i></a>
                                <p class="pt-3 ps-3">Toilet <br><span><?php echo $res['toilet'] ?></span></p>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center">
                                <a href=""><i class="fas fa-utensils"></i></a>
                                <p class="pt-3 ps-3">Kitchen <br><span>1</span></p>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center">
                                <a href=""><i class="fas fa-utensils"></i></a>
                                <p class="pt-3 ps-3">Status <br><span><?php echo $res['furnished_status'] ?></span></p>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center ">
                                <a href=""><i class="fas fa-car"></i></a>
                                
                                    <?php 
                                        if($res['parking_space'] == 1) {

                                    ?>
                                        <p class="pt-3 ps-3">Parking Space <br><span>Yes</span></p>
                                    <?php
                                        }else{
                                    ?>
                                        <p class="pt-3 ps-3">Parking Space <br><span> - </span></p>
                                    <?php
                                        }
                                    ?>
                                
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center ">
                                <a href=""><i class="fas fa-bolt"></i></a>
                                <?php 
                                        if($res['electricity_supply'] == 1) {

                                    ?>
                                        <p class="pt-3 ps-3">Electricity Supply <br><span>Yes</span></p>
                                    <?php
                                        }else{
                                    ?>
                                        <p class="pt-3 ps-3">Electricity Supply <br><span> - </span></p>
                                    <?php
                                        }
                                    ?>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center">
                                <a href=""><i class="fas fa-tint"></i></a>
                                     <?php 
                                        if($res['water_supply'] == 1) {

                                    ?>
                                        <p class="pt-3 ps-3">Water Supply <br><span>Yes</span></p>
                                    <?php
                                        }else{
                                    ?>
                                        <p class="pt-3 ps-3">Water Supply <br><span> - </span></p>
                                    <?php
                                        }
                                    ?>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center">
                                <a href=""><i class="fas fa-tint"></i></a>
                                 <?php 
                                        if($res['security'] == 1) {

                                    ?>
                                        <p class="pt-3 ps-3">Security <br><span>Yes</span></p>
                                    <?php
                                        }else{
                                    ?>
                                        <p class="pt-3 ps-3">Security <br><span> - </span></p>
                                    <?php
                                        }
                                    ?>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center">
                                <a href=""><i class="fas fa-tint"></i></a>
                                 <?php 
                                        if($res['pop_ceiling'] == 1) {

                                    ?>
                                        <p class="pt-3 ps-3">Pop Ceiling <br><span>Yes</span></p>
                                    <?php
                                        }else{
                                    ?>
                                        <p class="pt-3 ps-3">Pop Ceiling<br><span> - </span></p>
                                    <?php
                                        }
                                    ?>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center">
                                <a href=""><i class="fas fa-tint"></i></a>
                                 <?php 
                                        if($res['tiled_floor'] == 1) {

                                    ?>
                                        <p class="pt-3 ps-3">Tiled Floor<br><span>Yes</span></p>
                                    <?php
                                        }else{
                                    ?>
                                        <p class="pt-3 ps-3">Tiled Floor<br><span> - </span></p>
                                    <?php
                                        }
                                    ?>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex flex-row align-items-center">
                                <a href=""><i class="fas fa-tint"></i></a>
                                 <?php 
                                        if($res['prepaid_meter'] == 1) {

                                    ?>
                                        <p class="pt-3 ps-3">Prepaid Meter<br><span>Yes</span></p>
                                    <?php
                                        }else{
                                    ?>
                                        <p class="pt-3 ps-3">Prepaid Meter<br><span> - </span></p>
                                    <?php
                                        }
                                    ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row my-4 bg-light p-3">
                    <div class="col-md-6 ">
                        <h3>Address</h3>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="register.html" class="btn btn-primary">Open on Google Maps</a>
                        
                    </div>
                    <div class="col-md-12 text-end">
                        <iframe src="" frameborder="0"></iframe>
                    </div>
                    
                </div>
            </div>
            <div class="col-md-3 bg-light text-center py-5 " >
                <img src="media/profile_pictures/<?php echo $res['profile_picture']; ?>" class="img-fluid rounded rounded-circle" alt="Agent Image" style="width: 100px; height: 100px; object-fit: cover;">
                <h4 class="p-1"><?php echo $res['first_name']." ".$res['last_name'] ?></h4>
                <p><span class='badge text-bg-success'> Verified</span></p>

                <div class="review d-flex flex-row align-items-center justify-content-center g-2">
                    <a href="" class="text-primary p-1"><i class="fa-solid fa-star"></i></i></a>
                    <a href="" class="text-primary p-1"><i class="fa-solid fa-star"></i></i></a>
                    <a href="" class="text-primary p-1"><i class="fa-solid fa-star"></i></i></a>
                    <a href="" class="text-primary p-1"><i class="fa-solid fa-star"></i></i></a>
                    <a href="" class="text-primary p-1"><i class="fa-solid fa-star"></i></i></a>
                </div>
                
                <p>Get in touch with the agent for more information.</p>
                <button class="col-12 btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">Send Message </button>
                <a href="confirm_payment.php?id=<?php echo $res['property_id']?>" class="btn  mt-2 col-12">View Profile<a>
               
            </div>
        </div>

    </div>

    <!-- Footer  -->
        <?php include 'footer.php'; ?>
    <!-- Footer  -->






    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Offcanvas</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
             <h1>Chat about Property #<?php echo $res['property_id']?></h1><!-- Messages Container -->
            <!-- Message Form -->
            <form class = "chat_box col-12" method ="post" action="API/Sendmessage.php" id="chat-form">
                 <input type="number" hidden id="property_id" name="property_id" value="<?php echo $res['property_id']?>">
                <input type="number" hidden id="Agent_id" name="Agent_id" value="<?php echo $res['Agent_id']; ?>">	
                <div class = "col-md-12 chat_box" id="chatbox">									
                    <br />											
                    <div class = "form-group col-12">						
                        <textarea class = "input_message form-control" name='message' id='message' placeholder = "Enter Message" rows="5"></textarea>			
                    </div>						
                    <div class = "form-group input_send_holder col-12">				
                        <input type ="submit" value = "Send" id='send' class = "btn btn-primary btn-block input_send col-12" />			
                    </div>				
                </div>	
            </form>
                
        </div>
    </div>

    <script src="jquery.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script>

        // Your Pusher credentials (public key is safe to show)
        const pusher = new Pusher('<?php echo PUSHER_APP_KEY; ?>', {
            cluster: '<?php echo PUSHER_APP_CLUSTER; ?>',
            encrypted: true
        });
        
        // Subscribe to the channel for this property
        const channelName = 'property-<?php echo $property_id; ?>';
        const channel = pusher.subscribe(channelName);
        
        // Listen for new messages
        channel.bind('new-message', function(data) {
            console.log('New message:', data);
            
            // // Add message to the chat box
            // const chatBox = document.getElementById('chat-box');
            // const messageDiv = document.createElement('div');
            // messageDiv.className = 'message';
            // messageDiv.innerHTML = `
            //     <strong>${data.user}:</strong> ${data.message}
            //     <span class="time">${data.time}</span>
            // `;
            // chatBox.appendChild(messageDiv);
            
            // // Auto-scroll to bottom
            // chatBox.scrollTop = chatBox.scrollHeight;
        });


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
                    // Clear the input field
                    alert(response);
                    $("#message").val('');

                    // Add message to the chat box
                const chatBox = $('#chat-box');
                const messageDiv = document.createElement('div');
                messageDiv.className = 'message';
                messageDiv.innerHTML = `
                    <strong>${data.user}:</strong> ${data.message}
                    <span class="time">${data.time}</span>
                `;
                chatBox.appendChild(messageDiv);
                
                // Auto-scroll to bottom
                chatBox.scrollTop = chatBox.scrollHeight;
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