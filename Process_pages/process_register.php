<?php

session_start();
// Process registration logic here`
if(isset($_POST['btn'])){
    $firstname = htmlentities($_POST['firstname']);
    $lastname = htmlentities($_POST['lastname']);
    $email = htmlentities($_POST['email']);
    $phone = htmlentities($_POST['phone']);
    $password = htmlentities($_POST['password']);
    $cpassword = htmlentities($_POST['c_password']);    

    if(empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($phone) || empty($cpassword) ){
        $_SESSION['errormsg'] = "All fields are required";
        header("location:../register.php");
        exit;
    }
    
     
        include_once 'classes/Tenant.php';

        $user = new Tenant();
        $newUser = $user->register_tenant($firstname, $lastname, $email, $password, $phone);
        if($newUser == false){
            $_SESSION['errormsg'] = "Registeration failed, please try again";
            exit;
        }

        $_SESSION['useronline'] = $newUser;
        $_SESSION['user_id'] = $newUser;
        $_SESSION['user_type'] = 'tenant';
        $_SESSION['user_name'] = trim($firstname . ' ' . $lastname);
        header("location:../index.php");
        // echo "Tenant data saved, successfully";
        include_once "classes/Registaration.php";
            
            $name = $firstname . ' ' . $lastname;
            $recipient_email = $email;
            $recipient_name = $name;
            $subject = "Account Creation Successfull";
            $body = "You have successfully created your account";


            $message = new Message();
            $message->welcome($recipient_email, $recipient_name, $subject, $body);
        
        
}
else{
    $_SESSION['errormsg'] = "kindly fill the form to register";
    header("location:../register.php");
    exit;
}

?>