<?php


require_once __DIR__ . '/../config/database.php';





class Profile {
    public $conn;
    private $table = "profiles";

    public $id;
    public $bio;
    public $avatar;
    public $date_naissance;
    public $user_id;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (bio, avatar, date_naissance, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$this->bio, $this->avatar, $this->date_naissance, $this->user_id]);
    }

    public function readByUserId($user_id) {
        $query = "
            SELECT 
                u.id as user_id,
                u.name,
                u.email,
                u.role,
                p.bio,
                p.avatar,
                p.date_naissance
            FROM users u
            LEFT JOIN profiles p ON u.id = p.user_id
            WHERE u.id = ?
            LIMIT 1
        ";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function edit($user_id, $bio, $avatar, $date_naissance) {
        $query = "UPDATE " . $this->table . " SET bio = ?, avatar = ?, date_naissance = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt->execute([$bio, $avatar, $date_naissance, $user_id])) {
            print_r($stmt->errorInfo()); // ← Affiche l’erreur SQL
            return false;
        }
        return true;
    }
    

    

    public function getByUserId($user_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function exists($user_id) {
        $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetchColumn() > 0;
    }
    
    
    public function deleteByUserId($userId) {
        $sql = "DELETE FROM profiles WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    
    
}


