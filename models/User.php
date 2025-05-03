<?php
require_once __DIR__ . '/../config/database.php';

class User {
    public $conn;
    private $table = "users";

    public $id;
    public $name;
    public $email;
    public $password;
    public $role;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$this->name, $this->email, $this->password, $this->role]);
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update() {
        $query = "UPDATE " . $this->table . " SET name = ?, email = ?, role = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$this->name, $this->email, $this->role, $this->id]);
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$this->id]);
    }

    public function login($email, $password) {
        // 1. Valide d'abord l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            error_log("Email invalide: $email");
            return false;
        }
    
        // 2. Cherche l'utilisateur
        $query = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt->execute([$email])) {
            error_log("Erreur SQL: " . print_r($stmt->errorInfo(), true));
            return false;
        }
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // 3. Debug complet
        error_log("Tentative de login - Email: $email");
        error_log("Utilisateur trouvé: " . print_r($user, true));
    
        // 4. Vérifie le mot de passe
        if ($user) {
            $isValid = password_verify($password, $user['password']);
            error_log("Résultat password_verify: " . ($isValid ? "OK" : "Échec"));
            
            if ($isValid) {
                return $user;
            }
        }
    
        return false;
    }

    
    

    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserById($id) {
        return $this->readOne($id);
    }




    
    public function getUserByEmail($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function setPasswordResetToken($email, $token) {
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $query = "UPDATE " . $this->table . " SET reset_token = ?, reset_expires = ? WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$token, $expires, $email]);
    }
    
    public function getUserByResetToken($token) {
        $query = "SELECT * FROM " . $this->table . " WHERE reset_token = ? AND reset_expires > NOW() LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function updatePassword($userId, $hashedPassword) {
        $query = "UPDATE " . $this->table . " SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$hashedPassword, $userId]);
    }
}