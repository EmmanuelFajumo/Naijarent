<?php

session_start();
// Process registration logic here
if(isset($_POST['loginbtn'])){
    
    $email = htmlentities($_POST['agent_email']);
    $password = htmlentities($_POST['agent_password']);
    
    

    if( empty($email) || empty($password)){
        echo "<h3 style='color:red;'> Go back and fill the form </h3>";
        header("location:../agent_login.php");
        exit;
    }
    
    
        include_once 'classes/Agent.php';

        $agent = new Agent(); 
        $res = $agent->login($email, $password);

        if($res > 0){
            $_SESSION['agent_online'] = $res;
            $_SESSION['user_id'] = $res;
            $_SESSION['user_type'] = 'agent';
            $_SESSION['user_name'] = 'Agent ' . $res;
            header("location:../Agent/agent_dashboard.php");
            exit;
        }
        else{
           header("location:../agent/agent_login.php");
            $_SESSION['errormsg'] = "Email or Password is incorrect";
            exit;
        }
        
}
else{
    $_SESSION['errormsg'] = "kindly fill the form to login";
    exit;
}