<?php
session_start();

if(isset($_POST['btn'])){
    $email = htmlentities($_POST['user_email']);
    $password = htmlentities($_POST['user_password']);

    if( empty($email) || empty($password)){
        $_SESSION['errormsg'] = "Go back and fill the form";
        header("location:../login.php");
        exit;
    }

    include_once 'classes/Tenant.php';

    $tenant = new Tenant();
    $res = $tenant->login($email, $password);

    if((int)$res > 0){
        $userData = $tenant->fetch_user_detailby_id($res);
        $_SESSION['useronline'] = $res;
        $_SESSION['user_id'] = $res;
        $_SESSION['user_type'] = 'tenant';
        if ($userData) {
            $_SESSION['user_name'] = trim(($userData['first_name'] ?? '') . ' ' . ($userData['last_name'] ?? ''));
        }
        header("location:../tenant_dashboard.php");
        exit;
    }
    else{
        $_SESSION['errormsg'] = "Email or Password is incorrect";
        header("location:../login.php");
        exit;
    }
}
else{
    echo "Go back to where you are coming from";
}
