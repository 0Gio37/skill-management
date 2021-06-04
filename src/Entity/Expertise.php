<?php

namespace App\Entity;

use App\Repository\ExpertiseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExpertiseRepository::class)
 */
class Expertise
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
    private $niveau;

    /**
     * @ORM\OneToMany(targetEntity=LienUserSkill::class, mappedBy="expertise")
     */
    private $lienUserSkills;

    public function __construct()
    {
        $this->lienUserSkills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * @return Collection|LienUserSkill[]
     */
    public function getLienUserSkills(): Collection
    {
        return $this->lienUserSkills;
    }

    public function addLienUserSkill(LienUserSkill $lienUserSkill): self
    {
        if (!$this->lienUserSkills->contains($lienUserSkill)) {
            $this->lienUserSkills[] = $lienUserSkill;
            $lienUserSkill->setExpertise($this);
        }

        return $this;
    }

    public function removeLienUserSkill(LienUserSkill $lienUserSkill): self
    {
        if ($this->lienUserSkills->removeElement($lienUserSkill)) {
            // set the owning side to null (unless already changed)
            if ($lienUserSkill->getExpertise() === $this) {
                $lienUserSkill->setExpertise(null);
            }
        }

        return $this;
    }
}
