<?php

namespace App\Entity;

use App\Repository\StocksRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StocksRepository::class)]
class Stocks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produits $nomProduit = null;

    #[ORM\ManyToOne]
    private ?Fournisseurs $nomFournisseur = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?int $prixUnitaire = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateReception = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNomFournisseur(): ?Fournisseurs
    {
        return $this->nomFournisseur;
    }

    public function setNomFournisseur(?Fournisseurs $nomFournisseur): static
    {
        $this->nomFournisseur = $nomFournisseur;

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

    public function getPrixUnitaire(): ?int
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(int $prixUnitaire): static
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function getDateReception(): ?\DateTimeInterface
    {
        return $this->dateReception;
    }

    public function setDateReception(?\DateTimeInterface $dateReception): static
    {
        $this->dateReception = $dateReception;

        return $this;
    }
}
