<?php
require_once '../../model/Event.php'; // Assure-toi que le chemin est correct

if (isset($_GET['event_id'])) {
    $event_id = intval($_GET['event_id']);

    if (Event::deleteEvent($event_id)) {
        header("Location: dashboard.php?deleted=1");
        exit();
    } else {
        echo "Erreur : Impossible de supprimer l'événement.";
    }
} else {
    echo "Erreur : ID de l'événement non spécifié.";
}
?>