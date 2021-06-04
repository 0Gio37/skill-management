<?php

namespace App\Entity;

use App\Repository\LienUserSkillRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=LienUserSkillRepository::class)
 * @UniqueEntity(fields = {"user", "skill"},
 *     errorPath="skill",
 *     message="Compétence deja listée une fois")
 */
class LienUserSkill
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="lienUserSkills")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity=Skill::class, inversedBy="lienUserSkills")
     */
    protected $skill;

    /**
     * @ORM\ManyToOne(targetEntity=Expertise::class, inversedBy="lienUserSkills")
     */
    private $expertise;

    /**
     * @ORM\Column(type="boolean")
     */
    private $prefer;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): self
    {
        $this->skill = $skill;

        return $this;
    }

    public function getExpertise(): ?Expertise
    {
        return $this->expertise;
    }

    public function setExpertise(?Expertise $expertise): self
    {
        $this->expertise = $expertise;

        return $this;
    }

    public function getPrefer(): ?bool
    {
        return $this->prefer;
    }

    public function setPrefer(bool $prefer): self
    {
        $this->prefer = $prefer;

        return $this;
    }


}
