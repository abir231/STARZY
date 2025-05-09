<?php
// Vérifier si l'extension GD est disponible
if (extension_loaded('gd') && function_exists('gd_info')) {
    echo "<h2>Extension GD disponible</h2>";
    echo "<pre>";
    print_r(gd_info());
    echo "</pre>";
} else {
    echo "<h2>L'extension GD n'est pas disponible</h2>";
    echo "<p>Veuillez activer l'extension GD dans PHP pour utiliser le captcha.</p>";
    echo "<p>Dans votre fichier php.ini, décommentez la ligne : extension=gd</p>";
}
?> 