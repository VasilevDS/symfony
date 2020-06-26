<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    public function findAllByIdJoinedToUser()
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT s, u
            FROM App\Entity\Student s
            INNER JOIN s.user u'
        );
        return $query->getResult();
    }

    public function findOneByIdJoinedToUser(int $id)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT s, u
            FROM App\Entity\Student s
            INNER JOIN s.user u
            WHERE s.id = :id'
        )->setParameter('id', $id);

        try {
            return $query->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
}
