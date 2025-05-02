<?php

class Produit {

    // Déclaration des attributs de la classe
    private $id;
    private $image;
    private $prix;
    private $description;
    private $categorie;
    private $disponibilite;
    private $nom_produit;

    // Constructeur pour initialiser les attributs
    public function __construct($id, $image, $prix, $description, $categorie, $disponibilite, $nom_produit) {
        $this->id = $id;
        $this->image = $image;
        $this->prix = $prix;
        $this->description = $description;
        $this->categorie = $categorie;
        $this->disponibilite = $disponibilite;
        $this->nom_produit = $nom_produit;
    }

    // Getters et setters pour accéder et modifier les attributs

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getPrix() {
        return $this->prix;
    }

    public function setPrix($prix) {
        $this->prix = $prix;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getCategorie() {
        return $this->categorie;
    }

    public function setCategorie($categorie) {
        $this->categorie = $categorie;
    }

    public function getDisponibilite() {
        return $this->disponibilite;
    }

    public function setDisponibilite($disponibilite) {
        $this->disponibilite = $disponibilite;
    }

    public function getNomProduit() {
        return $this->nom_produit;
    }

    public function setNomProduit($nom_produit) {
        $this->nom_produit = $nom_produit;
    }

    

}
?>
