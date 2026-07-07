<?php
session_start();
//require_once "agentguard.php";
require_once "../Process_pages/classes/Agent.php";
require_once "../Process_pages/classes/Payment.php";

//check if ref is not in session and not in url or if both are not the same, then send away with error message

$refcode_session = isset($_SESSION['paystack_reference']) ? $_SESSION['paystack_reference'] : "";

$refcode_url = isset($_GET['reference']) ? $_GET['reference'] : "";

if(empty($refcode_session) || empty($refcode_url) || ($refcode_session != $refcode_url)){
    $_SESSION['errormsg'] = "Error confirming your payment. Send a message to admin@naijarent.com with title of Error: $refcode_session";
    header('location:agent_dashboard.php');
    exit;
}

//call a method that will send the refcode to paystack to confirm the payment
$pay = new Payment();
$res = $pay->verify_payment($refcode_session);
$res = json_decode($res);

//send them away with a success meessage
    $amount = $pay->fetch_property_id($_SESSION['$refcode_session']);
    if(!$amount){
        $_SESSION['errormsg'] = "Error!!!!";
        header('location:agent_dashboard.php');
        exit;
    }
    if($res->status == true && $res->data->amount == $amount){
        $update_payment = $pay->update_payment_status("successful", $res->data->paid_at, $refcode_session);
        if($update_payment){
            $_SESSION['successmsg'] = "You have successfully paid to for this apartment, Kinldy check your email for a detailed guide on what to do next";
            header('location:agent_dashboard_edit_listing.php?id='.$_SESSION['property_id']);
        exit;
        }
        else{
            $_SESSION['errormsg'] = "Our server seem to be asleep admin@naijarent.com with title of the payment Confirmation Error: REF code: $refcode_session ";
            header('location:agent_dashboard.php');
            exit;
        }
    }else{
            $_SESSION['errormsg'] = "Payment not successful ";
            header('location:agent_dashboard.php');
            exit;
    }


    ?>