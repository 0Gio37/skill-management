<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 */
class Company
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
    private $lieu;

    /**
     * @ORM\OneToMany(targetEntity=Mission::class, mappedBy="company")
     */
    private $mission;

    public function __construct()
    {
        $this->mission = new ArrayCollection();
    }

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

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * @return Collection|Mission[]
     */
    public function getMission(): Collection
    {
        return $this->mission;
    }

    public function addMission(Mission $mission): self
    {
        if (!$this->mission->contains($mission)) {
            $this->mission[] = $mission;
            $mission->setCompany($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): self
    {
        if ($this->mission->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getCompany() === $this) {
                $mission->setCompany(null);
            }
        }

        return $this;
    }
}
