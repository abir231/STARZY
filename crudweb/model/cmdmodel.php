<?php
class Commande {
    private int $id_commande;
    private int $id_client;
    private int $id_produit;
    private string $date;
    private string $statut;
    private float $montant;
    private string $adresse;

    // Constructeur
    public function __construct(int $id_commande, int $id_client, int $id_produit, string $date, string $statut, float $montant, string $adresse) {
        $this->id_commande = $id_commande;
        $this->id_client = $id_client;
        $this->id_produit = $id_produit;
        $this->date = $date;
        $this->statut = $statut;
        $this->montant = $montant;
        $this->adresse = $adresse;
    }

    // Getters
    public function getIdCommande(): int {
        return $this->id_commande;
    }

    public function getIdClient(): int {
        return $this->id_client;
    }

    public function getIdProduit(): int {
        return $this->id_produit;
    }

    public function getDate(): string {
        return $this->date;
    }

    public function getStatut(): string {
        return $this->statut;
    }

    public function getMontant(): float {
        return $this->montant;
    }

    public function getAdresse(): string {
        return $this->adresse;
    }

    // Setters
    public function setIdCommande(int $id_commande): void {
        $this->id_commande = $id_commande;
    }

    public function setIdClient(int $id_client): void {
        $this->id_client = $id_client;
    }

    public function setIdProduit(int $id_produit): void {
        $this->id_produit = $id_produit;
    }

    public function setDate(string $date): void {
        $this->date = $date;
    }

    public function setStatut(string $statut): void {
        $this->statut = $statut;
    }

    public function setMontant(float $montant): void {
        $this->montant = $montant;
    }

    public function setAdresse(string $adresse): void {
        $this->adresse = $adresse;
    }

  
}


?>
