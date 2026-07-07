<?php
session_start();
require_once '../vendor/autoload.php';
require_once 'classes/config.php';
require_once 'classes/ChatService.php';

use Pusher\Pusher;

if (isset($_POST['property_id']) && isset($_POST['receiver_id']) && isset($_POST['message'])) {
    $propertyId = (int)$_POST['property_id'];
    $receiverId = (int)$_POST['receiver_id'];
    $message = trim($_POST['message']);

    $senderId = null;
    if (!empty($_SESSION['useronline'])) {
        $senderId = (int)$_SESSION['useronline'];
    } elseif (!empty($_SESSION['agent_online'])) {
        $senderId = (int)$_SESSION['agent_online'];
    }

    if ($senderId) {
        $chatService = new ChatService();
        $result = $chatService->saveMessage($propertyId, $senderId, $receiverId, $message);

        if ($result) {
            $pusher = new Pusher(
                PUSHER_APP_KEY,
                PUSHER_APP_SECRET,
                PUSHER_APP_ID,
                ['cluster' => PUSHER_APP_CLUSTER, 'useTLS' => true]
            );

            $pusher->trigger('property-' . $propertyId, 'new-message', [
                'sender_id' => $senderId,
                'sender_name' => 'User',
                'message' => htmlspecialchars($message, ENT_QUOTES, 'UTF-8'),
                'time' => date('h:i A'),
                'property_id' => $propertyId,
                'receiver_id' => $receiverId
            ]);

            echo json_encode(['status' => 'success', 'message' => 'Message sent successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send message']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

