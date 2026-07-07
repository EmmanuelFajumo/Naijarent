<?php
session_start();
require_once "classes/Agent.php";
$logout = new Agent();
$logout->logout();
header("location: ../Agent/agent_login.php");
exit;