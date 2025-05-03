<?php
$rid = isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['id']) ? intval($_POST['id']) : '');
require_once(__DIR__.'/../controller/commentaireC.php');
require_once(__DIR__.'/../model/commentaire.php');

$commentaireC = new CommentaireC();
$message = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        empty($_POST['contenu']) ||
        empty($_POST['datec']) ||
        empty($_POST['note']) ||
        empty($_POST['id'])
    ) {
        $error = 'Veuillez remplir tous les champs.';
    } else {
        $commentaire = new Commentaire(
            null,
            $_POST['contenu'],
            $_POST['datec'],
            $_POST['note'],
            $_POST['id']
        );
        $message = $commentaireC->addCommentaire($commentaire);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un commentaire</title>
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
    <h2>💬 Ajouter un commentaire</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" id="commentaireForm">
        <input type="hidden" name="id" value="<?= htmlspecialchars($rid) ?>">

        <div class="form-group">
            <label for="contenu">Contenu :</label>
            <textarea name="contenu" id="contenu" required></textarea>
        </div>

        <div class="form-group">
            <label for="datec">Date :</label>
            <input type="text" name="datec" id="datec" value="<?= date('Y-m-d') ?>" readonly>
        </div>

        <div class="form-group">
    <label>Note :</label>
    <div id="stars" style="font-size: 2rem; color: #ccc; cursor: pointer;">
        <span data-value="1">&#9733;</span>
        <span data-value="2">&#9733;</span>
        <span data-value="3">&#9733;</span>
        <span data-value="4">&#9733;</span>
        <span data-value="5">&#9733;</span>
    </div>
    <input type="hidden" name="note" id="note" required>
</div>


        <div class="form-group" style="text-align: center;">
            <button type="submit" class="btn">Envoyer</button>
        </div>
        <a href="clientco.php?id=<?=$rid  ?>" class="btn btn-outline-dark ms-2">Liste des commentaires  </a>

    </form>
</div>
<script>
    const stars = document.querySelectorAll('#stars span');
    const noteInput = document.getElementById('note');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-value');
            noteInput.value = rating;

            // Mettre à jour les couleurs des étoiles
            stars.forEach(s => {
                s.style.color = s.getAttribute('data-value') <= rating ? '#FFD700' : '#ccc';
            });
        });
    });

    document.getElementById("commentaireForm").addEventListener("submit", function(event) {
        const note = noteInput.value;
        const contenu = document.getElementById("contenu").value.trim();

        if (!note || note < 1 || note > 5) {
            alert("Veuillez sélectionner une note entre 1 et 5 en cliquant sur les étoiles.");
            event.preventDefault();
        }

        if (contenu === "") {
            alert("Le contenu ne peut pas être vide.");
            event.preventDefault();
        }
    });
</script>


</body>
</html>
