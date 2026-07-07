<?php
session_start();
require_once "agentguard.php";
require_once "../process_pages/classes/Agent.php";
$agent = new Agent();
$det = $agent->fetch_agent_details($_SESSION['agent_online']);

require_once "../process_pages/classes/ChatService.php";
require_once "../process_pages/classes/config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard</title>
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
        .dashboard {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .conversations {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 20px;
            margin-top: 20px;
        }
        .conversation-list {
            background: white;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            max-height: 600px;
            overflow-y: auto;
        }
        .conversation-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background 0.2s;
            position: relative;
        }
        .conversation-item:hover {
            background: #f0f7ff;
        }
        .conversation-item.active {
            background: #007bff;
            color: white;
        }
        .conversation-item .property-title {
            font-weight: bold;
        }
        .conversation-item .last-message {
            font-size: 13px;
            color: #666;
            margin-top: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .conversation-item.active .last-message {
            color: #ddd;
        }
        .conversation-item .badge {
            background: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 2px 8px;
            font-size: 12px;
            float: right;
            margin-top: -5px;
        }
        .conversation-item .message-time {
            font-size: 11px;
            color: #999;
            float: right;
        }
        .conversation-item.active .message-time {
            color: #ddd;
        }
        .chat-window {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            height: 600px;
        }
        .chat-header {
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .chat-header h3 {
            margin: 0;
            color: #333;
        }
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 10px 0;
        }
        .message {
            margin: 8px 0;
            padding: 10px 15px;
            border-radius: 10px;
            max-width: 70%;
            word-wrap: break-word;
        }
        .message.sent {
            background: #007bff;
            color: white;
            margin-left: auto;
        }
        .message.received {
            background: #e9ecef;
            color: #333;
            margin-right: auto;
        }
        .message .time {
            font-size: 11px;
            opacity: 0.7;
            margin-left: 10px;
        }
        .message .sender {
            font-weight: bold;
            display: block;
            font-size: 12px;
        }
        .message.sent .sender {
            color: #cce5ff;
        }
        .chat-input {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }
        .chat-input input {
            flex: 1;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
        }
        .chat-input input:focus {
            border-color: #007bff;
        }
        .chat-input button {
            padding: 12px 25px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }
        .chat-input button:hover {
            background: #0056b3;
        }
        .chat-input button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .no-conversation {
            text-align: center;
            color: #888;
            padding: 100px 0;
        }
        .tenant-info {
            font-size: 13px;
            color: #666;
        }
        .loading-spinner {
            text-align: center;
            padding: 20px;
            color: #999;
        }
        .empty-state {
            text-align: center;
            color: #999;
            padding: 40px 0;
        }
        
        /* Toast Notification */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-left: 4px solid #007bff;
            z-index: 9999;
            transform: translateX(120%);
            transition: transform 0.3s ease;
            max-width: 350px;
        }
        .toast.show {
            transform: translateX(0);
        }
        .toast .toast-title {
            font-weight: bold;
            color: #333;
        }
        .toast .toast-message {
            color: #666;
            margin-top: 5px;
            font-size: 14px;
        }
        .toast .toast-time {
            font-size: 11px;
            color: #999;
            margin-top: 5px;
        }
        .notification-bell {
            position: relative;
            cursor: pointer;
            font-size: 24px;
        }
        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 2px 8px;
            font-size: 12px;
            font-weight: bold;
            display: none;
        }
        .notification-badge.show {
            display: inline-block;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <?php // include 'nav.php'; ?>

    <div class="container-fluid" style="min-height:400px;">
        <div class="row">

            <!-- Sidebar (Profile and Navigation) -->
            <?php include 'agent_nav.php'; ?>
            <!-- Sidebar (Profile and Navigation) -->

            <!-- Main Content -->
            <div class="col-md-9 px-5 mt-3 pb-5">
                
                <div class="row g-3 mb-5">
                    <div class="dashboard">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                            <h2>💬 Messages</h2>
                            <div class="notification-bell" id="notificationBell">
                                🔔
                                <span class="notification-badge" id="notificationBadge">0</span>
                            </div>
                        </div>
                        
                        <div class="conversations">
                            <!-- Left Side: Conversation List -->
                            <div class="conversation-list" id="conversation-list">
                                <div class="loading-spinner">Loading conversations...</div>
                            </div>

                            <!-- Right Side: Chat Window -->
                            <div class="chat-window">
                                <div class="chat-header">
                                    <div>
                                        <h3 id="chat-title">Select a conversation</h3>
                                        <div class="tenant-info" id="tenant-info">Click a conversation to start chatting</div>
                                    </div>
                                    <span id="propertyStatus" style="font-size:13px;color:#888;"></span>
                                </div>

                                <div class="chat-messages" id="chat-messages">
                                    <div class="no-conversation">👈 Select a conversation from the left</div>
                                </div>

                                <div class="chat-input">
                                    <input type="text" id="message-input" placeholder="Type your reply..." disabled>
                                    <button id="send-btn" onclick="sendMessage()" disabled>Send</button>
                                </div>
                            </div>
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
    <div class="toast" id="toast">
        <div class="toast-title" id="toastTitle">📩 New Message</div>
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
                    conversationList.innerHTML = '<div class="empty-state">Error loading conversations</div>';
                    return;
                }
                
                if (data.length === 0) {
                    conversationList.innerHTML = '<div class="empty-state">No conversations yet</div>';
                    return;
                }
                
                // Clear loading message
                conversationList.innerHTML = '';
                
                // Add each conversation
                data.forEach(conv => {
                    addConversationItem(conv);
                });
                
                // Auto-select first conversation
                const firstItem = conversationList.querySelector('.conversation-item');
                if (firstItem) {
                    firstItem.click();
                }
            })
            .catch(error => {
                console.error('Error loading conversations:', error);
                conversationList.innerHTML = '<div class="empty-state">Error loading conversations</div>';
            });
    }

    // ============================================
    // 2. ADD CONVERSATION ITEM TO LIST
    // ============================================
    function addConversationItem(conv) {
        const item = document.createElement('div');
        item.className = 'conversation-item';
        item.dataset.property = conv.property_id;
        item.dataset.tenant = conv.tenant_id;
        item.dataset.chat = conv.chat_id;
        
        const lastMessage = conv.last_message || 'No messages yet';
        const lastTime = conv.last_message_time ? formatTime(conv.last_message_time) : '';
        const unread = parseInt(conv.unread_count) || 0;
        
        item.innerHTML = `
            <div class="property-title">🏠 ${conv.property_title}</div>
            <div class="tenant-info">Tenant: ${conv.tenant_name}</div>
            <div class="last-message">${lastMessage}</div>
            <span class="message-time">${lastTime}</span>
            ${unread > 0 ? `<span class="badge">${unread}</span>` : ''}
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
        document.querySelectorAll('.conversation-item').forEach(i => i.classList.remove('active'));
        item.classList.add('active');
        
        // Get data
        currentPropertyId = parseInt(item.dataset.property);
        currentTenantId = parseInt(item.dataset.tenant);
        const propertyTitle = item.querySelector('.property-title').textContent;
        const tenantName = item.querySelector('.tenant-info').textContent.replace('Tenant: ', '');
        
        // Update header
        chatTitle.textContent = propertyTitle;
        tenantInfo.textContent = 'Tenant: ' + tenantName;
        
        // Enable input
        messageInput.disabled = false;
        sendBtn.disabled = false;
        messageInput.focus();
        
        // Load messages
        loadMessages(currentPropertyId);
        
        // Remove badge
        const badge = item.querySelector('.badge');
        if (badge) badge.remove();
        
        // Update unread count
        updateBadge();
    }

    // ============================================
    // 4. LOAD MESSAGES FOR A CONVERSATION
    // ============================================
    function loadMessages(propertyId) {
        chatMessages.innerHTML = '<div class="loading-spinner">Loading messages...</div>';
        
        const formData = new FormData();
        formData.append('property_id', propertyId);
        
        fetch('../process_pages/fetch_conversation_messages.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                chatMessages.innerHTML = '<div class="no-conversation">Error loading messages</div>';
                return;
            }
            
            chatMessages.innerHTML = '';
            
            if (data.length === 0) {
                chatMessages.innerHTML = '<div class="no-conversation">No messages yet. Start the conversation!</div>';
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
            chatMessages.innerHTML = '<div class="no-conversation">Error loading messages</div>';
        });
    }

    // ============================================
    // 5. ADD MESSAGE TO CHAT WINDOW
    // ============================================
    function addMessageToChat(sender, message, time, isSent) {
        // Remove empty state if it exists
        const emptyState = chatMessages.querySelector('.no-conversation');
        if (emptyState) emptyState.remove();
        
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message ' + (isSent ? 'sent' : 'received');
        
        messageDiv.innerHTML = `
            <span class="sender">${isSent ? 'You' : sender}</span>
            ${message}
            <span class="time">${time}</span>
        `;
        
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
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
        const items = conversationList.querySelectorAll('.conversation-item');
        let found = false;
        
        items.forEach(item => {
            if (parseInt(item.dataset.property) === propertyId) {
                found = true;
                const lastMsg = item.querySelector('.last-message');
                const msgTime = item.querySelector('.message-time');
                
                lastMsg.textContent = sender + ': ' + message;
                msgTime.textContent = time || formatTime(new Date());
                
                // If not active, add badge
                if (!item.classList.contains('active')) {
                    let badge = item.querySelector('.badge');
                    if (!badge) {
                        badge = document.createElement('span');
                        badge.className = 'badge';
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
        document.getElementById('toastTitle').textContent = '📩 New message from ' + sender;
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