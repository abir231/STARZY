<?php
// Démarrer la session pour accéder au mot captcha
session_start();

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclure les fichiers nécessaires
    require_once('C:\xampp\htdocs\chaima\controller\ressourceC.php');
    require_once('C:\xampp\htdocs\chaima\model\ressource.php');

    $ressourceC = new ressourceC();
    
    // Vérifier le captcha
    if (!isset($_POST['captcha']) || !isset($_SESSION['captcha_word']) || 
        strtolower($_POST['captcha']) !== strtolower($_SESSION['captcha_word'])) {
        // Si le captcha n'est pas valide
        ?>
        <script>
            alert("Code de sécurité incorrect. Veuillez réessayer.");
            window.location.href = 'front-office/ressource.php';
        </script>
        <?php
        exit();
    }
    
    // Réinitialiser le captcha après vérification (pour éviter la réutilisation)
    unset($_SESSION['captcha_word']);

    // Vérifier que tous les champs requis sont définis et non vides
    if (
        isset($_POST["titre"], $_POST["type_ressource"], $_POST["categorie"], $_POST["date_publication"], $_POST["description"], $_POST["fichier_ou_lien"], $_POST["statut"]) &&
        !empty($_POST["titre"]) &&
        !empty($_POST["type_ressource"]) &&
        !empty($_POST["categorie"]) &&
        !empty($_POST["date_publication"]) &&
        !empty($_POST["description"]) &&
        !empty($_POST["fichier_ou_lien"]) &&
        !empty($_POST["statut"])
    ) {
        // Création de l'objet ressource avec les données du formulaire
        $ressource = new Ressource(
            null,   // id non passé car auto-incrémenté
            $_POST['titre'],
            $_POST['type_ressource'],
            $_POST['categorie'],
            $_POST['date_publication'],
            $_POST['description'],
            $_POST['fichier_ou_lien'],
            $_POST['statut']
        );

        // Ajouter l'objet ressource à la base de données via le contrôleur
        $ressourceC->addRessource($ressource);

        // Rediriger vers la liste des ressources
        header('Location: /chaima/view/front-office/listeRessourceClient.php');
        exit();
    } else {
        // Si les champs sont invalides ou manquants
        ?>
        <script>
            alert("Veuillez remplir tous les champs requis !");
            window.location.href = 'view/front-office/ressource.php';
        </script>
        <?php
    }
} else {
    // Si la requête n'est pas de type POST
    ?>
    <script>
        alert("Accès non autorisé !");
        window.location.href = 'view/front-office/ressource.php';
    </script>
    <?php
}
?>
