<?php
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Users</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
        </div>
    </nav>

    <!-- Container principal -->
    <div class="container-xl">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">User Management</h4>
                <form method="GET" action="" class="d-flex">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by name..." 
                               value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" class="btn btn-custom">Search</button>
                        <?php if (!empty($search)): ?>
                            <a href="users.php" class="btn btn-secondary">Reset</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="5" class="text-center">
                                    No users found <?= !empty($search) ? 'matching "' . htmlspecialchars($search) . '"' : '' ?>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td><?= $user['name'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td><?= $user['role'] ?></td>
                                    <td>
                                        <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-custom btn-sm">Edit</a>
                                        <a href="../index.php?action=delete&id=<?= $user['id'] ?>" class="btn btn-danger-custom btn-sm">Delete</a>
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
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <script>
        alert("Login successful. Welcome!");
    </script>
<?php endif; ?>