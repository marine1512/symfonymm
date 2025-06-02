<?php

namespace App\Tests\Entity;

use App\Entity\Sweatshirt;
use PHPUnit\Framework\TestCase;

class SweatshirtTest extends TestCase
{
    public function testGetSetName(): void
    {
        $sweatshirt = new Sweatshirt();

        // Définit et teste le nom du Sweatshirt
        $sweatshirt->setName('Sweatshirt noir');
        $this->assertEquals('Sweatshirt noir', $sweatshirt->getName());
    }

    public function testGetSetPrice(): void
    {
        $sweatshirt = new Sweatshirt();

        // Définit et teste le prix
        $sweatshirt->setPrice(29.99);
        $this->assertEquals(29.99, $sweatshirt->getPrice());
    }

    public function testGetSetIsPromoted(): void
    {
        $sweatshirt = new Sweatshirt();

        // Définit et teste si le Sweatshirt est en promotion
        $sweatshirt->setIsPromoted(true);
        $this->assertTrue($sweatshirt->getIsPromoted());

        $sweatshirt->setIsPromoted(false);
        $this->assertFalse($sweatshirt->getIsPromoted());
    }

    public function testGetSetStockBySize(): void
    {
        $sweatshirt = new Sweatshirt();

        $stock = ['S' => 10, 'M' => 5, 'L' => 3];

        // Définit le stock par taille et vérifie
        $sweatshirt->setStockBySize($stock);
        $this->assertEquals($stock, $sweatshirt->getStockBySize());
    }

    public function testGetSetImage(): void
    {
        $sweatshirt = new Sweatshirt();

        $imagePath = '/images/sweatshirt.png';

        // Définit et teste l'image associée
        $sweatshirt->setImage($imagePath);
        $this->assertEquals($imagePath, $sweatshirt->getImage());

        // Définit l'image à null et vérifie
        $sweatshirt->setImage(null);
        $this->assertNull($sweatshirt->getImage());
    }

    public function testGetIdDefault(): void
    {
        $sweatshirt = new Sweatshirt();

        // Par défaut, l'ID est null
        $this->assertNull($sweatshirt->getId());
    }
}