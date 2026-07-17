<?php
session_start();
    if(isset($_POST['delete'])){
        $property_id = $_POST['id'];

        require_once "classes/Agent.php";
        $agent = new Agent;
        $delete = $agent->delete_listing_by_id($property_id);
        if($delete){
            $_SESSION['successmsg'] = "This listing has been deleted successfully";
            header("location:../Agent/agent_dashboard_listings.php");
            exit;
        }
        else{
            $_SESSION['errormsg'] = "Failed to delete this particular listing";
            header("location:../Agent/agent_dashboard_listings.php");
            exit;
        }


    }
    else{
        header("location:../index.php");
        exit;
    }
?>