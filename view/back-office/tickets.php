<?php
require_once '../../model/Config.php';
$conn = Config::getConnection();

// Requête avec jointures
$sql = "SELECT 
            t.ticket_id, 
            t.ticket_date, 
            u.nom_user, 
            u.email, 
            e.nom_event
        FROM 
            ticket t
        JOIN 
            users u ON t.user_id = u.user_id
        JOIN 
            evenements e ON t.event_id = e.event_id
        ORDER BY 
            t.ticket_id DESC";

$tickets = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Tickets</title>
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
            color: #fff;
        }

        tr:hover {
            background-color: aliceblue;
            color: black;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Starzy Admin</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="eventlistbyticket.php">Event List by Ticket</a>
    <a href="gestionevent.php">Gestion des Événements</a>
    <a href="tickets.php">Gestion des Tickets</a>
</div>

<div class="main-content">
    <div class="main-header">
        <h1>Liste des Tickets</h1>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID Ticket</th>
                <th>Date Ticket</th>
                <th>Nom Utilisateur</th>
                <th>Email</th>
                <th>Événement</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tickets as $ticket): ?>
                <tr>
                    <td><?= htmlspecialchars($ticket['ticket_id']) ?></td>
                    <td><?= htmlspecialchars($ticket['ticket_date']) ?></td>
                    <td><?= htmlspecialchars($ticket['nom_user']) ?></td>
                    <td><?= htmlspecialchars($ticket['email']) ?></td>
                    <td><?= htmlspecialchars($ticket['nom_event']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>