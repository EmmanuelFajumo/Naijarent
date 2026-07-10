<?php
session_start();

if(!isset($_SESSION['agent_online'])){
    header("location:../Agent/agent_login.php");
    exit;
}

if(isset($_POST['property_id']) && isset($_POST['Agent_id']) && isset($_POST['message'])){
    $property_id = (int)$_POST['property_id'];
    $agent_id = (int)$_SESSION['agent_online'];
    $tenant_id = (int)$_POST['Agent_id'];
    $message = trim($_POST['message']);

    if(empty($message)){
        $_SESSION['errormsg'] = "Please enter a message";
        header("location:../Agent/agent_dashboard_messages.php");
        exit;
    }

    require_once "classes/ChatService.php";
    $chat = new ChatService();

    // Find the conversation_id from the conversations table
    $conversations = $chat->fetch_agent_conversations($agent_id);
    $conversation_id = null;

    foreach($conversations as $conv){
        if((int)$conv['property_id'] === $property_id && (int)$conv['tenant_id'] === $tenant_id){
            $conversation_id = (int)$conv['id'];
            break;
        }
    }

    if($conversation_id === null){
        // Create a new conversation if one doesn't exist
        $conversation_id = $chat->saveConversation($tenant_id, $agent_id, $property_id);
    }

    if($conversation_id){
        $result = $chat->send_agent_reply_and_notify($conversation_id, $agent_id, $message, $property_id, $tenant_id);
        
        if($result['success']){
            $_SESSION['successmsg'] = "Message sent successfully";
        } else {
            $_SESSION['errormsg'] = "Failed to send message: " . ($result['error'] ?? 'Unknown error');
        }
    } else {
        $_SESSION['errormsg'] = "Failed to create conversation";
    }

    header("location:../Agent/agent_dashboard_messages.php");
    exit;
} else {
    header("location:../Agent/agent_dashboard_messages.php");
    exit;
}
?>