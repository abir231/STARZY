<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// controllers/AdminController.php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/DiscussModel.php';
require_once __DIR__ . '/../models/MessageModel.php';

class AdminController {
    private $discussModel;
    private $messageModel;
    
    public function __construct() {
        $this->discussModel = new DiscussModel();
        $this->messageModel = new MessageModel();
    }
    
    public function index() {
        // Load the admin dashboard view
        include(__DIR__ . '/../views/BackOffice/static/chat-admin.html');
    }
    
    public function getStats() {
        // Get total discussions count
        $totalDiscussions = $this->discussModel->getTotalDiscussionsCount();
        
        // Get total messages count
        $totalMessages = $this->messageModel->getTotalMessagesCount();
        
        // Get discussions created in the past week
        $recentDiscussions = $this->discussModel->getRecentDiscussionsCount();
        
        // Return the statistics as JSON
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'data' => [
                'total_discussions' => $totalDiscussions,
                'total_messages' => $totalMessages,
                'recent_discussions' => $recentDiscussions
            ]
        ]);
    }
    
    public function getDiscussionsWithMessageCount() {
        // Get all discussions with message counts
        $discussions = $this->discussModel->getDiscussionsWithMessageCount();
        
        // Return the discussions as JSON
        header('Content-Type: application/json');
        echo json_encode($discussions);
    }
}

// Handle direct access to this file
if (basename($_SERVER['SCRIPT_FILENAME']) == basename(__FILE__)) {
    // Create controller instance
    $controller = new AdminController();
    
    // Check if an action is specified
    if (isset($_GET['action'])) {
        // Handle specific actions
        switch ($_GET['action']) {
            case 'getStats':
                $controller->getStats();
                break;
            case 'getDiscussionsWithMessageCount':
                $controller->getDiscussionsWithMessageCount();
                break;
            default:
                // Log the invalid action
                error_log("Invalid action requested: " . $_GET['action']);
                
                // Show a user-friendly error
                header('HTTP/1.1 404 Not Found');
                echo "Action not found: " . htmlspecialchars($_GET['action']);
                break;
        }
    } else {
        // No action specified, show the admin dashboard
        $controller->index();
    }
    exit;
}
?>