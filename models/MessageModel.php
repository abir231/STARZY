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
            // Note: Using correct column names from your database
            $query = "SELECT m.*, d.nom_user, d.user_id 
                     FROM messages m 
                     INNER JOIN discuss d ON m.discussion_id = d.id_dis 
                     WHERE m.discussion_id = :discussion_id 
                     ORDER BY m.date_envoi ASC";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':discussion_id', $discussionId, PDO::PARAM_INT);
            $stmt->execute();
            
            $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Add reaction data to each message
            foreach ($messages as &$message) {
                $message['reactions'] = $this->getMessageReactions($message['id_message']);
            }
            
            return $messages;
        } catch (PDOException $e) {
            error_log('MessageModel::getMessagesByDiscussionId - ' . $e->getMessage());
            return [];
        }
    }
    
    public function getMessageById($messageId) {
        try {
            // Note: Using correct column names from your database
            $query = "SELECT m.*, d.nom_user, d.user_id 
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
            // Important: Do NOT strip HTML tags from raw_message
            $query = "INSERT INTO messages (discussion_id, raw_message, date_envoi) 
                     VALUES (:discussion_id, :raw_message, NOW())";
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
            // First delete any reactions for this message
            $this->deleteMessageReactions($messageId);
            
            // Then delete the message
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
    
    // New methods for reactions
    
    public function addReaction($messageId, $userId, $reactionType) {
        try {
            // First remove any existing reaction
            $this->removeReaction($messageId, $userId);
            
            // Then add the new reaction
            $query = "INSERT INTO message_reactions (message_id, user_id, reaction_type) 
                      VALUES (:message_id, :user_id, :reaction_type)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':message_id', $messageId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':reaction_type', $reactionType, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('MessageModel::addReaction - ' . $e->getMessage());
            return false;
        }
    }
    
    public function removeReaction($messageId, $userId) {
        try {
            $query = "DELETE FROM message_reactions 
                      WHERE message_id = :message_id AND user_id = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':message_id', $messageId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('MessageModel::removeReaction - ' . $e->getMessage());
            return false;
        }
    }
    
    public function getMessageReactions($messageId) {
        try {
            $query = "SELECT reaction_type, COUNT(*) as count 
                      FROM message_reactions 
                      WHERE message_id = :message_id 
                      GROUP BY reaction_type";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':message_id', $messageId, PDO::PARAM_INT);
            $stmt->execute();
            
            // Initialize default counts
            $reactions = [
                'like' => 0,
                'dislike' => 0
            ];
            
            // Fill in actual counts
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $reactions[$row['reaction_type']] = (int)$row['count'];
            }
            
            return $reactions;
        } catch (PDOException $e) {
            error_log('MessageModel::getMessageReactions - ' . $e->getMessage());
            return ['like' => 0, 'dislike' => 0];
        }
    }
    
    public function getUserReaction($messageId, $userId) {
        try {
            $query = "SELECT reaction_type 
                      FROM message_reactions 
                      WHERE message_id = :message_id AND user_id = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':message_id', $messageId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['reaction_type'] : null;
        } catch (PDOException $e) {
            error_log('MessageModel::getUserReaction - ' . $e->getMessage());
            return null;
        }
    }
    
    public function deleteMessageReactions($messageId) {
        try {
            $query = "DELETE FROM message_reactions WHERE message_id = :message_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':message_id', $messageId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('MessageModel::deleteMessageReactions - ' . $e->getMessage());
            return false;
        }
    }
}
?>