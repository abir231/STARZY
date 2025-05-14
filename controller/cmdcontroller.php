<?php
require_once(__DIR__ . '/../config/database.php');

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

    public function deleteCommandebyidprod($id) {
        $db = config::getConnexion();
        $sql = "DELETE FROM commande WHERE id_produit = :id";  
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
    public function getPrixProduit($id_produit) {
        $db = config::getConnexion();
        $sql = "SELECT prix FROM produit WHERE id = :id";
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id_produit]);
            $result = $query->fetch();
            return $result ? $result['prix'] : null;
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    public function updatemontant($id) {
        $db = config::getConnexion();
        $sql = "UPDATE commande 
            SET montant = montant -(select prix from produits where produits.ID = commande.id_produit) 
            WHERE id_commande = :id;
            ";
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id' => $id,
                
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    public function updatemontantplus($id) {
        $db = config::getConnexion();
        $sql = "UPDATE commande 
            SET montant = montant + (select prix from produits where produits.ID = commande.id_produit)  
            WHERE id_commande = :id;
            ";
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id' => $id,
                
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    
    // Dans ton modèle (par exemple cmdmodel.php)
// Dans ton modèle (par exemple cmdmodel.php)
public function updateAllAdresses($adresse) {
    $db = config::getConnexion();
    $sql = "UPDATE commande SET adresse = :adresse";
    try {
        $query = $db->prepare($sql);
        $query->execute([
            'adresse' => $adresse
        ]);
    } catch (Exception $e) {
        die('Erreur de mise à jour: ' . $e->getMessage());
    }
}

public function updateStatutCommande($id_commande, $nouveau_statut) {
    // Appel de la méthode qui effectue la mise à jour dans la base de données
    $db = config::getConnexion(); // Assure-toi que la connexion à la base de données est bien gérée
    $sql = "UPDATE commande SET statut = :statut WHERE id_commande = :id_commande";
    try {
        $query = $db->prepare($sql);
        $query->execute([
            'statut' => $nouveau_statut,
            'id_commande' => $id_commande
        ]);
    } catch (Exception $e) {
        die('Erreur lors de la mise à jour du statut : ' . $e->getMessage());
    }
}
}
     

?>
