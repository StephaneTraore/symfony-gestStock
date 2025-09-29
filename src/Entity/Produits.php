<?php

namespace App\Entity;

use App\Repository\ProduitsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ProduitsRepository::class)]
#[Vich\Uploadable]
class Produits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

     // NOTE: This is not a mapped field of entity metadata, just a simple property.
     #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'imageName')]
     private ?File $imageFile = null;
 
     #[ORM\Column(nullable: true)]
     private ?string $imageName = null;

    #[ORM\Column(length: 150)]
    private ?string $nomProduit = null;

    #[ORM\Column(length: 150)]
    private ?string $categoriesProduit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descriptionProduit = null;

    #[ORM\Column]
    private ?int $prixProduit = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateFabrication = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateExpiration = null;

    #[ORM\Column]
    private ?int $idCategorie = null;

    #[ORM\ManyToOne(inversedBy: 'produit')]
    private ?Categories $categories = null;

    public function getId(): ?int
    {
        return $this->id;
    }

   

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->dateFabrication = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function getNomProduit(): ?string
    {
        return $this->nomProduit;
    }

    public function setNomProduit(string $nomProduit): static
    {
        $this->nomProduit = $nomProduit;

        return $this;
    }

    public function __toString()
    {
        return $this->getNomProduit();
        
        
    }

    public function getCategoriesProduit(): ?string
    {
        return $this->categoriesProduit;
    }

    public function setCategoriesProduit(string $categoriesProduit): static
    {
        $this->categoriesProduit = $categoriesProduit;

        return $this;
    }

    public function getDescriptionProduit(): ?string
    {
        return $this->descriptionProduit;
    }

    public function setDescriptionProduit(?string $descriptionProduit): static
    {
        $this->descriptionProduit = $descriptionProduit;

        return $this;
    }

    public function getPrixProduit(): ?int
    {
        return $this->prixProduit;
    }

    public function setPrixProduit(int $prixProduit): static
    {
        $this->prixProduit = $prixProduit;

        return $this;
    }

    public function getDateFabrication(): ?\DateTimeInterface
    {
        return $this->dateFabrication;
    }

    public function setDateFabrication(?\DateTimeInterface $dateFabrication): static
    {
        $this->dateFabrication = $dateFabrication;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(?\DateTimeInterface $dateExpiration): static
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    public function getIdCategorie(): ?int
    {
        return $this->idCategorie;
    }

    public function setIdCategorie(int $idCategorie): static
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }

    public function getCategories(): ?Categories
    {
        return $this->categories;
    }

    public function setCategories(?Categories $categories): static
    {
        $this->categories = $categories;

        return $this;
    }

   
}
