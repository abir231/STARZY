<?php
require_once('../config.php'); 
require_once('../model/cmdmodel.php');

 // Connexion à la base de données

class ProduitController {

    // Fonction pour récupérer tous les produits
    public function getProduits() {
        $db = config::getConnexion(); // Connexion à la base de données
        $sql = "SELECT ID, nom, image, prix, description, categorie, disponibite FROM produits";  
        try {
            $query = $db->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }


   
    

    // Fonction pour ajouter un produit
    public function addProduit($produit) {
        $db = config::getConnexion(); 
        $req = "INSERT INTO produits (nom, image, prix, description, categorie, disponibite) 
                VALUES (:nom_produit, :image, :prix, :description, :categorie, :disponibite)";
        
        try {
            // Exécution de la requête avec les données
            $query = $db->prepare($req);
            $query->execute([
                'nom' => $produit['nom'],
                'image' => $produit['image'],
                'prix' => $produit['prix'],
                'description' => $produit['description'],
                'categorie' => $produit['categorie'],
                'disponibite' => $produit['disponibite']
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    
    // Fonction pour supprimer un produit
    public function deleteProduit($id) {
        $db = config::getConnexion();
        $req = "DELETE FROM produits WHERE ID = :id";  
        try {
            $query = $db->prepare($req);
            $query->execute(['ID' => $id]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Fonction pour récupérer un produit par son ID
    public function getProduitById($id) {
        $db = config::getConnexion();
        $sql = "SELECT ID, nom, image, prix, description, categorie, disponibite FROM produits WHERE ID = :id";
        try {
            $query = $db->prepare($sql);
            $query->execute([':id' => $id]);
            return $query->fetch();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Fonction pour mettre à jour un produit
    public function updateProduit($id, $nom_produit, $image, $prix, $description, $categorie, $disponibilite) {
        $db = config::getConnexion();
        $sql = "UPDATE produits SET nom = :nom_produit, image = :image, prix = :prix, 
                description = :description, categorie = :categorie, disponibite = :disponibite WHERE ID = :id";
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'ID' => $id,
                'nom' => $nom_produit,
                'image' => $image,
                'prix' => $prix,
                'description' => $description,
                'categorie' => $categorie,
                'disponibite' => $disponibilite
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
}
?>
