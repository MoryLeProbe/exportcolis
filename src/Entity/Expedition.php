<?php

namespace App\Entity;

use App\Repository\ExpeditionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpeditionRepository::class)]
class Expedition
{
    public const TYPE_MARITIME = 'MARITIME';
    public const TYPE_AERIEN = 'AERIEN';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $numero = null;

    #[ORM\Column(length: 20)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateDepart = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateArriveePrevue = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateArriveeReelle = null;

    #[ORM\Column(length: 100)]
    private ?string $portDepart = null;

    #[ORM\Column(length: 100)]
    private ?string $portArrivee = null;

    /**
     * @var Collection<int, Colis>
     */
    #[ORM\OneToMany(targetEntity: Colis::class, mappedBy: 'expedition')]
    private Collection $colis;

    public function __construct()
    {
        $this->colis = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDateDepart(): ?\DateTime
    {
        return $this->dateDepart;
    }

    public function setDateDepart(\DateTime $dateDepart): static
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getDateArriveePrevue(): ?\DateTime
    {
        return $this->dateArriveePrevue;
    }

    public function setDateArriveePrevue(\DateTime $dateArriveePrevue): static
    {
        $this->dateArriveePrevue = $dateArriveePrevue;

        return $this;
    }

    public function getDateArriveeReelle(): ?\DateTime
    {
        return $this->dateArriveeReelle;
    }

    public function setDateArriveeReelle(?\DateTime $dateArriveeReelle): static
    {
        $this->dateArriveeReelle = $dateArriveeReelle;

        return $this;
    }

    public function getPortDepart(): ?string
    {
        return $this->portDepart;
    }

    public function setPortDepart(string $portDepart): static
    {
        $this->portDepart = $portDepart;

        return $this;
    }

    public function getPortArrivee(): ?string
    {
        return $this->portArrivee;
    }

    public function setPortArrivee(string $portArrivee): static
    {
        $this->portArrivee = $portArrivee;

        return $this;
    }

    /**
     * @return Collection<int, Colis>
     */
    public function getColis(): Collection
    {
        return $this->colis;
    }

    public function addColi(Colis $coli): static
    {
        if (!$this->colis->contains($coli)) {
            $this->colis->add($coli);
            $coli->setExpedition($this);
        }

        return $this;
    }

    public function removeColi(Colis $coli): static
    {
        if ($this->colis->removeElement($coli)) {
            // set the owning side to null (unless already changed)
            if ($coli->getExpedition() === $this) {
                $coli->setExpedition(null);
            }
        }

        return $this;
    }
}
