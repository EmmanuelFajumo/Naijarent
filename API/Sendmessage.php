<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../Process_pages/classes/config.php';
require_once '../Process_pages/classes/ChatService.php';

use Pusher\Pusher;

$propertyId = $_POST['property_id'];
$receiverId =  $_POST['Agent_id'];
$messageText = $_POST['message'];
$senderId = (int)$_SESSION['useronline'];
$senderName = $_SESSION['username'] ?? 'User';


//Validation for required fields
if ($propertyId <= 0 || $receiverId <= 0 || $messageText === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data']);
    exit;
}

$chat = new ChatService();
$chatId = $chat->saveConversation($propertyId, $senderId, $receiverId);
if ($chatId === false) {
    header("../tenant_dashboard.php");
    exit;
}



$saveMessage = $chat->saveMessage($chatId, $senderId, $receiverId, $messageText);

if (!$saveMessage) {
    echo "Failed to save message.";
    exit;
}


// Pusher: Send to Pusher server
$pusher = new Pusher(
    PUSHER_APP_KEY,
    PUSHER_APP_SECRET,
    PUSHER_APP_ID,
    ['cluster' => PUSHER_APP_CLUSTER, 'useTLS' => true]
);

$data = [
    'sender_id' => $senderId,
    'sender_name' => $senderName,
    'message' => htmlspecialchars($messageText, ENT_QUOTES, 'UTF-8'),
    'time' => date('h:i A'),
    'property_id' => $propertyId,
    'receiver_id' => $receiverId,
    'chat_id' => $chatId
];

// Send to TWO channels:
// 1. Property channel (for the tenant)
$pusher->trigger('property-' . $propertyId, 'new-message', $data);

// 2. Agent's personal channel (for notifications)
$pusher->trigger('agent-' . $receiverId, 'new-message', $data);

// Also trigger a notification event specifically
$pusher->trigger('agent-' . $receiverId, 'new-notification', [
    'property_id' => $propertyId,
    'sender_name' => $senderName,
    'message_preview' => substr($messageText, 0, 30) . (strlen($messageText) > 30 ? '...' : ''),
    'time' => date('h:i A')
]);


if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    echo json_encode(['success' => true]);
    exit;
}

header("Location: ../tenant_dashboard.php");
exit;
