<?php
require_once '../../model/Config.php';
require_once '../../model/event.php';

class EventController {
    private $pdo;

    public function __construct() {
        $database = new Config();
        $this->pdo = $database->getConnection();
    }
    public function addEvent($nom, $date, $location, $description, $image) {
        $sql = "INSERT INTO evenements (nom_event, date_event, location_event, description, image) 
                VALUES (:nom, :date, :location, :description, :image)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        return $stmt->execute();
    }
    public function updateEvent($id, $nom, $date, $location, $description, $image) {
        $sql = "UPDATE evenements
                SET nom_event = :nom, date_event = :date, location_event = :location, description = :description, image = :image 
                WHERE event_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        return $stmt->execute();
    }
    public function deleteEvent($id) {
        $sql = "DELETE FROM evenements WHERE event_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function getAllEvents() {
        $sql = "SELECT * FROM evenements";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getEventById($id) {
        $sql = "SELECT * FROM evenements WHERE event_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>