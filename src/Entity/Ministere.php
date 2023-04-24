<?php

namespace App\Entity;

use App\Repository\MinistereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MinistereRepository::class)
 */
class Ministere
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Inscription::class, mappedBy="ministere")
     */
    private $inscriptions;

    /**
     * @ORM\OneToMany(targetEntity=Domaines::class, mappedBy="ministere")
     */
    private $domaines;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nameAr;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
        $this->domaines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setMinistere($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getMinistere() === $this) {
                $inscription->setMinistere(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Domaines>
     */
    public function getDomaines(): Collection
    {
        return $this->domaines;
    }

    public function addDomaine(Domaines $domaine): self
    {
        if (!$this->domaines->contains($domaine)) {
            $this->domaines[] = $domaine;
            $domaine->setMinistere($this);
        }

        return $this;
    }

    public function removeDomaine(Domaines $domaine): self
    {
        if ($this->domaines->removeElement($domaine)) {
            // set the owning side to null (unless already changed)
            if ($domaine->getMinistere() === $this) {
                $domaine->setMinistere(null);
            }
        }

        return $this;
    }
    public function __toString():string
    {
        return $this->name;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getNameAr(): ?string
    {
        return $this->nameAr;
    }

    public function setNameAr(?string $nameAr): self
    {
        $this->nameAr = $nameAr;

        return $this;
    }
}
