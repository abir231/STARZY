<?php
/**
 * Configuration pour un captcha simple
 * Génère des mots aléatoires et gère la vérification
 */

// Liste de mots pour le captcha
$captcha_words = [
    'etoile', 'planete', 'galaxie', 'univers', 'comete', 
    'nebuleuse', 'astronome', 'satellite', 'telescope', 'cosmos',
    'soleil', 'lune', 'jupiter', 'mars', 'saturne',
    'venus', 'mercure', 'neptune', 'uranus', 'pluton',
    'fusion', 'gravite', 'orbite', 'lumiere', 'espace'
];

// Fonction pour générer un mot aléatoire
function generateCaptchaWord() {
    global $captcha_words;
    $index = array_rand($captcha_words);
    return $captcha_words[$index];
}
?> 