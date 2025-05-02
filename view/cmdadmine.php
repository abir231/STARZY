<?php
include("../controller/cmdcontroller.php");
include("../controller/fichiercontroller.php");

$produitController = new ProduitController();
$commandeController = new CommandeController(); 
// Gérer la suppression d'une commande
if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];
    $commandeController->deleteCommande($idToDelete);
    header("Location: cmdadmine.php"); // Redirige pour éviter une suppression répétée si on rafraîchit
    exit();
}

// Vérifier si l'ID de la commande est passé via GET
if (isset($_GET['id_commande'])) {
    $id_commande = $_GET['id_commande'];
    
    // Vérifier si la requête est POST et si l'adresse est présente
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adresse']) && !empty($_POST['adresse'])) {
        $adresse = $_POST['adresse'];  // Récupérer l'adresse du formulaire
        
        // Mettre à jour l'adresse dans la base de données
        try {
            $commandeController->updateAdresse($id_commande, $adresse);
            // Rediriger après la mise à jour
            header('Location: cmdadmine.php');
            exit();
        } catch (Exception $e) {
            // Gérer les erreurs si la mise à jour échoue
            echo "Erreur lors de la mise à jour de l'adresse : " . $e->getMessage();
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Afficher un message d'erreur si l'adresse est vide
        echo "L'adresse ne peut pas être vide.";
    }
} 

