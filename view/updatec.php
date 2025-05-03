<?php
require_once(__DIR__.'/../controller/commentaireC.php');
require_once(__DIR__.'/../model/commentaire.php');

$commentaireC = new commentaireC();
$idr = isset($_GET['idc']) ? intval($_GET['idc']) : 0;
$pid = isset($_GET['id']) ? intval($_GET['id']) : 0;
$commentaire = $commentaireC->getCommentaireById($idr); // correction ici

$message = '';
$error = '';

if (!$commentaire) {
    echo '<div class="alert alert-danger">Commentaire introuvable.</div>';
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $f = new commentaire(
        $idr,
        $_POST['contenu'],
        $_POST['datec'],
        $_POST['note'],
        $pid
    );
    $commentaireC->updateCommentaire($f);
    $message = 'Commentaire modifié avec succès !';
    $commentaire = $commentaireC->getCommentaireById($idr); // Recharger les nouvelles données
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un commentaire</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Space+Mono&display=swap" rel="stylesheet">
    <style>
        body {
            background: #0a0818 url('https://images.unsplash.com/photo-1465101162946-4377e57745c3') center/cover no-repeat;
            color: #e0e0e0;
            font-family: 'Space Mono', monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 191, 255, 0.2);
            max-width: 600px;
            width: 100%;
            backdrop-filter: blur(8px);
        }

        h2 {
            font-family: 'Orbitron', sans-serif;
            font-size: 2rem;
            margin-bottom: 1rem;
            text-align: center;
            text-shadow: 0 0 10px rgba(0, 191, 255, 0.4);
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
        }

        input,
        textarea {
            width: 100%;
            padding: 0.8rem;
            border-radius: 8px;
            border: 1px solid rgba(0, 191, 255, 0.3);
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            font-family: 'Space Mono', monospace;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border: 1px solid #00BFFF;
            background: transparent;
            color: #00BFFF;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: rgba(0, 191, 255, 0.2);
            color: #fff;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .alert-info {
            background: rgba(0, 191, 255, 0.1);
            color: #00BFFF;
        }

        .alert-danger {
            background: rgba(255, 0, 0, 0.1);
            color: #ff4f4f;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>💬 Modifier un commentaire</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" id="commentaireForm">
        <input type="hidden" name="id" value="<?= htmlspecialchars($idr) ?>">

        <div class="form-group">
            <label for="contenu">Contenu :</label>
            <textarea name="contenu" id="contenu" required><?= htmlspecialchars($commentaire['contenu']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="datec">Date :</label>
            <input type="text" name="datec" id="datec" value="<?= htmlspecialchars($commentaire['datec']) ?>" readonly>
        </div>

        <div class="form-group">
    <label for="note">Note :</label>
    <div id="stars">
        <?php
        $note = intval($commentaire['note']);
        for ($i = 1; $i <= 5; $i++) {
            $color = $i <= $note ? '#FFD700' : '#ccc'; // jaune si sélectionné
            echo "<span data-value='$i' style='cursor:pointer; font-size: 2rem; color: $color;'>&#9733;</span>";
        }
        ?>
    </div>
    <input type="hidden" name="note" id="note" value="<?= htmlspecialchars($note) ?>">
</div>

        <div class="form-group" style="text-align: center;">
            <button type="submit" class="btn">Enregistrer</button>
        </div>
        <a href="clientco.php?id=<?= $pid ?>" class="btn btn-outline-dark ms-2">⬅️ Retour aux commentaires</a>
    </form>
</div>

<script>
    document.getElementById("commentaireForm").addEventListener("submit", function(event) {
        var note = document.getElementById("note").value;
        if (note < 1 || note > 5 || isNaN(note)) {
            alert("Veuillez entrer une note valide entre 1 et 5.");
            event.preventDefault();
        }

        var contenu = document.getElementById("contenu").value;
        if (contenu.trim() === "") {
            alert("Le contenu ne peut pas être vide.");
            event.preventDefault();
        }
    });
</script>
<script>
    const stars = document.querySelectorAll("#stars span");
    const noteInput = document.getElementById("note");

    function updateStars(rating) {
        stars.forEach((s, i) => {
            s.style.color = (i + 1) <= rating ? "#FFD700" : "#ccc";
        });
    }

    stars.forEach((star, index) => {
        star.addEventListener("click", () => {
            const rating = index + 1;
            noteInput.value = rating;
            updateStars(rating);
        });

        star.addEventListener("mouseover", () => {
            updateStars(index + 1);
        });

        star.addEventListener("mouseout", () => {
            updateStars(parseInt(noteInput.value));
        });
    });

    // Initialiser avec la note actuelle
    document.addEventListener("DOMContentLoaded", () => {
        updateStars(parseInt(noteInput.value));
    });
</script>

</body>
</html>
