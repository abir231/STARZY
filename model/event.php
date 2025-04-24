<?php
require_once 'Config.php';

class Event
{
    // Ajouter un événement
    public static function addEvent($nom, $date, $lieu, $desc, $image, $prix)
    {
        $pdo = Config::getConnection();
        $sql = "INSERT INTO evenements (nom_event, date_event, location_event, description, image, prix)
                VALUES (:nom, :date, :lieu, :description, :image, :prix)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':nom' => $nom,
            ':date' => $date,
            ':lieu' => $lieu,
            ':description' => $desc,
            ':image' => $image,
            ':prix' => $prix
        ]);
    }

    // Récupérer tous les événements
    public static function getAll()
    {
        $pdo = Config::getConnection();
        $sql = "SELECT * FROM evenements ORDER BY date_event ASC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Supprimer un événement
    public static function delete($id)
    {
        $pdo = Config::getConnection();
        $sql = "DELETE FROM evenements WHERE event_id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // Mettre à jour un événement
    public static function update($id, $nom, $date, $lieu, $desc, $image, $prix)
    {
        $pdo = Config::getConnection();
        $sql = "UPDATE evenements 
                SET nom_event = :nom, date_event = :date, location_event = :lieu, 
                    description = :desc, image = :image, prix = :prix
                WHERE event_id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nom' => $nom,
            ':date' => $date,
            ':lieu' => $lieu,
            ':desc' => $desc,
            ':image' => $image,
            ':prix' => $prix
        ]);
    }
    public static function getEventById($id)
{
    $pdo = Config::getConnection();
    $sql = "SELECT * FROM evenements WHERE event_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}