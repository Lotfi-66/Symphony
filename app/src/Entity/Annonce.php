<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Entity\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
#[UniqueEntity("titre")]
#[Vich\Uploadable]
class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le champ doit être correctement remplis')]
    #[Assert\Length(min: 10, max: 200, maxMessage: 'il y a trop de charactères',minMessage: "Il n'y a pas assez de charactères" )]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\Regex(pattern: "/\d/",match: true, message: "Vous devez rentrer un chiffre")]
    private ?int $prix = null;

    #[ORM\Column(length: 200)]
    private ?string $ville = null;

    #[ORM\Column(length: 6)]
    private ?string $codePostal = null;

    #[ORM\Column(length: 1)]
    private ?string $dpe = null;

    #[ORM\Column]
    private ?int $surface = null;

    #[ORM\Column]
    private ?int $nbrPiece = null;

    #[ORM\Column]
    private ?bool $isExclusive = null;

    #[ORM\Column]
    private ?bool $isRental = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datePublication = null;

    /**
     * @var Collection<int, Agence>
     */
    #[ORM\ManyToMany(targetEntity: Agence::class, inversedBy: 'annonces')]
    private Collection $agences;

    /**
     * @var Collection<int, Equipement>
     */
    #[ORM\ManyToMany(targetEntity: Equipement::class)]
    private Collection $equipements;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    // propriete pour Vich
    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $filename = "default.webp"; // champ du nom du fichier

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updateAt = null;

    #[Vich\UploadableField(mapping: 'annonces', fileNameProperty: "filename")]
    private ?File $imageFile = null;

    // fin des propriete vich

    public function __construct()
    {
        $this->agences = new ArrayCollection();
        $this->equipements = new ArrayCollection();
        $this->setExclusive(false);
        $this->setRental(false);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getDpe(): ?string
    {
        return $this->dpe;
    }

    public function setDpe(string $dpe): static
    {
        $this->dpe = $dpe;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): static
    {
        $this->surface = $surface;

        return $this;
    }

    public function getNbrPiece(): ?int
    {
        return $this->nbrPiece;
    }

    public function setNbrPiece(int $nbrPiece): static
    {
        $this->nbrPiece = $nbrPiece;

        return $this;
    }

    public function isExclusive(): ?bool
    {
        return $this->isExclusive;
    }

    public function setExclusive(bool $isExclusive): static
    {
        $this->isExclusive = $isExclusive;

        return $this;
    }

    public function isRental(): ?bool
    {
        return $this->isRental;
    }

    public function setRental(bool $isRental): static
    {
        $this->isRental = $isRental;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeInterface $datePublication): static
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * @return Collection<int, Agence>
     */
    public function getAgences(): Collection
    {
        return $this->agences;
    }

    public function addAgence(Agence $agence): static
    {
        if (!$this->agences->contains($agence)) {
            $this->agences->add($agence);
        }

        return $this;
    }

    public function removeAgence(Agence $agence): static
    {
        $this->agences->removeElement($agence);

        return $this;
    }

    /**
     * @return Collection<int, Equipement>
     */
    public function getEquipements(): Collection
    {
        return $this->equipements;
    }

    public function addEquipement(Equipement $equipement): static
    {
        if (!$this->equipements->contains($equipement)) {
            $this->equipements->add($equipement);
        }

        return $this;
    }

    public function removeEquipement(Equipement $equipement): static
    {
        $this->equipements->removeElement($equipement);

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getDatePub()
    {
        return $this->getDatePublication()->format('d/m/Y');
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): Annonce
    {
        $this->filename = $filename;
        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): Annonce
    {
        $this->updateAt = $updateAt;
        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): Annonce
    {
        $this->imageFile = $imageFile;
        if( $imageFile !== null){
            $this->updateAt = new \DateTime('now');
        }
        return $this;
    }




}
