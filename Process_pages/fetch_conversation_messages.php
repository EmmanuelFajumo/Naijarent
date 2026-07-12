<?php
session_start();
require_once "classes/ChatService.php";

header('Content-Type: application/json');

// The JS sends POST with property_id
$property_id = isset($_POST['property_id']) ? (int)$_POST['property_id'] : 0;

if ($property_id <= 0) {
    echo json_encode(['error' => 'Invalid property ID']);
    exit;
}

$chat = new ChatService();

// Get the agent_id from session
$agent_id = isset($_SESSION['agent_online']) ? (int)$_SESSION['agent_online'] : 0;

// Find the conversation_id from property_id and agent_id
$conversations = $chat->fetch_agent_conversations($agent_id);
$conversation_id = null;

foreach ($conversations as $conv) {
    if ((int)$conv['property_id'] === $property_id) {
        $conversation_id = (int)$conv['id'];
        break;
    }
}

if ($conversation_id === null) {
    echo json_encode([]);
    exit;
}

// Fetch messages
$messages = $chat->fetch_conversation_messages($conversation_id);

// Format messages for the frontend
$formatted = [];
foreach ($messages as $msg) {
    $isSent = ($msg['sender_type'] ?? '') === 'agent';
    $formatted[] = [
        'sender_name' => $isSent ? 'You' : 'Tenant',
        'message' => $msg['content'],
        'message_type' => $isSent ? 'sent' : 'received',
        'created_at' => $msg['created_at']
    ];
}

echo json_encode($formatted);
?>