<?php

namespace App\Entity;

use App\Repository\DomainesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DomainesRepository::class)
 */
class Domaines
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity=Ministere::class, inversedBy="domaines")
     */
    private $ministere;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $categorieAr;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getCategorie(): ?string
    {
        
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        
        $this->categorie = $categorie;

        return $this;
    }

    public function getMinistere(): ?Ministere
    {
        return $this->ministere;
    }

    public function setMinistere(?Ministere $ministere): self
    {
        $this->ministere = $ministere;

        return $this;
    }
    public function __toString():string
    {
        return $this->categorie;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(?string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getCategorieAr(): ?string
    {
        return $this->categorieAr;
    }

    public function setCategorieAr(?string $categorieAr): self
    {
        $this->categorieAr = $categorieAr;

        return $this;
    }
 
}
