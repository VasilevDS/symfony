<?php


namespace App\Service;


use App\DTO\User\StudentDTO;
use App\Entity\Student;
use App\Repository\StudentRepository;
use App\Resource\StudentResource;
use Doctrine\ORM\EntityManagerInterface;

class StudentService
{
    private EntityManagerInterface $manager;
    private StudentRepository $repository;
    private UserService $userService;

    public function __construct(EntityManagerInterface $manager,
                                StudentRepository $repository,
                                UserService $userService)
    {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->userService = $userService;
    }

    public function getAll(): array
    {
        $students = $this->repository->findAll();
        $data = [];
        foreach ($students as $student) {
            $data[] = StudentResource::toArray($student);
        }
        return $data;
    }

    public function add(StudentDTO $DTO): array
    {
        $user = $this->userService->createOrUpdate($DTO);
        $student = new Student();
        $student->setUser($user);

        $this->manager->persist($student);
        $this->manager->flush();

        return StudentResource::toArray($student);
    }

    public function get(int $id): array
    {
        $student = $this->repository->find($id);
        if ($student === null) {
            return ['error' => "student not found [id: $id]"];
        }

        return StudentResource::toArray($student);
    }

    public function update(int $id, StudentDTO $DTO): array
    {
        $student = $this->repository->find($id);
        if ($student === null) {
            return ['error' => "student not found [id: $id]"];
        }
        $user = $student->getUser();
        $user = $this->userService->createOrUpdate($DTO, $user);
        $student->setUser($user);

        $this->manager->persist($student);
        $this->manager->flush();

        return StudentResource::toArray($student);
    }

    public function remove(int $id): array
    {
        $student = $this->repository->find($id);
        if ($student === null) {
            return ['error' => "student not found [id: $id]"];
        }
        $this->manager->remove($student);
        $this->manager->flush();
        return ['status' => "student[id: $id] deleted"];
    }
}