<?php
require_once '../../model/Config.php';
$pdo = Config::getConnection();

$event_id = $_GET['event_id'] ?? null;
$event = null;
$errorMessage = "";

if ($event_id) {
    $stmt = $pdo->prepare("SELECT * FROM evenements WHERE event_id = ?");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$event) {
        $errorMessage = "Événement introuvable.";
    }
} else {
    $errorMessage = "Aucun événement spécifié.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de réservation</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #121212;
            color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.4);
            width: 600px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #444;
            text-align: left;
        }

        .btn-purple {
            background-color: #9b59b6;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-purple:hover {
            background-color: #8e44ad;
        }

        .actions {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="container">
    <div style="text-align: right; margin-bottom: 20px;">
            <a href="vosreservations.php" class="btn-purple">Vos Réservations</a>
        </div>
        <h1>Confirmation de réservation</h1>

        <?php if ($errorMessage): ?>
            <p style="color: #e74c3c; font-weight: bold;"><?= $errorMessage ?></p>
            <a href="events.php" class="btn-purple">Retour aux événements</a>
        <?php elseif ($event): ?>
            <table>
                <tr><th>Titre</th><td><?= htmlspecialchars($event['nom_event']) ?></td></tr>
                <tr><th>Description</th><td><?= htmlspecialchars($event['description']) ?></td></tr>
                <tr><th>Lieu</th><td><?= htmlspecialchars($event['location_event']) ?></td></tr>
                <tr><th>Date</th><td><?= htmlspecialchars($event['date_event']) ?></td></tr>
                <tr><th>Prix</th><td><?= htmlspecialchars($event['prix']) ?> DT</td></tr>
            </table>

            <div class="actions">
                <a href="events.php" class="btn-purple">Non</a>
                <a href="paiement.php?event_id=<?= $event_id ?>" class="btn-purple">Oui</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
