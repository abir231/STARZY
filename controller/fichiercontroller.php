<?php
require_once(__DIR__ .'/../config/database.php'); 
require_once(__DIR__ .'/../model/fichiermodel.php');

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


   
    

    public function addProduit($produit) {
        $db = config::getConnexion();
        $req = "INSERT INTO produits (ID, nom, image, prix, description, categorie, disponibite) 
                VALUES (:id, :nom, :image, :prix, :description, :categorie, :disponibite)";
    
        try {
            // Exécution de la requête avec les données
            $query = $db->prepare($req);
            $query->execute([
                'nom' => $produit->getNomProduit(),
                'image' => $produit->getImage(),
                'prix' => $produit->getPrix(),
                'description' => $produit->getDescription(),
                'categorie' => $produit->getCategorie(),
                'disponibite' => $produit->getDisponibilite(),
                'id' => $produit->getId()
            ]);
    
            // Rediriger vers la page d'affichage des produits après l'ajout
            header('Location: indiv.php'); // Assure-toi que le nom de la page est correct
            exit();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    
    
    // Fonction pour supprimer un produit
    public function deleteProduit($id) {
        $db = config::getConnexion();
        
        // Vérification si l'ID est numérique pour éviter des injections ou erreurs
        if (!is_numeric($id)) {
            die("ID non valide.");
        }
    
        $req = "DELETE FROM produits WHERE ID = :id";  
        try {
            $query = $db->prepare($req);
            // Exécution de la requête avec la bonne clé
            $query->execute(['id' => $id]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    
    public function getProduitById($id) {
        $db = config::getConnexion();
        $sql = "SELECT ID, nom, image, prix, description, categorie, disponibite FROM produits WHERE ID = :id";
        try {
            $query = $db->prepare($sql);
            // Vérification de la validité de l'ID
            if (!is_numeric($id)) {
                die("ID non valide.");
            }
            $query->execute([':id' => $id]);
            return $query->fetch();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    

    // Fonction pour mettre à jour un produit
    public function updateProduit($produit) {
        $db = config::getConnexion();
        $req = "UPDATE produits SET 
                    nom = :nom,
                    image = :image,
                    prix = :prix,
                    description = :description,
                    categorie = :categorie,
                    disponibite = :disponibite
                WHERE ID = :id";
    
        try {
            $query = $db->prepare($req);
            $query->execute([
                'nom' => $produit->getNomProduit(),
                'image' => $produit->getImage(),
                'prix' => $produit->getPrix(),
                'description' => $produit->getDescription(),
                'categorie' => $produit->getCategorie(),
                'disponibite' => $produit->getDisponibilite(),
                'id' => $produit->getId()
            ]);
    
            // Redirection après mise à jour
            
          
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    public function rechercherProduitsParCategorie($categorie) {
        $db = config::getConnexion(); // Connexion à la base de données

        $sql = "SELECT ID, nom, image, prix, description, categorie, disponibite 
        FROM produits 
        WHERE categorie = :categorie";

try {
    $query = $db->prepare($sql);
    $query->bindParam(':categorie', $categorie);
    $query->execute();
    return $query->fetchAll();
} catch (Exception $e) {
    die('Erreur: ' . $e->getMessage());
}
}
public function rechercherProduitsParNom($nom) {
    $db = config::getConnexion(); // Connexion à la base de données

    $sql = "SELECT ID, nom, image, prix, description, categorie, disponibite 
            FROM produits 
            WHERE nom LIKE :nom";

    try {
        $query = $db->prepare($sql);
        $nomRecherche = "%" . $nom . "%"; // Pour chercher une correspondance partielle
        $query->bindParam(':nom', $nomRecherche);
        $query->execute();
        return $query->fetchAll();
    } catch (Exception $e) {
        die('Erreur: ' . $e->getMessage());
    }
}
public function rechercherEtTrierProduits($nom, $critereTri = null) {
    $db = config::getConnexion(); // Connexion à la base de données

    $sql = "SELECT ID, nom, image, prix, description, categorie, disponibite 
            FROM produits 
            WHERE nom LIKE :nom";

    if ($critereTri === 'nom') {
        $sql .= " ORDER BY nom ASC";
    } elseif ($critereTri === 'disponibite') {
        // Ici on trie pour avoir 'oui' avant 'non'
        $sql .= " ORDER BY 
                    CASE disponibite 
                        WHEN 'oui' THEN 0 
                        WHEN 'non' THEN 1 
                        ELSE 2 
                    END, nom ASC";
    }

    try {
        $query = $db->prepare($sql);
        $nomRecherche = "%" . $nom . "%";
        $query->bindParam(':nom', $nomRecherche);
        $query->execute();
        return $query->fetchAll();
    } catch (Exception $e) {
        die('Erreur: ' . $e->getMessage());
    }
}

}

?>
