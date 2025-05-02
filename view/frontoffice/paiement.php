<?php
require_once '../../model/Config.php';
$pdo = Config::getConnection();

$event_id = $_GET['event_id'] ?? null;
$successMessage = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $num_card = $_POST['num_card'] ?? '';
    $code_card = $_POST['code_card'] ?? '';

    // Vérification côté serveur
    if (empty($nom) || empty($email) || empty($num_card) || empty($code_card)) {
        $errorMessage = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Adresse email invalide.";
    } elseif (!preg_match('/^\d{4,16}$/', $num_card)) {
        $errorMessage = "Numéro de carte invalide.";
    } elseif (!preg_match('/^\d{3,4}$/', $code_card)) {
        $errorMessage = "Code de carte invalide.";
    } else {
        // Vérifie si l'utilisateur existe
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE nom_user = ? AND email = ?");
        $stmt->execute([$nom, $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $errorMessage = "Utilisateur introuvable.";
        } else {
            $user_id = $user['user_id'];

            // Vérifie la carte
            $stmt = $pdo->prepare("SELECT montant FROM paiements WHERE user_id = ? AND num_card = ?");
            $stmt->execute([$user_id, $num_card]);
            $paiement = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$paiement) {
                $errorMessage = "Carte non trouvée ou utilisateur invalide.";
            } else {
                // Récupère le prix de l'événement
                $stmt = $pdo->prepare("SELECT prix FROM evenements WHERE event_id = ?");
                $stmt->execute([$event_id]);
                $event = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$event) {
                    $errorMessage = "Événement introuvable.";
                } else {
                    $prix = $event['prix'];
                    $montant_dispo = $paiement['montant'];

                    if ($prix > $montant_dispo) {
                        $errorMessage = "Montant insuffisant pour réserver cet événement.";
                    } else {
                        // Déduire le montant
                        $stmt = $pdo->prepare("UPDATE paiements SET montant = montant - ? WHERE user_id = ? AND num_card = ?");
                        $stmt->execute([$prix, $user_id, $num_card]);

                        // Insérer la réservation
                        $dateActuelle = date('Y-m-d H:i:s');
                        $stmt = $pdo->prepare("INSERT INTO ticket (user_id, event_id, ticket_date) VALUES (?, ?, ?)");
                        $stmt->execute([$user_id, $event_id, $dateActuelle]);

                        $successMessage = "Réservation réussie ! Redirection en cours...";
                        header("refresh:2;url=events.php");
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement</title>
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
            width: 400px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            background-color: #2c2c2c;
            border: none;
            border-radius: 5px;
            color: #fff;
        }

        .btn {
            margin-top: 20px;
            background-color: #9b59b6;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
        }

        .btn:hover {
            background-color: #8e44ad;
        }

        .message {
            font-weight: bold;
            margin-top: 15px;
            text-align: center;
        }

        .success {
            color: #2ecc71;
        }

        .error {
            color: #e74c3c;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Paiement</h1>

    <?php if ($successMessage): ?>
        <div class="message success"><?= $successMessage ?></div>
    <?php elseif ($errorMessage): ?>
        <div class="message error"><?= $errorMessage ?></div>
    <?php endif; ?>

    <form method="POST" onsubmit="return validateForm();">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" required>

        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required>

        <label for="num_card">Numéro de carte :</label>
        <input type="text" name="num_card" id="num_card" required>

        <label for="code_card">Code de carte :</label>
        <input type="password" name="code_card" id="code_card" required>

        <button type="submit" class="btn">Confirmer la réservation</button>
    </form>
</div>

<script>
function validateForm() {
    const nom = document.getElementById('nom').value.trim();
    const email = document.getElementById('email').value.trim();
    const num_card = document.getElementById('num_card').value.trim();
    const code_card = document.getElementById('code_card').value.trim();

    if (!nom || !email || !num_card || !code_card) {
        alert("Tous les champs sont obligatoires.");
        return false;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert("Adresse email invalide.");
        return false;
    }

    if (!/^\d{4,16}$/.test(num_card)) {
        alert("Numéro de carte invalide (entre 4 et 16 chiffres).");
        return false;
    }

    if (!/^\d{3,4}$/.test(code_card)) {
        alert("Code de carte invalide (entre 3 et 4 chiffres).");
        return false;
    }

    return true;
}
</script>
</body>
</html>