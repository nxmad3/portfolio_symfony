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
    private $image;

    public function __construct()
    {
        $this->image = new ArrayCollection();
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
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Projet $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image[] = $image;
            $image->addTechno($this);
        }

        return $this;
    }

    public function removeImage(Projet $image): self
    {
        if ($this->image->removeElement($image)) {
            $image->removeTechno($this);
        }

        return $this;
    }
}
