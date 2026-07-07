<?php
    if(isset($_POST['btn'])){
        $name = $_POST['propertyTypeName'];
        $description = $_POST['propertyTypeDescription'];
        if(empty($name) || empty($description)){
            $_SESSION['errormsg'] = "field cannot be empty";
            header("location:../Admin/admin_dashboard_property_type.php");
            exit;

        }

        require_once "classes/Admin.php";
        $pt = new Admin;
        $pt->insert_property_type($name, $description);
        if($pt){
           header("location:../Admin/admin_dashboard_property_type.php");
        $_SESSION['success'] = "A new property type added";
        }

    }
    else{
        header("location:../Admin/admin_dashboard_property_type.php");
        
    }

?>