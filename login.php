<?php
    session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="animate.min.css">
    <link rel="stylesheet" href="fontawesome\css\all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="style.css">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap" rel="stylesheet">



</head>
<body>
    <!-- Navigation -->
    <?php include 'nav.php'; ?>

    <!-- Register Form -->
    <div class="container" id="registerForm" style="min-height: 400px;">
        <div class="row py-5">
            <div class="col-md-6 offset-md-3 border px-0">
                <p class="text-left py-3 px-2" style="background-color: #F4F5F4;">Create Your Account</p>
                
                <!-- Account Type Tabs -->
                <div class="d-flex border-bottom mb-3 px-3">
                    <button class="btn btn-sm px-4 py-2 tab-btn active-tab" data-target="tenantRegister" style="border: none; background: none; font-weight: 600; color: #1E3888; border-bottom: 3px solid #1E3888; border-radius: 0;">Tenant</button>
                    <button class="btn btn-sm px-4 py-2 tab-btn" data-target="agentRegister" style="border: none; background: none; font-weight: 600; color: #666; border-radius: 0;">Agent</button>
                </div>

                <!-- Tenant Registration Form -->
                <form action="process_pages/process_register.php" class="form p-3" method="post" id="tenantRegisterForm">
                     <div class="mb-2">
                        <label for="firstname" class="form-label label">First Name</label>
                            <div class="input-group">
                                <input type="text" name='firstname' class="form-control" id="firstname" >
                                <span class="input-group-text"><i class="fa-regular fa-address-card"></i></span>
                            </div>
                     </div>
                     <div class="mb-2">
                        <label for="lastname" class="form-label label">Last Name</label>
                            <div class="input-group">
                                <input type="text" name='lastname' class="form-control" id="lastname" >
                                <span class="input-group-text"><i class="fa-solid fa-address-card"></i></span>
                            </div>
                     </div>
                     <div class="mb-2">
                        <label for="email" class="form-label label">Email</label>
                            <div class="input-group">
                                <input type="email" name='email' class="form-control" id="email" >
                                <span class="input-group-text"> <i class="fa-solid fa-envelope"></i> </span>
                            </div>
                     </div>
                     <div class="mb-2">
                        <label for="phone" class="form-label label">Phone</label>
                            <div class="input-group">
                                <input type="tel" class="form-control" id="tel" name='phone'>
                                <span class="input-group-text"> <i class="fa-solid fa-phone"></i> </span>
                            </div>
                     </div>
                     <div class="mb-2">
                        <label for="password" class="form-label label">Password</label>
                        <div class="input-group">
                            <input type="password" name='password' class="form-control" id="password" >
                            <span class="input-group-text"> <i class="fa-solid fa-unlock"></i> </span>
                        </div>
                     </div>
                     <div class="mb-2">
                        <label for="confirmPassword" class="form-label label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" name='c_password' class="form-control" id="confirmPassword" >
                            <span class="input-group-text"> <i class="fa-solid fa-unlock"></i> </span>
                        </div>
                     </div>
                     <div class="row mb-2 mt-4 d-flex flex-column">
                        <div class="mt-4" >
                            <button class="btn btn-primary mb-3" id="registerNow" type="submit" name='btn'>Create Account</button>
                            <p class="small text-muted">By registering you accept our Terms of Use and Privacy and agree that we and our selected partners may contact you with relevant offers and services.</p>
                        </div>
                     </div>
                </form>

                <!-- Agent Registration Form -->
                <form action="process_pages/process_register_agent.php" class="form p-3" method="post" id="agentRegisterForm" style="display: none;">
                     <div class="mb-2">
                        <label for="agent_firstname" class="form-label label">First Name</label>
                            <div class="input-group">
                                <input type="text" name='firstname' class="form-control" id="agent_firstname" >
                                <span class="input-group-text"><i class="fa-regular fa-address-card"></i></span>
                            </div>
                     </div>
                     <div class="mb-2">
                        <label for="agent_lastname" class="form-label label">Last Name</label>
                            <div class="input-group">
                                <input type="text" name='lastname' class="form-control" id="agent_lastname" >
                                <span class="input-group-text"><i class="fa-solid fa-address-card"></i></span>
                            </div>
                     </div>
                     <div class="mb-2">
                        <label for="agent_email" class="form-label label">Email</label>
                            <div class="input-group">
                                <input type="email" name='email' class="form-control" id="agent_email" >
                                <span class="input-group-text"> <i class="fa-solid fa-envelope"></i> </span>
                            </div>
                     </div>
                     <div class="mb-2">
                        <label for="agent_phone" class="form-label label">Phone</label>
                            <div class="input-group">
                                <input type="tel" class="form-control" id="agent_phone" name='phone'>
                                <span class="input-group-text"> <i class="fa-solid fa-phone"></i> </span>
                            </div>
                     </div>
                     <div class="mb-2">
                        <label for="agent_password" class="form-label label">Password</label>
                        <div class="input-group">
                            <input type="password" name='password' class="form-control" id="agent_password" >
                            <span class="input-group-text"> <i class="fa-solid fa-unlock"></i> </span>
                        </div>
                     </div>
                     <div class="mb-2">
                        <label for="agent_confirmPassword" class="form-label label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" name='c_password' class="form-control" id="agent_confirmPassword" >
                            <span class="input-group-text"> <i class="fa-solid fa-unlock"></i> </span>
                        </div>
                     </div>
                     <div class="row mb-2 mt-4 d-flex flex-column">
                        <div class="mt-4" >
                            <button class="btn btn-primary mb-3" type="submit" name='btn'>Create Account</button>
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

                <!-- Account Type Tabs -->
                <div class="d-flex border-bottom mb-3 px-3">
                    <button class="btn btn-sm px-4 py-2 tab-btn active-tab" data-target="tenantLogin" style="border: none; background: none; font-weight: 600; color: #1E3888; border-bottom: 3px solid #1E3888; border-radius: 0;">Tenant</button>
                    <button class="btn btn-sm px-4 py-2 tab-btn" data-target="agentLogin" style="border: none; background: none; font-weight: 600; color: #666; border-radius: 0;">Agent</button>
                </div>

                <!-- Tenant Login Form -->
                <form action="process_pages/process_login.php" class="form p-3" id="tenantLoginForm" method='post'>
                    <?php
                        if(isset($_SESSION['errormsg'])){
                    ?>

                    <div class='alert alert-danger mb-2 alert-dismissible fade show' role='alert'>
                            <?php echo $_SESSION['errormsg'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    
                    <?php
                            } unset($_SESSION['errormsg']);
                    ?>
                     <div class="mb-2">
                        <label for="user_email" class="form-label label">Email</label>
                        <div class="input-group">
                            <input type="email" class="form-control" id="user_email" name="user_email" >
                            <span class="input-group-text"> <i class="fa-solid fa-envelope"></i> </span>
                        </div>
                     </div>
                     <div class="mb-2">
                        <label for="user_password" class="form-label label">Password</label>
                        <div class='input-group'>
                            <input type="password" class="form-control" id="user_password" name="user_password">
                            <span class="input-group-text"> <i class="fa-solid fa-unlock"></i> </span>
                        </div>
                     </div>
                     <div class="mb-2 mt-4 d-flex flex-column">
                        <button class="btn btn-primary mb-3" type="submit" name="btn" >Sign In</button>
                        <p class="small text-muted">Don't have an account? <a href="#" class="text-decoration-none" id="register">Click here to register.</a></p>
                    </div>
                </form>

                <!-- Agent Login Form -->
                <form action="process_pages/process_agent_login.php" class="form p-3" id="agentLoginForm" method='post' style="display: none;">
                    <?php
                        if(isset($_SESSION['errormsg'])){
                    ?>

                    <div class='alert alert-danger mb-2 alert-dismissible fade show' role='alert'>
                            <?php echo $_SESSION['errormsg'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    
                    <?php
                            } unset($_SESSION['errormsg']);
                    ?>
                     <div class="mb-2">
                        <label for="agent_email" class="form-label label">Email</label>
                        <div class="input-group">
                            <input type="email" class="form-control" id="agent_email" name="agent_email" >
                            <span class="input-group-text"> <i class="fa-solid fa-envelope"></i> </span>
                        </div>
                     </div>
                     <div class="mb-2">
                        <label for="agent_password" class="form-label label">Password</label>
                        <div class='input-group'>
                            <input type="password" class="form-control" id="agent_password" name="agent_password">
                            <span class="input-group-text"> <i class="fa-solid fa-unlock"></i> </span>
                        </div>
                     </div>
                     <div class="mb-2 mt-4 d-flex flex-column">
                        <button class="btn btn-primary mb-3" type="submit" name="loginbtn" >Sign In</button>
                        <p class="small text-muted">Don't have an account? <a href="#" class="text-decoration-none" id="register">Click here to register.</a></p>
                    </div>
                </form>
            </div>
        </div>
     </div>

     <!-- Footer  -->
         <?php include 'footer.php'; ?>
    <!-- Footer  -->



    <script src="jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){

            $('#registerForm').hide();
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

            // Tab switching for register forms
            $('#registerForm .tab-btn').click(function(){
                var target = $(this).data('target');
                $('#registerForm .tab-btn').css({'color': '#666', 'border-bottom': '3px solid transparent'});
                $(this).css({'color': '#1E3888', 'border-bottom': '3px solid #1E3888'});
                if(target === 'tenantRegister'){
                    $('#tenantRegisterForm').show();
                    $('#agentRegisterForm').hide();
                } else {
                    $('#tenantRegisterForm').hide();
                    $('#agentRegisterForm').show();
                }
            });

            // Tab switching for login forms
            $('#loginForm .tab-btn').click(function(){
                var target = $(this).data('target');
                $('#loginForm .tab-btn').css({'color': '#666', 'border-bottom': '3px solid transparent'});
                $(this).css({'color': '#1E3888', 'border-bottom': '3px solid #1E3888'});
                if(target === 'tenantLogin'){
                    $('#tenantLoginForm').show();
                    $('#agentLoginForm').hide();
                } else {
                    $('#tenantLoginForm').hide();
                    $('#agentLoginForm').show();
                }
            });


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
                        alert('Please fill in all fields');
                        e.preventDefault();
                    } else {
                        alert('Login successful!');
                    }
        })

    })
    </script>
</body>
</html>