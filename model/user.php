<?php
require_once "Config.php";

class User {
    private $user_id;
    private $nom_user;
    private $email;
    private $password;
    private $role;

    public function __construct($nom_user, $email, $password, $role) {
        $this->nom_user = $nom_user;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->role = $role;
    }

    public function save() {
        $pdo = Config::getConnection();
        $stmt = $pdo->prepare("INSERT INTO users (nom_user, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$this->nom_user, $this->email, $this->password, $this->role]);
    }

    public static function getUserByEmail($email) {
        $pdo = Config::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAllUsers() {
        $pdo = Config::getConnection();
        $stmt = $pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>