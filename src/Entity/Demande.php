<?php

namespace App\Entity;

use App\Repository\DemandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeRepository::class)]
class Demande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_demande = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\Column(length: 50)]
    private ?string $Statut = null;

    #[ORM\OneToOne(mappedBy: 'demande', cascade: ['persist', 'remove'])]
   // #[ORM\JoinColumn(name: 'id_rendezvous', referencedColumnName: 'id_rendezvous')]
    private ?RendezVous $rendezVous = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'don',nullable: false)]
    private ?Don $don = null;

    #[ORM\ManyToOne(inversedBy: 'demandes')]
    #[ORM\JoinColumn(name: 'directeurCampagne', referencedColumnName: 'id')]
    private ?User1 $directeurCampagne = null;

    public function getId_demande(): ?int
    {
        return $this->id_demande;
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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->Statut;
    }

    public function setStatut(string $Statut): static
    {
        $this->Statut = $Statut;

        return $this;
    }

    public function getRendezVous(): ?RendezVous
    {
        return $this->rendezVous;
    }

    public function setRendezVous(RendezVous $rendezVous): static
    {
        // set the owning side of the relation if necessary
        if ($rendezVous->getDemande() !== $this) {
            $rendezVous->setDemande($this);
        }

        $this->rendezVous = $rendezVous;

        return $this;
    }

    public function getDon(): ?Don
    {
        return $this->don;
    }

    public function setDon(Don $don): static
    {
        $this->don = $don;

        return $this;
    }

    public function getDirecteurCampagne(): ?User1
    {
        return $this->directeurCampagne;
    }

    public function setDirecteurCampagne(?User1 $directeurCampagne): static
    {
        $this->directeurCampagne = $directeurCampagne;

        return $this;
    }
}
