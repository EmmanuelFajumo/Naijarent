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

    <!-- Register Form -->
     
    <div class="container" id="registerForm" style="min-height: 400px;">
        <div class="row py-5">
            <div class="col-md-6 offset-md-3 border px-0">
                <?php 
                    if( isset($_SESSION['errormsg'])){
                ?>

                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <p> <?php echo  $_SESSION['errormsg']; unset($_SESSION['errormsg']); ?></p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                <?php } ?>
                <p class="text-left py-3 px-2" style="background-color: #F4F5F4;" >Create Your Account</p>
                <form action="../process_pages/process_register_agent.php" class="form p-3" method="post" id="Register" enctype='multipart/form-data'>
                     <div class="mb-2">
                        <label for="firstname" class="form-label label">First Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="firstname" name='firstname' >
                                <span class="input-group-text"><i class="fa-regular fa-address-card"></i></span>
                            </div>
                     </div>
                     <div class="mb-2">
                        <label for="lastname" class="form-label label">Last Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="lastname" name='lastname'>
                                <span class="input-group-text"><i class="fa-solid fa-address-card"></i></span>
                            </div>
                     </div>
                     <div class="mb-2">
                        <label for="email" class="form-label label">Email</label>
                            <div class="input-group">
                                <input type="email" class="form-control" id="email" name='email'>
                                <span class="input-group-text"> <i class="fa-solid fa-envelope"></i> </span>
                            </div>
                     </div>
                     <div class="mb-2">
                        <label for="phone" class="form-label label">Phone</label>
                            <div class="input-group">
                                <input type="tel" class="form-control" id="tel" name='phone'>
                                <span class="input-group-text"> <i class="fa-solid fa-envelope"></i> </span>
                            </div>
                     </div>
                     <div class="mb-2">
                        <label for="password" class="form-label label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name='password'>
                            <span class="input-group-text"> <i class="fa-solid fa-unlock"></i> </span>
                        </div>
                     </div>
                     <div class="mb-2">
                        <label for="confirmPassword" class="form-label label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirmPassword" name='c_password'>
                            <span class="input-group-text"> <i class="fa-solid fa-unlock"></i> </span>
                        </div>
                     </div>
                     <div class="row mb-2 mt-4 d-flex flex-column">
                        <!-- <div class="mb-2" >
                            <input type="file" name="profile_picture"  class='form-control' id="profile_picture" accept='image/png, image/jpg, image/jpeg'>
                        </div> -->
                        <div class="mt-4" >
                            <button class="btn btn-primary mb-3" id="registerNow" type="submit" name='btn'>Create Account</button>
                            <p class="small text-muted">By registering you accept our Terms of Use and Privacy and agree that we and our selected partners may contact you with relevant offers and services.</p>
                        </div>
                     </div>
                </form>
                <p class="text-left py-3 px-2" style="background-color: #F4F5F4;">Already have an account? <a href="#" class="text-decoration-none" id="login">Click here to sign in.</a></p>
               
            </div>
        </div>


    </div>

    <!-- Login Form -->
     <div class="container" id="loginForm">
        <div class="row py-5">
            <div class="col-md-6 offset-md-3 border px-0">
                <p class="text-left py-3 px-2" style="background-color: #F4F5F4;">Sign In to Your Account</p>
                <form action="../Process_pages/process_agent_login.php" class="form p-3" id="Login" method='post'>
                     <div class="mb-2">
                        <label for="user_email" class="form-label label">Email</label>
                        <div class="input-group">
                            <input type="email" class="form-control" id="user_email" name='agent_email' >
                            <span class="input-group-text"> <i class="fa-solid fa-envelope"></i> </span>
                        </div>
                     </div>
                     <div class="mb-2">
                        <label for="user_password" class="form-label label">Password</label>
                        <div class='input-group'>
                            <input type="password" class="form-control" id="user_password" name='agent_password'>
                            <span class="input-group-text"> <i class="fa-solid fa-unlock"></i> </span>
                        </div>
                     </div>
                     <div class="mb-2 mt-4 d-flex flex-column">
                        <button class="btn btn-primary mb-3" type="submit" name='loginbtn'>Sign In</button>
                        <p class="small text-muted">Don't have an account? <a href="#" class="text-decoration-none" id="register">Click here to register.</a></p>
                    </div>
                </form>
            </div>
        </div>
     </div>

     <!-- Footer  -->
     <?php //include '../footer.php'; ?>

    <!-- Footer  -->








    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){

            $('#loginForm').hide();
            $('#login').click(function(e){
                e.preventDefault();
                $('#loginForm').show().addClass('animate__animated animate__fadeIn');
                $('#registerForm').hide();
            })

            $('#register').click(function(e){
                e.preventDefault();
                $('#registerForm').show().addClass('animate__animated animate__fadeIn');
                $('#loginForm').hide();
            })


            $('#Register').submit(function(e){
                
                // Handle registration logic here
                var firstName = $('#firstName').val();
                var lastName = $('#lastName').val();
                var email = $('#email').val();
                var password = $('#password').val();

                if(firstName === '' || lastName === '' || email === '' || password       === '') {
                    e.preventDefault();
                    alert('Please fill in all fields');
                    
                } else {
                    alert('Registration successful!');
                }
            })

             $('#Login').submit(function(e){
                var email = $('#user_email').val();
                var password = $('#user_password').val();
                // Handle login logic here
                    if(email === '' || password === '') {
                        e.preventDefault();
                        alert('Please fill in all fields');
                    } else {
                        alert('Login successful!');
                    }
            })

            $("#loginForm").click(function(){
                
            });


        })


    </script>
</body>
</html>