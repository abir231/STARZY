<?php
require_once('../config.php'); 
require_once('../model/cmdmodel.php'); 

class CommandeController {

    // Récupérer toutes les commandes
    public function getCommandes() {
        $db = config::getConnexion(); 
        $sql = "SELECT id_commande, id_client, id_produit, date, statut, montant, adresse FROM commande";  
        try {
            $query = $db->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Ajouter une commande
    public function addCommande($commande) {
        $db = config::getConnexion(); 
        $sql = "INSERT INTO commande (id_client, id_produit, date, statut, montant, adresse) 
                VALUES (:id_client, :id_produit, :date, :statut, :montant, :adresse)";
        
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id_client' => $commande['id_client'],
                'id_produit' => $commande['id_produit'],
                'date' => $commande['date'],
                'statut' => $commande['statut'],
                'montant' => $commande['montant'],
                'adresse' => $commande['adresse']
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    
    // Supprimer une commande
    public function deleteCommande($id) {
        $db = config::getConnexion();
        $sql = "DELETE FROM commande WHERE id_commande = :id";  
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Récupérer une commande par son ID
    public function getCommandeById($id) {
        $db = config::getConnexion();
        $sql = "SELECT id_commande, id_client, id_produit, date, statut, montant, adresse FROM commande WHERE id_commande = :id";
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            return $query->fetch();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Mettre à jour une commande
    public function updateCommande($id, $id_client, $id_produit, $date, $statut, $montant, $adresse) {
        $db = config::getConnexion();
        $sql = "UPDATE commande SET id_client = :id_client, id_produit = :id_produit, date = :date, 
                statut = :statut, montant = :montant, adresse = :adresse WHERE id_commande = :id";
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id' => $id,
                'id_client' => $id_client,
                'id_produit' => $id_produit,
                'date' => $date,
                'statut' => $statut,
                'montant' => $montant,
                'adresse' => $adresse
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
}
?>
