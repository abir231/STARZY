<?php
require_once '../../model/Config.php';
$conn = Config::getConnection();

$sql = "SELECT * FROM evenements ORDER BY event_id DESC";
$events = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Événements</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #0f0c29;
            color: white;
            display: flex;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            background-color: #0f0c29;
            padding-top: 30px;
            position: fixed;
            left: 0;
            top: 0;
        }

        .sidebar h2 {
            color: #ffc107;
            text-align: center;
            margin-bottom: 40px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #1a237e;
        }

        .main-content {
            margin-left: 240px;
            padding: 40px;
            width: calc(100% - 240px);
        }

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .main-header h1 {
            color: #fff;
        }

        .add-btn {
            padding: 10px 20px;
            background-color: #1DB954;
            color: white;
            text-decoration: none;
            border-radius: 10px;
        }

        table {
            width: 100%;
            margin-top: 40px;
            border-collapse: collapse;
            background-color: #1a237e;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.4);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #333;
        }

        th {
            color: #ffc107;
            color:#fff;
        }

        tr:hover {
            background-color:aliceblue;
        }

        .btn {
            padding: 8px 12px;
            border-radius: 8px;
            text-decoration: none;
            margin-right: 10px;
            color: white;
        }

        .edit-btn {
            background-color: #ffc107;
        }

        .delete-btn {
            background-color: #dc3545;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Starzy Admin</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="eventlistbyticket.php">Event List by Ticket</a>
    <a href="gestionevent.php">Gestion des Événements</a>
</div>

<div class="main-content">
    <div class="main-header">
        <h1>Liste des Événements</h1>
        <a class="add-btn" href="addEvent.php">+ Ajouter un événement</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Date</th>
                <th>Lieu</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= htmlspecialchars($event['event_id']) ?></td>
                    <td><?= htmlspecialchars($event['nom_event']) ?></td>
                    <td><?= htmlspecialchars($event['date_event']) ?></td>
                    <td><?= htmlspecialchars($event['location_event']) ?></td>
                    <td style="max-width: 300px; overflow-wrap: break-word;"><?= htmlspecialchars($event['description']) ?></td>
                    <td style="white-space: nowrap; vertical-align: middle; text-align: right;">
                        <a class="btn edit-btn" href="updateEvent.php?event_id=<?= $event['event_id'] ?>" class="btn btn-sm btn-primary" style="margin-right: 5px;">Modifier</a>
                        <a class="btn delete-btn" href="deleteEvent.php?event_id=<?= $event['event_id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');"class="btn btn-sm btn-danger">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>