<?php   
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/database.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register($data) {
        try {
            $this->userModel->name = $data['name'];
            $this->userModel->email = $data['email'];
            $this->userModel->password = password_hash($data['password'], PASSWORD_DEFAULT);
            $this->userModel->role = $data['role'] ?? 'user'; // Par défaut 'user'
            
            return $this->userModel->create();
        } catch (Exception $e) {
            error_log("Registration error: " . $e->getMessage());
            return false;
        }
    }

    public function login($data) {
        try {
            error_log("Tentative de login avec email: " . $data['email']);
            
            $email = $data['email'];
            $password = $data['password'];
    
            $user = $this->userModel->login($email, $password);
            
            error_log("Résultat login: " . print_r($user, true));
            
            if ($user) {
                unset($user['password']);
                return $user;
            }
            
            return false;
        } catch (Exception $e) {
            error_log("Erreur login: " . $e->getMessage());
            return false;
        }
    }
    public function getAllUsers() {
        try {
            return $this->userModel->readAll();
        } catch (Exception $e) {
            error_log("Error getting all users: " . $e->getMessage());
            return [];
        }
    }

    public function deleteUser($id) {
        try {
            $this->userModel->id = $id;
            return $this->userModel->delete();
        } catch (Exception $e) {
            error_log("Error deleting user: " . $e->getMessage());
            return false;
        }
    }

    public function updateUser($data) {
        try {
            $this->userModel->id = $data['id'];
            $this->userModel->name = $data['name'];
            $this->userModel->email = $data['email'];
            $this->userModel->role = $data['role'];
            
            return $this->userModel->update();
        } catch (Exception $e) {
            error_log("Error updating user: " . $e->getMessage());
            return false;
        }
    }

    public function readOne($id) {
        try {
            return $this->userModel->getUserById($id);
        } catch (Exception $e) {
            error_log("Error reading user: " . $e->getMessage());
            return false;
        }
    }

    public function getUserById($id) {
        return $this->readOne($id);
    }
}