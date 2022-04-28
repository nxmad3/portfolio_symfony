<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToMany(targetEntity: Projet::class, inversedBy: 'image')]
    private $projet;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'image')]
    private $users;

    #[ORM\OneToOne(mappedBy: 'image', targetEntity: Competence::class, cascade: ['persist', 'remove'])]
    private $competence;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $file;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): self
    {
        $this->projet = $projet;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addImage($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeImage($this);
        }

        return $this;
    }

    public function getCompetence(): ?Competence
    {
        return $this->competence;
    }

    public function setCompetence(?Competence $competence): self
    {
        // unset the owning side of the relation if necessary
        if ($competence === null && $this->competence !== null) {
            $this->competence->setImage(null);
        }

        // set the owning side of the relation if necessary
        if ($competence !== null && $competence->getImage() !== $this) {
            $competence->setImage($this);
        }

        $this->competence = $competence;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file): void
    {
        $this->file = $file;
    }
}
