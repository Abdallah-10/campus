<?php

namespace App\Entity;

use App\Repository\MessangerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessangerRepository::class)
 */
class Messanger
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messangers")
     */
    private $contacter;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="senders")
     */
    private $sender;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAdd;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getContacter(): ?User
    {
        return $this->contacter;
    }

    public function setContacter(?User $contacter): self
    {
        $this->contacter = $contacter;

        return $this;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->dateAdd;
    }

    public function setDateAdd(\DateTimeInterface $dateAdd): self
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }
    
  
}
