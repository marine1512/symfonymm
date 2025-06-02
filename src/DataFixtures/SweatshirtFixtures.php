<?php

namespace App\DataFixtures;

use App\Entity\Sweatshirt;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SweatshirtFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sweatshirts = [
            ['name' => 'Blackbelt', 'price' => 29.90, 'isPromoted' => true, 'image' => 'images/1.jpeg'],
            ['name' => 'Bluebelt', 'price' => 29.90, 'isPromoted' => false, 'image' => 'images/2.jpeg'],
            ['name' => 'Street', 'price' => 34.50, 'isPromoted' => false, 'image' => 'images/3.jpeg'],
            ['name' => 'Pokeball', 'price' => 45, 'isPromoted' => true, 'image' => 'images/4.jpeg'],
            ['name' => 'PinkLady', 'price' => 29.90, 'isPromoted' => false, 'image' => 'images/5.jpeg'],
            ['name' => 'Snow', 'price' => 32, 'isPromoted' => false, 'image' => 'images/6.jpeg'],
            ['name' => 'Greyback', 'price' => 28.50, 'isPromoted' => false, 'image' => 'images/7.jpeg'],
            ['name' => 'BlueCloud', 'price' => 45, 'isPromoted' => false, 'image' => 'images/8.jpeg'],
            ['name' => 'BornInUsa', 'price' => 59.90, 'isPromoted' => true, 'image' => 'images/9.jpeg'],
            ['name' => 'GreenSchool', 'price' => 42.20, 'isPromoted' => false, 'image' => 'images/10.jpeg'],
        ];

        foreach ($sweatshirts as $data) {
            $sweatshirt = new Sweatshirt();
            $sweatshirt->setName($data['name']);
            $sweatshirt->setPrice($data['price']);
            $sweatshirt->setIsPromoted($data['isPromoted']);
            $sweatshirt->setStockBySize([
                'XS' => 2, 'S' => 2, 'M' => 2, 'L' => 2, 'XL' => 2,
            ]);
            $sweatshirt->setImage($data['image']);

            $manager->persist($sweatshirt);
        }

        // Sauvegarde dans la base de données
        $manager->flush();
    }
}