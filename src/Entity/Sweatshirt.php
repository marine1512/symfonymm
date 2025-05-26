<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Sweatshirt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'float')] 
    private ?float $price = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $isPromoted = null;

    #[ORM\Column(type: 'json')] 
    private array $stockBySize = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $image = null; 

    // Getters et Setters

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getIsPromoted(): ?bool
    {
        return $this->isPromoted;
    }

    public function setIsPromoted(bool $isPromoted): self
    {
        $this->isPromoted = $isPromoted;
        return $this;
    }

    public function getStockBySize(): array
    {
        return $this->stockBySize;
    }

    public function setStockBySize(array $stockBySize): self
    {
        $this->stockBySize = $stockBySize;
        return $this;
    }
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }


}