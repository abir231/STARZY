<?php
require_once('C:\xampp\htdocs\chaima\controller\ressourceC.php');
require_once('C:\xampp\htdocs\chaima\model\ressource.php');
$controller = new ressourceC();
$listeressource = $controller->listRessources();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Starzy - Ressources</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Space+Mono&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Styles généraux et d'interface */
        body {
            font-family: 'Space Mono', monospace;
            background: #0a0818 url('https://images.unsplash.com/photo-1465101162946-4377e57745c3') center/cover;
            color: #e0e0e0;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            padding: 20px;
        }

        /* Section des ressources (cartes) */
        .ressource-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .ressource-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 1rem;
            border-radius: 15px;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(0, 191, 255, 0.3);
            min-height: 320px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            text-align: center;
            overflow: hidden;
        }

        .ressource-card a {
            color: #00BFFF;
            text-decoration: none;
            font-size: 1.2rem;
            padding: 10px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: rgba(0, 191, 255, 0.2);
            margin-top: 10px;
        }

        .ressource-card a:hover {
            color: #FFFFFF;
            background: rgba(0, 191, 255, 0.4);
        }

        /* Style pour l'évaluation */
        .evaluation {
            margin: 10px 0;
            padding: 5px 10px;
            background-color: rgba(0, 191, 255, 0.2);
            border-radius: 8px;
            display: inline-block;
            font-weight: bold;
        }

        .evaluation-high {
            color: #00ff00;
        }

        .evaluation-medium {
            color: #ffff00;
        }

        .evaluation-low {
            color: #ff6600;
        }

        /* Styles pour les boutons de tri */
        .sort-options {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }

        .sort-btn {
            background: rgba(0, 191, 255, 0.2);
            color: #e0e0e0;
            border: 1px solid rgba(0, 191, 255, 0.4);
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Space Mono', monospace;
        }

        .sort-btn:hover {
            background: rgba(0, 191, 255, 0.4);
        }

        .sort-btn.active {
            background: rgba(0, 191, 255, 0.6);
            box-shadow: 0 0 10px rgba(0, 191, 255, 0.4);
        }

        h2 {
            font-family: 'Orbitron', sans-serif;
            text-align: center;
            margin: 2rem 0;
            font-size: 2.5rem;
            text-shadow: 0 0 15px rgba(0, 191, 255, 0.5);
        }

        .header-text {
            text-align: center;
            margin-bottom: 2rem;
        }

        /* Style pour le bouton Home */
        .home-button {
            position: fixed;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
            background: rgba(0, 191, 255, 0.2);
            border: 1px solid rgba(0, 191, 255, 0.4);
            color: #e0e0e0;
            border-radius: 8px;
            text-decoration: none;
            font-family: 'Space Mono', monospace;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            z-index: 1000;
        }

        .home-button:hover {
            background: rgba(0, 191, 255, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 0 15px rgba(0, 191, 255, 0.3);
        }

        /* Style pour le bouton d'ajout de ressource */
        .add-resource-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: rgba(0, 191, 255, 0.2);
            border: 1px solid rgba(0, 191, 255, 0.4);
            color: #e0e0e0;
            border-radius: 8px;
            text-decoration: none;
            font-family: 'Space Mono', monospace;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            z-index: 1000;
        }

        .add-resource-button:hover {
            background: rgba(0, 191, 255, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 0 15px rgba(0, 191, 255, 0.3);
        }
    </style>
</head>
<body>
    <!-- Bouton Home -->
    <a href="../designe.php" class="home-button">🏠 Accueil</a>

    <!-- Bouton Ajouter Ressource -->
    <a href="../front-office/ressource.php" class="add-resource-button">➕ Ajouter Ressource</a>

    <h2>🔧 Ressources</h2>
    <p class="header-text">Découvrez une sélection de ressources pratiques pour apprendre et explorer.</p>

    <!-- Options de tri -->
    <div class="sort-options">
        <button class="sort-btn active" onclick="sortResources('default')">Par défaut</button>
        <button class="sort-btn" onclick="sortResources('rating-high')">Meilleures évaluations</button>
        <button class="sort-btn" onclick="sortResources('rating-low')">Faibles évaluations</button>
        <button class="sort-btn" onclick="sortResources('date-new')">Plus récentes</button>
    </div>

    <!-- Affichage direct des ressources -->
    <div class="ressource-container">
        <?php
        foreach ($listeressource as $row) {
            if ($row['statut'] == 'publie') {
                $ressource = new ressource(
                    $row['id'],
                    $row['titre'],
                    $row['type_ressource'],
                    $row['categorie'],
                    $row['date_publication'],
                    $row['description'],
                    $row['fichier_ou_lien'],
                    $row['statut']
                );
                $rating = $controller->getAverageRating($ressource->getId());
                $ratingClass = '';
                if ($rating != 'N/A') {
                    if (floatval($rating) >= 4) {
                        $ratingClass = 'evaluation-high';
                    } else if (floatval($rating) >= 3) {
                        $ratingClass = 'evaluation-medium';
                    } else {
                        $ratingClass = 'evaluation-low';
                    }
                }
                ?>
                <div class="ressource-card">
                    <h3><?php echo htmlspecialchars($ressource->getTitre()); ?></h3>
                    <p><strong>Catégorie :</strong> <?php echo htmlspecialchars($ressource->getCategorie()); ?></p>
                    <p><strong>Date de publication :</strong> <?php echo htmlspecialchars($ressource->getDatePublication()); ?></p>
                    <p><strong>Description :</strong> <?php echo htmlspecialchars($ressource->getDescription()); ?></p>
                    <p><strong>Évaluation :</strong> <span class="evaluation <?php echo $ratingClass; ?>"><?php echo $rating; ?>/5</span></p>
                    <a href="<?php echo htmlspecialchars($ressource->getFichierOuLien()); ?>" target="_blank">Voir la ressource</a>
                    <a href="../ajoutc.php?id=<?php echo $ressource->getId(); ?>" class="btn btn-sm btn-outline-dark">Commenter</a>
                </div>
                <?php
            }
        }
        ?>
    </div>

    <script>
        // Fonction pour trier les ressources
        function sortResources(sortType) {
            // Récupérer toutes les ressources
            const container = document.querySelector('.ressource-container');
            const cards = Array.from(container.getElementsByClassName('ressource-card'));
            
            // Marquer le bouton actif
            document.querySelectorAll('.sort-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');

            // Trier les cartes
            cards.sort((a, b) => {
                switch(sortType) {
                    case 'rating-high':
                        const ratingA = parseFloat(a.querySelector('.evaluation').textContent) || 0;
                        const ratingB = parseFloat(b.querySelector('.evaluation').textContent) || 0;
                        return ratingB - ratingA;
                    case 'rating-low':
                        const ratingLowA = parseFloat(a.querySelector('.evaluation').textContent) || 0;
                        const ratingLowB = parseFloat(b.querySelector('.evaluation').textContent) || 0;
                        return ratingLowA - ratingLowB;
                    case 'date-new':
                        const dateA = new Date(a.querySelector('p:nth-child(3)').textContent.split(':')[1]);
                        const dateB = new Date(b.querySelector('p:nth-child(3)').textContent.split(':')[1]);
                        return dateB - dateA;
                    default:
                        return 0; // Garder l'ordre original
                }
            });

            // Réinsérer les cartes triées
            cards.forEach(card => container.appendChild(card));
        }
    </script>
</body>
</html>
