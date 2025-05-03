<?php
require_once 'config/database.php';

$db = new Database();
$pdo = $db->getConnection();

// 1. Vérifie l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute(['sdds@gmail.com']);
$user = $stmt->fetch();

echo "<h2>Test pour sdds@gmail.com</h2>";
echo "<p>Hash en base :<br>".htmlspecialchars($user['password'])."</p>";

// 2. Test avec les 2 mots de passe possibles
$tests = [
    '3Azerty@' => "Ancien mot de passe que tu voulais",
    'password' => "Nouveau mot de passe que tu as hashé"
];

foreach ($tests as $pwd => $description) {
    $valid = password_verify($pwd, $user['password']);
    echo "<p>Avec '<strong>$pwd</strong>' ($description) : ".
         ($valid ? "✅ VALIDE" : "❌ INVALIDE")."</p>";
}
?>