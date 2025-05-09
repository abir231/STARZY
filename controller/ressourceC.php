<?php
require_once('config.php');

class ressourceC
{
    // Ajouter une ressource
    function addRessource($ressource)
    {
        $sql = "INSERT INTO ressource (titre, type_ressource, categorie, date_publication, description, fichier_ou_lien, statut) 
            VALUES (:titre, :type_ressource, :categorie, :date_publication, :description, :fichier_ou_lien, :statut)";

        $db = config::getConnexion();

        try {
            // Préparation de la requête SQL
            $query = $db->prepare($sql);

            // Exécution de la requête avec les paramètres
            $query->execute([
                'titre' => $ressource->getTitre(),
                'type_ressource' => $ressource->getTypeRessource(),
                'categorie' => $ressource->getCategorie(),
                'date_publication' => $ressource->getDatePublication(),
                'description' => $ressource->getDescription(),
                'fichier_ou_lien' => $ressource->getFichierOuLien(),
                'statut' => $ressource->getStatut(),
            ]);

            return "Ressource ajoutée avec succès!";
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return "Erreur lors de l'ajout de la ressource.";
        } catch (Exception $e) {
            echo 'Erreur générale: ' . $e->getMessage();
            return "Erreur générale.";
        }
    }

    // Liste des ressources
    public function listRessources()
    {
        $sql = "SELECT * FROM ressource";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    // Supprimer une ressource
    function deleteRessource($id)
    {
        $sql = "DELETE FROM ressource WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);
        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    // Afficher une ressource
    function showRessource($id)
    {
        $sql = "SELECT * FROM ressource WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
            $ressource = $query->fetch();
            return $ressource;
        } catch (Exception $e) {
            throw new Exception('Error showing ressource: ' . $e->getMessage());
        }
    }

    // Mettre à jour une ressource
    public function updateRessource($ressource, $id)
    {
        $sql = "UPDATE ressource SET
                    titre = :titre,
                    type_ressource = :type_ressource,
                    categorie = :categorie,
                    date_publication = :date_publication,
                    description = :description,
                    fichier_ou_lien = :fichier_ou_lien,
                    statut = :statut
                WHERE id = :id";

        $db = config::getConnexion();
        $query = $db->prepare($sql);

        $query->bindValue(':titre', $ressource->getTitre());
        $query->bindValue(':type_ressource', $ressource->getTypeRessource());
        $query->bindValue(':categorie', $ressource->getCategorie());
        $query->bindValue(':date_publication', $ressource->getDatePublication());
        $query->bindValue(':description', $ressource->getDescription());
        $query->bindValue(':fichier_ou_lien', $ressource->getFichierOuLien());
        $query->bindValue(':statut', $ressource->getStatut());
        $query->bindValue(':id', $id);

        return $query->execute();
    }

    // Calculer la moyenne des notes pour une ressource
    public function getAverageRating($id)
    {
        $sql = "SELECT AVG(note) as moyenne FROM commentaire WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
            $result = $query->fetch();
            return $result['moyenne'] ? round($result['moyenne'], 1) : 'N/A';
        } catch (Exception $e) {
            return 'N/A';
        }
    }

    // Statistiques
    
    // Obtenir le nombre de ressources par catégorie
    public function getResourcesByCategory()
    {
        $sql = "SELECT categorie, COUNT(*) as total FROM ressource GROUP BY categorie ORDER BY total DESC";
        $db = config::getConnexion();
        try {
            $query = $db->query($sql);
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
            return [];
        }
    }
    
    // Obtenir le nombre de ressources par type
    public function getResourcesByType()
    {
        $sql = "SELECT type_ressource, COUNT(*) as total FROM ressource GROUP BY type_ressource ORDER BY total DESC";
        $db = config::getConnexion();
        try {
            $query = $db->query($sql);
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
            return [];
        }
    }
    
    // Obtenir les ressources les mieux notées
    public function getTopRatedResources($limit = 5)
    {
        $sql = "SELECT r.id, r.titre, AVG(c.note) as moyenne 
                FROM ressource r 
                LEFT JOIN commentaire c ON r.id = c.id 
                GROUP BY r.id, r.titre 
                HAVING moyenne IS NOT NULL 
                ORDER BY moyenne DESC 
                LIMIT :limit";
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
    
    // Obtenir les ressources les plus commentées
    public function getMostCommentedResources($limit = 5)
    {
        $sql = "SELECT r.id, r.titre, COUNT(c.idc) as nb_commentaires 
                FROM ressource r 
                LEFT JOIN commentaire c ON r.id = c.id 
                GROUP BY r.id, r.titre 
                ORDER BY nb_commentaires DESC 
                LIMIT :limit";
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
    
    // Obtenir les statistiques de ressources par mois
    public function getResourcesByMonth()
    {
        $sql = "SELECT DATE_FORMAT(date_publication, '%Y-%m') as mois, COUNT(*) as total 
                FROM ressource 
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
    
    // Obtenir le nombre total de ressources
    public function getTotalResources()
    {
        $sql = "SELECT COUNT(*) as total FROM ressource";
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
}
?>