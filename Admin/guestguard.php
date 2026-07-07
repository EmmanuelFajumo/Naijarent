<?php
     if(isset($_SESSION['admin_online'])){
        $_SESSION['errormsg'] = "You need to be logged in to access this page";
        header("location:admin_login.php");
        exit;
    }

?>