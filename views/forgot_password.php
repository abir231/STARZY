<?php
session_start();
require_once __DIR__ . '/../config/database.php';  // Remonte d'un niveau vers /config
require_once __DIR__ . '/../models/User.php';     // Remonte d'un niveau vers /models

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email invalide";
    } else {
        $user = new User();
        $existingUser = $user->getUserByEmail($email);
        
        if ($existingUser) {
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Mise à jour dans la base
            $query = "UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?";
            $stmt = $user->conn->prepare($query);
            $stmt->execute([$token, $expires, $email]);
            
            // Lien absolu corrigé
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $baseUrl = "http://".$_SERVER['HTTP_HOST'].str_replace('/views/forgot_password.php', '', $_SERVER['SCRIPT_NAME']);
$resetLink = $baseUrl."/views/reset_password.php?token=$token";
            
            $success = '
            <div class="alert alert-success">
                <h5>Lien de test (DEV)</h5>
                <input type="text" id="resetLink" value="'.$resetLink.'" class="form-control mb-2" readonly>
                <button onclick="copyLink()" class="btn btn-secondary">Copier</button>
                <a href="'.$resetLink.'" class="btn btn-primary">Ouvrir</a>
                <script>
                function copyLink() {
                    const link = document.getElementById("resetLink");
                    link.select();
                    document.execCommand("copy");
                    alert("Copié !");
                }
                </script>
            </div>';
        } else {
            $success = '<div class="alert alert-info">Email non trouvé (simulation)</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3>Réinitialisation</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>
                        
                        <?php if ($success): ?>
                            <?= $success ?>
                            <a href="/votre_projet/views/login.php" class="btn btn-link">Retour</a>
                        <?php else: ?>
                            <form method="POST">
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Générer lien</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>