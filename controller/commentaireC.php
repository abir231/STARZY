<?php
require_once('config.php');
require_once(__DIR__.'/../model/commentaire.php');

class CommentaireC
{
    // Ajouter un commentaire
    public function addCommentaire($commentaire)
    {
        $sql = "INSERT INTO commentaire (contenu, datec, note, id) VALUES (:contenu, :datec, :note, :id)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'contenu' => $commentaire->getContenu(),
                'datec' => $commentaire->getDatec(),
                'note' => $commentaire->getNote(),
                'id' => $commentaire->getId(),
            ]);
            return "Commentaire ajouté avec succès !";
        } catch (PDOException $e) {
            echo 'Erreur PDO : ' . $e->getMessage();
            return "Erreur lors de l'ajout du commentaire.";
        } catch (Exception $e) {
            echo 'Erreur générale : ' . $e->getMessage();
            return "Erreur générale.";
        }
    }

    // Liste des commentaires
    public function listCommentaires()
    {
        $sql = "SELECT * FROM commentaire";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
            return null;
        }
    }

    // Supprimer un commentaire
    public function deleteCommentaire($idc)
    {
        $sql = "DELETE FROM commentaire WHERE idc = :idc";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['idc' => $idc]);
            return "Commentaire supprimé.";
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
            return null;
        }
    }

    // Modifier un commentaire
    public function updateCommentaire($commentaire)
    {
        $sql = "UPDATE commentaire SET contenu = :contenu, datec = :datec, note = :note, id = :id WHERE idc = :idc";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'idc' => $commentaire->getIdc(),
                'contenu' => $commentaire->getContenu(),
                'datec' => $commentaire->getDatec(),
                'note' => $commentaire->getNote(),
                'id' => $commentaire->getId(),
            ]);
            return "Commentaire modifié.";
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
            return null;
        }
    }

    // Récupérer un commentaire par ID
    public function getCommentaireById($idc)
    {
        $sql = "SELECT * FROM commentaire WHERE idc = :idc";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['idc' => $idc]);
            return $query->fetch();
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
            return null;
        }
    }
}
?>
