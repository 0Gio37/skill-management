<?php

namespace App\Entity;

class SearchBySkillLevel
{

    private $niveau;


    private $nom;


    public function getNiveau()
    {
        return $this->niveau;
    }

    public function setNiveau($niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom): self
    {
        $this->nom = $nom;

        return $this;
    }
}
