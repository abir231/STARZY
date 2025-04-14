<?php
require_once "Config.php";

class Ticket {
    private $ticket_id;
    private $user_id;
    private $event_id;
    private $prix;

    public function __construct($user_id, $event_id, $prix) {
        $this->user_id = $user_id;
        $this->event_id = $event_id;
        $this->prix = $prix;
    }

    public function save() {
        $pdo = Config::getConnection();
        $stmt = $pdo->prepare("INSERT INTO tickets (user_id, event_id, prix) VALUES (?, ?, ?)");
        return $stmt->execute([$this->user_id, $this->event_id, $this->prix]);
    }

    public static function getTicketsByUser($user_id) {
        $pdo = Config::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM tickets WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllTickets() {
        $pdo = Config::getConnection();
        $stmt = $pdo->query("SELECT * FROM tickets");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>