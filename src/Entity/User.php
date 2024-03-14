<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $matricule = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numero_patient = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sexe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $date_actuelle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $anneenaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $moisnaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $specialite = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: PlageHoraire::class)]
    private Collection $plageHoraires;

    public function __construct()
    {
        $this->plageHoraires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getNumeroPatient(): ?string
    {
        return $this->numero_patient;
    }

    public function setNumeroPatient(string $numero_patient): self
    {
        $this->numero_patient = $numero_patient;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateActuelle(): ?string
    {
        return $this->date_actuelle;
    }

    public function setDateActuelle(string $date_actuelle): self
    {
        $this->date_actuelle = $date_actuelle;

        return $this;
    }

    public function getAnneenaissance(): ?string
    {
        return $this->anneenaissance;
    }

    public function setAnneenaissance(?string $anneenaissance): self
    {
        $this->anneenaissance = $anneenaissance;

        return $this;
    }

    public function getMoisnaissance(): ?string
    {
        return $this->moisnaissance;
    }

    public function setMoisnaissance(?string $moisnaissance): self
    {
        $this->moisnaissance = $moisnaissance;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(?string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * @return Collection<int, PlageHoraire>
     */
    public function getPlageHoraires(): Collection
    {
        return $this->plageHoraires;
    }

    public function addPlageHoraire(PlageHoraire $plageHoraire): self
    {
        if (!$this->plageHoraires->contains($plageHoraire)) {
            $this->plageHoraires->add($plageHoraire);
            $plageHoraire->setUser($this);
        }

        return $this;
    }

    public function removePlageHoraire(PlageHoraire $plageHoraire): self
    {
        if ($this->plageHoraires->removeElement($plageHoraire)) {
            // set the owning side to null (unless already changed)
            if ($plageHoraire->getUser() === $this) {
                $plageHoraire->setUser(null);
            }
        }

        return $this;
    }
}
