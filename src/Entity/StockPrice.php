<?php

namespace App\Entity;

use App\Repository\StockPriceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StockPriceRepository::class)
 */
class StockPrice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="stockPrices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity=Exchange::class, inversedBy="stockPrices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $exchange;

    /**
     * @ORM\ManyToOne(targetEntity=StockType::class, inversedBy="stockPrices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $stockType;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getExchange(): ?Exchange
    {
        return $this->exchange;
    }

    public function setExchange(?Exchange $exchange): self
    {
        $this->exchange = $exchange;

        return $this;
    }

    public function getStockType(): ?StockType
    {
        return $this->stockType;
    }

    public function setStockType(?StockType $stockType): self
    {
        $this->stockType = $stockType;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'price' => $this->getPrice(),
            'stockType' => $this->getStockType()->toArray(),
            'company' => $this->getCompany()->toArray(),
            'exchange' => $this->getExchange()->toArray(),
            'createdAt' => $this->getCreatedAt()->format(\DateTime::ISO8601),
            'updatedAt' => $this->getUpdatedAt()->format(\DateTime::ISO8601),
        ];
    }
}
