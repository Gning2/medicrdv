<?php

namespace App\Entity;

use App\Repository\PlageHoraireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlageHoraireRepository::class)]
class PlageHoraire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $jour = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $hd = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $hf = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $IdMedecin = null;

    #[ORM\ManyToOne(inversedBy: 'plageHoraires')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(?string $jour): self
    {
        $this->jour = $jour;

        return $this;
    }

    public function getHd(): ?string
    {
        return $this->hd;
    }

    public function setHd(?string $hd): self
    {
        $this->hd = $hd;

        return $this;
    }

    public function getHf(): ?string
    {
        return $this->hf;
    }

    public function setHf(?string $hf): self
    {
        $this->hf = $hf;

        return $this;
    }

    public function getIdMedecin(): ?string
    {
        return $this->IdMedecin;
    }

    public function setIdMedecin(?string $IdMedecin): self
    {
        $this->IdMedecin = $IdMedecin;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
