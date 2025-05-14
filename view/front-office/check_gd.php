<?php
// Vérifier si l'extension GD est disponible
if (extension_loaded('gd') && function_exists('gd_info')) {
    echo "<h2 style='color: green;'>✅ Extension GD disponible</h2>";
    echo "<pre>";
    print_r(gd_info());
    echo "</pre>";
} else {
    echo "<h2 style='color: red;'>❌ L'extension GD n'est pas disponible</h2>";
    echo "<p>Pour activer l'extension GD :</p>";
    echo "<ol>";
    echo "<li>Ouvrez le fichier php.ini dans C:\xampp\php\</li>";
    echo "<li>Cherchez la ligne <code>;extension=gd</code></li>";
    echo "<li>Retirez le point-virgule au début pour avoir <code>extension=gd</code></li>";
    echo "<li>Sauvegardez le fichier</li>";
    echo "<li>Redémarrez Apache dans XAMPP</li>";
    echo "</ol>";
}

// Vérifier les permissions d'écriture
$upload_dir = __DIR__;
if (is_writable($upload_dir)) {
    echo "<p style='color: green;'>✅ Le dossier est accessible en écriture</p>";
} else {
    echo "<p style='color: red;'>❌ Le dossier n'est pas accessible en écriture</p>";
}

// Vérifier la configuration PHP
echo "<h3>Configuration PHP pertinente :</h3>";
echo "<ul>";
echo "<li>memory_limit: " . ini_get('memory_limit') . "</li>";
echo "<li>upload_max_filesize: " . ini_get('upload_max_filesize') . "</li>";
echo "<li>max_execution_time: " . ini_get('max_execution_time') . "</li>";
echo "</ul>";
?> 