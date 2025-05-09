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
    <title>Starzy - Tutoriels & Livres</title>
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
        }

        /* Section des livres et ressources (cartes) */
        .livre-container, .ressource-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .livre-card, .ressource-card {
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

        .livre-card img, .ressource-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
        }

        .livre-card a, .ressource-card a {
            color: #00BFFF;
            text-decoration: none;
            font-size: 1.2rem;
            padding: 10px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: rgba(0, 191, 255, 0.2);
        }

        .livre-card a:hover, .ressource-card a:hover {
            color: #FFFFFF;
            background: rgba(0, 191, 255, 0.4);
        }

        /* Style spécifique au contenu */
        .sidebar {
            position: fixed;
            right: -180px;
            top: 50%;
            transform: translateY(-50%);
            width: 240px;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border-radius: 15px 0 0 15px;
            box-shadow: -5px 0 30px rgba(0, 191, 255, 0.3);
            transition: right 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Autres styles */
        h2 {
            font-family: 'Orbitron', sans-serif;
            margin: 2rem 0;
            font-size: 2.5rem;
            text-shadow: 0 0 15px rgba(0, 191, 255, 0.5);
        }

        .content {
            display: none;
            padding: 20px;
            text-align: center;
        }

        .content.active {
            display: block;
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
            margin-bottom: 20px;
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
    </style>
</head>
<body>

    <nav class="sidebar">
        <ul class="nav-links">
            <li><a href="#" onclick="showSection('accueil')">🚀 Accueil</a></li>
            <li><a href="#" onclick="showSection('tutoriels')">📚 Tutoriels</a></li>
            <li><a href="#" onclick="showSection('livres')">📖 Livres</a></li>
            <li><a href="#" onclick="showSection('ressources')">🔧 Ressources</a></li>
        </ul>
    </nav>

    <div id="accueil" class="content active">
        <h2>Bienvenue sur Starzy</h2>
        <p>Découvrez l'univers fascinant de l'astronomie et des sciences.</p>
    </div>

    <div id="ressources" class="content">
        <h2>🔧 Ressources</h2>
        <p>Découvrez une sélection de ressources pratiques pour apprendre et explorer.</p>

        <!-- Options de tri -->
        <div class="sort-options">
            <button class="sort-btn" onclick="sortResources('default')">Par défaut</button>
            <button class="sort-btn" onclick="sortResources('rating-high')">Meilleures évaluations</button>
            <button class="sort-btn" onclick="sortResources('rating-low')">Faibles évaluations</button>
            <button class="sort-btn" onclick="sortResources('date-new')">Plus récentes</button>
        </div>

        <!-- Conteneur pour les ressources -->
        <div class="ressource-container" id="ressourceContainer">
            <!-- Resources will be loaded by JavaScript -->
        </div>
    </div>

    <div id="livres" class="content">
        <h2>📖 Livres</h2>
        <p>Découvrez une sélection de livres sur l'astronomie et les sciences.</p>

        <div class="livre-container">
            <div class="livre-card">
                <img src="img1.jfif" alt="Livre 1">
                <a href="https://example.com/livre1.pdf" target="_blank">Livre 1</a>
            </div>
            <div class="livre-card">
                <img src="img2.jfif" alt="Livre 2">
                <a href="https://example.com/livre2.pdf" target="_blank">Livre 2</a>
            </div>
            <div class="livre-card">
                <img src="img3.jfif" alt="Livre 3">
                <a href="https://example.com/livre3.pdf" target="_blank">Livre 3</a>
            </div>
            <div class="livre-card">
                <img src="img4.jfif" alt="Livre 4">
                <a href="https://example.com/livre4.pdf" target="_blank">Livre 4</a>
            </div>
        </div>
    </div>

    <script>
        function showSection(section) {
            let sections = document.querySelectorAll('.content');
            sections.forEach(sec => sec.classList.remove('active'));
            document.getElementById(section).classList.add('active');
        }

        // Données des ressources
        const ressources = [
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
                    $ratingValue = ($rating == 'N/A') ? 0 : floatval($rating);
                    ?>
                    {
                        id: <?php echo json_encode($ressource->getId()); ?>,
                        titre: <?php echo json_encode($ressource->getTitre()); ?>,
                        categorie: <?php echo json_encode($ressource->getCategorie()); ?>,
                        datePublication: <?php echo json_encode($ressource->getDatePublication()); ?>,
                        description: <?php echo json_encode($ressource->getDescription()); ?>,
                        fichierOuLien: <?php echo json_encode($ressource->getFichierOuLien()); ?>,
                        rating: <?php echo json_encode($rating); ?>,
                        ratingValue: <?php echo $ratingValue; ?>
                    },
                    <?php
                }
            }
            ?>
        ];

        // Fonction pour trier les ressources
        function sortResources(sortType) {
            // Marquer le bouton actif
            document.querySelectorAll('.sort-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');

            // Copier le tableau pour ne pas modifier l'original
            let sortedResources = [...ressources];

            // Trier selon le critère
            switch(sortType) {
                case 'rating-high':
                    sortedResources.sort((a, b) => {
                        // S'assurer que les valeurs sont numériques et gérer N/A
                        const valueA = a.rating === 'N/A' ? 0 : parseFloat(a.rating) || 0;
                        const valueB = b.rating === 'N/A' ? 0 : parseFloat(b.rating) || 0;
                        return valueB - valueA;
                    });
                    break;
                case 'rating-low':
                    sortedResources.sort((a, b) => {
                        // S'assurer que les valeurs sont numériques et gérer N/A
                        const valueA = a.rating === 'N/A' ? 0 : parseFloat(a.rating) || 0;
                        const valueB = b.rating === 'N/A' ? 0 : parseFloat(b.rating) || 0;
                        return valueA - valueB;
                    });
                    break;
                case 'date-new':
                    sortedResources.sort((a, b) => {
                        // Convertir les chaînes de date en objets Date
                        const dateA = new Date(a.datePublication);
                        const dateB = new Date(b.datePublication);
                        return dateB - dateA;
                    });
                    break;
                default:
                    // Pas de tri, garder l'ordre d'origine
                    break;
            }

            // Afficher les ressources triées
            displayResources(sortedResources);
        }

        // Fonction pour afficher les ressources
        function displayResources(resourceList) {
            const container = document.getElementById('ressourceContainer');
            container.innerHTML = '';

            resourceList.forEach(resource => {
                // Déterminer la classe CSS pour l'évaluation
                let ratingClass = '';
                if (resource.rating !== 'N/A') {
                    if (parseFloat(resource.rating) >= 4) {
                        ratingClass = 'evaluation-high';
                    } else if (parseFloat(resource.rating) >= 3) {
                        ratingClass = 'evaluation-medium';
                    } else {
                        ratingClass = 'evaluation-low';
                    }
                }

                const card = document.createElement('div');
                card.className = 'ressource-card';
                card.innerHTML = `
                    <h3>${resource.titre}</h3>
                    <p><strong>Categorie :</strong> ${resource.categorie}</p>
                    <p><strong>Date de publication :</strong> ${resource.datePublication}</p>
                    <p><strong>Description :</strong> ${resource.description}</p>
                    <p><strong>Evaluation :</strong> <span class="evaluation ${ratingClass}">${resource.rating}/5</span></p>
                    <a href="${resource.fichierOuLien}" target="_blank">ressource</a>
                    <div class="text-center mt-2">
                        <a class="btn btn-sm btn-outline-dark" href="../ajoutc.php?id=${resource.id}">Commenter</a>
                    </div>
                `;
                container.appendChild(card);
            });
        }

        // Afficher les ressources au chargement
        document.addEventListener('DOMContentLoaded', function() {
            displayResources(ressources);
        });
    </script>

</body>
</html>
