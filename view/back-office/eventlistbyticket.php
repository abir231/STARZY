<?php
require_once '../../model/Config.php';

$pdo = Config::getConnection(); // Important : on initialise ici la connexion PDO

// Récupération des événements pour le menu déroulant
$events = $pdo->query("SELECT event_id, nom_event FROM evenements")->fetchAll();

// Vérifier si un événement est sélectionné
$selectedEventId = isset($_GET['event_id']) ? intval($_GET['event_id']) : null;
$participants = [];

if ($selectedEventId) {
    $stmt = $pdo->prepare("SELECT u.nom_user, u.email, t.prix_ticket FROM ticket t JOIN users u ON t.user_id = u.user_id WHERE t.event_id = ?");
    $stmt->execute([$selectedEventId]);
    $participants = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Event List by Ticket</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .sidebar {
      width: 250px;
      background-color: #343a40;
      min-height: 100vh;
      color: white;
      padding: 20px;
    }
    .sidebar h2 {
      color: #ffc107;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 5px;
    }
    .sidebar a:hover {
      background-color: #495057;
    }
    .main {
      flex-grow: 1;
      background-color: #f8f9fa;
      padding: 30px;
    }
    .box {
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

<div class="sidebar">
  <h2>Starzy Admin</h2>
  <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
  <a href="gestionevent.php"><i class="fas fa-plus"></i> gestion event</a>
  <a href="eventlistbyticket.php"><i class="fas fa-list"></i> Event List by Ticket</a>
</div>

<div class="main">
  <h2 class="mb-4">Liste des Participants par Événement</h2>

  <form method="GET" class="mb-4">
    <div class="input-group">
      <select name="event_id" class="form-select">
        <option value="">-- Choisir un événement --</option>
        <?php foreach ($events as $event): ?>
          <option value="<?= $event['event_id'] ?>" <?= $selectedEventId == $event['event_id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($event['nom_event']) ?>
          </option>
        <?php endforeach; ?>
      </select>
      <button type="submit" class="btn btn-warning">Afficher</button>
    </div>
  </form>

  <?php if ($selectedEventId && empty($participants)): ?>
    <div class="alert alert-warning">Aucun participant pour cet événement.</div>
  <?php elseif ($selectedEventId): ?>
    <div class="box">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Prix du Ticket (€)</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($participants as $participant): ?>
            <tr>
              <td><?= htmlspecialchars($participant['nom_user']) ?></td>
              <td><?= htmlspecialchars($participant['email']) ?></td>
              <td><?= htmlspecialchars($participant['prix_ticket']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

</body>
</html>