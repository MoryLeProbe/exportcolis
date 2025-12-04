<?php

namespace App\Entity;

use App\Repository\ColisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: ColisRepository::class)]
class Colis
{
    public const STATUT_EN_ATTENTE = 'en_attente';
    public const STATUT_TRANSIT = 'en_transit';
    public const STATUT_ARRIVE = 'arrive';
    public const STATUT_LIVRE = 'livre';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    private ?string $numero = null;

    #[ORM\Column]
    private ?float $poids = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $contenu = null;

    #[ORM\Column(length: 30)]
    private ?string $statut = self::STATUT_EN_ATTENTE;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    // Fichier uploadé lors du formulaire
    private ?File $imageFile = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'colis')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\ManyToOne(inversedBy: 'colis')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Destinataire $destinataire = null;

    #[ORM\ManyToOne(inversedBy: 'colis')]
    private ?Expedition $expedition = null;

    /**
     * @var Collection<int, HistoriqueColis>
     */
     #[ORM\OneToMany(mappedBy: 'colis', targetEntity: HistoriqueColis::class, cascade: ['persist', 'remove'])]
    private Collection $historiqueColis;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->historiqueColis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(float $poids): static
    {
        $this->poids = $poids;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getDestinataire(): ?Destinataire
    {
        return $this->destinataire;
    }

    public function setDestinataire(?Destinataire $destinataire): static
    {
        $this->destinataire = $destinataire;

        return $this;
    }

    public function getExpedition(): ?Expedition
    {
        return $this->expedition;
    }

    public function setExpedition(?Expedition $expedition): static
    {
        $this->expedition = $expedition;

        return $this;
    }

    /**
     * @return Collection<int, HistoriqueColis>
     */
    public function getHistoriqueColis(): Collection
    {
        return $this->historiqueColis;
    }

    public function addHistoriqueColi(HistoriqueColis $historiqueColi): static
    {
        if (!$this->historiqueColis->contains($historiqueColi)) {
            $this->historiqueColis->add($historiqueColi);
            $historiqueColi->setColis($this);
        }

        return $this;
    }

    public function removeHistoriqueColi(HistoriqueColis $historiqueColi): static
    {
        if ($this->historiqueColis->removeElement($historiqueColi)) {
            // set the owning side to null (unless already changed)
            if ($historiqueColi->getColis() === $this) {
                $historiqueColi->setColis(null);
            }
        }

        return $this;
    }
}
