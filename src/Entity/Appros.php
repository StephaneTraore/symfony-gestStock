<?php

namespace App\Entity;

use App\Repository\ApprosRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApprosRepository::class)]
class Appros
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fournisseurs $nomFornisseur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produits $nomProduit = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateAppros = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->getNomFornisseur();
        return $this->getNomProduit();
    }

    public function getNomFornisseur(): ?Fournisseurs
    {
        return $this->nomFornisseur;
    }

    public function setNomFornisseur(?Fournisseurs $nomFornisseur): static
    {
        $this->nomFornisseur = $nomFornisseur;

        return $this;
    }

    public function getNomProduit(): ?Produits
    {
        return $this->nomProduit;
    }

    public function setNomProduit(?Produits $nomProduit): static
    {
        $this->nomProduit = $nomProduit;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDateAppros(): ?\DateTimeInterface
    {
        return $this->dateAppros;
    }

    public function setDateAppros(?\DateTimeInterface $dateAppros): static
    {
        $this->dateAppros = $dateAppros;

        return $this;
    }
}
