<?php /** @noinspection PhpDocSignatureInspection */

namespace App\Repository;

use App\DTO\TeacherDTO;
use App\Entity\Teacher;
use App\Resource\TeacherResource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
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

    public function save(TeacherDTO $dto): array
    {
        $user = $this->userRep->createOrUpdateUser($dto);

        $teacher = new Teacher();
        $teacher->setUser($user);

        $this->manager->persist($teacher);
        $this->manager->flush();

        return TeacherResource::toArray($teacher);
    }

    public function findOneByIdJoinedToUser()
    {
        $query = $this->manager->createQuery(
            'SELECT t, u
        FROM App\Entity\Teacher t
        INNER JOIN t.user u'
        );

        return $query->execute();
    }

    /**
     * @throws EntityNotFoundException
     */
    public function update(int $idTeacher, TeacherDTO $dto): array
    {
        $teacher = $this->findOrFail($idTeacher);

        $user = $this->userRep->createOrUpdateUser($dto);
        $teacher->setUser($user);
        $this->manager->persist($teacher);
        $this->manager->flush();

        return TeacherResource::toArray($teacher);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function destroy(int $idTeacher): bool
    {
        $teacher = $this->findOrFail($idTeacher);
        $this->manager->remove($teacher);
        $this->manager->flush();

        return true;
    }

    /**
     * @throws EntityNotFoundException
     */
    public function findOrFail(int $idTeacher): Teacher
    {
        $teacher = $this->find($idTeacher);
        if($teacher === null) {
            throw new EntityNotFoundException("teacher not found [id: $idTeacher]");
        }
        return $teacher;
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
