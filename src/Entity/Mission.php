<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MissionRepository::class)
 */
class Mission
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descirptif;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $debut;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fin;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $en_cours;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="mission")
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="mission")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescirptif(): ?string
    {
        return $this->descirptif;
    }

    public function setDescirptif(?string $descirptif): self
    {
        $this->descirptif = $descirptif;

        return $this;
    }

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(?\DateTimeInterface $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(?\DateTimeInterface $fin): self
    {
        $this->fin = $fin;

        return $this;
    }

    public function getEnCours(): ?bool
    {
        return $this->en_cours;
    }

    public function setEnCours(?bool $en_cours): self
    {
        $this->en_cours = $en_cours;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
