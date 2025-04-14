<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations - Événements Astronomiques</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono&display=swap" rel="stylesheet">
    <style>
        body {
            background-image: url('background3.jpg');
            background-size: cover;
            color: #ffffff;
            padding: 20px;
            font-family: 'Space Mono', monospace;
        }

        h1, h2 {
            color: #ff6f61;
        }

        .navbar {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">🌌 Starzy</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
      <li class="nav-item active"><a class="nav-link" href="info.php">Événements</a></li>
      <li class="nav-item"><a class="nav-link" href="produits.php">Produits</a></li>
      <li class="nav-item"><a class="nav-link" href="panier.php">Panier</a></li>
      <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
    </ul>
  </div>
</nav>

<!-- Contenu principal -->
<div class="container mt-5">
    <h1 class="text-center mb-4">Informations sur les Événements Astronomiques</h1>

    <!-- Événements -->
    <?php
    $evenements = [
        [
            "titre" => "Observation de la Lune",
            "description" => "Venez vivre une expérience inoubliable lors de l'observation de la Lune à l'aide de télescopes professionnels...",
            "lieu" => "Parc National de Montagne, Région des Alpes, Ville de Valoria",
            "date" => "15 juillet 2025, à partir de 21h00"
        ],
        [
            "titre" => "Des Étoiles Filantes",
            "description" => "Observez le ciel étoilé et admirez des milliers d'étoiles filantes lors de cet événement unique...",
            "lieu" => "Observatoire de la Côte, Région de la Côte d'Azur, Ville de Marseille",
            "date" => "10 Août 2025, de 22h00 à 00h00"
        ],
        [
            "titre" => "Éclipse",
            "description" => "Assistez à un spectacle astronomique rare : une éclipse solaire totale...",
            "lieu" => "Plage d'Horizon, Région de Normandie, Ville de Caen",
            "date" => "5 Juin 2025, à partir de 12h30"
        ],
        [
            "titre" => "Observation des Comètes",
            "description" => "Joignez-vous à nous pour observer les comètes traversant notre ciel...",
            "lieu" => "Mont des Cieux, Région du Massif Central, Ville de Clermont-Ferrand",
            "date" => "25 Novembre 2025, à partir de 20h00"
        ],
        [
            "titre" => "Ateliers d'Astronomie",
            "description" => "Participez à un atelier interactif d'astronomie et apprenez à utiliser un télescope...",
            "lieu" => "Centre d'Astronomie de la Vallée, Région Rhône-Alpes, Ville de Lyon",
            "date" => "30 Mai 2025, de 14h00 à 17h00"
        ],
        [
            "titre" => "Camps d'Astronomie",
            "description" => "Passez une nuit sous les étoiles lors de notre camp d'astronomie...",
            "lieu" => "Forêt de Ciel Bleu, Région de la Dordogne, Ville de Sarlat",
            "date" => "12 Juillet 2025, du 12 au 13 Juillet"
        ],
        [
            "titre" => "Stages d'Astronomie",
            "description" => "Rejoignez notre stage d'astronomie et perfectionnez vos connaissances...",
            "lieu" => "Université des Sciences Célestes, Région Île-de-France, Ville de Paris",
            "date" => "22-24 Juin 2025"
        ],
        [
            "titre" => "Observation d'Étoiles au Milieu de la Nature",
            "description" => "Évadez-vous dans la nature et observez les étoiles loin des lumières de la ville...",
            "lieu" => "Parc Naturel du Grand Lac, Région de la Savoie, Ville de Chambéry",
            "date" => "20 Août 2025, de 21h00 à 23h30"
        ],
        [
            "titre" => "Des Aventures Astronomiques dans le Monde Virtuel (VR)",
            "description" => "Explorez l'univers de manière immersive grâce à notre expérience de réalité virtuelle...",
            "lieu" => "Centre de Réalité Virtuelle, Région de Provence-Alpes-Côte d'Azur, Ville de Nice",
            "date" => "18 Septembre 2025, de 10h00 à 18h00"
        ]
    ];

    foreach ($evenements as $i => $e) {
        echo "<div id='evenement" . ($i + 1) . "'>";
        echo "<h2>" . $e["titre"] . "</h2>";
        echo "<p>" . $e["description"] . "<br><strong>Lieu :</strong> " . $e["lieu"] . "<br><strong>Date :</strong> " . $e["date"] . "</p>";
        echo "</div><hr>";
    }
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<a href="events.php">retour</a>
</body>
</html>