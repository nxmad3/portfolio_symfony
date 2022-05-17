<?php

namespace App\Entity;

use App\Repository\TechnoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TechnoRepository::class)]
class Techno
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $label;

    #[ORM\ManyToMany(targetEntity: Projet::class, mappedBy: 'techno')]
    private $Projet;

    public function __construct()
    {
        $this->Projet = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Projet>
     */
    public function getProjet(): Collection
    {
        return $this->Projet;
    }

    public function addProjet(Projet $Projet): self
    {
        if (!$this->Projet->contains($Projet)) {
            $this->Projet[] = $Projet;
            $Projet->addTechno($this);
        }

        return $this;
    }

    public function removeProjet(Projet $Projet): self
    {
        if ($this->Projet->removeElement($Projet)) {
            $Projet->removeTechno($this);
        }

        return $this;
    }
}
