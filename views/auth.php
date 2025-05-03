<?php
session_start();
require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../models/User.php';

// Debug
file_put_contents('auth.log', "\n\n".date('Y-m-d H:i:s')." - Nouvelle tentative\n", FILE_APPEND);

try {
    $db = new Database();
    $userModel = new User($db->getConnection());

    // Validation
    if (empty($_POST['email']) || empty($_POST['password'])) {
        throw new Exception("Tous les champs sont requis");
    }

    // Tentative de connexion
    $user = $userModel->login($_POST['email'], $_POST['password']);

    if ($user) {
        // Stockage en session (version structurée recommandée)
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role'],
            'name' => $user['name']
        ];

        file_put_contents('auth.log', "Connexion réussie: ".$user['email']."\n", FILE_APPEND);
        
        // Redirection selon le rôle
        if ($user['role'] === 'admin') {
            header('Location: ../views/users.php');
        } else {
            header('Location: ../views/profile.php');
        }
     
    } else {
        throw new Exception("Identifiants incorrects");
    }

} catch (Exception $e) {
    file_put_contents('auth.log', "ERREUR: ".$e->getMessage()."\n", FILE_APPEND);
    $_SESSION['login_error'] = $e->getMessage();
    header('Location: login.php');
    exit;
}
?>