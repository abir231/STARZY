<?php
// Active le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Initialisation
require_once __DIR__.'/config/database.php';
require_once __DIR__.'/models/User.php';

// 2. Crée un utilisateur TEST si besoin
$db = new Database();
$pdo = $db->getConnection();
$pdo->exec("INSERT IGNORE INTO users (name, email, password, role) VALUES 
    ('Test User', 'test@test.com', '".password_hash('123456', PASSWORD_DEFAULT)."', 'user')");

// 3. Test de connexion
$userModel = new User($pdo);
$result = $userModel->login('test@test.com', '123456'); // Email/mdp garantis

// 4. Affiche le résultat
echo "<h1>Résultat du test</h1>";
if ($result) {
    echo "<div style='background:green;color:white;padding:20px;'>";
    echo "SUCCÈS ! Voici les données utilisateur :";
    echo "<pre>".print_r($result, true)."</pre>";
    echo "</div>";
} else {
    echo "<div style='background:red;color:white;padding:20px;'>";
    echo "ÉCHEC. Vérifie que :";
    echo "<ul>";
    echo "<li>La table 'users' existe</li>";
    echo "<li>L'utilisateur test@test.com est présent</li>";
    echo "<li>Le mot de passe est haché avec password_hash()</li>";
    echo "</ul>";
    
    // Debug supplémentaire
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    echo "<p>Table 'users' existe: ".($stmt->rowCount() ? 'OUI' : 'NON')."</p>";
}
?>