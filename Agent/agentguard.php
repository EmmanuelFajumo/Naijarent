<?php
     if(!isset($_SESSION['agent_online'])){
        $_SESSION['errormsg'] = "You need to be logged in to access this page";
        header("location:agent_login.php");
        exit;
    }

?>