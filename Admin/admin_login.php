<?php
    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>



    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="stylesheet" href="../fontawesome\css\all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap" rel="stylesheet">




</head>
<body>
    <!-- Navigation -->
     <?php include 'nav.php'; ?>


    <!-- Login Form -->
     <div class="container" id="loginForm">
        <div class="row py-5">
            <div class="col-md-6 offset-md-3 border px-0">
                <p class="text-left py-3 px-2" style="background-color: #F4F5F4;">Login as Admin</p>
                <form action="process_pages/process_admin_login.php" class="form p-3" id="Login" method="post">
                     <div class="mb-2">
                        <label for="user_email" class="form-label label">Admin Username</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="username" name='username'>
                            <span class="input-group-text"> <i class="fa-solid fa-envelope"></i> </span>
                        </div>
                     </div>
                     <div class="mb-2">
                        <label for="user_password" class="form-label label">Password</label>
                        <div class='input-group'>
                            <input type="password" class="form-control" id="user_password" name='password'>
                            <span class="input-group-text"> <i class="fa-solid fa-unlock"></i> </span>
                        </div>
                     </div>
                     <div class="mb-2 mt-4 d-flex flex-column">
                        <button class="btn btn-primary mb-3" type="submit" name='btn'>Sign In</button>
                    </div>
                </form>
            </div>
        </div>
     </div>

     <!-- Footer  -->
        <?php include '../footer.php'; ?>
    <!-- Footer  -->



    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
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