<?php /** @noinspection PhpUnhandledExceptionInspection */


namespace App\Service;


use App\DTO\Request\User\StudentCreateDTO;
use App\DTO\Response\DTO\StudentDTO;
use App\DTO\Response\Factory\StudentDTOFactory;
use App\Entity\Student;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class StudentService
{
    private EntityManagerInterface $manager;
    private StudentRepository $repository;
    private UserService $userService;
    private StudentDTOFactory $DTOFactory;

    public function __construct(
        EntityManagerInterface $manager,
        StudentRepository $repository,
        UserService $userService,
        StudentDTOFactory $DTOFactory
    )
    {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->userService = $userService;
        $this->DTOFactory = $DTOFactory;
    }

    public function getAll(): array
    {
        $students = $this->repository->findAllByIdJoinedToUser();
        $data = [];
        foreach ($students as $student) {
            $data[] = $this->DTOFactory->fromStudent($student);
        }
        return $data;
    }

    public function add(StudentCreateDTO $DTO): StudentDTO
    {
        $user = $this->userService->createOrUpdate($DTO);
        $student = new Student();
        $student->setUser($user);

        $this->manager->persist($student);
        $this->manager->flush();

        return $this->DTOFactory->fromStudent($student);
    }

    public function get(int $id): StudentDTO
    {
        $student = $this->repository->findOneByIdJoinedToUser($id);
        if ($student === null) {
            throw new EntityNotFoundException("student not found [id: $id]");
        }

        return $this->DTOFactory->fromStudent($student);
    }

    public function update(int $id, StudentCreateDTO $DTO): StudentDTO
    {
        $student = $this->repository->findOneByIdJoinedToUser($id);
        if ($student === null) {
            throw new EntityNotFoundException("student not found [id: $id]");
        }
        $user = $student->getUser();
        $user = $this->userService->createOrUpdate($DTO, $user);
        $student->setUser($user);

        $this->manager->persist($student);
        $this->manager->flush();

        return $this->DTOFactory->fromStudent($student);
    }

    public function remove(int $id): array
    {
        $student = $this->repository->find($id);
        if ($student === null) {
            throw new EntityNotFoundException("student not found [id: $id]");
        }
        $this->manager->remove($student);
        $this->manager->flush();
        return ['status' => "student[id: $id] deleted"];
    }
}