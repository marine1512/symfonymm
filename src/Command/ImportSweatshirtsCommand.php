<?php

namespace App\Command;

use App\Entity\Sweatshirt;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'app:import-sweatshirts', 
    description: 'Importe les sweat-shirts dans la base de données'
)]
class ImportSweatshirtsCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $sweatshirts = [
            ['name' => 'Blackbelt', 'price' => 29.90, 'isPromoted' => false],
            ['name' => 'Bluebelt', 'price' => 29.90, 'isPromoted' => false],
            ['name' => 'Street', 'price' => 34.50, 'isPromoted' => false],
            ['name' => 'Pokeball **', 'price' => 45, 'isPromoted' => true],
            ['name' => 'PinkLady', 'price' => 29.90, 'isPromoted' => false],
            ['name' => 'Snow', 'price' => 32, 'isPromoted' => false],
            ['name' => 'Greyback', 'price' => 28.50, 'isPromoted' => false],
            ['name' => 'BlueCloud', 'price' => 45, 'isPromoted' => false],
            ['name' => 'BornInUsa **', 'price' => 59.90, 'isPromoted' => true],
            ['name' => 'GreenSchool', 'price' => 42.20, 'isPromoted' => false],
        ];

        foreach ($sweatshirts as $data) {
            $sweatshirt = new Sweatshirt();
            $sweatshirt->setName($data['name']);
            $sweatshirt->setPrice($data['price']);
            $sweatshirt->setIsPromoted($data['isPromoted']);
            $sweatshirt->setStockBySize([
                'XS' => 2, 'S' => 2, 'M' => 2, 'L' => 2, 'XL' => 2,
            ]);

            $this->entityManager->persist($sweatshirt);
        }

        $this->entityManager->flush();

        $io->success('Les sweat-shirts ont été importés avec succès !');
        return Command::SUCCESS;
    }
}