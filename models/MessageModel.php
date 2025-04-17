<?php
// models/MessageModel.php

require_once __DIR__ . '/../config.php';

class MessageModel {
    private $db;
    
    public function __construct() {
        global $conn;
        $this->db = $conn;
    }
    
    public function getMessagesByDiscussionId($discussionId) {
        try {
            // Modified query to include user_id from discuss table
            $query = "SELECT m.*, d.nom_user, d.user_id 
                     FROM messages m 
                     INNER JOIN discuss d ON m.discussion_id = d.id_dis 
                     WHERE m.discussion_id = :discussion_id 
                     ORDER BY m.date_envoi ASC";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':discussion_id', $discussionId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('MessageModel::getMessagesByDiscussionId - ' . $e->getMessage());
            return [];
        }
    }
    
    public function getMessageById($messageId) {
        try {
            // Modified to join with discuss to get user_id
            $query = "SELECT m.*, d.user_id 
                     FROM messages m 
                     INNER JOIN discuss d ON m.discussion_id = d.id_dis 
                     WHERE m.id_message = :message_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':message_id', $messageId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('MessageModel::getMessageById - ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Create a new message
     * 
     * @param int $discussionId The discussion ID
     * @param string $rawMessage The message content
     * @param int|null $userId Optional user ID for tracking message ownership
     * @return int|bool The new message ID or false on failure
     */
    public function createMessage($discussionId, $rawMessage, $userId = null) {
        try {
            // Check if the messages table has a user_id column
            // If not, use the original query
            $hasUserIdColumn = $this->checkIfColumnExists('messages', 'user_id');
            
            if ($hasUserIdColumn && $userId) {
                $query = "INSERT INTO messages (discussion_id, raw_message, date_envoi, user_id) 
                         VALUES (:discussion_id, :raw_message, NOW(), :user_id)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':discussion_id', $discussionId, PDO::PARAM_INT);
                $stmt->bindParam(':raw_message', $rawMessage, PDO::PARAM_STR);
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            } else {
                // Original query without user_id
                $query = "INSERT INTO messages (discussion_id, raw_message, date_envoi) 
                         VALUES (:discussion_id, :raw_message, NOW())";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':discussion_id', $discussionId, PDO::PARAM_INT);
                $stmt->bindParam(':raw_message', $rawMessage, PDO::PARAM_STR);
            }
            
            $stmt->execute();
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log('MessageModel::createMessage - ' . $e->getMessage());
            return false;
        }
    }
    
    public function updateMessage($messageId, $newText) {
        try {
            $query = "UPDATE messages SET raw_message = :new_text WHERE id_message = :message_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':new_text', $newText, PDO::PARAM_STR);
            $stmt->bindParam(':message_id', $messageId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('MessageModel::updateMessage - ' . $e->getMessage());
            return false;
        }
    }
    
    public function deleteMessage($messageId) {
        try {
            $query = "DELETE FROM messages WHERE id_message = :message_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':message_id', $messageId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('MessageModel::deleteMessage - ' . $e->getMessage());
            return false;
        }
    }
    
    // New methods for admin dashboard
    
    public function getTotalMessagesCount() {
        try {
            $query = "SELECT COUNT(*) as count FROM messages";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $e) {
            error_log('MessageModel::getTotalMessagesCount - ' . $e->getMessage());
            return 0;
        }
    }
    
    public function getMessagesCountByDiscussionId($discussionId) {
        try {
            $query = "SELECT COUNT(*) as count FROM messages WHERE discussion_id = :discussion_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':discussion_id', $discussionId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $e) {
            error_log('MessageModel::getMessagesCountByDiscussionId - ' . $e->getMessage());
            return 0;
        }
    }
    
    public function getRecentMessagesCount() {
        try {
            $query = "SELECT COUNT(*) as count FROM messages WHERE date_envoi >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $e) {
            error_log('MessageModel::getRecentMessagesCount - ' . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Helper method to check if a column exists in a table
     *
     * @param string $table Table name
     * @param string $column Column name
     * @return bool True if column exists, false otherwise
     */
    private function checkIfColumnExists($table, $column) {
        try {
            $query = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = :table AND COLUMN_NAME = :column";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':table', $table, PDO::PARAM_STR);
            $stmt->bindParam(':column', $column, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('MessageModel::checkIfColumnExists - ' . $e->getMessage());
            return false;
        }
    }
}