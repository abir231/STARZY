<?php
// models/DiscussModel.php

require_once __DIR__ . '/../config.php';

class DiscussModel {
    private $db;
    
    public function __construct() {
        global $conn;
        $this->db = $conn;
    }
    
    public function getAllDiscussions() {
        try {
            $query = "SELECT * FROM discuss ORDER BY creation_date DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('DiscussModel::getAllDiscussions - ' . $e->getMessage());
            return [];
        }
    }
    
    public function getDiscussionById($id) {
        try {
            $query = "SELECT * FROM discuss WHERE id_dis = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('DiscussModel::getDiscussionById - ' . $e->getMessage());
            return false;
        }
    }
    
    public function createDiscussion($nomUser, $userId) {
        try {
            $query = "INSERT INTO discuss (nom_user, user_id) VALUES (:nom_user, :user_id)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nom_user', $nomUser, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log('DiscussModel::createDiscussion - ' . $e->getMessage());
            return false;
        }
    }
    
    public function updateDiscussionName($discussionId, $newName) {
        try {
            $query = "UPDATE discuss SET nom_user = :new_name WHERE id_dis = :discussion_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':new_name', $newName, PDO::PARAM_STR);
            $stmt->bindParam(':discussion_id', $discussionId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('DiscussModel::updateDiscussionName - ' . $e->getMessage());
            return false;
        }
    }
    
    public function deleteDiscussion($discussionId) {
        try {
            // Begin transaction
            $this->db->beginTransaction();
            
            // Delete all messages in the discussion first
            $deleteMessagesQuery = "DELETE FROM messages WHERE discussion_id = :discussion_id";
            $deleteMessagesStmt = $this->db->prepare($deleteMessagesQuery);
            $deleteMessagesStmt->bindParam(':discussion_id', $discussionId, PDO::PARAM_INT);
            $deleteMessagesStmt->execute();
            
            // Then delete the discussion
            $deleteDiscussionQuery = "DELETE FROM discuss WHERE id_dis = :discussion_id";
            $deleteDiscussionStmt = $this->db->prepare($deleteDiscussionQuery);
            $deleteDiscussionStmt->bindParam(':discussion_id', $discussionId, PDO::PARAM_INT);
            $deleteDiscussionStmt->execute();
            
            // Commit transaction
            $this->db->commit();
            
            return true;
        } catch (PDOException $e) {
            // Roll back transaction if there was an error
            $this->db->rollBack();
            error_log('DiscussModel::deleteDiscussion - ' . $e->getMessage());
            return false;
        }
    }
    
    // New methods for admin dashboard
    
    public function getTotalDiscussionsCount() {
        try {
            $query = "SELECT COUNT(*) as count FROM discuss";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $e) {
            error_log('DiscussModel::getTotalDiscussionsCount - ' . $e->getMessage());
            return 0;
        }
    }
    
    public function getRecentDiscussionsCount() {
        try {
            $query = "SELECT COUNT(*) as count FROM discuss WHERE creation_date >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $e) {
            error_log('DiscussModel::getRecentDiscussionsCount - ' . $e->getMessage());
            return 0;
        }
    }
    
    public function getDiscussionsWithMessageCount() {
        try {
            $query = "SELECT d.*, COUNT(m.id_message) as message_count 
                     FROM discuss d 
                     LEFT JOIN messages m ON d.id_dis = m.discussion_id 
                     GROUP BY d.id_dis 
                     ORDER BY d.creation_date DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('DiscussModel::getDiscussionsWithMessageCount - ' . $e->getMessage());
            return [];
        }
    }
}