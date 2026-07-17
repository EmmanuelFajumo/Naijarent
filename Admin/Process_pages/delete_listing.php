<?php
    session_start();
    if(isset($_POST['delete'])){

        require_once "../classes/Admin.php";
        $del = new Admin();
        $id = $_POST['pro_id'];
        $delete = $del->delete_listing_by_id($id);
        if($delete){
            header("location: ../admin_dashboard_manage_listings.php");
            exit;
        }

    }
    else{
        header("location:../admin_dashboard.php");
        exit;
    }

?>