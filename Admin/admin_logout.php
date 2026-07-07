<?php
session_start();
require_once "classes/Admin.php";
$logout = new Admin();
$logout->logout();
header("location: admin_login.php");
exit;