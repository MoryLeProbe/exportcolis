<?php

namespace App\Entity;

use App\Repository\HistoriqueColisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoriqueColisRepository::class)]
class HistoriqueColis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $statut = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTime $dateAction = null;

    #[ORM\ManyToOne(inversedBy: 'historiqueColis')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Colis $colis = null;

     public function __construct()
    {
        $this->dateAction = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDateAction(): ?\DateTime
    {
        return $this->dateAction;
    }

    public function setDateAction(\DateTime $dateAction): static
    {
        $this->dateAction = $dateAction;

        return $this;
    }

    public function getColis(): ?Colis
    {
        return $this->colis;
    }

    public function setColis(?Colis $colis): static
    {
        $this->colis = $colis;

        return $this;
    }
}
