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
    $sender_email = $user['email'];
    $sender_name = $user['first_name'] . " " . $user['last_name'];

    
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


            require_once "classes/Site.php";
            $site = new Site();
            $property_det = $site->fetch_property_detail($property_id);
            $property_name = $property_det['title'];
            $message_body = "<html><head><title>New Message</title></head>
            <body>
                <p>Hi $agent_name, You have new message from $sender_name, ($sender_email) about property $property_name.</p>
                <p>The message is: <br> $message</p><br><br>
                <p>Reach out to him at $sender_email.</p>
                <p>click the link below to reply to the message</p><a href='http://localhost/FAJUMO_Emmanuel/RMS/agent-messages.php'>View Messages</a>
            </body></html>" ;
            require_once "classes/Email.php";
            $email = new Email();
            $send_email = $email->agent_message_alert($agent_email, $agent_name, "New Message", $message_body);
            if($send_email){
                $_SESSION['successmsg'] ="Message sent successfully, the agent will get back to you as soon as possible";
            }else{
                $_SESSION['errormsg'] ="Message sent successfully, but email failed to send. the agent will get back to you as soon as possible";
            }
        }

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
