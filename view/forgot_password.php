<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format d'email invalide";
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
            
            // Construction du lien
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $baseUrl = $protocol . "://" . $_SERVER['HTTP_HOST'] . str_replace('/views/forgot_password.php', '', $_SERVER['SCRIPT_NAME']);
            $resetLink = $baseUrl . "/views/reset_password.php?token=$token";
            
            // Configuration de PHPMailer avec gestion améliorée des erreurs
            $mail = new PHPMailer(true);
            
            try {
                // Paramètres SMTP optimisés
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'pondokarfouli456@gmail.com';
                $mail->Password = 'azmv fnue khwb fkhy'; // Mot de passe d'application
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                
                // Options SSL (nécessaires pour certains hébergements)
                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    ]
                ];
                
                // Debugging (à commenter en production)
                $mail->SMTPDebug = 2; // Niveau 2 pour les logs détaillés
                ob_start(); // Capture les messages de debug
                
                // Expéditeur et destinataire
                $mail->setFrom('starzy@gmail.com', 'starzy');
                $mail->addAddress($email);
                
                // Contenu de l'email
                $mail->isHTML(true);
                $mail->Subject = 'Réinitialisation de votre mot de passe';
                $mail->Body = sprintf('
                    <h1>Réinitialisation de mot de passe</h1>
                    <p>Cliquez sur ce lien pour réinitialiser votre mot de passe :</p>
                    <p><a href="%s">Réinitialiser mon mot de passe</a></p>
                    <p>Ce lien expirera dans 1 heure.</p>
                    <p>Si vous n\'avez pas fait cette demande, ignorez cet email.</p>
                ', $resetLink);
                
                $mail->AltBody = sprintf(
                    "Pour réinitialiser votre mot de passe, visitez ce lien : %s (valable 1 heure)",
                    $resetLink
                );
                
                if ($mail->send()) {
                    $success = 'Un email de réinitialisation a été envoyé. Vérifiez votre boîte de réception.';
                    $_SESSION['reset_sent'] = true;
                } else {
                    throw new Exception("L'email n'a pas pu être envoyé.");
                }
                
                $smtp_debug = ob_get_clean(); // Récupère les logs
                error_log($smtp_debug); // Enregistre les logs SMTP
                
            } catch (Exception $e) {
                $error = "Une erreur est survenue lors de l'envoi de l'email. Veuillez réessayer plus tard.";
                error_log("Erreur PHPMailer: " . $e->getMessage() . "\n" . $mail->ErrorInfo);
            }
        } else {
            // Message générique pour éviter la divulgation d'informations
            $success = 'Si votre email existe dans notre système, vous recevrez un lien de réinitialisation.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h3><i class="bi bi-key"></i> Réinitialisation du mot de passe</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <?= htmlspecialchars($error) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($success): ?>
                            <div class="alert alert-success">
                                <?= htmlspecialchars($success) ?>
                                <?php if (isset($_SESSION['reset_sent'])): ?>
                                    <div class="mt-2">
                                        <small class="text-muted">Vérifiez votre dossier spam si vous ne voyez pas l'email.</small>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="login.php" class="btn btn-outline-primary">Retour à la connexion</a>
                            </div>
                        <?php else: ?>
                            <form method="POST" novalidate>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Adresse email</label>
                                    <input type="email" class="form-control" id="email" name="email" required
                                           placeholder="Entrez votre email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                                    <div class="invalid-feedback">
                                        Veuillez entrer une adresse email valide.
                                    </div>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-send"></i> Envoyer le lien de réinitialisation
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validation côté client
        (function() {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>
</html>