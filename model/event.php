<?php
require_once "Config.php";

class Event {
    private $event_id;
    private $nom_event;
    private $date_event;
    private $location_event;
    private $description;
    private $image;

    public function __construct($nom_event, $date_event, $location_event, $description, $image) {
        $this->nom_event = $nom_event;
        $this->date_event = $date_event;
        $this->location_event = $location_event;
        $this->description = $description;
        $this->image = $image;
    }

    public function save() {
        $pdo = Config::getConnection();
        $stmt = $pdo->prepare("INSERT INTO evenements (nom_event, date_event, location_event, description, image) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $this->nom_event,
            $this->date_event,
            $this->location_event,
            $this->description,
            $this->image
        ]);
    }

    public static function getAllEvents() {
        $pdo = Config::getConnection();
        $stmt = $pdo->query("SELECT * FROM evenements");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getEventById($event_id) {
        $pdo = Config::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM evenements WHERE event_id = ?");
        $stmt->execute([$event_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateEvent($event_id, $nom_event, $date_event, $location_event, $description, $image) {
        $pdo = Config::getConnection();
        $stmt = $pdo->prepare("UPDATE evenements SET nom_event = ?, date_event = ?, location_event = ?, description = ?, image = ? WHERE event_id = ?");
        return $stmt->execute([
            $nom_event,
            $date_event,
            $location_event,
            $description,
            $image,
            $event_id
        ]);
    }

    public static function countEvents() {
        $pdo = Config::getConnection();
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM evenements");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public static function deleteEvent($event_id) {
        $pdo = Config::getConnection();
        $stmt = $pdo->prepare("DELETE FROM evenements WHERE event_id = ?");
        return $stmt->execute([$event_id]);
    }
    public static function addEvent($nom, $date, $lieu, $desc, $image) {
        $pdo = Config::getConnection();
        $stmt = $pdo->prepare("INSERT INTO evenements (nom_event, date_event, location_event, description, image) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $nom,
            $date,
            $lieu,
            $desc,
            $image
        ]);
    }
}
?>