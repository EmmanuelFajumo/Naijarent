<?php
session_start();
require_once "agentguard.php";
require_once "../process_pages/classes/Agent.php";
$agent = new Agent();
$det = $agent->fetch_agent_details($_SESSION['agent_online']);

require_once "../process_pages/classes/ChatService.php";
require_once "../process_pages/classes/config.php";

$chats = new ChatService;
$all_chats = $chats->fetch_agent_conversations($_SESSION['agent_online']);
// echo "<pre>";
// print_r($all_chats);
// echo "</pre>";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard - Messages</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --navy-dark: #14213D;
            --navy-light: #1E3888;
            --gold: #FFD700;
            --gold-hover: #FFA500;
            --bg-light: #f8f9fc;
        }

        /* ── Layout ── */
        .messages-wrapper {
            background: var(--bg-light);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }

        /* ── Conversation List ── */
        .conversation-list-panel {
            background: #fff;
            border-right: 1px solid #eef0f4;
            max-height: 650px;
            overflow-y: auto;
        }
        .conversation-list-panel::-webkit-scrollbar {
            width: 5px;
        }
        .conversation-list-panel::-webkit-scrollbar-thumb {
            background: #d0d4dc;
            border-radius: 10px;
        }

        .conv-search-box {
            padding: 16px 16px 8px;
        }
        .conv-search-box .search-inner {
            display: flex;
            align-items: center;
            background: var(--bg-light);
            border-radius: 10px;
            padding: 8px 14px;
            border: 1.5px solid transparent;
            transition: all 0.3s ease;
        }
        .conv-search-box .search-inner:focus-within {
            border-color: var(--navy-light);
            box-shadow: 0 0 0 3px rgba(30, 56, 136, 0.08);
        }
        .conv-search-box input {
            border: none;
            background: transparent;
            width: 100%;
            font-size: 0.85rem;
            outline: none;
        }
        .conv-search-box input::placeholder {
            color: #adb5bd;
        }

        .conv-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            cursor: pointer;
            transition: all 0.2s ease;
            border-bottom: 1px solid #f1f3f6;
            position: relative;
        }
        .conv-item:hover {
            background: rgba(30, 56, 136, 0.04);
        }
        .conv-item.active {
            background: linear-gradient(135deg, var(--navy-dark), var(--navy-light));
            border-bottom-color: transparent;
        }
        .conv-item .conv-avatar {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(30, 56, 136, 0.1);
            color: var(--navy-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
            font-weight: 600;
        }
        .conv-item.active .conv-avatar {
            background: rgba(255,255,255,0.2);
            color: #fff;
        }
        .conv-item .conv-body {
            flex: 1;
            min-width: 0;
        }
        .conv-item .conv-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2px;
        }
        .conv-item .conv-title {
            font-weight: 600;
            font-size: 0.9rem;
            color: #1a1a2e;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .conv-item.active .conv-title {
            color: #fff;
        }
        .conv-item .conv-time {
            font-size: 0.72rem;
            color: #adb5bd;
            white-space: nowrap;
            margin-left: 8px;
        }
        .conv-item.active .conv-time {
            color: rgba(255,255,255,0.65);
        }
        .conv-item .conv-tenant {
            font-size: 0.78rem;
            color: #6c757d;
            margin-bottom: 3px;
        }
        .conv-item.active .conv-tenant {
            color: rgba(255,255,255,0.75);
        }
        .conv-item .conv-preview {
            font-size: 0.8rem;
            color: #8e94a2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .conv-item.active .conv-preview {
            color: rgba(255,255,255,0.6);
        }
        .conv-item .unread-badge {
            position: absolute;
            top: 14px;
            right: 16px;
            background: #dc3545;
            color: #fff;
            border-radius: 50px;
            padding: 1px 9px;
            font-size: 0.7rem;
            font-weight: 700;
            min-width: 22px;
            text-align: center;
        }
        .conv-item.active .unread-badge {
            background: rgba(255,255,255,0.3);
            color: #fff;
        }

        /* ── Chat Panel ── */
        .chat-panel {
            display: flex;
            flex-direction: column;
            background: #fff;
            height: 650px;
        }
        .chat-header {
            padding: 16px 20px;
            border-bottom: 1px solid #eef0f4;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }
        .chat-header .chat-header-info h5 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            color: var(--navy-dark);
        }
        .chat-header .chat-header-info small {
            color: #6c757d;
            font-size: 0.8rem;
        }
        .chat-header .chat-header-status {
            font-size: 0.78rem;
            padding: 4px 12px;
            border-radius: 50px;
            background: rgba(25, 135, 84, 0.1);
            color: #198754;
            font-weight: 500;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: var(--bg-light);
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .chat-messages::-webkit-scrollbar {
            width: 5px;
        }
        .chat-messages::-webkit-scrollbar-thumb {
            background: #d0d4dc;
            border-radius: 10px;
        }

        .msg {
            max-width: 75%;
            padding: 10px 16px;
            border-radius: 10px;
            font-size: 0.88rem;
            line-height: 1.45;
            position: relative;
            word-wrap: break-word;
        }
        .msg.sent {
            background: linear-gradient(135deg, var(--navy-dark), var(--navy-light));
            color: #fff;
            align-self: flex-end;
            border-bottom-right-radius: 4px;
        }
        .msg.received {
            background: #fff;
            color: #1a1a2e;
            align-self: flex-start;
            border-bottom-left-radius: 4px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }
        .msg .msg-sender {
            font-weight: 600;
            font-size: 0.75rem;
            display: block;
            margin-bottom: 2px;
        }
        .msg.sent .msg-sender {
            color: rgba(255,255,255,0.7);
        }
        .msg.received .msg-sender {
            color: var(--navy-light);
        }
        .msg .msg-time {
            font-size: 0.65rem;
            opacity: 0.6;
            display: block;
            text-align: right;
            margin-top: 4px;
        }
        .msg.sent .msg-time {
            color: rgba(255,255,255,0.7);
        }
        .msg.received .msg-time {
            color: #adb5bd;
        }

        .no-conversation-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #adb5bd;
        }
        .no-conversation-placeholder i {
            font-size: 3rem;
            margin-bottom: 12px;
            opacity: 0.4;
        }
        .no-conversation-placeholder p {
            font-size: 0.9rem;
            margin: 0;
        }

        .chat-input-area {
            padding: 14px 20px;
            border-top: 1px solid #eef0f4;
            display: flex;
            gap: 10px;
            align-items: center;
            flex-shrink: 0;
            background: #fff;
        }
        .chat-input-area input {
            flex: 1;
            padding: 10px 16px;
            border: 1.5px solid #e9ecef;
            border-radius: 10px;
            font-size: 0.88rem;
            outline: none;
            transition: all 0.3s ease;
        }
        .chat-input-area input:focus {
            border-color: var(--navy-light);
            box-shadow: 0 0 0 3px rgba(30, 56, 136, 0.08);
        }
        .chat-input-area input:disabled {
            background: #f8f9fa;
            cursor: not-allowed;
        }
        .btn-send {
            padding: 10px 22px;
            background: linear-gradient(135deg, var(--navy-dark), var(--navy-light));
            color: #fff;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.88rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(20, 33, 61, 0.2);
            white-space: nowrap;
        }
        .btn-send:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(20, 33, 61, 0.3);
        }
        .btn-send:disabled {
            background: #ccc;
            box-shadow: none;
            cursor: not-allowed;
        }

        /* ── Toast ── */
        .toast-custom {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #fff;
            padding: 16px 20px;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            border-left: 4px solid var(--navy-light);
            z-index: 9999;
            transform: translateX(120%);
            transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1);
            max-width: 360px;
            min-width: 280px;
        }
        .toast-custom.show {
            transform: translateX(0);
        }
        .toast-custom .toast-title {
            font-weight: 600;
            color: var(--navy-dark);
            font-size: 0.9rem;
            margin-bottom: 4px;
        }
        .toast-custom .toast-message {
            color: #6c757d;
            font-size: 0.83rem;
        }
        .toast-custom .toast-time {
            font-size: 0.7rem;
            color: #adb5bd;
            margin-top: 6px;
        }

        .notification-bell-wrap {
            position: relative;
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(30, 56, 136, 0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            font-size: 1.2rem;
            color: var(--navy-dark);
        }
        .notification-bell-wrap:hover {
            background: rgba(30, 56, 136, 0.12);
        }
        .notification-badge-custom {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #dc3545;
            color: #fff;
            border-radius: 50%;
            padding: 1px 7px;
            font-size: 0.65rem;
            font-weight: 700;
            display: none;
            min-width: 20px;
            text-align: center;
        }
        .notification-badge-custom.show {
            display: inline-block;
        }

        .loading-spinner {
            text-align: center;
            padding: 30px 0;
            color: #adb5bd;
            font-size: 0.85rem;
        }
        .empty-state {
            text-align: center;
            padding: 40px 16px;
            color: #adb5bd;
            font-size: 0.85rem;
        }

        /* ── Section Divider ── */
        .section-divider {
            height: 2px;
            background: linear-gradient(to right, transparent, rgba(20, 33, 61, 0.12), transparent);
            border: none;
            margin: 16px 0 24px;
            opacity: 1;
        }
    </style>
</head>

<body>

    <div class="container-fluid" style="min-height: 100vh; background: var(--bg-light);">
        <div class="row">

            <!-- Sidebar -->
            <?php include 'agent_nav.php'; ?>

            <!-- Main Content -->
            <div class="col-md-9 px-4 px-lg-5 pb-5 pt-4">

                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <div>
                        <h2 class="mb-1" style="font-size: 1.75rem; color: var(--navy-dark);">Messages</h2>
                        <p class="text-muted mb-0" style="font-size: 0.95rem;">
                            <i class="fa-regular fa-envelope me-2 opacity-50"></i>
                            Chat with tenants about your properties
                        </p>
                    </div>
                    <div class="notification-bell-wrap" id="notificationBell">
                        <i class="fa-regular fa-bell"></i>
                        <span class="notification-badge-custom" id="notificationBadge">0</span>
                    </div>
                </div>

                <hr class="section-divider">

                <!-- Messages Layout -->
                <div class="messages-wrapper row g-0">
                    
                    <!-- Left: Conversation List -->
                    <div class="col-lg-4 conversation-list-panel">
                        <div class="conv-search-box">
                            <div class="search-inner">
                                <i class="fa-solid fa-magnifying-glass text-muted me-2" style="font-size:0.82rem;"></i>
                                <input type="text" placeholder="Search conversations..." id="convSearch">
                            </div>
                        </div>
                        <div id="conversation-list">
                            <div class="loading-spinner">
                                <i class="fa-solid fa-spinner fa-spin me-2"></i>Loading conversations...
                            </div>
                            <div class="" id="chatPreview">
                               <?php foreach($all_chats as $chat): ?>
                                   <div class="conv-item" data-property="<?= $chat['property_id'] ?>" data-tenant="<?= $chat['tenant_id'] ?>" data-chat="<?= $chat['id'] ?>" onclick="loadMessages(<?= $chat['property_id'] ?>); this.closest('.conv-item').classList.add('active'); document.querySelectorAll('#chatPreview .conv-item').forEach(i => i.classList.remove('active')); this.classList.add('active');">
                                       <div class="conv-avatar">T</div>
                                       <div class="conv-body">
                                           <div class="conv-header">
                                               <span class="conv-title">Property #<?= $chat['property_id'] ?></span>
                                               <span class="conv-time"><?= date('h:i A', strtotime($chat['created_at'])) ?></span>
                                           </div>
                                           <div class="conv-tenant"><i class="fa-regular fa-user me-1"></i>Tenant #<?= $chat['tenant_id'] ?></div>
                                           <div class="conv-preview">Click to view messages</div>
                                       </div>
                                   </div>
                               <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Chat Window -->
                    <div class="col-lg-8 chat-panel">
                        <div class="chat-header">
                            <div class="chat-header-info">
                                <h5 id="chat-title">Select a conversation</h5>
                                <small id="tenant-info">Click a conversation to start chatting</small>
                            </div>
                            <span class="chat-header-status" id="propertyStatus" style="display:none;">
                                <i class="fa-regular fa-circle-check me-1"></i> Active
                            </span>
                        </div>

                        <div class="chat-messages" id="chat-messages">
                            <div class="no-conversation-placeholder">
                                <i class="fa-regular fa-comment-dots"></i>
                                <p>Select a conversation from the left panel</p>
                            </div>
                        </div>

                        <div class="chat-input-area">
                            <input type="text" id="message-input" placeholder="Type your reply..." disabled>
                            <button id="send-btn" class="btn-send" onclick="sendMessage()" disabled>
                                <i class="fa-regular fa-paper-plane me-1"></i> Send
                            </button>
                        </div>
                    </div>

                </div>

            </div>
            <!-- Main Content End -->
        </div> 
    </div>

    <!-- Hidden form for sending messages -->
    <form id="message-form" method="POST" action="../process_pages/send_message.php" style="display:none;">
        <input type="hidden" name="property_id" id="hidden-property-id">
        <input type="hidden" name="Agent_id" id="hidden-receiver-id">
        <input type="hidden" name="message" id="hidden-message">
    </form>

    <!-- Toast Notification -->
    <div class="toast-custom" id="toast">
        <div class="toast-title" id="toastTitle"><i class="fa-regular fa-envelope me-1"></i> New Message</div>
        <div class="toast-message" id="toastMessage">Message preview</div>
        <div class="toast-time" id="toastTime">Just now</div>
    </div>

    <!-- Footer -->
    <?php //include '../footer.php'; ?>

    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script>
    // ============================================
    // AGENT DASHBOARD - REAL-TIME CHAT
    // ============================================

    const agentId = <?php echo $det['agent_id']; ?>;
    const agentName = '<?php echo $det['first_name']; ?>';
    const pusherKey = '<?php echo PUSHER_APP_KEY; ?>';
    const pusherCluster = '<?php echo PUSHER_APP_CLUSTER; ?>';

    // Current state
    let currentPropertyId = null;
    let currentTenantId = null;
    let unreadCount = 0;

    // DOM Elements
    const conversationList = document.getElementById('conversation-list');
    const chatMessages = document.getElementById('chat-messages');
    const chatTitle = document.getElementById('chat-title');
    const tenantInfo = document.getElementById('tenant-info');
    const propertyStatus = document.getElementById('propertyStatus');
    const messageInput = document.getElementById('message-input');
    const sendBtn = document.getElementById('send-btn');
    const notificationBadge = document.getElementById('notificationBadge');
    const toast = document.getElementById('toast');

    // ============================================
    // 1. LOAD CONVERSATIONS FROM DATABASE
    // ============================================
    function loadConversations() {
        fetch('../process_pages/fetch_agent_conversations.php')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    conversationList.innerHTML = '<div class="empty-state"><i class="fa-solid fa-triangle-exclamation me-2"></i>Error loading conversations</div>';
                    return;
                }
                
                if (data.length === 0) {
                    conversationList.innerHTML = '<div class="empty-state"><i class="fa-regular fa-inbox me-2"></i>No conversations yet</div>';
                    return;
                }
                
                // Clear loading message
                conversationList.innerHTML = '';
                
                // Add each conversation
                data.forEach(conv => {
                    addConversationItem(conv);
                });
                
                // Auto-select first conversation
                const firstItem = conversationList.querySelector('.conv-item');
                if (firstItem) {
                    firstItem.click();
                }
            })
            .catch(error => {
                console.error('Error loading conversations:', error);
                conversationList.innerHTML = '<div class="empty-state"><i class="fa-solid fa-triangle-exclamation me-2"></i>Error loading conversations</div>';
            });
    }

    // ============================================
    // 2. ADD CONVERSATION ITEM TO LIST
    // ============================================
    function addConversationItem(conv) {
        const item = document.createElement('div');
        item.className = 'conv-item';
        item.dataset.property = conv.property_id;
        item.dataset.tenant = conv.tenant_id;
        item.dataset.chat = conv.chat_id;
        
        const lastMessage = conv.last_message || 'No messages yet';
        const lastTime = conv.last_message_time ? formatTime(conv.last_message_time) : '';
        const unread = parseInt(conv.unread_count) || 0;
        const initials = conv.tenant_name ? conv.tenant_name.charAt(0).toUpperCase() : 'T';
        
        item.innerHTML = `
            <div class="conv-avatar">${initials}</div>
            <div class="conv-body">
                <div class="conv-header">
                    <span class="conv-title">${conv.property_title}</span>
                    <span class="conv-time">${lastTime}</span>
                </div>
                <div class="conv-tenant"><i class="fa-regular fa-user me-1"></i>${conv.tenant_name}</div>
                <div class="conv-preview">${lastMessage}</div>
            </div>
            ${unread > 0 ? `<span class="unread-badge">${unread}</span>` : ''}
        `;
        
        // Add click event
        item.addEventListener('click', function() {
            openConversation(this);
        });
        
        conversationList.appendChild(item);
    }

    // ============================================
    // 3. OPEN A CONVERSATION
    // ============================================
    function openConversation(item) {
        // Remove active class from all
        document.querySelectorAll('.conv-item').forEach(i => i.classList.remove('active'));
        item.classList.add('active');
        
        // Get data
        currentPropertyId = parseInt(item.dataset.property);
        currentTenantId = parseInt(item.dataset.tenant);
        const propertyTitle = item.querySelector('.conv-title').textContent;
        const tenantName = item.querySelector('.conv-tenant').textContent.replace(/^.*?Tenant:\s*/, '').trim();
        
        // Update header
        chatTitle.textContent = propertyTitle;
        tenantInfo.textContent = 'Tenant: ' + tenantName;
        propertyStatus.style.display = 'inline-block';
        
        // Enable input
        messageInput.disabled = false;
        sendBtn.disabled = false;
        messageInput.focus();
        
        // Load messages
        loadMessages(currentPropertyId);
        
        // Remove badge
        const badge = item.querySelector('.unread-badge');
        if (badge) badge.remove();
        
        // Update unread count
        updateBadge();
    }

    // ============================================
    // 4. LOAD MESSAGES FOR A CONVERSATION
    // ============================================
    function loadMessages(propertyId) {
        chatMessages.innerHTML = '<div class="loading-spinner"><i class="fa-solid fa-spinner fa-spin me-2"></i>Loading messages...</div>';
        
        const formData = new FormData();
        formData.append('property_id', propertyId);
        
        fetch('../process_pages/fetch_conversation_messages.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                chatMessages.innerHTML = '<div class="no-conversation-placeholder"><i class="fa-solid fa-triangle-exclamation"></i><p>Error loading messages</p></div>';
                return;
            }
            
            chatMessages.innerHTML = '';
            
            if (data.length === 0) {
                chatMessages.innerHTML = '<div class="no-conversation-placeholder"><i class="fa-regular fa-comment-dots"></i><p>No messages yet. Start the conversation!</p></div>';
                return;
            }
            
            // Add each message
            data.forEach(msg => {
                const isSent = msg.message_type === 'sent';
                addMessageToChat(
                    msg.sender_name, 
                    msg.message, 
                    formatTime(msg.created_at), 
                    isSent
                );
            });
            
            // Scroll to bottom
            chatMessages.scrollTop = chatMessages.scrollHeight;
        })
        .catch(error => {
            console.error('Error loading messages:', error);
            chatMessages.innerHTML = '<div class="no-conversation-placeholder"><i class="fa-solid fa-triangle-exclamation"></i><p>Error loading messages</p></div>';
        });
    }

    // ============================================
    // 5. ADD MESSAGE TO CHAT WINDOW
    // ============================================
    function addMessageToChat(sender, message, time, isSent) {
        // Remove empty state if it exists
        const emptyState = chatMessages.querySelector('.no-conversation-placeholder');
        if (emptyState) emptyState.remove();
        
        const messageDiv = document.createElement('div');
        messageDiv.className = 'msg ' + (isSent ? 'sent' : 'received');
        
        messageDiv.innerHTML = `
            <span class="msg-sender">${isSent ? 'You' : sender}</span>
            ${escapeHtml(message)}
            <span class="msg-time">${time}</span>
        `;
        
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Simple escape to prevent XSS
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // ============================================
    // 6. SEND MESSAGE
    // ============================================
    function sendMessage() {
        const input = document.getElementById('message-input');
        const message = input.value.trim();
        
        if (!message || !currentPropertyId || !currentTenantId) {
            return;
        }
        
        // Add message to chat immediately (optimistic update)
        const time = new Date().toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'});
        addMessageToChat('You', message, time, true);
        
        // Clear input
        input.value = '';
        
        // Send via form
        document.getElementById('hidden-property-id').value = currentPropertyId;
        document.getElementById('hidden-receiver-id').value = currentTenantId;
        document.getElementById('hidden-message').value = message;
        document.getElementById('message-form').submit();
    }

    // ============================================
    // 7. UPDATE CONVERSATION LIST (Real-time)
    // ============================================
    function updateConversationList(propertyId, sender, message, time) {
        const items = conversationList.querySelectorAll('.conv-item');
        let found = false;
        
        items.forEach(item => {
            if (parseInt(item.dataset.property) === propertyId) {
                found = true;
                const preview = item.querySelector('.conv-preview');
                const msgTime = item.querySelector('.conv-time');
                
                preview.textContent = sender + ': ' + message;
                msgTime.textContent = time || formatTime(new Date());
                
                // If not active, add badge
                if (!item.classList.contains('active')) {
                    let badge = item.querySelector('.unread-badge');
                    if (!badge) {
                        badge = document.createElement('span');
                        badge.className = 'unread-badge';
                        item.appendChild(badge);
                    }
                    badge.textContent = parseInt(badge.textContent || '0') + 1;
                    
                    // Increment unread count
                    unreadCount++;
                    updateBadge();
                }
                
                // Move to top of list
                conversationList.prepend(item);
            }
        });
        
        // If not found, reload conversations
        if (!found) {
            loadConversations();
        }
    }

    // ============================================
    // 8. TOAST NOTIFICATION
    // ============================================
    function showToast(sender, message, time) {
        document.getElementById('toastTitle').innerHTML = '<i class="fa-regular fa-envelope me-1"></i> New message from ' + sender;
        document.getElementById('toastMessage').textContent = message;
        document.getElementById('toastTime').textContent = time || 'Just now';
        
        toast.classList.add('show');
        
        // Auto-hide after 5 seconds
        clearTimeout(toast._timeout);
        toast._timeout = setTimeout(() => {
            toast.classList.remove('show');
        }, 5000);
    }

    // ============================================
    // 9. UPDATE NOTIFICATION BADGE
    // ============================================
    function updateBadge() {
        if (unreadCount > 0) {
            notificationBadge.textContent = unreadCount;
            notificationBadge.classList.add('show');
        } else {
            notificationBadge.classList.remove('show');
        }
    }

    // ============================================
    // 10. CONNECT TO PUSHER
    // ============================================
    const pusher = new Pusher(pusherKey, {
        cluster: pusherCluster,
        encrypted: true
    });

    // Subscribe to agent's personal channel
    const agentChannel = pusher.subscribe('agent-' + agentId);
    console.log('Agent channel subscribed: agent-' + agentId);

    // Listen for new messages
    agentChannel.bind('new-message', function(data) {
        console.log('📩 New message received:', data);
        
        // If this is from the agent themselves, ignore (already added by form)
        if (data.sender_id == agentId) {
            return;
        }
        
        // If this conversation is currently open, add message to chat
        if (data.property_id == currentPropertyId) {
            addMessageToChat(data.sender_name, data.message, data.time, false);
        }
        
        // Update the conversation list
        updateConversationList(data.property_id, data.sender_name, data.message, data.time);
        
        // Show toast notification
        showToast(data.sender_name, data.message, data.time);
    });

    // ============================================
    // 11. UTILITY FUNCTIONS
    // ============================================
    function formatTime(dateTime) {
        const date = new Date(dateTime);
        return date.toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'});
    }

    // ============================================
    // 12. EVENT LISTENERS
    // ============================================
    
    // Enter key to send
    messageInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendMessage();
        }
    });

    // Click notification bell to reset
    document.getElementById('notificationBell').addEventListener('click', function() {
        unreadCount = 0;
        updateBadge();
    });

    // Conversation search
    document.getElementById('convSearch').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const items = conversationList.querySelectorAll('.conv-item');
        items.forEach(item => {
            const title = item.querySelector('.conv-title').textContent.toLowerCase();
            const tenant = item.querySelector('.conv-tenant').textContent.toLowerCase();
            if (title.includes(query) || tenant.includes(query)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // ============================================
    // 13. INITIALIZE
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        loadConversations();
        
        // Request notification permission
        if ('Notification' in window) {
            Notification.requestPermission();
        }
    });

    console.log('Agent dashboard initialized for agent ID:', agentId);
    </script>

</body>
</html>