<?php
session_start();

if(isset($_POST['btn'])){
    $email = $_POST['user_email'];
    $password = $_POST['user_password'];

    header("location:tenant_dashboard.php");

    // if(empty($email) || empty($password)){
    //     echo "<h2> Go back and fill the form </h2>";
    //     exit;
    // }
    
    
}
else{
    echo "Go back to where you are coming from";
}
