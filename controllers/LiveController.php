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
        include(__DIR__ . '/../views/FrontOffice/live.php');
    }
    
    public function getDiscussions() {
        // Use the method that includes message counts
        $discussions = $this->discussModel->getDiscussionsWithMessageCount();
        
        // Set the correct content type header
        header('Content-Type: application/json');
        
        // Return the discussions as JSON
        echo json_encode($discussions);
    }
    
    public function getMessages() {
        if (!isset($_GET['discussion_id'])) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Discussion ID is required']);
            return;
        }
        
        // Get the discussion ID from query parameters
        $discussionId = filter_input(INPUT_GET, 'discussion_id', FILTER_VALIDATE_INT);
        
        // Check if current_user_id was provided (for client comparison)
        $currentUserId = isset($_GET['current_user_id']) ? filter_input(INPUT_GET, 'current_user_id', FILTER_VALIDATE_INT) : null;
        
        // Get messages for the specified discussion
        $messages = $this->messageModel->getMessagesByDiscussionId($discussionId);
        
        // For each message, get reaction counts and user reaction
        foreach ($messages as &$message) {
            // Get reaction counts
            $reactions = $this->messageModel->getMessageReactions($message['id_message']);
            $message['reactions'] = $reactions;
            
            // If current user ID is provided, get their reaction
            if ($currentUserId) {
                $userReaction = $this->messageModel->getUserReaction($message['id_message'], $currentUserId);
                $message['user_reaction'] = $userReaction;
                
                // Add user_id if not present (should be added by model)
                if (!isset($message['user_id'])) {
                    $message['user_id'] = $currentUserId; // For demo, marking all as current user's messages
                }
            }
        }
        
        // Set the correct content type header
        header('Content-Type: application/json');
        
        // Return the messages as JSON
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
            $rawMessage = isset($_POST['message']) ? $_POST['message'] : null; // Don't sanitize HTML content for audio messages
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
                
                if ($message) {
                    $discussion = $this->discussModel->getDiscussionById($discussionId);
                    $message['nom_user'] = $discussion['nom_user'];
                    
                    // Add user_id to identify message ownership (if not already in message)
                    if (!isset($message['user_id']) && $userId) {
                        $message['user_id'] = $userId;
                    }
                    
                    // Add empty reaction counts
                    $message['reactions'] = ['like' => 0, 'dislike' => 0];
                    $message['user_reaction'] = null;
                    
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'success', 'message' => $message]);
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'error', 'message' => 'Message created but could not be retrieved']);
                }
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
            $newText = isset($_POST['new_text']) ? $_POST['new_text'] : null; // Don't sanitize to allow HTML
            
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
    
    // New method to add a reaction to a message
    public function addReaction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and sanitize input
            $messageId = filter_input(INPUT_POST, 'message_id', FILTER_VALIDATE_INT);
            $userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
            $reactionType = filter_input(INPUT_POST, 'reaction_type', FILTER_SANITIZE_STRING);
            
            if (!$messageId || !$userId || !in_array($reactionType, ['like', 'dislike'])) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
                return;
            }
            
            $success = $this->messageModel->addReaction($messageId, $userId, $reactionType);
            
            header('Content-Type: application/json');
            if ($success) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to add reaction']);
            }
        }
    }
    
    // New method to remove a reaction from a message
    public function removeReaction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and sanitize input
            $messageId = filter_input(INPUT_POST, 'message_id', FILTER_VALIDATE_INT);
            $userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
            
            if (!$messageId || !$userId) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
                return;
            }
            
            $success = $this->messageModel->removeReaction($messageId, $userId);
            
            header('Content-Type: application/json');
            if ($success) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to remove reaction']);
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
            $controller->getMessages();
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
        case 'addReaction':
            $controller->addReaction();
            break;
        case 'removeReaction':
            $controller->removeReaction();
            break;
        default:
            header('HTTP/1.1 404 Not Found');
            echo "Action not found";
            break;
    }
    exit;
}
?>