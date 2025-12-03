<?php

namespace App\Entity;

use App\Repository\TarifPortRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TarifPortRepository::class)]
class TarifPort
{
    public const TYPE_MARITIME = 'MARITIME';
    public const TYPE_AERIEN = 'AERIEN';
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'tarifPorts')]
    private ?Port $portDepart = null;

    #[ORM\ManyToOne(inversedBy: 'tarifPorts')]
    private ?Port $portArrivee = null;

    #[ORM\Column(length: 20)]
    private ?string $typeTransport = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $prixKg = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPortDepart(): ?Port
    {
        return $this->portDepart;
    }

    public function setPortDepart(?Port $portDepart): static
    {
        $this->portDepart = $portDepart;

        return $this;
    }

    public function getPortArrivee(): ?Port
    {
        return $this->portArrivee;
    }

    public function setPortArrivee(?Port $portArrivee): static
    {
        $this->portArrivee = $portArrivee;

        return $this;
    }

    public function getTypeTransport(): ?string
    {
        return $this->typeTransport;
    }

    public function setTypeTransport(string $typeTransport): static
    {
        $this->typeTransport = $typeTransport;

        return $this;
    }

    public function getPrixKg(): ?string
    {
        return $this->prixKg;
    }

    public function setPrixKg(string $prixKg): static
    {
        $this->prixKg = $prixKg;

        return $this;
    }
}
