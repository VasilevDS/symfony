<?php

namespace App\Repository;

use App\Entity\Freetime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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

    public function findAllByIdJoinedToEventAndTeacher()
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT f, e, t, u
            FROM App\Entity\Freetime f
            INNER JOIN f.event e
            INNER JOIN f.teacher t
            INNER JOIN t.user u'
        );
        return $query->getResult();
    }

    public function findOneByIdJoinedToEventAndTeacher(int $id)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT f, e, t, u
            FROM App\Entity\Freetime f
            INNER JOIN f.event e
            INNER JOIN f.teacher t
            INNER JOIN t.user u
            WHERE f.id = :id'
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
