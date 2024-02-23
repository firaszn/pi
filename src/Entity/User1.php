<?php

namespace App\Entity;
use App\Repository\User1Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as CustomAssert; 

#[ORM\Entity(repositoryClass: User1Repository::class)]
class User1 implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: "Please enter an email address.")]
    #[Assert\Email(message: "The email '{{ value }}' is not a valid email.")]
    private ?string $Email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank(message: "Please enter a password.")]
    #[Assert\Length(min: 6, minMessage: "Your password must be at least {{ limit }} characters long.")]
    #[Assert\Regex(
        pattern: "/^(?=.*[A-Za-z])(?=.*\d).+$/",
        message: "Your password must contain at least one letter and one digit."
    )]
    private ?string $Password = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please enter a name.")]
    #[Assert\Length(
        min: 2,
        max: 10,
        minMessage: "Name should be at least {{ limit }} characters.",
        maxMessage: "Name should be at most {{ limit }} characters."
    )]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please enter a last name.")]
    #[Assert\Length(
        min: 2,
        max: 10,
        minMessage: "Last name should be at least {{ limit }} characters.",
        maxMessage: "Last name should be at most {{ limit }} characters."
    )]
    private ?string $Prenom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please enter an address.")]
    #[Assert\Length(
        min: 2,
        max: 20,
        minMessage: "Address should be at least {{ limit }} characters.",
        maxMessage: "Address should be at most {{ limit }} characters."
    )]
    private ?string $Adresse = null;


    

    private $resetToken;


    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }


    public function setResetToken(string $resetToken): self
    {
        $this->resetToken = $resetToken;


        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNom(): ?string
    {
        return $this->Nom;
    }


    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;


        return $this;
    }


    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }


    public function setPrenom(string $Prenom): static
    {
        $this->Prenom = $Prenom;


        return $this;
    }


    public function getEmail(): ?string
    {
        return $this->Email;
    }


    public function setEmail(string $Email): static
    {
        $this->Email = $Email;


        return $this;
    }


   

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }


    public function setAdresse(string $Adresse): static
    {
        $this->Adresse = $Adresse;


        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->Email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->Email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): static
    {
        $this->Password = $Password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Don>
     */
    public function getDons(): Collection
    {
        return $this->dons;
    }


    public function addDon(Don $don): static
    {
        if (!$this->dons->contains($don)) {
            $this->dons->add($don);
            $don->setDonateur($this);
        }


        return $this;
    }


    public function removeDon(Don $don): static
    {
        if ($this->dons->removeElement($don)) {
            // set the owning side to null (unless already changed)
            if ($don->getDonateur() === $this) {
                $don->setDonateur(null);
            }
        }


        return $this;
    }


    /**
     * @return Collection<int, Demande>
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }


    public function addDemande(Demande $demande): static
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes->add($demande);
            $demande->setDirecteurCampagne($this);
        }


        return $this;
    }


    public function removeDemande(Demande $demande): static
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getDirecteurCampagne() === $this) {
                $demande->setDirecteurCampagne(null);
            }
        }


        return $this;
    }


   




}

















