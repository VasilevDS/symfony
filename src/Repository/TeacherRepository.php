<?php /** @noinspection PhpDocSignatureInspection */

namespace App\Repository;

use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Teacher|null find($id, $lockMode = null, $lockVersion = null)
 * @method Teacher|null findOneBy(array $criteria, array $orderBy = null)
 * @method Teacher[]    findAll()
 * @method Teacher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeacherRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $manager;
    private UserRepository $userRep;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager, UserRepository $userRep)
    {
        parent::__construct($registry, Teacher::class);
        $this->manager = $manager;
        $this->userRep = $userRep;
    }

    public function findAllByIdJoinedToUser()
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT t, u
            FROM App\Entity\Teacher t
            INNER JOIN t.user u
            INNER JOIN t.themes th'
        );
        return $query->getResult();
    }

    public function findOneByIdJoinedToUser(int $id)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT t, u, th
            FROM App\Entity\Teacher t
            INNER JOIN t.user u
            INNER JOIN t.themes th
            WHERE t.id = :id'
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
