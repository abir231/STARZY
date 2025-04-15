<?php
require_once '../../model/Config.php';
$pdo = Config::getConnection(); // <--- C'est ça qui manquait !

// Récupération des revenus par événement
$query = "SELECT e.nom_event, SUM(t.prix_ticket) AS total_revenue
          FROM ticket t
          JOIN evenements e ON t.event_id = e.event_id
          GROUP BY e.nom_event";
$stmt = $pdo->prepare($query);
$stmt->execute();
$revenues = $stmt->fetchAll(PDO::FETCH_ASSOC);

$labels = [];
$data = [];

foreach ($revenues as $row) {
    $labels[] = $row['nom_event'];
    $data[] = $row['total_revenue'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Revenus par événement</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    display: flex;
}
.main-content {
    margin-left: 270px;
    padding: 30px;
    flex-grow: 1;
    background-color: #f4f4f4;
    min-height: 100vh;
}
.sidebar {
            width: 240px;
            height: 100vh;
            background-color: #1f1f1f;
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
            background-color: #333;
        }
h1 {
    margin-bottom: 20px;
}
</style>

</head>
<body>
    <div class="sidebar">
        <h2>Starzy Admin</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="eventlistbyticket.php">Event List by Ticket</a></li>
            <li><a href="gestionevent.php">Gestion des événements</a></li>
        </ul>
    </div>
    <div class="main-content">
        <h1>Courbe des revenus par événement</h1>
        <canvas id="revenueChart" width="800" height="400"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Revenus (€)',
                    data: <?= json_encode($data) ?>,
                    backgroundColor: 'rgba(255, 165, 0, 0.7)', // orange sunset
                    borderColor: 'rgba(255, 140, 0, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
