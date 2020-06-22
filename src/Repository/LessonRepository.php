<?php

namespace App\Repository;

use App\Entity\Lesson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Lesson|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lesson|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lesson[]    findAll()
 * @method Lesson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LessonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lesson::class);
    }

    public function findAllByIdJoinedToAllRelation()
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT l, e, th, t, s
            FROM App\Entity\Lesson l
            INNER JOIN l.event e
            INNER JOIN l.theme th
            INNER JOIN l.teacher t
            INNER JOIN l.student s'
        );
        return $query->getResult();
    }

    public function findOneByIdJoinedToEventAndTeacher(int $id)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT l, e, th, t, s
            FROM App\Entity\Lesson l
            INNER JOIN l.event e
            INNER JOIN l.theme th
            INNER JOIN l.teacher t
            INNER JOIN l.student s
            WHERE l.id = :id'
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
