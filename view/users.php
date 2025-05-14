<?php
session_start();
                                         
require_once __DIR__ . "/../controller/UserController.php";

// Récupérer le terme de recherche s'il existe
$search = isset($_GET['search']) ? trim($_GET['search']) : ''; 

// Récupérer les utilisateurs
$controller = new UserController();
$users = $controller->getAllUsers(); 

// Filtrer les utilisateurs si un terme de recherche est présent 
if (!empty($search)) {
    $users = array_filter($users, function($user) use ($search) {
        return stripos($user['name'], $search) !== false;
    });
}

// Gestion de la suppression
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $controller->deleteUser($_GET['id']);
    header("Location: users.php?success=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstroAdmin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --space-blue: #0a1a2f;
            --space-purple: #4e2a8e;
            --neon-blue: #00f0ff;
            --neon-pink: #ff00aa;
            --star-white: #e0e0e0;
            --dark-matter: #0d0d1a;
        }
        
        body {
            background: var(--space-blue);
            color: var(--star-white);
            font-family: 'Roboto', sans-serif;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(78, 42, 142, 0.15) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(0, 240, 255, 0.1) 0%, transparent 20%),
                url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><circle cx="10" cy="10" r="0.5" fill="white" opacity="0.8"/><circle cx="30" cy="70" r="0.7" fill="white" opacity="0.6"/><circle cx="80" cy="20" r="0.3" fill="white" opacity="0.9"/><circle cx="60" cy="50" r="0.4" fill="white" opacity="0.7"/><circle cx="90" cy="90" r="0.5" fill="white" opacity="0.5"/></svg>');
        }

        h1, h2, h3, h4, .navbar-brand {
            font-family: 'Orbitron', sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .card {
            background: rgba(13, 13, 26, 0.8);
            border: 1px solid rgba(0, 240, 255, 0.2);
            border-radius: 10px;
            backdrop-filter: blur(10px);
            box-shadow: 0 0 20px rgba(0, 240, 255, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 240, 255, 0.2);
        }

        .table th, .table td {
            color: var(--star-white);
            border-color: rgba(0, 240, 255, 0.1);
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 240, 255, 0.05);
        }

        .btn-neon {
            background: transparent;
            color: var(--neon-blue);
            border: 1px solid var(--neon-blue);
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
            z-index: 1;
        }

        .btn-neon:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 240, 255, 0.4), transparent);
            transition: 0.5s;
            z-index: -1;
        }

        .btn-neon:hover {
            color: var(--space-blue);
            box-shadow: 0 0 10px var(--neon-blue), 0 0 20px var(--neon-blue);
        }

        .btn-neon:hover:before {
            left: 100%;
        }

        .btn-danger-neon {
            background: transparent;
            color: var(--neon-pink);
            border: 1px solid var(--neon-pink);
        }

        .btn-danger-neon:hover {
            color: var(--space-blue);
            box-shadow: 0 0 10px var(--neon-pink), 0 0 20px var(--neon-pink);
        }

        .container-xl {
            margin-top: 30px;
        }

        .navbar {
            background: rgba(10, 26, 47, 0.9);
            border-bottom: 1px solid rgba(0, 240, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            color: var(--neon-blue);
            font-weight: 700;
            text-shadow: 0 0 5px rgba(0, 240, 255, 0.5);
        }

        .navbar-nav a {
            color: var(--star-white);
            position: relative;
        }

        .navbar-nav a:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--neon-blue);
            transition: width 0.3s;
        }

        .navbar-nav a:hover {
            color: var(--neon-blue);
        }

        .navbar-nav a:hover:after {
            width: 100%;
        }
        
        .search-box {
            margin-bottom: 20px;
            position: relative;
        }
        
        .search-box input {
            background: rgba(13, 13, 26, 0.8);
            border: 1px solid rgba(0, 240, 255, 0.3);
            color: var(--star-white);
            padding-left: 40px;
            border-radius: 50px;
        }
        
        .search-box input:focus {
            background: rgba(13, 13, 26, 0.9);
            border-color: var(--neon-blue);
            box-shadow: 0 0 10px rgba(0, 240, 255, 0.3);
            color: var(--star-white);
        }
        
        .search-box:before {
            content: '\f002';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            left: 15px;
            top: 10px;
            color: var(--neon-blue);
            z-index: 10;
        }
        
        .welcome-section {
            background: rgba(13, 13, 26, 0.6);
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 3px solid var(--neon-blue);
            position: relative;
            overflow: hidden;
        }
        
        .welcome-section:before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0,240,255,0.1) 0%, transparent 70%);
            animation: pulse 15s infinite linear;
            z-index: -1;
        }
        
        @keyframes pulse {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .admin-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--neon-blue), var(--neon-pink));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: bold;
            color: var(--space-blue);
        }
        
        .glow-text {
            text-shadow: 0 0 10px rgba(0, 240, 255, 0.7);
        }
        
        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }
        
        .status-active {
            background-color: #00ff88;
            box-shadow: 0 0 10px #00ff88;
        }
        
        .status-inactive {
            background-color: #ff5555;
            box-shadow: 0 0 10px #ff5555;
        }
        
        /* Animation for table rows */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        tbody tr {
            animation: fadeIn 0.5s ease-out;
            animation-fill-mode: both;
        }
        
        tbody tr:nth-child(1) { animation-delay: 0.1s; }
        tbody tr:nth-child(2) { animation-delay: 0.2s; }
        tbody tr:nth-child(3) { animation-delay: 0.3s; }
        tbody tr:nth-child(4) { animation-delay: 0.4s; }
        tbody tr:nth-child(5) { animation-delay: 0.5s; }
        tbody tr:nth-child(n+6) { animation-delay: 0.6s; }
        
        /* Floating astronaut */
        .astronaut {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 100px;
            height: 100px;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><circle cx="256" cy="256" r="256" fill="%230a1a2f"/><circle cx="256" cy="256" r="240" fill="%234e2a8e"/><circle cx="256" cy="180" r="80" fill="%23fff"/><circle cx="220" cy="160" r="15" fill="%230a1a2f"/><circle cx="290" cy="160" r="15" fill="%230a1a2f"/><path d="M220 220 q36 20 72 0" fill="none" stroke="%230a1a2f" stroke-width="8"/><path d="M150 350 l30 -60 146 0 30 60 z" fill="%23fff"/><path d="M150 350 l70 80 72 -80" fill="none" stroke="%2300f0ff" stroke-width="8"/></svg>');
            background-size: contain;
            z-index: 100;
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_dashboard.php">
                <i class="fas fa-rocket me-2"></i>AstroAdmin
            </a>
            <div class="navbar-nav ms-auto align-items-center">
                <div class="admin-avatar">
                    <?= strtoupper(substr($_SESSION['user_name'], 0, 1)) ?>
                </div>
                <span class="nav-link me-3"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                <a class="btn btn-neon btn-sm" href="../view/logout.php">
                    <i class="fas fa-power-off me-1"></i> Déconnexion
                </a>
            </div>
        </div>
    </nav>

    <div class="container-xl">
        <!-- Section Bienvenue -->
        <div class="welcome-section mb-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="glow-text">Commande Spatiale</h1>
                    <p class="lead mb-0">Bienvenue Commandant <?= htmlspecialchars($_SESSION['user_email']) ?></p>
                    <p class="text-muted">Système de gestion de l'équipage interstellaire</p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="status-indicator status-active"></span>
                    <span>Système opérationnel</span>
                </div>
            </div>
        </div>

        <!-- Gestion des utilisateurs -->
        <div class="card mb-5">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-users me-2"></i>Gestion de l'équipage
                </h4>
                <form method="GET" action="" class="d-flex" id="searchForm">
                    <div class="input-group search-box">
                        <input type="text" name="search" id="searchInput" class="form-control ps-4" 
                               placeholder="Rechercher un membre d'équipage..." 
                               value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" class="btn btn-neon">
                            <i class="fas fa-search"></i>
                        </button>
                        <?php if (!empty($search)): ?>
                            <a href="admin_dashboard.php" class="btn btn-neon ms-2">
                                <i class="fas fa-sync-alt"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th><i class="fas fa-id-card me-1"></i> ID</th>
                                <th><i class="fas fa-user-astronaut me-1"></i> Nom</th>
                                <th><i class="fas fa-envelope me-1"></i> Email</th>
                                <th><i class="fas fa-user-shield me-1"></i> Rôle</th>
                                <th><i class="fas fa-space-shuttle me-1"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTable">
                            <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fas fa-user-slash me-2"></i>
                                        Aucun membre d'équipage <?= !empty($search) ? 'correspondant à "' . htmlspecialchars($search) . '"' : 'trouvé' ?>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td>#<?= $user['id'] ?></td>
                                        <td>
                                            <span class="status-indicator <?= $user['status'] ?? 1 ? 'status-active' : 'status-inactive' ?>"></span>
                                            <?= htmlspecialchars($user['name']) ?>
                                        </td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $user['role'] === 'admin' ? 'info' : 'secondary' ?>">
                                                <?= $user['role'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-neon btn-sm">
                                                <i class="fas fa-edit me-1"></i>Modifier
                                            </a>
                                            <a href="users.php?action=delete&id=<?= $user['id'] ?>" 
                                               class="btn btn-danger-neon btn-sm"
                                               onclick="return confirm('Confirmer l\'éjection de ce membre de l\'équipage?')">
                                               <i class="fas fa-trash-alt me-1"></i>Éjecter
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="astronaut"></div>

    <!-- Lien vers les scripts Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Recherche dynamique
        $(document).ready(function() {
            // Délai pour éviter des requêtes trop fréquentes
            var delayTimer;
            $('#searchInput').on('input', function() {
                clearTimeout(delayTimer);
                delayTimer = setTimeout(function() {
                    performSearch();
                }, 300);
            });
            
            function performSearch() {
                var searchTerm = $('#searchInput').val();
                $.ajax({
                    url: 'admin_dashboard.php',
                    type: 'GET',
                    data: { search: searchTerm },
                    success: function(data) {
                        // Extraire juste le tbody de la réponse
                        var newTableBody = $(data).find('#usersTable').html();
                        $('#usersTable').html(newTableBody);
                        
                        // Réappliquer les animations
                        $('#usersTable tr').each(function(index) {
                            $(this).css('animation', 'fadeIn 0.5s ease-out ' + (index * 0.1) + 's both');
                        });
                    }
                });
            }
        });

        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            $(document).ready(function() {
                // Notification moderne au lieu d'une alert
                var notification = $('<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">' +
                    '<div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">' +
                    '<div class="toast-header bg-success text-white">' +
                    '<strong class="me-auto">Succès</strong>' +
                    '<button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>' +
                    '</div>' +
                    '<div class="toast-body bg-dark">' +
                    'Opération effectuée avec succès!' +
                    '</div>' +
                    '</div>' +
                    '</div>');
                
                $('body').append(notification);
                
                // Fermer automatiquement après 3 secondes
                setTimeout(function() {
                    notification.find('.toast').toast('hide');
                    setTimeout(function() {
                        notification.remove();
                    }, 500);
                }, 3000);
            });
        <?php endif; ?>
    </script>
</body>
</html>