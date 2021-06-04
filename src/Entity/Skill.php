<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=SkillRepository::class)
 * @UniqueEntity("nom",
 * message="Compétence deja listée")
 */
class Skill
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $nom;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="skill")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=LienUserSkill::class, mappedBy="skill")
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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
            $lienUserSkill->setSkill($this);
        }

        return $this;
    }

    public function removeLienUserSkill(LienUserSkill $lienUserSkill): self
    {
        if ($this->lienUserSkills->removeElement($lienUserSkill)) {
            // set the owning side to null (unless already changed)
            if ($lienUserSkill->getSkill() === $this) {
                $lienUserSkill->setSkill(null);
            }
        }

        return $this;
    }
}
