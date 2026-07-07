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

    public function saveMessage($chatId, $senderId, $receiverId, $message)
    {
        //$propertyId = (int)$propertyId;
        $senderId = (int)$senderId;
        $receiverId = (int)$receiverId;
        $message = $message;

        if ( $senderId <= 0 || $receiverId <= 0 || $message === '') {
            return false;
        }

        try {
            $sql = "INSERT INTO messages (conversation_id, sender_id, receiver_id, content, sent_at) VALUES (?, ?, ?,?, NOW())";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$chatId, $senderId, $receiverId, $message]);
        } catch (PDOException $e) {
            echo('Message save failed: ' . $e->getMessage());
           // return false;
        }
    }

    public function saveConversation( $propertyId, $tenantId, $agentId)
    {
        $propertyId = (int)$propertyId;
        $tenantId = (int)$tenantId;
        $agentId = (int)$agentId;
        

        if ($propertyId <= 0 || $tenantId <= 0 || $agentId <= 0) {
            return false;
        }
        try{
            $sql = "SELECT id FROM conversations WHERE property_id = ? AND tenant_id = ? AND agent_id =?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$propertyId, $tenantId, $agentId]);

                $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                return $result['id'];
            }
            
            // Create new conversation
            $sql = "INSERT INTO conversations (property_id, tenant_id, agent_id, created_at) VALUES (?, ?, ?, NOW())";
            $stmt = $this->conn->prepare($sql);
            $res =$stmt->execute([$propertyId, $tenantId, $agentId]);
            $chatId = $this->conn->lastInsertId();
            return $chatId;
        }
        catch(PDOException $e){
             echo $e->getMessage();
            //return false;
        }
    }



    public function fetch_agent_conversations($agent_id){
        $sql = "SELECT * FROM conversations WHERE agent_id = ? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$agent_id]);
        $conversations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $conversations;

    }

    


}

// $test = new ChatService();
// var_dump($test->fetch_agent_conversations(6));