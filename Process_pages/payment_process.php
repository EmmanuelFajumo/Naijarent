<?php
session_start();
require_once "../Agent/agentguard.php";
require_once "classes/Agent.php";
require_once "classes/Payment.php";
require_once "classes/Site.php";

$agent = new Agent();
$pay = new Payment();
$prop = new Site();

// if(!isset($_GET['confirm'])){
//     $_SESSION['errormsg'] = "Kindly select an apartment you want to rent";
//     header("locaton:../index.php");
// }

$property_id = $_GET['property_id'];
$agent_id = $_SESSION['agent_online'];
$generated_ref = $pay->generate_ref_code();

$property_deets = $prop->fetch_property_detail($property_id);
$amount = 30000;
$agent_deet = $agent->fetch_agent_details($agent_id);

$date = date("Y-M-d H:i:s");

//user details
$email = $agent_deet['email'];
$fullname = $agent_deet['first_name']." ".$agent_deet['last_name'];


$agent_id = $property_deets['Agent_id'];

$payment_attempt = $pay->add_payment_attempt($amount, $property_id, $generated_ref, $fullname, $email, $agent_id);

if((int)$payment_attempt == 0){
    $_SESSION['errormsg'] = "You have paid for this appartment already";
    header("location: ../agent/agent_dashboard_listings.php");
    exit;
}

//initialize paystack method

$_SESSION['paystack_reference'] = $generated_ref;
    $res = $pay->initialize_paystack($email, $amount, $generated_ref);
    if(!$res){
        $_SESSION['errormsg'] = "Error loading Paystack.";
        header("location:../profile.php");
        exit;
    }
    $paystack = json_decode($res);

    // echo "<pre>";
    // print_r($paystack);
    // echo "</pre>";
    // die;
    $url = $paystack->data->authorization_url;
    header("location: $url"); //redirecting to paystact GUI
    exit;

