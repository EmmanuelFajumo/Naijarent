<?php

$email = $_POST['email'];
$password =  $_POST['email'];

require_once "../process_pages/classes/Agent.php";

$chec = new Agent();
$res = $chec->login($email, $password);

echo $res;


?>
