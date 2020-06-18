<?php

namespace App\Repository;

use App\Entity\Freetime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Freetime|null find($id, $lockMode = null, $lockVersion = null)
 * @method Freetime|null findOneBy(array $criteria, array $orderBy = null)
 * @method Freetime[]    findAll()
 * @method Freetime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FreetimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Freetime::class);
    }

    // /**
    //  * @return Freetime[] Returns an array of Freetime objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Freetime
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
