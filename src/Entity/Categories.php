<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $categorieProduit = null;

    #[ORM\OneToMany(mappedBy: 'categories', targetEntity: Produits::class)]
    private Collection $produit;

    public function __construct()
    {
        $this->produit = new ArrayCollection();
    }

    public function __toString()
    {
        // return $this->getProduit();
        return $this->getcategorieProduit();

        
    }

    

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getcategorieProduit(): ?string
    {
        return $this->categorieProduit;
    }

    public function setcategorieProduit(?string $categorieProduit): static
    {
        $this->categorieProduit = $categorieProduit;

        return $this;
    }

    /**
     * @return Collection<int, Produits>
     */
    public function getProduit(): Collection
    {
        return $this->produit;
    }

    public function addProduit(Produits $produit): static
    {
        if (!$this->produit->contains($produit)) {
            $this->produit->add($produit);
            $produit->setCategories($this);
        }

        return $this;
    }

    public function removeProduit(Produits $produit): static
    {
        if ($this->produit->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getCategories() === $this) {
                $produit->setCategories(null);
            }
        }

        return $this;
    }

   

}
