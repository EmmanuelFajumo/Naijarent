<?php

if(isset($_POST['deletebtn'])){
    require_once "classes/Admin.php";
    $id = $_POST['property_typeid'];


    $delete = new Admin();
    $delete->delete_property_type($id);
    header("location:../Admin/admin_dashboard_property_type.php");
    }
else{

}