<?php

namespace App\Repository;

use App\Entity\Brewers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Brewers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Brewers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Brewers[]    findAll()
 * @method Brewers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrewersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Brewers::class);
    }

//    /**
//     * @return Brewers[] Returns an array of Brewers objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Brewers
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
