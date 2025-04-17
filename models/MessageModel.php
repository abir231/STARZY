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
            $query = "SELECT m.*, d.nom_user 
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
            $query = "SELECT * FROM messages WHERE id_message = :message_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':message_id', $messageId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('MessageModel::getMessageById - ' . $e->getMessage());
            return false;
        }
    }
    
    public function createMessage($discussionId, $rawMessage) {
        try {
            $query = "INSERT INTO messages (discussion_id, raw_message) VALUES (:discussion_id, :raw_message)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':discussion_id', $discussionId, PDO::PARAM_INT);
            $stmt->bindParam(':raw_message', $rawMessage, PDO::PARAM_STR);
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
}