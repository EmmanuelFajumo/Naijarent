<?php
session_start();
require_once "process_pages/classes/Tenant.php";
$logout = new Tenant();
$logout->logout();
header("location: login.php");
exit;