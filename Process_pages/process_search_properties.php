<?php
    session_start();
    require_once "classes/Site.php";

    if(isset($_GET['property_type']) || isset($_GET['state']) || isset($_GET['lga'])){

        $property_type = isset($_GET['property_type']) ? $_GET['property_type'] : "";
        $state = isset($_GET['state']) ? $_GET['state'] : "";
        $lga = isset($_GET['lga']) ? $_GET['lga'] : "";

        $site = new Site();
        $results = $site->search_property($property_type, $state, $lga);

        if($results !== false){
            $results_json = urlencode(json_encode($results));
            header("location:../search_properties.php?results=".$results_json);
            exit;
        } else {
            header("location:../search_properties.php?error=search_failed");
            exit;
        }
    } else {
        header("location:../search_properties.php");
        exit;
    }
?>