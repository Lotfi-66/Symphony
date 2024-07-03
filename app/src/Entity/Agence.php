<?php

namespace App\Entity;

use App\Repository\AgenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgenceRepository::class)]
class Agence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $codeAgence = null;

    /**
     * @var Collection<int, Capacite>
     */
    #[ORM\ManyToMany(targetEntity: Capacite::class)]
    private Collection $capacites;

    /**
     * @var Collection<int, Annonce>
     */
    #[ORM\ManyToMany(targetEntity: Annonce::class, mappedBy: 'agences')]
    private Collection $annonces;

    public function __construct()
    {
        $this->capacites = new ArrayCollection();
        $this->annonces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCodeAgence(): ?string
    {
        return $this->codeAgence;
    }

    public function setCodeAgence(string $codeAgence): static
    {
        $this->codeAgence = $codeAgence;

        return $this;
    }

    /**
     * @return Collection<int, Capacite>
     */
    public function getCapacites(): Collection
    {
        return $this->capacites;
    }

    public function addCapacite(Capacite $capacite): static
    {
        if (!$this->capacites->contains($capacite)) {
            $this->capacites->add($capacite);
        }

        return $this;
    }

    public function removeCapacite(Capacite $capacite): static
    {
        $this->capacites->removeElement($capacite);

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): static
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces->add($annonce);
            $annonce->addAgence($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): static
    {
        if ($this->annonces->removeElement($annonce)) {
            $annonce->removeAgence($this);
        }

        return $this;
    }
}
