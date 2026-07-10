<?php
require_once 'config.php';
require_once 'Db.php';

class ChatService extends Db
{
    private $conn;

    public function __construct()
    {
        $this->conn = $this->connect();
        if (!$this->conn) {
            throw new \RuntimeException('Database connection failed');
        }
    }

    public function saveConversation($customer_id, $receiverId, $property_id)
    {
        $customer_id = (int)$customer_id;
        $receiverId = (int)$receiverId;
        $property_id = (int)$property_id;

        $sql = "SELECT * FROM conversations WHERE tenant_id = ? AND agent_id = ? AND property_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$customer_id, $receiverId, $property_id]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if($res){
            return $res['id'];
        }
        else {
            $sql = "INSERT INTO conversations (tenant_id, agent_id, property_id, created_at) VALUES (?, ?, ?, NOW())";
            $stmt = $this->conn->prepare($sql);
            $res = $stmt->execute([$customer_id, $receiverId, $property_id]);
            if($res){
                $chat_id = $this->conn->lastInsertId();
                return $chat_id;
            }
            else{
                return $chat_id;
            }
        }
        
 
        
    }


    public function saveMessage( $message, $chat_id)
    {
        if ( $chat_id <= 0) {
            echo('Message save failed: ');
            //return false;
        }   
        
 
        try {
            $sql = "INSERT INTO messages (content, conversation_id) VALUES (?, ?)";
            $stmt = $this->conn->prepare($sql);
            $res = $stmt->execute([$message, $chat_id]);
            if($res){
                return true;
            }
            else{
                echo('Message save fail ' . $e->getMessage());
                //return false;
            }
        } catch (PDOException $e) {
            echo('Message save failed: ' . $e->getMessage());
          // return false;
        }
    }


    public function fetch_agent_conversations($agent_id){
        $sql = "SELECT * FROM conversations WHERE agent_id = ? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$agent_id]);
        $conversations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $conversations;

    }

    /**
     * Fetches all conversations for an agent with detailed data:
     * tenant name, property title, last message, unread count, etc.
     */
    public function fetch_agent_conversations_with_details($agent_id){
        try{
            $sql = "SELECT * FROM conversations JOIN messages ON conversations.conversation";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$agent_id]);
            $conversations = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $conversations;
        }catch(PDOException $e){
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Fetches all messages for a specific conversation with sender info.
     */
    public function fetch_conversation_messages($conversation_id){
        try{
            $sql = "SELECT 
                        m.id,
                        m.content AS message,
                        m.sender_type,
                        m.is_read,
                        m.created_at,
                        CASE 
                            WHEN m.sender_type = 'agent' THEN a.first_name
                            WHEN m.sender_type = 'tenant' THEN t.first_name
                        END AS sender_name,
                        CASE 
                            WHEN m.sender_type = 'agent' THEN 'sent'
                            WHEN m.sender_type = 'tenant' THEN 'received'
                        END AS message_type
                    FROM messages m
                    LEFT JOIN agentprofile a ON m.sender_id = a.Agent_id AND m.sender_type = 'agent'
                    LEFT JOIN tenant t ON m.sender_id = t.tenant_id AND m.sender_type = 'tenant'
                    WHERE m.conversation_id = ?
                    ORDER BY m.created_at ASC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$conversation_id]);
            $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Mark unread tenant messages as read
            $updateSql = "UPDATE messages SET is_read = 1 WHERE conversation_id = ? AND sender_type = 'tenant' AND is_read = 0";
            $updateStmt = $this->conn->prepare($updateSql);
            $updateStmt->execute([$conversation_id]);

            return $messages;
        }catch(PDOException $e){
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Sends a reply from the agent, triggers Pusher notification, 
     * and sends an email to the tenant.
     */
    public function send_agent_reply_and_notify($conversation_id, $agent_id, $message, $property_id, $tenant_id){
        try{
            // Save the message
            $sql = "INSERT INTO messages (content, conversation_id, sender_id, sender_type, is_read, created_at) VALUES (?, ?, ?, 'agent', 1, NOW())";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([$message, $conversation_id, $agent_id]);

            if(!$result){
                return ['success' => false, 'error' => 'Failed to save message'];
            }

            // Fetch agent details
            require_once "Agent.php";
            $agent = new Agent();
            $agent_deet = $agent->fetch_agent_details($agent_id);
            $agent_name = $agent_deet['first_name'] . ' ' . $agent_deet['last_name'];

            // Fetch tenant details
            $tenantSql = "SELECT * FROM tenant WHERE tenant_id = ?";
            $tenantStmt = $this->conn->prepare($tenantSql);
            $tenantStmt->execute([$tenant_id]);
            $tenant = $tenantStmt->fetch(PDO::FETCH_ASSOC);
            $tenant_email = $tenant['email'];
            $tenant_name = $tenant['first_name'] . ' ' . $tenant['last_name'];

            // Fetch property title
            $propSql = "SELECT title FROM properties WHERE property_id = ?";
            $propStmt = $this->conn->prepare($propSql);
            $propStmt->execute([$property_id]);
            $property = $propStmt->fetch(PDO::FETCH_ASSOC);
            $property_title = $property['title'];

            // Send email notification to the tenant
            require_once "Email.php";
            $email = new Email();
            $subject = "Reply from Agent regarding " . $property_title;
            $email_body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                    <h2 style='color: #1E3888;'>You have a new reply from your agent</h2>
                    <p>Hi <strong>{$tenant_name}</strong>,</p>
                    <p><strong>{$agent_name}</strong> has replied to your message regarding <strong>{$property_title}</strong>.</p>
                    <div style='background: #f4f6fb; padding: 15px; border-radius: 8px; margin: 15px 0;'>
                        <p style='margin: 0;'><em>{$message}</em></p>
                    </div>
                    <p>Log in to your dashboard to view the full conversation and reply.</p>
                    <a href='" . SITE_URL . "' style='display: inline-block; background: #1E3888; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>View Message</a>
                    <p style='margin-top: 20px; color: #999; font-size: 0.85em;'>This is an automated message from NaijaRent.</p>
                </div>
            ";
            $email->agent_message_alert($tenant_email, $tenant_name, $subject, $email_body);

            // Trigger Pusher notification for real-time update
            require_once __DIR__ . '/../../vendor/autoload.php';
            $pusher = new Pusher\Pusher(PUSHER_APP_KEY, PUSHER_APP_SECRET, PUSHER_APP_ID, [
                'cluster' => PUSHER_APP_CLUSTER,
                'useTLS' => true
            ]);

            $time = date('h:i A');
            $pusher->trigger('agent-' . $agent_id, 'new-message', [
                'property_id' => (int)$property_id,
                'sender_id' => (int)$agent_id,
                'sender_name' => $agent_name,
                'message' => $message,
                'time' => $time,
                'conversation_id' => (int)$conversation_id
            ]);

            return ['success' => true];

        }catch(Exception $e){
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    

}

// $test = new ChatService();
// $res = ($test->fetch_agent_conversations(11));

// echo "<pre>";
// print_r($res);
// echo "</pre>";