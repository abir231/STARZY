<?php
$rid = isset($_GET['id']) ? intval($_GET['id']) : 0;

require_once('C:\xampp\htdocs\integration\controller\commentaireC.php');
require_once('C:\xampp\htdocs\integration\model\ressource.php'); // si tu en as besoin

$commentaireC = new commentaireC();
$commentaires = $commentaireC->listCommentaires();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Starzy - Commentaires</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Space+Mono&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Space Mono', monospace;
            background: #0a0818 url('https://images.unsplash.com/photo-1465101162946-4377e57745c3') center/cover;
            color: #e0e0e0;
            padding: 2rem;
        }
        .card {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(0, 191, 255, 0.3);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(5px);
        }
        h2 {
            font-family: 'Orbitron', sans-serif;
            text-shadow: 0 0 15px rgba(0, 191, 255, 0.5);
        }
        .btn-group {
            margin-top: 1rem;
        }
        .btn {
            display: inline-block;
            padding: 8px 14px;
            margin-right: 10px;
            border-radius: 8px;
            text-decoration: none;
            background-color: rgba(0, 191, 255, 0.2);
            color: #00BFFF;
            border: 1px solid #00BFFF;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background-color: rgba(0, 191, 255, 0.4);
            color: white;
        }

        /* Style pour les boutons de navigation */
        .nav-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .nav-btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-family: 'Orbitron', sans-serif;
            transition: all 0.3s ease;
            background: linear-gradient(45deg, rgba(0, 191, 255, 0.2), rgba(138, 43, 226, 0.2));
            border: 1px solid rgba(0, 191, 255, 0.4);
            color: #00BFFF;
        }

        .nav-btn:hover {
            background: linear-gradient(45deg, rgba(0, 191, 255, 0.4), rgba(138, 43, 226, 0.4));
            transform: translateY(-2px);
            box-shadow: 0 0 15px rgba(0, 191, 255, 0.3);
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <!-- Boutons de navigation -->
    <div class="nav-buttons">
        <a href="front-office/listeRessourceClient.php" class="nav-btn">🔙 Retour aux Ressources</a>
        <a href="designe.php" class="nav-btn">🏠 Retour à l'Accueil</a>
    </div>

    <h2>Commentaires associés</h2>

    <?php foreach ($commentaires as $com): ?>
        <?php if ($com['id'] == $rid): ?>
            <div class="card">
                <p><strong>Note :</strong> <?= htmlspecialchars($com['note']); ?>/5</p>
                <p><strong>Contenu :</strong> <?= nl2br(htmlspecialchars($com['contenu'])); ?></p>
                <p><strong>Date :</strong> <?= htmlspecialchars($com['datec']); ?></p>

                <div class="btn-group">
                    <a class="btn" href="updatec.php?id=<?= $com['id']; ?> &idc=<?= $com['idc']; ?>">✏️ Modifier</a>
                    <a class="btn" href="deleteco.php?id=<?= $com['id']; ?> &idc=<?= $com['idc']; ?>"  onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">🗑️ Supprimer</a>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

</body>
</html>
