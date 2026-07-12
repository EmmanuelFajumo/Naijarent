<?php
session_start();
require_once 'classes/ChatService.php';
require_once "classes/Tenant.php";



if(isset($_POST['send'])){

    if(!isset($_SESSION['useronline'])){
        $_SESSION['errormsg'] = "Kindly register send a message to the agent";
        header('location: ../register.php');
        exit;
    }

    $property_id = $_POST['property_id'];
    $receiver_id = $_POST['Agent_id'];
    $message = $_POST['message'];
    
    if(empty($property_id) || empty($receiver_id) || empty($message)){
        $_SESSION['errormsg'] = "Kinly enter your message";
        header("location:../property_details.php?id=$property_id");
        exit;
    }

    $tenant = new Tenant();
    $user = $tenant->fetch_user_detailby_id($_SESSION['useronline']);
    $sender_id = $user['tenant_id'];
    // $conversation_id = md5(uniqid(mt_rand(), true));


    $chat = new ChatService();
    $chat_id = $chat->saveConversation($sender_id, $receiver_id, $property_id);
    if($chat_id){
        $rep = $chat->saveMessage($message, $chat_id);
        //echo "Message sent successfully";
        if($rep){
            //send email notification to agent.
            require_once "classes/Agent.php";
            $agent = new Agent();
            $agent_deet = $agent-> fetch_agent_details($receiver_id);
            $agent_email = $agent_deet['email'];
            $agent_name = $agent_deet['first_name'] . " " . $agent_deet['last_name'];
            $property_link = "../property_details.php?id=" . $property_id;
            $link_to_view_message = "../Agent/messages.php";
            $message_body = "Hi $agent_name, You have new message.";
            require_once "classes/Email.php";
            $email = new Email();
            $send_email = $email->agent_message_alert($agent_email, $agent_name, "New Message", $message_body);
            if($send_email){
                $_SESSION['successmsg'] ="Message sent successfully, the agent will get back to you as soon as possible";
            }else{
                $_SESSION['errormsg'] ="Message sent successfully, but email failed to send. the agent will get back to you as soon as possible";
            }
        }

        //this is the main redirection code that was commented out
        header("location:../property_details.php?id=$property_id");
        exit;
    }else{
        $_SESSION['errormsg'] ="Failed to send message, try again later";
        header("location:../property_details.php?id=$property_id");
        exit;
    }   

}
else{
    header("location:../index.php");
    exit;
}
