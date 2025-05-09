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

    // Statistiques
    
    // Obtenir le nombre total de commentaires
    public function getTotalComments()
    {
        $sql = "SELECT COUNT(*) as total FROM commentaire";
        $db = config::getConnexion();
        try {
            $query = $db->query($sql);
            $result = $query->fetch();
            return $result['total'];
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
            return 0;
        }
    }
    
    // Obtenir la répartition des notes
    public function getRatingDistribution()
    {
        $sql = "SELECT note, COUNT(*) as total FROM commentaire GROUP BY note ORDER BY note";
        $db = config::getConnexion();
        try {
            $query = $db->query($sql);
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
            return [];
        }
    }
    
    // Obtenir la moyenne globale des notes
    public function getOverallAverageRating()
    {
        $sql = "SELECT AVG(note) as moyenne FROM commentaire";
        $db = config::getConnexion();
        try {
            $query = $db->query($sql);
            $result = $query->fetch();
            return $result['moyenne'] ? round($result['moyenne'], 1) : 'N/A';
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
            return 'N/A';
        }
    }
    
    // Obtenir les commentaires par mois
    public function getCommentsByMonth()
    {
        $sql = "SELECT DATE_FORMAT(datec, '%Y-%m') as mois, COUNT(*) as total 
                FROM commentaire 
                GROUP BY mois 
                ORDER BY mois";
        $db = config::getConnexion();
        try {
            $query = $db->query($sql);
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
            return [];
        }
    }
    
    // Obtenir les ressources avec le plus grand nombre de commentaires
    public function getMostCommentedResources($limit = 5)
    {
        $sql = "SELECT id, COUNT(*) as total FROM commentaire GROUP BY id ORDER BY total DESC LIMIT :limit";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':limit', $limit, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
            return [];
        }
    }
}
?>
