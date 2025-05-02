<?php
require_once '../../model/Config.php';
$pdo = Config::getConnection();

$errorMessage = "";
$successMessage = "";
$tickets = [];
$user = null;

// Traitement de la suppression
if (isset($_GET['delete_ticket_id'])) {
    $delete_ticket_id = intval($_GET['delete_ticket_id']);

    // 1. Récupérer les infos du ticket avant suppression
    $stmtInfo = $pdo->prepare("
        SELECT t.ticket_id, t.event_id, t.user_id, e.prix, u.email, u.nom_user
        FROM ticket t
        JOIN evenements e ON t.event_id = e.event_id
        JOIN users u ON t.user_id = u.user_id
        WHERE t.ticket_id = ?
    ");
    $stmtInfo->execute([$delete_ticket_id]);
    $ticketInfo = $stmtInfo->fetch(PDO::FETCH_ASSOC);

    if ($ticketInfo) {
        $prix = $ticketInfo['prix'];
        $user_id = $ticketInfo['user_id'];

        // 2. Ajouter le montant au compte bancaire (paiements)
        $stmtUpdatePaiement = $pdo->prepare("
            UPDATE paiements
            SET montant = montant + ?
            WHERE user_id = ?
        ");
        $stmtUpdatePaiement->execute([$prix, $user_id]);

        // 3. Supprimer le ticket
        $stmtDelete = $pdo->prepare("DELETE FROM ticket WHERE ticket_id = ?");
        $stmtDelete->execute([$delete_ticket_id]);

        header("Location: vosreservations.php?deleted=1"); // Redirection après succès
        exit;
    } else {
        $errorMessage = "Erreur : Ticket non trouvé.";
    }
}

// Vérification du message de succès
if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
    $successMessage = "Ticket supprimé et remboursement effectué avec succès.";
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);

    if (!empty($nom) && !empty($email)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE nom_user = ? AND email = ?");
        $stmt->execute([$nom, $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $user_id = $user['user_id'];

            $stmtTickets = $pdo->prepare("
                SELECT ticket.ticket_id, evenements.nom_event, evenements.prix, ticket.ticket_date
                FROM ticket
                JOIN evenements ON ticket.event_id = evenements.event_id
                WHERE ticket.user_id = ?
            ");
            $stmtTickets->execute([$user_id]);
            $tickets = $stmtTickets->fetchAll(PDO::FETCH_ASSOC);

            if (!$tickets) {
                $errorMessage = "Aucun ticket trouvé pour cet utilisateur.";
            }
        } else {
            $errorMessage = "Utilisateur non trouvé.";
        }
    } else {
        $errorMessage = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vos Réservations</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #121212;
            color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.4);
            width: 800px;
        }

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px 0;
            border: 1px solid #444;
            border-radius: 6px;
            background-color: #2c2c2c;
            color: #fff;
        }

        .btn-purple {
            background-color: #9b59b6;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-purple:hover {
            background-color: #8e44ad;
        }

        .btn-red {
            background-color: #e74c3c;
            color: #fff;
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
        }

        .btn-red:hover {
            background-color: #c0392b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #444;
            text-align: left;
        }

        .error-message {
            color: #e74c3c;
            font-weight: bold;
            margin-top: 20px;
        }

        .success-message {
            color: #2ecc71;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
    <script>
        function validateForm() {
            const nom = document.getElementById('nom').value.trim();
            const email = document.getElementById('email').value.trim();
            let error = "";

            if (nom === "") {
                error += "Le nom est requis.\n";
            }

            if (email === "") {
                error += "L'email est requis.\n";
            } else {
                const emailPattern = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
                if (!emailPattern.test(email)) {
                    error += "L'adresse email n'est pas valide.\n";
                }
            }

            if (error !== "") {
                alert(error);
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
<div class="container">
    <h1>Vos Réservations</h1>

    <form method="post" onsubmit="return validateForm();">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom">

        <label for="email">Email :</label>
        <input type="email" id="email" name="email">

        <button type="submit" class="btn-purple">Valider</button>
    </form>

    <?php if ($successMessage): ?>
        <p class="success-message"><?= htmlspecialchars($successMessage) ?></p>
    <?php endif; ?>

    <?php if ($errorMessage): ?>
        <p class="error-message"><?= htmlspecialchars($errorMessage) ?></p>
    <?php endif; ?>

    <?php if ($tickets): ?>
        <h2 style="margin-top: 40px;">Liste de vos tickets :</h2>
        <table>
            <thead>
            <tr>
                <th>ID Ticket</th>
                <th>Nom de l'événement</th>
                <th>Prix</th>
                <th>Date de réservation</th>
                <th>Action</th>
                <th>Télécharger</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tickets as $ticket): ?>
                <tr>
                    <td><?= htmlspecialchars($ticket['ticket_id']) ?></td>
                    <td><?= htmlspecialchars($ticket['nom_event']) ?></td>
                    <td><?= htmlspecialchars($ticket['prix']) ?> DT</td>
                    <td><?= htmlspecialchars($ticket['ticket_date']) ?></td>
                    <td>
                        <a href="vosreservations.php?delete_ticket_id=<?= $ticket['ticket_id'] ?>" class="btn-red" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce ticket ?');">
                            Supprimer
                        </a>
                    </td>
                    <td>
                        <a href="generer_ticket_pdf.php?ticket_id=<?= $ticket['ticket_id'] ?>" class="btn-purple" target="_blank">
                            Télécharger
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errorMessage)): ?>
        <p class="error-message">Aucun ticket restant.</p>
    <?php endif; ?>
</div>
</body>
</html>
