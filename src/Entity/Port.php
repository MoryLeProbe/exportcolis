<?php

namespace App\Entity;

use App\Repository\PortRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortRepository::class)]
class Port
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $pays = null;

    /**
     * @var Collection<int, TarifPort>
     */
    #[ORM\OneToMany(targetEntity: TarifPort::class, mappedBy: 'portDepart')]
    private Collection $tarifPorts;

    /**
     * @var Collection<int, Expedition>
     */
    #[ORM\OneToMany(targetEntity: Expedition::class, mappedBy: 'portDepart')]
    private Collection $expeditions;

    public function __construct()
    {
        $this->tarifPorts = new ArrayCollection();
        $this->expeditions = new ArrayCollection();
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

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection<int, TarifPort>
     */
    public function getTarifPorts(): Collection
    {
        return $this->tarifPorts;
    }

    public function addTarifPort(TarifPort $tarifPort): static
    {
        if (!$this->tarifPorts->contains($tarifPort)) {
            $this->tarifPorts->add($tarifPort);
            $tarifPort->setPortDepart($this);
        }

        return $this;
    }

    public function removeTarifPort(TarifPort $tarifPort): static
    {
        if ($this->tarifPorts->removeElement($tarifPort)) {
            // set the owning side to null (unless already changed)
            if ($tarifPort->getPortDepart() === $this) {
                $tarifPort->setPortDepart(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Expedition>
     */
    public function getExpeditions(): Collection
    {
        return $this->expeditions;
    }

    public function addExpedition(Expedition $expedition): static
    {
        if (!$this->expeditions->contains($expedition)) {
            $this->expeditions->add($expedition);
            $expedition->setPortDepart($this);
        }

        return $this;
    }

    public function removeExpedition(Expedition $expedition): static
    {
        if ($this->expeditions->removeElement($expedition)) {
            // set the owning side to null (unless already changed)
            if ($expedition->getPortDepart() === $this) {
                $expedition->setPortDepart(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;   // ou le champ que tu veux afficher
    }
}
