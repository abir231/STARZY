<?php
// Démarrer la session pour stocker le mot captcha
session_start();

// Inclure le fichier de configuration
require_once('../../config/captcha_config.php');

// Générer un mot aléatoire
$captcha_word = generateCaptchaWord();

// Stocker le mot en session pour vérification ultérieure
$_SESSION['captcha_word'] = $captcha_word;

// Paramètres de l'image
$width = 200;
$height = 60;
$font_size = 24;

// Créer une image vide
$image = imagecreatetruecolor($width, $height);

// Couleurs
$bg_color = imagecolorallocate($image, 20, 8, 24); // Fond sombre
$text_color = imagecolorallocate($image, 0, 191, 255); // Texte bleu clair
$noise_color = imagecolorallocate($image, 138, 43, 226); // Bruit violet

// Remplir le fond
imagefill($image, 0, 0, $bg_color);

// Ajouter du bruit aléatoire (points)
for ($i = 0; $i < 100; $i++) {
    imagesetpixel($image, rand(0, $width), rand(0, $height), $noise_color);
}

// Ajouter du bruit aléatoire (lignes)
for ($i = 0; $i < 5; $i++) {
    imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $noise_color);
}

// Ajouter le texte du captcha
// Différents angles pour chaque lettre
$x = 30;
$length = strlen($captcha_word);

// Vérifier si on peut utiliser les fonctions de texte avancées
if (function_exists('imagettftext')) {
    // Chemins possibles vers les polices
    $fonts = [
        'C:\Windows\Fonts\arial.ttf',
        'C:\Windows\Fonts\verdana.ttf',
        'C:\Windows\Fonts\ARIALBD.TTF',
        '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',  // Linux
        '/usr/share/fonts/TTF/arial.ttf'                    // Linux
    ];
    
    // Trouver une police qui existe
    $font_path = null;
    foreach ($fonts as $font) {
        if (file_exists($font)) {
            $font_path = $font;
            break;
        }
    }
    
    // Si une police a été trouvée, utiliser imagettftext
    if ($font_path) {
        for ($i = 0; $i < $length; $i++) {
            $angle = rand(-15, 15);
            $letter = $captcha_word[$i];
            imagettftext($image, $font_size, $angle, $x, 40, $text_color, $font_path, $letter);
            $x += 20 + rand(0, 10);
        }
    } else {
        // Pas de police TrueType trouvée, utiliser une méthode de secours
        $font_size = 5; // Taille de police pour imagestring (1-5)
        $x = 30;
        for ($i = 0; $i < $length; $i++) {
            $letter = $captcha_word[$i];
            imagestring($image, $font_size, $x, 20, $letter, $text_color);
            $x += 30;
        }
    }
} else {
    // La fonction imagettftext n'est pas disponible
    $font_size = 5; // Taille de police pour imagestring (1-5)
    $x = 30;
    for ($i = 0; $i < $length; $i++) {
        $letter = $captcha_word[$i];
        imagestring($image, $font_size, $x, 20, $letter, $text_color);
        $x += 30;
    }
}

// Envoyer les headers pour l'image
header('Content-Type: image/png');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Sortie de l'image
imagepng($image);
imagedestroy($image);
?> 