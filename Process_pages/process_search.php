<?php
    session_start();

    if(isset($_GET['search'])){
        $address = $_GET['address'];
        $state = isset($_GET['state']) ? $_GET['state'] : "";
        $property_type = isset($_GET['property_type']) ? $_GET['property_type'] : "";

        // var_dump($_GET);
        require_once "classes/Site.php";
        $fetch = new Site();
        $fetched = $fetch->search_properties($address, $state, $property_type);

        // echo "<pre>";
        // print_r($fetched);
        // echo "</pre>";
        // die;
        
        $_SESSION['search'] = $fetched;

        // var_dump($_SESSION['search']);
        header("Location: ../search_properties.php?data=result");
        exit;

    }
    else{
        header("location:../search_properties.php");
        exit;
    }



?>