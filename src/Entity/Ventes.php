<?php

namespace App\Entity;

use App\Repository\VentesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VentesRepository::class)]
class Ventes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produits $nomProduit = null;

    #[ORM\ManyToOne]
    private ?Clients $nomClient = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateVente = null;

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

    public function getNomClient(): ?Clients
    {
        return $this->nomClient;
    }

    public function setNomClient(?Clients $nomClient): static
    {
        $this->nomClient = $nomClient;

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

    public function getDateVente(): ?\DateTimeInterface
    {
        return $this->dateVente;
    }

    public function setDateVente(\DateTimeInterface $dateVente): static
    {
        $this->dateVente = $dateVente;

        return $this;
    }
}
