<?php

namespace App\Repository;

use App\Entity\TeacherTheme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TeacherTheme|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeacherTheme|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeacherTheme[]    findAll()
 * @method TeacherTheme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeacherThemeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeacherTheme::class);
    }

    // /**
    //  * @return TeacherTheme[] Returns an array of TeacherTheme objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TeacherTheme
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
