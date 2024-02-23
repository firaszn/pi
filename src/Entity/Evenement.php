<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_evenement = null;

    #[ORM\Column(length: 55)]
    private ?string $Titre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\Column]
    private ?int $Duree = null;

    #[ORM\Column(length: 55)]
    private ?string $Lieu = null;

    #[ORM\Column(length: 255)]
    private ?string $Objectif = null;

    #[ORM\OneToOne(mappedBy: 'Evenement', cascade: ['persist', 'remove'])]
    private ?Actualite $actualite = null;

    public function getId(): ?int
    {
        return $this->id_evenement;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): static
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): static
    {
        $this->Date = $Date;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->Duree;
    }

    public function setDuree(int $Duree): static
    {
        $this->Duree = $Duree;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->Lieu;
    }

    public function setLieu(string $Lieu): static
    {
        $this->Lieu = $Lieu;

        return $this;
    }

    public function getObjectif(): ?string
    {
        return $this->Objectif;
    }

    public function setObjectif(string $Objectif): static
    {
        $this->Objectif = $Objectif;

        return $this;
    }

    public function getActualite(): ?Actualite
    {
        return $this->actualite;
    }

    public function setActualite(?Actualite $actualite): static
    {
        // unset the owning side of the relation if necessary
        if ($actualite === null && $this->actualite !== null) {
            $this->actualite->setEvenement(null);
        }

        // set the owning side of the relation if necessary
        if ($actualite !== null && $actualite->getEvenement() !== $this) {
            $actualite->setEvenement($this);
        }

        $this->actualite = $actualite;

        return $this;
    }
}
