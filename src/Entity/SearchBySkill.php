<?php

namespace App\Entity;

class SearchBySkill
{

    private $nom;

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
