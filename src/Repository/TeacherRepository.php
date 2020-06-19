<?php

namespace App\Repository;

use App\DTO\TeacherDTO;
use App\Entity\Teacher;
use App\Entity\User;
use App\Resource\TeacherResource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Teacher::class);
        $this->manager = $manager;
    }

    public function save(TeacherDTO $dto): array
    {
        /** @var User $user */
        $user = new User();
        $user->setName($dto->getName())
            ->setEmail($dto->getEmail())
            ->setRoles($dto->getRoles())
            ->setPassword($dto->getPassword());

        /** @var Teacher $teacher */
        $teacher = new Teacher();
        $teacher->setUser($user);

        $this->manager->persist($teacher);
        $this->manager->flush();

        return TeacherResource::toArray($teacher);
    }

    public function findOneByIdJoinedToUser()
    {
        //$entityManager = $this->getEntityManager();

        $query = $this->manager->createQuery(
            'SELECT t, u
        FROM App\Entity\Teacher t
        //INNER JOIN t.user u'
        );
        dd($query->getSQL()); //
        return $query->execute();
    }

    // /**
    //  * @return Teacher[] Returns an array of Teacher objects
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
    public function findOneBySomeField($value): ?Teacher
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
