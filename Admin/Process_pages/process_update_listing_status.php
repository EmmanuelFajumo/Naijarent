<?php
session_start();
    
    if(isset($_POST['approve'])){
        $property_id = $_POST['property_id'];

        require_once "../classes/Admin.php";
        $sta = new Admin();
        $verify = $sta->update_property_status("approved", $property_id);
        if($verify){
            header("location: ../admin_dashboard_manage_listings.php");
            exit;
        }
        else{
            echo $verify;
        }

    }
    elseif(isset($_POST['rejected'])){
        $property_id = $_POST['property_id'];

        require_once "classes/Admin.php";
        $sta = new Admin();
        $verify = $sta->update_property_status("rejected", $property_id);
        if($verify){
           header("location: ../admin_dashboard_manage_listings.php");
            exit;
        }else{
            echo $verify;
        }
    }
    elseif(isset($_POST['under review'])){
        $property_id = $_POST['property_id'];

        require_once "classes/Admin.php";
        $sta = new Admin();
        $verify = $sta->update_property_status("under review", $property_id);
        if($verify){
            header("location: ../admin_dashboard_manage_listings.php");
            exit;
        }      
        else{
            echo $verify;
        }  

    }

