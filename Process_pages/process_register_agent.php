<?php
session_start();
// Process registration logic here
if(isset($_POST['btn'])){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $cpassword = $_POST['c_password'];

    // $name = $_FILES['profile_picture']['name'];
    // $tmp_name = $_FILES['profile_picture']['tmp_name'];
    // $error = $_FILES['profile_picture']['error'];
    // $size = $_FILES['profile_picture']['size'];

    //check if there is error
    // if($error !=0){
    //     $_SESSION['errormsg'] = "Kindly upload a real image";
    //     header("location:../register.php");
    //     exit;
    // }

    //validate the file size
    // if($size > (1024 * 1024 * 3)){
    //     $_SESSION['errormsg'] = "File size too large. Maximum size must be 3mb";
    //     header("location:../register.php");
    //     exit;
    // }

    //validate wrong file type
    // $accepted = ['jpg', 'jpeg', 'png'];
    // $user_extension = pathinfo($name, PATHINFO_EXTENSION);
    // $user_extension = strtolower($user_extension);
    // if(!in_array($user_extension, $accepted)){
    //     $_SESSION['errormsg'] = "wrong file type. Upload an image wiht extension png or jpg or jpeg";
    //     header("location:../register.php");
    //     exit;
    // }
    

    //rename the file
    // $unique_filename = uniqid("NR_user_").time()."_".$name;
    // $res = move_uploaded_file($tmp_name, "../uploads/$unique_filename");
    
    

    if(empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($phone) || empty($cpassword) ){
        echo "<h3 style='color:red;'> Go back and fill the form </h3>";
        header("location:register.php");
        exit;
    }
    
    
        include_once 'classes/Agent.php';

        $agent = new Agent();
        $storeAgent = $agent->register_agent($firstname, $lastname, $email, $password, $phone);
        if($storeAgent == false){
            echo "Agent data not saved, try again ";
        }
        else{
            $_SESSION['firstname'] = $firstname;   
            header("location:../Agent/agent_login.php");
            return "Account created successfully";
        }
        
}
else{
    $_SESSION['errormsg'] = "kindly fill the form to register";
    header("location:../register.php");
    exit;
}