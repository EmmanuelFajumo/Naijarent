<?php

session_start();
// Process registration logic here
if(isset($_POST['btn'])){
    
    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);
    
    

    if( empty($username) || empty($password)){
        echo "<h3 style='color:red;'> Go back and fill the form </h3>";
        header("location:../admin_login.php");
        exit;
    }
    
    
        include_once '../classes/Admin.php';

        $agent = new Admin(); 
        $res = $agent->login($username, $password);

        if((int)$res > 0){
            $_SESSION['admin_online'] = $res;
            header("location:../admin_dashboard.php");
            exit;
        }
        else{
           header("location:../admin_login.php");
            $_SESSION['errormsg'] = "Email or Password is incorrect";
            exit;
        }
        
}
else{
    $_SESSION['errormsg'] = "kindly fill the form to login";
    header('location:../admin_dashboard.php');
    exit;
}