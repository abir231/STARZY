<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/database.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User(); // Initialisation du modèle User
    }

    public function register($data) {
        try {
            $this->userModel->name = $data['name'];
            $this->userModel->email = $data['email'];
            $this->userModel->password = password_hash($data['password'], PASSWORD_DEFAULT);
            $this->userModel->role = 'user';
            
            return $this->userModel->create();
        } catch (Exception $e) {
            error_log("Registration error: " . $e->getMessage());
            return false;
        }
    }

    public function login($data) {
        try {
            $email = $data['email'];
            $password = $data['password'];
            
            // Utilisation du modèle User pour la connexion
            $user = $this->userModel->login($email, $password);
            
            if (!$user) {
                return false;
            }
            
            // Retourne l'utilisateur sans le mot de passe
            unset($user['password']);
            return $user;
            
        } catch (PDOException $e) {
            error_log("Database error in login: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General error in login: " . $e->getMessage());
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