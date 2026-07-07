<?php
// api/auth-channel.php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../Process_pages/classes/Session.php';
require_once __DIR__ . '/../Process_pages/classes/ChatService.php';

use App\Classes\ChatService;
use App\Classes\Session;

Session::start();

if (!Session::isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$socketId = $_POST['socket_id'] ?? null;
$channelName = $_POST['channel_name'] ?? null;

if (!$socketId || !$channelName) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required data']);
    exit;
}

$propertyId = null;
if (preg_match('/^(?:private-)?property-conversation-(\d+)$/', $channelName, $matches)) {
    $propertyId = (int)$matches[1];
}

if (!$propertyId) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid channel name']);
    exit;
}

$user = Session::getUser();
$hasPermission = checkUserPropertyPermission($user['id'], $propertyId);

if (!$hasPermission) {
    http_response_code(403);
    echo json_encode(['error' => 'You do not have permission to access this chat']);
    exit;
}

try {
    $chatService = new ChatService();

    if (strpos($channelName, 'private-') === 0) {
        $auth = $chatService->authenticateChannel($channelName, $socketId);

        if ($auth) {
            echo $auth;
            exit;
        }

        http_response_code(403);
        echo json_encode(['error' => 'Authentication failed']);
        exit;
    }

    http_response_code(200);
    echo json_encode(['success' => true, 'channel' => $channelName]);
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

function checkUserPropertyPermission($userId, $propertyId)
{
    if (empty($userId) || empty($propertyId)) {
        return false;
    }

    return true;
}