// Récupérer la liste des commandes
$list = $commandeController->getCommandes();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STARZY Admin - Cosmic Theme</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.css">
    <style>
        :root {
            --primary-dark: #0f0c29;
            --primary-medium: #1a237e;
            --primary-light:rgb(229, 227, 231);
            --accent-gold: #FFD700;
            --accent-pink: rgb(207, 144, 165);
            --text-light: #f8f9fa;
            --sidebar-width: 280px;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, var(--primary-dark), var(--primary-medium));
            color: var(--text-light);
            min-height: 100vh;
        }

        /* ========== COSMIC NAVBAR ========== */
        .cosmic-nav-container {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-medium) 100%);
            padding: 0 2rem;
            height: 80px;
            z-index: 1000;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
        }

        .cosmic-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
        }

        .cosmic-search-box {
            position: relative;
            margin-right: auto;
            margin-left: 2rem;
        }

        .cosmic-search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
        }

        .cosmic-search-input {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 0.8rem 1rem 0.8rem 3rem;
            border-radius: 30px;
            width: 250px;
            transition: all 0.3s;
        }

        .cosmic-search-input:focus {
            outline: none;
            border-color: #4fc3f7;
            box-shadow: 0 0 0 2px rgba(79, 195, 247, 0.3);
            width: 300px;
        }

        .cosmic-nav-elements {
            display: flex;
            gap: 1.5rem;
        }

        .cosmic-nav-item {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            padding: 0.5rem;
        }

        .cosmic-icon {
            font-size: 1.4rem;
            color: rgba(255, 255, 255, 0.9);
            transition: all 0.3s;
        }

        .cosmic-nav-item:hover .cosmic-icon {
            transform: scale(1.2);
            color: var(--accent-gold);
            filter: drop-shadow(0 0 8px currentColor);
        }

        .cosmic-notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--accent-gold);
            color: var(--primary-dark);
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
            animation: blink 2s infinite;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: linear-gradient(to bottom, var(--primary-dark), var(--primary-medium));
            z-index: 1001;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.2);
        }

        .sidebar-content {
            height: 100%;
            overflow-y: auto;
            padding: 20px 0;
        }

       
        .sidebar-div {
            padding: 15px;
        }

        .sidebar-item {
            margin-bottom: 5px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            border-radius: 8px;
            transition: all 0.3s;
            background: rgba(0, 0, 0, 0.2);
        }

        .sidebar-link i {
            margin-right: 10px;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .sidebar-item.active .sidebar-link {
            background: rgba(207, 144, 165, 0.3);
        }

        /* ========== TABLE STYLES ========== */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: 80px;
            padding: 2rem;
        }

        .table-container {
            background: linear-gradient(to right, var(--primary-dark), var(--primary-medium));
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
            margin-bottom: 2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: linear-gradient(to right, var(--primary-dark), var(--primary-medium));
            color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(207, 144, 165, 0.5);
        }

        th, td {
            padding: 12px 20px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.1);
        }

        tr:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.02);
            transition: all 0.3s;
        }

        th {
            background-color: var(--primary-medium);
            font-weight: bold;
            text-transform: uppercase;
        }

        table, th, td {
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            display: inline-block;
        }

        .status-active {
            background: rgba(0, 200, 83, 0.2);
            color: #00c853;
        }

        .status-pending {
            background: rgba(255, 171, 0, 0.2);
            color: #ffab00;
        }

        .action-btn {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            margin-right: 10px;
            transition: all 0.2s;
        }

        .action-btn:hover {
            color: var(--accent-gold);
            transform: scale(1.1);
        }

        /* Animations */
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        /* Responsive */
        @media (max-width: 992px) {
            .cosmic-search-input {
                width: 200px;
            }
            .cosmic-search-input:focus {
                width: 250px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .cosmic-nav-container {
                left: 0;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Cosmic Navigation Bar -->
<div class="cosmic-nav-container">
   <div class="cosmic-navbar">
      <!-- Brand Logo with Astronomy Theme -->
      <div class="cosmic-brand">
      <img src="logo.png" alt="Logo STARZY" class="cosmic-logo">
      <span class="cosmic-title">STARZY</span>
      </div>
   </div>
</div>
<style>


/* Logo dans la navbar */
.cosmic-logo {
    height: 160px; /* Ajuster la hauteur du logo, ici 30px */
    width: auto; /* Garder les proportions du logo */
}


<style>
/* Conteneur des éléments de la navbar (notifications, utilisateur...) */
.cosmic-nav-elements {
    display: flex;
    align-items: center;
}

/* Éléments de la navbar (icônes) */
.cosmic-nav-item {
    margin-left: 20px;
    position: relative;
}

/* Icônes de la navbar */
.cosmic-icon {
    color: white;
    font-size: 18px;
}

/* Badge de notification */
.cosmic-notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background-color: red;
    color: white;
    border-radius: 50%;
    font-size: 12px;
    padding: 2px 6px;
}
</style>
<style>
.cosmic-brand {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.cosmic-title {
    font-size: 2rem;
    font-weight: bold;
    color: var(--accent-gold);
    text-shadow: 1px 1px 5px black;
}
</style>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-content">
           
            <div class="sidebar-div">
                <ul>
                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="">
                            <i data-feather="sliders"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="">
                            <i data-feather="book"></i>
                            <span>Activités</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="">
                            <i data-feather="grid"></i>
                            <span>Patrimoines</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="">
                            <i data-feather="user"></i>
                            <span>Comptes</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="">
                            <i data-feather="calendar"></i>
                            <span>Événements</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="">
                            <i data-feather="users"></i>
                            <span>Utilisateurs</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Cosmic Navbar -->
    <div class="cosmic-nav-container">
    <div class="cosmic-navbar">
        <!-- Logo dans la navbar -->
        <div class="cosmic-logo-container">
            <img src="logo.png" alt="Logo" class="cosmic-logo">
        </div>

        <div class="cosmic-search-box">
            <i class="fas fa-search cosmic-search-icon"></i>
            <input type="text" class="cosmic-search-input" placeholder="Rechercher...">
        </div>
        
        <div class="cosmic-nav-elements">
            <div class="cosmic-nav-item">
                <i class="fas fa-home cosmic-icon"></i>
                <span class="cosmic-notification-badge">3</span>
            </div>
            <div class="cosmic-nav-item">
                <i class="fas fa-bell cosmic-icon"></i>
                <span class="cosmic-notification-badge">5</span>
            </div>
            <div class="cosmic-nav-item">
                <i class="fas fa-user cosmic-icon"></i>
            </div>
        </div>
    </div>
</div>

   <!-- Main Content -->
<div class="main-content">
    <div class="table-container">
        <h2><i class="fas fa-table"></i> Tableau des commandes </h2>
        
        <table>
            <thead>
                <tr>
                    <th>Nom de produits</th>
                    <th>Nom</th>
                    <th>Montant</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>adresse </th>
                    <th>Actions</th>

                </tr>
            </thead>
            <tbody>
            <?php foreach($list as $cmd): ?>
                <tr>
                    <?php
                        // Récupérer le produit associé à la commande à l'aide de l'ID du produit
                        $produitInfo = $produitController->getProduitById($cmd['id_produit']); 
                        if ($produitInfo === null) {
                            // Si aucun produit trouvé, on peut afficher un message d'erreur ou une valeur par défaut
                            $produitInfo = ['nom' => 'Produit non trouvé', 'ID' => 'N/A'];
                        } // Assurez-vous que $cmd['id_produit'] est bien un ID valide
                        ?>
                    <td>
                        <h6 class="mb-1"><?= htmlspecialchars($produitInfo ['nom']) ?></h6>
                        <small class="text-muted">Réf: PROD-<?= htmlspecialchars($produitInfo ['ID']) ?></small>
                    </td>
                    <td><?= htmlspecialchars($cmd['id_client']) ?></td> <!-- ou le nom du client si tu l’as -->
                    <td><?= htmlspecialchars($cmd['montant']) ?> TND</td>
                    <td><?= htmlspecialchars($cmd['date']) ?></td>
                    
                    <td>
                        <?php if ($cmd['statut'] == 'En attente'): ?>
                            <span class="status-badge status-pending"><?= $cmd['statut'] ?></span>
                        <?php elseif ($cmd['statut'] == 'Actif' || $cmd['statut'] == 'Confirmée'): ?>
                            <span class="status-badge status-active"><?= $cmd['statut'] ?></span>
                        <?php else: ?>
                            <span class="status-badge"><?= $cmd['statut'] ?></span>
                        <?php endif; ?>
                        
                    </td>
                    <td>
                    <small class="text-primary"><?= htmlspecialchars($cmd['adresse']) ?></small>
                </td>
                    

                    <td>
                        <button class="action-btn"><i class="fas fa-eye"></i></button>
                        <button class="action-btn"><i class="fas fa-edit"></i></button>
                        <a class="action-btn" href="?delete=<?= $cmd['id_commande'] ?>" onclick="return confirm('Voulez-vous vraiment supprimer cette commande ?');">
    <i class="fas fa-trash"></i>
</a>

                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();
    </script>
</body>
</html>