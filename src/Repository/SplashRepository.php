<?php

namespace App\Repository;

use App\Entity\Splash;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Splash|null find($id, $lockMode = null, $lockVersion = null)
 * @method Splash|null findOneBy(array $criteria, array $orderBy = null)
 * @method Splash[]    findAll()
 * @method Splash[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SplashRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Splash::class);
    }

    // /**
    //  * @return Splash[] Returns an array of Splash objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Splash
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
