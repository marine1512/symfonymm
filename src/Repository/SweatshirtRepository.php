<?php

namespace App\Repository;

use App\Entity\Sweatshirt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sweatshirt>
 */
class SweatshirtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sweatshirt::class);
    }

    /**
     * Retourne une liste de sweat-shirts promus.
     *
     * @return Sweatshirt[]
     */
    public function findPromotedSweatshirts(): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.isPromoted = :promoted')
            ->setParameter('promoted', true)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByPriceRange(float $minPrice, float $maxPrice)
{
    return $this->createQueryBuilder('p')
        ->andWhere('p.price BETWEEN :minPrice AND :maxPrice')
        ->setParameter('minPrice', $minPrice)
        ->setParameter('maxPrice', $maxPrice)
        ->getQuery()
        ->getResult();
}
}