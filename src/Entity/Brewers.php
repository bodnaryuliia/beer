<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BrewersRepository")
 */
class Brewers
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Beers", mappedBy="brewId")
     */
    private $beers;

    public function __construct()
    {
        $this->beers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Beers[]
     */
    public function getBeers(): Collection
    {
        return $this->beers;
    }

    public function addBeer(Beers $beer): self
    {
        if (!$this->beers->contains($beer)) {
            $this->beers[] = $beer;
            $beer->setBrewId($this);
        }

        return $this;
    }

    public function removeBeer(Beers $beer): self
    {
        if ($this->beers->contains($beer)) {
            $this->beers->removeElement($beer);
            // set the owning side to null (unless already changed)
            if ($beer->getBrewId() === $this) {
                $beer->setBrewId(null);
            }
        }

        return $this;
    }
}
