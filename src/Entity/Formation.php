<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    
    private $cover;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $duration;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $langue;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_start;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_end;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="text")
     */
    private $apercu;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $objectifs;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $certifs;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $structure;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $criteres;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $thematique;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\ManyToMany(targetEntity=Inscription::class, mappedBy="formation", cascade={"remove"})
     */
    private $inscriptions;

    /**
     * @ORM\Column(type="date" , nullable=true)
     */
    private $dateInsD;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateInsF;

    /**
     * @ORM\OneToMany(targetEntity=Like::class, mappedBy="post" , cascade={"remove"})
     */
    private $likes;

    /**
     * @ORM\OneToMany(targetEntity=Rating::class, mappedBy="article" , cascade={"remove"})
     */
    private $ratings;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $partenaire;

   

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        
    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getDuration(): ?float
    {
        return $this->duration;
    }

    public function setDuration(?float $duration): self
    {
        $this->duration = $duration;

        return $this;
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

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(?\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(?\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getApercu(): ?string
    {
        return $this->apercu;
    }

    public function setApercu(string $apercu): self
    {
        $this->apercu = $apercu;

        return $this;
    }

    public function getObjectifs(): ?string
    {
        return $this->objectifs;
    }

    public function setObjectifs(?string $objectifs): self
    {
        $this->objectifs = $objectifs;

        return $this;
    }

    public function getCertifs(): ?string
    {
        return $this->certifs;
    }

    public function setCertifs(?string $certifs): self
    {
        $this->certifs = $certifs;

        return $this;
    }

    public function getStructure(): ?string
    {
        return $this->structure;
    }

    public function setStructure(?string $structure): self
    {
        $this->structure = $structure;

        return $this;
    }

    public function getCriteres(): ?string
    {
        return $this->criteres;
    }

    public function setCriteres(?string $criteres): self
    {
        $this->criteres = $criteres;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getThematique(): ?string
    {
        return $this->thematique;
    }

    public function setThematique(string $thematique): self
    {
        $this->thematique = $thematique;

        return $this;
    }
    public function __toString(): string
    {
        return $this->type;
    }


    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

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
            $inscription->addFormation($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            $inscription->removeFormation($this);
        }

        return $this;
    }

    public function getDateInsD(): ?\DateTimeInterface
    {
        return $this->dateInsD;
    }

    public function setDateInsD(\DateTimeInterface $dateInsD): self
    {
        $this->dateInsD = $dateInsD;

        return $this;
    }

    public function getDateInsF(): ?\DateTimeInterface
    {
        return $this->DateInsF;
    }

    public function setDateInsF(\DateTimeInterface $DateInsF): self
    {
        $this->DateInsF = $DateInsF;

        return $this;
    }

    /**
     * @return Collection<int, Like>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setPost($this);
        }

        return $this;
    }

    public function removeLike(Like $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getPost() === $this) {
                $like->setPost(null);
            }
        }

        return $this;
    }

    
    public function isLikedByUser(User $user) : bool {
        foreach($this->likes as $like){
             if($like->getUser() === $user ) return true;
        }
         return false;
     }
     public function isRatingdByUser(User $user) : bool {
        foreach($this->ratings as $rating){
             if($rating->getUser() === $user ) return true;
        }
         return false;
     }
    /**
     * @return Collection<int, Rating>
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setArticle($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getArticle() === $this) {
                $rating->setArticle(null);
            }
        }

        return $this;
    }

    public function getPartenaire(): ?string
    {
        return $this->partenaire;
    }

    public function setPartenaire(?string $partenaire): self
    {
        $this->partenaire = $partenaire;

        return $this;
    }


}
