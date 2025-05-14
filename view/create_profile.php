<?php
session_start();
require_once __DIR__ . '/../model/Profile.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$profile = new Profile();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bio = $_POST['bio'];
    $date_naissance = $_POST['date_naissance'];
    $avatar = null;

    if (!empty($_FILES['avatar']['name'])) {
        $target_dir = "uploads/";
        $avatar = basename($_FILES["avatar"]["name"]);
        move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_dir . $avatar);
    }

    // Définir les attributs de l'objet
    $profile->bio = $bio;
    $profile->date_naissance = $date_naissance;
    $profile->avatar = $avatar;
    $profile->user_id = $user['id'];

    if ($profile->exists($user['id'])) {
        // Le profil existe, on fait un update
        $profile->edit($user['id'], $bio, $avatar, $date_naissance);
    } else {
        // Le profil n'existe pas, on le crée
        $profile->create();
    }
    

    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Compléter le profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Compléter mon profil</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="bio" class="form-label">Bio</label>
            <textarea name="bio" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="date_naissance" class="form-label">Date de naissance</label>
            <input type="date" name="date_naissance" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="avatar" class="form-label">Photo de profil</label>
            <input type="file" name="avatar" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Sauvegarder</button>
    </form>
</body>
</html>
