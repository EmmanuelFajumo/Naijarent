<?php
session_start();
header('Content-Type: application/json');

if(!isset($_SESSION['agent_online'])){
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

require_once "classes/ChatService.php";

if(isset($_POST['property_id'])){
    $property_id = (int)$_POST['property_id'];
    $agent_id = (int)$_SESSION['agent_online'];
    $chat = new ChatService();

    // Find the conversation_id from property_id and agent_id
    $conversations = $chat->fetch_agent_conversations($agent_id);
    $conversation_id = null;

    foreach($conversations as $conv){
        if((int)$conv['property_id'] === $property_id){
            $conversation_id = (int)$conv['id'];
            break;
        }
    }

    if($conversation_id){
        $messages = $chat->fetch_conversation_messages($conversation_id);
        echo json_encode($messages);
    } else {
        echo json_encode(['error' => 'Conversation not found']);
    }
} else {
    echo json_encode(['error' => 'Missing property ID']);
}
?>
