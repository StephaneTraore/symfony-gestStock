<?php

namespace App\Entity;

use App\Repository\ClientsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientsRepository::class)]
class Clients
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nomClient = null;

    #[ORM\Column(length: 150)]
    private ?string $prenomClient = null;

    #[ORM\Column]
    private ?string $adresseClient = null;

    #[ORM\Column]
    private ?int $Telephone = null;

    #[ORM\Column(length: 150)]
    private ?string $EmailClient = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(string $nomClient): static
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    public function __toString()
    {
        return $this->getNomClient();
        return $this->getPrenomClient();
    }

    public function getPrenomClient(): ?string
    {
        return $this->prenomClient;
    }

    public function setPrenomClient(string $prenomClient): static
    {
        $this->prenomClient = $prenomClient;

        return $this;
    }

    public function getAdresseClient(): ?string
    {
        return $this->adresseClient;
    }

    public function setAdresseClient(string $adresseClient): static
    {
        $this->adresseClient = $adresseClient;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->Telephone;
    }

    public function setTelephone(int $Telephone): static
    {
        $this->Telephone = $Telephone;

        return $this;
    }

    public function getEmailClient(): ?string
    {
        return $this->EmailClient;
    }

    public function setEmailClient(string $EmailClient): static
    {
        $this->EmailClient = $EmailClient;

        return $this;
    }
}
