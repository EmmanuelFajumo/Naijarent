<?php
     if(!isset($_SESSION['useronline'])){
        $_SESSION['errormsg'] = "You need to be logged in as a user to access this page";
        header("location:login.php");
        exit;
    }

?>