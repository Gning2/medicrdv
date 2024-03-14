<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
class RendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_patient = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom_patient = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $service = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $num_tel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email_patient = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $date_rdv = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $naissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $heure_res = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sexe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $date_actuelle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $age = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $num_ref = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $motif = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPatient(): ?string
    {
        return $this->nom_patient;
    }

    public function setNomPatient(string $nom_patient): self
    {
        $this->nom_patient = $nom_patient;

        return $this;
    }

    public function getPrenomPatient(): ?string
    {
        return $this->prenom_patient;
    }

    public function setPrenomPatient(string $prenom_patient): self
    {
        $this->prenom_patient = $prenom_patient;

        return $this;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(string $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getNaissance(): ?string
    {
        return $this->naissance;
    }

    public function setNaissance(string $naissance): self
    {
        $this->naissance = $naissance;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->num_tel;
    }

    public function setNumTel(string $num_tel): self
    {
        $this->num_tel = $num_tel;

        return $this;
    }

    public function getEmailPatient(): ?string
    {
        return $this->email_patient;
    }

    public function setEmailPatient(string $email_patient): self
    {
        $this->email_patient = $email_patient;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDateRdv(): ?string
    {
        return $this->date_rdv;
    }

    public function setDateRdv(string $date_rdv): self
    {
        $this->date_rdv = $date_rdv;

        return $this;
    }

    public function getHeureRes(): ?string
    {
        return $this->heure_res;
    }

    public function setHeureRes(string $heure_res): self
    {
        $this->heure_res = $heure_res;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(?string $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getNumRef(): ?string
    {
        return $this->num_ref;
    }

    public function setNumRef(?string $num_ref): self
    {
        $this->num_ref = $num_ref;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(?string $motif): self
    {
        $this->motif = $motif;

        return $this;
    }
}
