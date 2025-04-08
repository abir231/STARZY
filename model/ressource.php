<?php
class Ressource
{
    private ?int $id ;
    private ?string $titre ;
    private ?string $type_ressource ;
    private ?string $categorie ;
    private ?string $date_publication ;
    private ?string $description ;
    private ?string $fichier_ou_lien ;
    private ?string $statut ;

    // Constructeur
    public function __construct($id = null, $titre, $type_ressource, $categorie, $date_publication, $description, $fichier_ou_lien, $statut)
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->type_ressource = $type_ressource;
        $this->categorie = $categorie;
        $this->date_publication = $date_publication;
        $this->description = $description;
        $this->fichier_ou_lien = $fichier_ou_lien;
        $this->statut = $statut;
    }

    // Getter et Setter pour id
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    // Getter et Setter pour titre
    public function getTitre()
    {
        return $this->titre;
    }

    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    // Getter et Setter pour type_ressource
    public function getTypeRessource()
    {
        return $this->type_ressource;
    }

    public function setTypeRessource($type_ressource)
    {
        $this->type_ressource = $type_ressource;
        return $this;
    }

    // Getter et Setter pour categorie
    public function getCategorie()
    {
        return $this->categorie;
    }

    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
        return $this;
    }

    // Getter et Setter pour date_publication
    public function getDatePublication()
    {
        return $this->date_publication;
    }

    public function setDatePublication($date_publication)
    {
        $this->date_publication = $date_publication;
        return $this;
    }

    // Getter et Setter pour description
    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    // Getter et Setter pour fichier_ou_lien
    public function getFichierOuLien()
    {
        return $this->fichier_ou_lien;
    }

    public function setFichierOuLien($fichier_ou_lien)
    {
        $this->fichier_ou_lien = $fichier_ou_lien;
        return $this;
    }

    // Getter et Setter pour statut
    public function getStatut()
    {
        return $this->statut;
    }

    public function setStatut($statut)
    {
        $this->statut = $statut;
        return $this;
    }
}
?>
