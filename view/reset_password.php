<?php
session_start();

// Debug - Vérifiez le chemin
error_log("Chemin actuel: " . __DIR__);

// Inclusion sécurisée
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/User.php';

$error = '';
$success = '';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $userModel = new User();
    
    try {
        $query = "SELECT * FROM users WHERE reset_token = ? AND reset_expires > NOW() LIMIT 1";
        $stmt = $userModel->conn->prepare($query);
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            $_SESSION['error'] = "Lien invalide ou expiré";
            header('Location: forgot_password.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        
        if (empty($password) || empty($confirm_password)) {
            $error = "Veuillez remplir tous les champs";
        } elseif ($password !== $confirm_password) {
            $error = "Les mots de passe ne correspondent pas";
        } elseif (strlen($password) < 8) {
            $error = "Le mot de passe doit contenir au moins 8 caractères";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $query = "UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?";
            $stmt = $userModel->conn->prepare($query);
            
            if ($stmt->execute([$hashedPassword, $user['id']])) {
                $success = "Votre mot de passe a été réinitialisé avec succès.";
            } else {
                $error = "Une erreur s'est produite. Veuillez réessayer.";
            }
        }
    }
        

    } catch(PDOException $e) {
        error_log("Erreur DB: " . $e->getMessage());
        $error = "Erreur système. Veuillez réessayer.";
    }
} else {
    header('Location: forgot_password.php');
    exit;
}

// Le HTML reste identique
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --space-dark: #0f172a;
            --space-light: #1e293b;
            --neon-blue: #38bdf8;
            --neon-purple: #818cf8;
            --plasma: #e879f9;
        }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background-color: var(--space-dark);
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(56, 189, 248, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(129, 140, 248, 0.1) 0%, transparent 50%);
        }

        .password-container {
            max-width: 500px;
            width: 100%;
            margin: 0 auto;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid rgba(56, 189, 248, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            padding: 2rem;
        }
        
        .password-title {
            color: var(--neon-blue);
            text-align: center;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }
        
        .login-btn {
            background: linear-gradient(135deg, var(--neon-blue), var(--neon-purple));
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(56, 189, 248, 0.4);
        }
        
        .form-control {
            background-color: rgba(30, 41, 59, 0.5);
            border: 1px solid rgba(56, 189, 248, 0.3);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 8px;
        }
        
        .form-control:focus {
            border-color: var(--neon-blue);
            box-shadow: 0 0 0 0.25rem rgba(56, 189, 248, 0.25);
        }
        
        .form-label {
            color: var(--neon-blue);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .password-strength {
            height: 5px;
            margin-top: 5px;
            background-color: var(--space-light);
            border-radius: 3px;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: width 0.3s ease;
        }
        
        .error-pulse {
            animation: pulse 0.5s ease;
        }
        
        @keyframes pulse {
            0% { transform: translateX(0); }
            20% { transform: translateX(-5px); }
            40% { transform: translateX(5px); }
            60% { transform: translateX(-5px); }
            80% { transform: translateX(5px); }
            100% { transform: translateX(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="password-container">
            <h2 class="password-title">
                <i class="bi bi-key-fill"></i>
                <span>NOUVEAU MOT DE PASSE</span>
                <i class="bi bi-key-fill"></i>
            </h2>
            
            <?php if ($error): ?>
                <div class="alert alert-danger error-pulse mb-4">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?= htmlspecialchars($success) ?>
                </div>
                <div class="text-center">
                    <a href="login.php" class="login-btn">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        <span>SE CONNECTER</span>
                    </a>
                </div>
            <?php else: ?>
                <form method="POST">
                    <div class="mb-4">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock-fill"></i>
                            <span>NOUVEAU MOT DE PASSE</span>
                        </label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="password-strength">
                            <div class="password-strength-bar" id="password-strength-bar"></div>
                        </div>
                        <small class="text-muted">Minimum 8 caractères</small>
                    </div>
                    
                    <div class="mb-4">
                        <label for="confirm_password" class="form-label">
                            <i class="bi bi-lock-fill"></i>
                            <span>CONFIRMER LE MOT DE PASSE</span>
                        </label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    
                    <button type="submit" class="login-btn">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <span>RÉINITIALISER</span>
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('password-strength-bar');
            let strength = 0;
            
            if (password.length > 0) strength += 20;
            if (password.length >= 8) strength += 20;
            if (/[A-Z]/.test(password)) strength += 20;
            if (/[0-9]/.test(password)) strength += 20;
            if (/[^A-Za-z0-9]/.test(password)) strength += 20;
            
            strengthBar.style.width = strength + '%';
            
            if (strength < 40) {
                strengthBar.style.backgroundColor = '#dc3545';
            } else if (strength < 80) {
                strengthBar.style.backgroundColor = '#ffc107';
            } else {
                strengthBar.style.backgroundColor = '#28a745';
            }
        });
    </script>
</body>
</html>