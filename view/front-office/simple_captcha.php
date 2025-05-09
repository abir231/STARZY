<?php
// Démarrer la session pour stocker le mot captcha
session_start();

// Inclure le fichier de configuration
require_once('../../config/captcha_config.php');

// Générer un mot aléatoire
$captcha_word = generateCaptchaWord();

// Stocker le mot en session pour vérification ultérieure
$_SESSION['captcha_word'] = $captcha_word;

// Sortie HTML
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Captcha Simple</title>
    <style>
        .captcha-text {
            font-family: monospace;
            font-size: 24px;
            letter-spacing: 5px;
            background: #0a0818;
            color: #00BFFF;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            user-select: none;
        }
    </style>
</head>
<body>
    <div class="captcha-text"><?php echo $captcha_word; ?></div>
</body>
</html> 