<?php

namespace App\Repository;

use App\Entity\Beers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


/**
 * @method Beers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Beers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Beers[]    findAll()
 * @method Beers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BeersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Beers::class);
    }


    //TODO needs refaktoring, it is not SOLID
    //TODO remove url actions, make more abstract
    //TODO multiple search doesn't work
    public function findByFields($parameters)
    {
        $sqlQuery = $this->createQueryBuilder('b');

        foreach ($parameters as $fieldKey => $value) {
            if ($value) {
                switch ($fieldKey) {
                    case 'brewer':
                        $sqlQuery->andWhere('b.brewerId = :val');
                        $sqlQuery->setParameter('val', $value);
                        break;
                    case 'fromprice':
                        $sqlQuery->andWhere('b.price >= :val');
                        $sqlQuery->setParameter('val', $value);
                        break;
                    case 'toprice':
                        $sqlQuery->andWhere('b.price <= :val');
                        $sqlQuery->setParameter('val', $value);
                        break;
                    case 'type':
                        $sqlQuery->andWhere('b.type LIKE :val');
                        $sqlQuery->setParameter('val', '%' . $value . '%');
                        break;
                    case 'country':
                        $sqlQuery->andWhere('b.country = :val');
                        $sqlQuery->setParameter('val', $value);
                        break;
                    case 'name':
                        $sqlQuery->andWhere('b.name LIKE :val');
                        $sqlQuery->setParameter('val', '%' . $value . '%');
                        break;
                }
            }
        }

        return $sqlQuery->getQuery()->getResult();
    }

//    /**
//     * @return Beers[] Returns an array of Beers objects
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
    public function findOneBySomeField($value): ?Beers
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
