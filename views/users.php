<?php
session_start();
                                         




 
require_once "../controllers/UserController.php";

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
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2e2d2b, #1b1b1b);
            color: #f0f0f0;
        }

        .card {
            background: #333;
            border: 1px solid #555;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }

        .table th, .table td {
            color: #e0e0e0;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #444;
        }

        .btn-custom {
            background-color: #1f8efa;
            color: #fff;
            border: none;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .btn-danger-custom {
            background-color: #e74c3c;
            color: #fff;
            border: none;
        }

        .btn-danger-custom:hover {
            background-color: #c0392b;
        }

        .container-xl {
            margin-top: 30px;
        }

        .navbar {
            background-color: #111;
        }

        .navbar-brand, .navbar-nav a {
            color: #f0f0f0;
        }

        .navbar-brand:hover, .navbar-nav a:hover {
            color: #1f8efa;
        }
        
        .search-box {
            margin-bottom: 20px;
        }
        
        .welcome-section {
            background: rgba(0, 0, 0, 0.2);
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_dashboard.php">Admin Panel</a>
            <div class="navbar-nav">
                <span class="nav-link">Bienvenue, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                <a class="nav-link" href="../views/logout.php">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container-xl">
        <!-- Section Bienvenue -->
        <div class="welcome-section">
            <h1>Bienvenue Administrateur <?php echo htmlspecialchars($_SESSION['user_email']); ?></h1>
            <p class="lead">Vous pouvez gérer tous les utilisateurs du système depuis ce panneau.</p>
        </div>

        <!-- Gestion des utilisateurs -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Gestion des utilisateurs</h4>
                <form method="GET" action="" class="d-flex">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Rechercher par nom..." 
                               value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" class="btn btn-custom">Rechercher</button>
                        <?php if (!empty($search)): ?>
                            <a href="admin_dashboard.php" class="btn btn-secondary">Réinitialiser</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="5" class="text-center">
                                    Aucun utilisateur trouvé <?= !empty($search) ? 'correspondant à "' . htmlspecialchars($search) . '"' : '' ?>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td><?= htmlspecialchars($user['name']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= $user['role'] ?></td>
                                    <td>
                                        <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-custom btn-sm">Modifier</a>
                                        <a href="users.php?action=delete&id=<?= $user['id'] ?>" 
                                           class="btn btn-danger-custom btn-sm"
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur?')">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Lien vers les scripts Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <script>
            $(document).ready(function() {
                alert("Opération effectuée avec succès!");
            });
        </script>
    <?php endif; ?>
</body>
</html>