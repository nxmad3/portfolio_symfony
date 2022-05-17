<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

    #[ORM\Column(type: 'date', nullable: true)]
    private $debut;

    #[ORM\Column(type: 'date', nullable: true)]
    private $fin;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $chargeTravail;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $repartition;

    #[ORM\ManyToMany(targetEntity: Techno::class, inversedBy: 'technos')]
    private $techno;

    #[ORM\ManyToMany(targetEntity: Outils::class, inversedBy: 'projets')]
    private $outils;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $pdfName;

    #[ORM\Column(type: 'array', nullable: true)]
    private $images = [];


    public function __construct()
    {
        $this->techno = new ArrayCollection();
        $this->image = new ArrayCollection();
        $this->pdf = new ArrayCollection();
        $this->outils = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getChargeTravail(): ?string
    {
        return $this->chargeTravail;
    }

    public function setChargeTravail(?string $chargeTravail): self
    {
        $this->chargeTravail = $chargeTravail;

        return $this;
    }

    public function getRepartition(): ?string
    {
        return $this->repartition;
    }

    public function setRepartition(?string $repartition): self
    {
        $this->repartition = $repartition;

        return $this;
    }

    /**
     * @return Collection<int, techno>
     */
    public function getTechno(): Collection
    {
        return $this->techno;
    }

    public function addTechno(techno $techno): self
    {
        if (!$this->techno->contains($techno)) {
            $this->techno[] = $techno;
        }

        return $this;
    }

    public function removeTechno(techno $techno): self
    {
        $this->techno->removeElement($techno);

        return $this;
    }


    /**
     * @return Collection<int, outils>
     */
    public function getOutils(): Collection
    {
        return $this->outils;
    }

    public function addOutil(outils $outil): self
    {
        if (!$this->outils->contains($outil)) {
            $this->outils[] = $outil;
        }

        return $this;
    }

    public function removeOutil(outils $outil): self
    {
        $this->outils->removeElement($outil);

        return $this;
    }



    /**
     * @return mixed
     */
    public function getPdfName()
    {
        return $this->pdfName;
    }

    /**
     * @param mixed $pdfName
     */
    public function setPdfName($pdfName): void
    {
        $this->pdfName = $pdfName;
    }

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImages(?array $images): self
    {
        $this->images = $images;

        return $this;
    }
}
