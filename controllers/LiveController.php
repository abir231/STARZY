<?php
// controllers/LiveController.php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/DiscussModel.php';
require_once __DIR__ . '/../models/MessageModel.php';

class LiveController {
    private $discussModel;
    private $messageModel;
    
    public function __construct() {
        $this->discussModel = new DiscussModel();
        $this->messageModel = new MessageModel();
    }
    
    public function index() {
        // Load the live chat view
        include(__DIR__ . '/../views/live.php');
    }
    
    public function getDiscussions() {
        // Use the method that includes message counts
        $discussions = $this->discussModel->getDiscussionsWithMessageCount();
        header('Content-Type: application/json');
        echo json_encode($discussions);
    }
    
    public function getMessages($discussionId) {
        // Check if current_user_id was provided (for client comparison)
        $currentUserId = isset($_GET['current_user_id']) ? filter_input(INPUT_GET, 'current_user_id', FILTER_VALIDATE_INT) : null;
        
        $messages = $this->messageModel->getMessagesByDiscussionId($discussionId);
        
        // Add the current user flag to each message for client-side comparison
        if ($currentUserId) {
            foreach ($messages as &$message) {
                // Add user_id if not present (should be added by model)
                if (!isset($message['user_id'])) {
                    $message['user_id'] = $currentUserId; // Temporarily mark all as current user's messages
                }
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode($messages);
    }
    
    public function createDiscussion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and sanitize input
            $nomUser = filter_input(INPUT_POST, 'nom_user', FILTER_SANITIZE_STRING);
            $userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
            
            if (!$nomUser || !$userId) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
                return;
            }
            
            $discussionId = $this->discussModel->createDiscussion($nomUser, $userId);
            
            if ($discussionId) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success', 'discussion_id' => $discussionId]);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Failed to create discussion']);
            }
        }
    }
    
    public function updateDiscussionName() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and sanitize input
            $discussionId = filter_input(INPUT_POST, 'discussion_id', FILTER_VALIDATE_INT);
            $newName = filter_input(INPUT_POST, 'new_name', FILTER_SANITIZE_STRING);
            
            if (!$discussionId || !$newName) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
                return;
            }
            
            $success = $this->discussModel->updateDiscussionName($discussionId, $newName);
            
            if ($success) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success']);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Failed to update discussion name']);
            }
        }
    }
    
    public function deleteDiscussion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and sanitize input
            $discussionId = filter_input(INPUT_POST, 'discussion_id', FILTER_VALIDATE_INT);
            
            if (!$discussionId) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
                return;
            }
            
            $success = $this->discussModel->deleteDiscussion($discussionId);
            
            if ($success) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success']);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete discussion']);
            }
        }
    }
    
    public function sendMessage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and sanitize input
            $discussionId = filter_input(INPUT_POST, 'discussion_id', FILTER_VALIDATE_INT);
            $rawMessage = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
            $userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
            
            if (!$discussionId || !$rawMessage) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
                return;
            }
            
            // Pass the user_id to createMessage (even if null)
            $messageId = $this->messageModel->createMessage($discussionId, $rawMessage, $userId);
            
            if ($messageId) {
                // Get the newly created message with user info
                $message = $this->messageModel->getMessageById($messageId);
                $discussion = $this->discussModel->getDiscussionById($discussionId);
                $message['nom_user'] = $discussion['nom_user'];
                
                // Add user_id to identify message ownership (if not already in message)
                if (!isset($message['user_id']) && $userId) {
                    $message['user_id'] = $userId;
                }
                
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success', 'message' => $message]);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Failed to send message']);
            }
        }
    }
    
    public function updateMessage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and sanitize input
            $messageId = filter_input(INPUT_POST, 'message_id', FILTER_VALIDATE_INT);
            $newText = filter_input(INPUT_POST, 'new_text', FILTER_SANITIZE_STRING);
            
            if (!$messageId || !$newText) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
                return;
            }
            
            $success = $this->messageModel->updateMessage($messageId, $newText);
            
            if ($success) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success']);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Failed to update message']);
            }
        }
    }
    
    public function deleteMessage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and sanitize input
            $messageId = filter_input(INPUT_POST, 'message_id', FILTER_VALIDATE_INT);
            
            if (!$messageId) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
                return;
            }
            
            $success = $this->messageModel->deleteMessage($messageId);
            
            if ($success) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success']);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete message']);
            }
        }
    }
}

// Handle API requests if this file is accessed directly
if (basename($_SERVER['SCRIPT_FILENAME']) == basename(__FILE__) && isset($_GET['action'])) {
    $controller = new LiveController();
    
    switch ($_GET['action']) {
        case 'getDiscussions':
            $controller->getDiscussions();
            break;
        case 'getMessages':
            if (isset($_GET['discussion_id'])) {
                $controller->getMessages($_GET['discussion_id']);
            }
            break;
        case 'createDiscussion':
            $controller->createDiscussion();
            break;
        case 'updateDiscussionName':
            $controller->updateDiscussionName();
            break;
        case 'deleteDiscussion':
            $controller->deleteDiscussion();
            break;
        case 'sendMessage':
            $controller->sendMessage();
            break;
        case 'updateMessage':
            $controller->updateMessage();
            break;
        case 'deleteMessage':
            $controller->deleteMessage();
            break;
        default:
            header('HTTP/1.1 404 Not Found');
            echo "Action not found";
            break;
    }
    exit;
}
?>