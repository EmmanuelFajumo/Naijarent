<?php
// classes/Message.php
namespace App\Classes;

require_once __DIR__ . '/Db.php';

class Message extends Db
{
    private $db;

    public function __construct()
    {
        $this->db = $this->connect();

        if (!$this->db) {
            throw new \RuntimeException('Database connection failed');
        }
    }

    public function save($propertyId, $senderId, $message, $senderType)
    {
        $propertyId = (int)$propertyId;
        $senderId = (int)$senderId;
        $message = trim($message);
        $senderType = strtolower((string)$senderType);

        if ($propertyId <= 0 || $senderId <= 0 || $message === '') {
            return false;
        }

        $this->ensureMessagesTable();

        $columns = $this->getMessageColumns();
        $insertSql = '';
        $params = [];

        if (in_array('sender_id', $columns, true) && in_array('sender_type', $columns, true)) {
            $insertSql = 'INSERT INTO messages (property_id, sender_id, sender_type, message, created_at) VALUES (?, ?, ?, ?, NOW())';
            $params = [$propertyId, $senderId, $senderType, $message];
        } elseif (in_array('tenant_id', $columns, true) && in_array('Agent_id', $columns, true)) {
            $insertSql = 'INSERT INTO messages (property_id, tenant_id, message, Agent_id, created_at) VALUES (?, ?, ?, ?, NOW())';
            $params = [
                $propertyId,
                $senderType === 'tenant' ? $senderId : null,
                $message,
                $senderType === 'agent' ? $senderId : null,
            ];
        } else {
            $insertSql = 'INSERT INTO messages (property_id, message, created_at) VALUES (?, ?, NOW())';
            $params = [$propertyId, $message];
        }

        try {
            $stmt = $this->db->prepare($insertSql);
            return $stmt->execute($params);
        } catch (\PDOException $e) {
            error_log('Message save failed: ' . $e->getMessage());
            return false;
        }
    }

    private function ensureMessagesTable()
    {
        try {
            $this->db->exec("CREATE TABLE IF NOT EXISTS messages (
                id INT AUTO_INCREMENT PRIMARY KEY,
                property_id INT NOT NULL,
                sender_id INT NULL,
                sender_type VARCHAR(20) NULL,
                tenant_id INT NULL,
                Agent_id INT NULL,
                message TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
        } catch (\PDOException $e) {
            error_log('Message table setup failed: ' . $e->getMessage());
        }
    }

    private function getMessageColumns()
    {
        try {
            $stmt = $this->db->query('SHOW COLUMNS FROM messages');
            return array_map(function ($column) {
                return $column['Field'];
            }, $stmt->fetchAll(\PDO::FETCH_ASSOC));
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getMessagesByProperty($propertyId, $limit = 50, $offset = 0)
    {
        $propertyId = (int)$propertyId;
        $limit = (int)$limit;
        $offset = (int)$offset;

        if ($propertyId <= 0) {
            return [];
        }

        try {
            $sql = 'SELECT * FROM messages WHERE property_id = :property_id ORDER BY created_at DESC LIMIT :limit OFFSET :offset';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':property_id', $propertyId, \PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log('Message fetch failed: ' . $e->getMessage());
            return [];
        }
    }
}