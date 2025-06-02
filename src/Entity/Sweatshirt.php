<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Représente un Sweatshirt avec ses propriétés basiques.
 */
#[ORM\Entity]
class Sweatshirt
{
    /**
     * Identifiant unique du Sweatshirt.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * Nom du Sweatshirt.
     *
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    /**
     * Prix du Sweatshirt en euros.
     *
     * @var float|null
     */
    #[ORM\Column(type: 'float')]
    private ?float $price = null;

    /**
     * Indique si le Sweatshirt est en promotion.
     *
     * @var bool|null
     */
    #[ORM\Column(type: 'boolean')]
    private ?bool $isPromoted = null;

    /**
     * Stock du Sweatshirt par taille (ex: ['S' => 10, 'M' => 5]).
     *
     * @var array
     */
    #[ORM\Column(type: 'json')]
    private array $stockBySize = [];

    /**
     * URL ou chemin local de l'image du Sweatshirt.
     *
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $image = null;

    /**
     * Retourne l'identifiant (ID) du Sweatshirt.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne le nom du Sweatshirt.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Définit le nom du Sweatshirt.
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Retourne le prix du Sweatshirt.
     *
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * Définit le prix du Sweatshirt.
     *
     * @param float $price
     * @return self
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Indique si le Sweatshirt est en promotion.
     *
     * @return bool|null
     */
    public function getIsPromoted(): ?bool
    {
        return $this->isPromoted;
    }

    /**
     * Définit si le Sweatshirt est en promotion.
     *
     * @param bool $isPromoted
     * @return self
     */
    public function setIsPromoted(bool $isPromoted): self
    {
        $this->isPromoted = $isPromoted;
        return $this;
    }

    /**
     * Retourne le stock du Sweatshirt par taille.
     *
     * @return array
     */
    public function getStockBySize(): array
    {
        return $this->stockBySize;
    }

    /**
     * Définit le stock du Sweatshirt par taille.
     *
     * @param array $stockBySize
     * @return self
     */
    public function setStockBySize(array $stockBySize): self
    {
        $this->stockBySize = $stockBySize;
        return $this;
    }

    /**
     * Retourne l'image associée au Sweatshirt.
     *
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Définit l'image associée au Sweatshirt.
     *
     * @param string|null $image
     * @return self
     */
    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }
}