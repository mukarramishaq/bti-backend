<?php

namespace App\Entity;

use App\Repository\StockTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StockTypeRepository::class)
 */
class StockType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=StockPrice::class, mappedBy="stockType")
     */
    private $stockPrices;

    public function __construct()
    {
        $this->stockPrices = new ArrayCollection();
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
     * @return Collection|StockPrice[]
     */
    public function getStockPrices(): Collection
    {
        return $this->stockPrices;
    }

    public function addStockPrice(StockPrice $stockPrice): self
    {
        if (!$this->stockPrices->contains($stockPrice)) {
            $this->stockPrices[] = $stockPrice;
            $stockPrice->setStockType($this);
        }

        return $this;
    }

    public function removeStockPrice(StockPrice $stockPrice): self
    {
        if ($this->stockPrices->removeElement($stockPrice)) {
            // set the owning side to null (unless already changed)
            if ($stockPrice->getStockType() === $this) {
                $stockPrice->setStockType(null);
            }
        }

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
        ];
    }
}
