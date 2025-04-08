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
}
?>