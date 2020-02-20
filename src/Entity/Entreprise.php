<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrepriseRepository")
 */
class Entreprise
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", length=100)
     */
    private $nom_ent;

    /**
     * @ORM\Column(type="text", length=60)
     */
    private $responsable;

    /**
     * @ORM\Column(type="text", length=60)
     */
    private $email;

    /**
     * @ORM\Column(type="text", length=20)
     */
    private $num_tel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Projet", mappedBy="entreprise")
     */
    private $projets;

    public function __construct()
    {
        $this->projets = new ArrayCollection();
    }


    public function getId()
    {
        return $this->id;
    }
  
    public function getNomEnt()
    {
        return $this->nom_ent;
    }

    public function setNomEnt($nom_ent)
    {
        $this->nom_ent = $nom_ent;
    }

    public function getResponsable()
    {
        return $this->responsable;
    }

    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getNumTel()
    {
        return $this->num_tel;
    }

    public function setNumTel($num_tel)
    {
        $this->num_tel = $num_tel;
    }

    /**
     * @return Collection|Projet[]
     */
    public function getProjets(): Collection
    {
        return $this->projets;
    }

    public function addProjet(Projet $projet): self
    {
        if (!$this->projets->contains($projet)) {
            $this->projets[] = $projet;
            $projet->setEntreprise($this);
        }

        return $this;
    }

    public function removeProjet(Projet $projet): self
    {
        if ($this->projets->contains($projet)) {
            $this->projets->removeElement($projet);
            // set the owning side to null (unless already changed)
            if ($projet->getEntreprise() === $this) {
                $projet->setEntreprise(null);
            }
        }

        return $this;
    }
}
