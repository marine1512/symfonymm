<?php

namespace App\DataFixtures;

use App\Entity\Sweatshirt;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Ajouter quelques utilisateurs
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@example.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin, 'admin')
        );
        $manager->persist($admin);

        $client = new User();
        $client->setUsername('client');
        $client->setEmail('client@example.com');
        $client->setRoles(['ROLE_CLIENT']);
        $client->setPassword(
            $this->passwordHasher->hashPassword($client, 'client')
        );
        $manager->persist($client);

        // Ajouter quelques sweatshirts
        $sweatshirt1 = new Sweatshirt();
        $sweatshirt1->setName('Sweatshirt Rouge');
        $sweatshirt1->setPrice(49.99);
        $sweatshirt1->setIsPromoted(true);
        $sweatshirt1->setStockBySize(['S' => 10, 'M' => 5, 'L' => 3]);
        $sweatshirt1->setImage('sweat-red.png');
        $manager->persist($sweatshirt1);

        $sweatshirt2 = new Sweatshirt();
        $sweatshirt2->setName('Sweatshirt Bleu');
        $sweatshirt2->setPrice(39.99);
        $sweatshirt2->setIsPromoted(false);
        $sweatshirt2->setStockBySize(['S' => 15, 'M' => 10, 'L' => 8, 'XL' => 4]);
        $sweatshirt2->setImage('sweat-blue.png');
        $manager->persist($sweatshirt2);

        // Flusher les entités dans la base
        $manager->flush();
    }
}