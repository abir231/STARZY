<?php
require_once '../../model/Config.php';
require_once '../../model/Event.php';
require_once '../../controller/eventController.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom_event']);
    $date = $_POST['date_event'];
    $lieu = trim($_POST['location_event']);
    $desc = trim($_POST['description']);
    $prix = floatval($_POST['prix']);
    $image = $_FILES['image']['name'];

    if (empty($nom) || empty($date) || empty($lieu) || empty($desc) || empty($image) || $prix <= 0) {
        $error = "Tous les champs sont obligatoires et le prix doit être strictement positif.";
    } elseif (strtotime($date) <= time()) {
        $error = "La date de l'événement doit être dans le futur.";
    } else {
        $target = "../../uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);

        if (Event::addEvent($nom, $date, $lieu, $desc, $image, $prix)) {
            header('Location: dashboard.php?added=1');
            exit();
        } else {
            $error = "Erreur lors de l'ajout de l'événement.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un événement</title>
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

        .error {
            background-color: #e74c3c;
            color: white;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Ajouter un événement</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
        <label for="nom_event">Nom :</label>
        <input type="text" name="nom_event" id="nom_event" required>

        <label for="date_event">Date :</label>
        <input type="date" name="date_event" id="date_event" required>

        <label for="location_event">Lieu :</label>
        <input type="text" name="location_event" id="location_event" required>

        <label for="description">Description :</label>
        <textarea name="description" id="description" required></textarea>

        <label for="prix">Prix (€) :</label>
        <input type="number" step="0.01" name="prix" id="prix" required>

        <label for="image">Image :</label>
        <input type="file" name="image" id="image" accept="image/*" required>

        <button type="submit">Ajouter</button>
        <a href="dashboard.php"><button type="button" class="cancel-btn">Annuler</button></a>
    </form>
</div>

<script>
    function validateForm() {
        const nom = document.getElementById("nom_event").value.trim();
        const date = document.getElementById("date_event").value;
        const lieu = document.getElementById("location_event").value.trim();
        const description = document.getElementById("description").value.trim();
        const prix = parseFloat(document.getElementById("prix").value);
        const today = new Date();
        const eventDate = new Date(date);

        if (!nom || !date || !lieu || !description || isNaN(prix)) {
            alert("Tous les champs sont obligatoires.");
            return false;
        }

        if (prix <= 0) {
            alert("Le prix doit être strictement positif.");
            return false;
        }

        if (eventDate <= today) {
            alert("La date de l'événement doit être ultérieure à aujourd'hui.");
            return false;
        }

        return true;
    }
</script>

</body>
</html>