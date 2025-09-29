<?php

namespace App\Entity;

use App\Repository\FournisseursRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FournisseursRepository::class)]
class Fournisseurs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nomFournisseur = null;

    #[ORM\Column(length: 150)]
    private ?string $prenomFournisseur = null;

    #[ORM\Column(length: 150)]
    private ?string $adresseFournisseur = null;

    #[ORM\Column]
    private ?int $telephoneFournisseur = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $emailFournisseur = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString()
    {
        return $this->getNomFournisseur();
        // return $this->getPrenomClient();
    }

    public function getNomFournisseur(): ?string
    {
        return $this->nomFournisseur;
    }

    public function setNomFournisseur(string $nomFournisseur): static
    {
        $this->nomFournisseur = $nomFournisseur;

        return $this;
    }

    public function getPrenomFournisseur(): ?string
    {
        return $this->prenomFournisseur;
    }

    public function setPrenomFournisseur(string $prenomFournisseur): static
    {
        $this->prenomFournisseur = $prenomFournisseur;

        return $this;
    }

    public function getAdresseFournisseur(): ?string
    {
        return $this->adresseFournisseur;
    }

    public function setAdresseFournisseur(string $adresseFournisseur): static
    {
        $this->adresseFournisseur = $adresseFournisseur;

        return $this;
    }

    public function getTelephoneFournisseur(): ?int
    {
        return $this->telephoneFournisseur;
    }

    public function setTelephoneFournisseur(int $telephoneFournisseur): static
    {
        $this->telephoneFournisseur = $telephoneFournisseur;

        return $this;
    }

    public function getEmailFournisseur(): ?string
    {
        return $this->emailFournisseur;
    }

    public function setEmailFournisseur(?string $emailFournisseur): static
    {
        $this->emailFournisseur = $emailFournisseur;

        return $this;
    }
}
