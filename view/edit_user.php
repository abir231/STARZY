<?php
require_once __DIR__ . "/../controller/UserController.php";

// Initialisation de la variable $user pour éviter les erreurs
$user = null;
if (isset($_GET['id'])) {
    $controller = new UserController();
    $user = $controller->getUserById($_GET['id']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Lien Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2e2d2b, #1b1b1b);
            color: #f0f0f0;
            font-family: 'Arial', sans-serif;
        }

        .card {
            background: #333;
            border: 1px solid #555;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.7);
        }

        .card-header {
            background-color: #1f8efa;
            color: white;
            font-weight: bold;
        }

        .card-body {
            background-color: #444;
        }

        .form-control {
            background-color: #555;
            border-color: #666;
            color: #fff;
        }

        .form-control:focus {
            background-color: #666;
            border-color: #1f8efa;
            box-shadow: 0 0 5px rgba(31, 143, 250, 0.8);
        }

        .btn-primary {
            background-color: #1f8efa;
            border-color: #1f8efa;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .btn {
            padding: 0.5rem 1.25rem;
        }

        .alert-warning {
            background-color: #ffcc00;
            color: #333;
        }

        .container {
            margin-top: 30px;
        }

        h3 {
            color: #f0f0f0;
        }

        label {
            color: #bbb;
        }

        /* Make the card responsive */
        @media (max-width: 768px) {
            .card {
                margin: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Container pour centrer et donner de l'espace -->
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Edit User Details</h3>
            </div>
            <div class="card-body">
                <?php if ($user): ?>
                    <!-- Formulaire de mise à jour de l'utilisateur -->
                    <form action="update_user.php" method="POST">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>" />

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputName">Name</label>
                            <input class="form-control" id="inputName" name="name" type="text" placeholder="Enter your name" value="<?= htmlspecialchars($user['name']) ?>" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputEmail">Email</label>
                            <input class="form-control" id="inputEmail" name="email" type="email" placeholder="Enter your email" value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>

                        <!-- Role -->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputRole">Role</label>
                            <input class="form-control" id="inputRole" name="role" type="text" placeholder="Enter role (e.g. user/admin)" value="<?= htmlspecialchars($user['role']) ?>" required>
                        </div>

                        <!-- Button Save -->
                        <button class="btn btn-primary" type="submit" name="update">Save changes</button>
                    </form>
                <?php else: ?>
                    <!-- Message si l'utilisateur n'est pas trouvé -->
                    <div class="alert alert-warning">User not found!</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Lien vers les scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
