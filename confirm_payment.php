<?php
    session_start();
    require_once "userguard.php";
    require_once "process_pages/classes/Site.php";
    $c = new Site();

    if(!isset($_GET['id'])){
        header('location:index.php');
        exit;
    }

    require_once("process_pages/classes/Tenant.php");
    $user = new Tenant();
    if(isset($_SESSION['useronline'])){
    $user_deet = $user->fetch_user_detailby_id($_SESSION['useronline']);
    }
    if(isset($_SESSION['agent_online'])){
        $user_deet = $user->fetch_user_detailby_id($_SESSION['agent_online']);
    } 



    if(empty($_GET['id'])){
        header("location:index.php");
        exit;
    }
    $res = $c->fetch_property_detail($_GET['id']);

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
                <!-- <img src="uploads/property_pictures/<?php echo $res['image1'] ?>" id="pro11" class="img-fluid rounded" alt=""> -->
                <!-- <img src="uploads/property_pictures/<?php //echo $res['image2'] ?>" id="pro12" class="img-fluid rounded" alt="">
                <img src="uploads/property_pictures/<?php //echo $res['image3'] ?>" id="pro13" class="img-fluid rounded" alt="">
                <img src="uploads/property_pictures/<?php// echo $res['image4'] ?>" id="pro14" class="img-fluid rounded" alt=""> -->
            </div>
            <!-- <div class="col-12 py-3">
                <div class="row">
                    <div class="col-sm-2">
                        <a type="botton" href="" id="pro1"> <img src="uploads/property_pictures/<?php// echo $res['image1'] ?>"
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
            </div> -->
        </div>

        <div class="row py-5 d-flex flex-row justify-content-between align-items-center g-5">
            <div class="col-md-8 py-3 ">
                <div class="row d-flex bg-light flex-row justify-content-between align-items-center px-3">
                    
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
                <div class="row py-4 bg-light px-5">
                    <h3 class="">Description</h3>
                    <p><?php echo $res['description'] ?></p>

                    <ul>
                        <li>AGENCY - 10% </li>
                        <li>LEGAL- 10% </li>
                        <li>CAUTION- 10%</li>
                    </ul>
                    <div class="d-flex gap-4">
                        <button type="submit" class="btn btn-outline-secondary mt-2 ">Cancel</button>
                        <form action="Process_pages/payment_process.php" method="get">
                            <input type="hidden" name="property_id" value="<?php echo $res['property_id'] ?>">
                            <button type="submit" class="btn btn-danger mt-2" name="confirm" value="confirmPayment">Yes, Confirm</button>
                        </form>
                    </div>
                </div>

                <div class='d-flex flex-row justify-content-between align-items-center g-5'>
                    
                </div>
                
            </div>
            <div class="col-md-3 bg-light text-center py-5 agnt" >
                <img src="media/q.png" class="img-fluid rounded rounded-circle" alt="Agent Image" style="width: 100px; height: 100px; object-fit: cover;">
                <h4 class="p-1"><?php echo $res['first_name']." ".$res['last_name'] ?></h4>
                <div class="review d-flex flex-row align-items-center justify-content-center g-2">
                    <a href="" class="text-primary p-1"><i class="fa-solid fa-star"></i></i></a>
                    <a href="" class="text-primary p-1"><i class="fa-solid fa-star"></i></i></a>
                    <a href="" class="text-primary p-1"><i class="fa-solid fa-star"></i></i></a>
                    <a href="" class="text-primary p-1"><i class="fa-solid fa-star"></i></i></a>
                    <a href="" class="text-primary p-1"><i class="fa-solid fa-star"></i></i></a>
                </div>
                <p>Get in touch with the agent for more information.</p>
                <form action="#">
                    <textarea name="message" id="" class="form-control" placeholder="Type your message here..."></textarea>
                    <button type="submit" class="btn btn-primary mt-2 col-12">Send Message</button>
                </form>
            </div>
        </div>

    </div>

    <!-- Footer  -->
        <?php include 'footer.php'; ?>
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