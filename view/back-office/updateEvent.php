<?php
require_once '../../model/Config.php';
require_once '../../model/Event.php';

$conn = Config::getConnection();
$event = [];

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];
    $event = Event::getEventById($event_id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
    $nom = $_POST['nom_event'];
    $date = $_POST['date_event'];
    $lieu = $_POST['location_event'];
    $desc = $_POST['description'];
    $img = $_POST['image'];
    if (Event::updateEvent($event_id, $nom, $date, $lieu, $desc,$img)) {
        header('Location: dashboard.php?update=success');
        exit();
    } else {
        $error = "Erreur lors de la mise à jour.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'événement</title>
    <link rel="stylesheet" href="../../static/app.css">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: Arial, sans-serif;
            padding: 30px;
        }

        .form-container {
            background-color: #1f1f1f;
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background-color: #2c2c2c;
            color: #fff;
        }

        button {
            background-color: #00b894;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .cancel-btn {
            background-color: #d63031;
            margin-left: 10px;
        }

        button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Modifier l'événement</h2>
    <?php if ($event): ?>
    <form method="POST">
        <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">

        <label for="nom_event">Nom :</label>
        <input type="text" name="nom_event" id="nom_event" value="<?= $event['nom_event'] ?>" required>

        <label for="date_event">Date :</label>
        <input type="date" name="date_event" id="date_event" value="<?= $event['date_event'] ?>" required>

        <label for="location_event">Lieu :</label>
        <input type="text" name="location_event" id="location_event" value="<?= $event['location_event'] ?>" required>

        <label for="description">Description :</label>
        <textarea name="description" id="description" required><?= $event['description'] ?></textarea>

        <button type="submit">Mettre à jour</button>
        <a href="dashboard.php"><button type="button" class="cancel-btn">Annuler</button></a>
    </form>
    <?php else: ?>
        <p>Événement introuvable.</p>
    <?php endif; ?>
</div>

</body>
</html>