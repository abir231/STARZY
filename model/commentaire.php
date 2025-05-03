<?php
class Commentaire
{
    private ?int $idc;
    private ?string $contenu;
    private ?string $datec;
    private ?string $note;
    private int $id;

    public function __construct($idc = null, ?string $contenu, ?string $datec, ?string $note, int $id)
    {
        $this->idc = $idc;
        $this->contenu = $contenu;
        $this->datec = $datec;
        $this->note = $note;
        $this->id = $id;
    }

    public function getIdc(): ?int { return $this->idc; }
    public function setIdc(int $idc): self { $this->idc = $idc; return $this; }

    public function getContenu(): ?string { return $this->contenu; }
    public function setContenu(?string $contenu): self { $this->contenu = $contenu; return $this; }

    public function getDatec(): ?string { return $this->datec; }
    public function setDatec(?string $datec): self { $this->datec = $datec; return $this; }

    public function getNote(): ?string { return $this->note; }
    public function setNote(?string $note): self { $this->note = $note; return $this; }

    public function getId(): int { return $this->id; }
    public function setId(int $id): self { $this->id = $id; return $this; }
}
?>
