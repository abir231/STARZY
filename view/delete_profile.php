<?php
session_start();
require_once __DIR__ . '/../model/Profile.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user']['id'];

$profileModel = new Profile();
$success = $profileModel->deleteByUserId($userId);

if ($success) {
    $_SESSION['message'] = "Profil supprimé avec succès.";
} else {
    $_SESSION['error'] = "Erreur lors de la suppression du profil.";
}

header("Location: profile.php");
exit;
