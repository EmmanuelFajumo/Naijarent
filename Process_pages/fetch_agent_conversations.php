<?php
session_start();
header('Content-Type: application/json');

if(!isset($_SESSION['agent_online'])){
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

require_once "classes/ChatService.php";

$agent_id = (int)$_SESSION['agent_online'];
$chat = new ChatService();
$conversations = $chat->fetch_agent_conversations_with_details($agent_id);

// Reformat the data for the frontend
if(!isset($conversations['error'])){
    $formatted = [];
    foreach($conversations as $conv){
        $formatted[] = [
            'chat_id' => $conv['chat_id'],
            'property_id' => $conv['property_id'],
            'tenant_id' => $conv['tenant_id'],
            'agent_id' => $conv['agent_id'],
            'property_title' => $conv['property_title'],
            'tenant_name' => $conv['tenant_first_name'] . ' ' . $conv['tenant_last_name'],
            'tenant_email' => $conv['tenant_email'],
            'last_message' => $conv['last_message'] ?? 'No messages yet',
            'last_message_time' => $conv['last_message_time'],
            'unread_count' => (int)$conv['unread_count'],
            'created_at' => $conv['created_at']
        ];
    }
    echo json_encode($formatted);
} else {
    echo json_encode(['error' => $conversations['error']]);
}
?>