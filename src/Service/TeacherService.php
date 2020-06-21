<?php


namespace App\Service;


use App\DTO\User\TeacherDTO;
use App\Entity\Teacher;
use App\Repository\TeacherRepository;
use App\Resource\TeacherResource;
use Doctrine\ORM\EntityManagerInterface;

class TeacherService
{
    private EntityManagerInterface $manager;
    private TeacherRepository $repository;
    private UserService $userService;

    public function __construct(EntityManagerInterface $manager,
                                TeacherRepository $repository,
                                UserService $userService)
    {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->userService = $userService;
    }

    public function getAll(): array
    {
        $themes = $this->repository->findAll();
        $data = [];
        foreach ($themes as $theme) {
            $data[] = TeacherResource::toArray($theme);
        }
        return $data;
    }

    public function add(TeacherDTO $DTO): array
    {
        $user = $this->userService->createOrUpdate($DTO);
        $teacher = new Teacher();
        $teacher->setUser($user);

        $this->manager->persist($teacher);
        $this->manager->flush();

        return TeacherResource::toArray($teacher);
    }

    public function get(int $id): array
    {
        $teacher = $this->repository->find($id);
        if ($teacher === null) {
            return ['error' => "teacher not found [id: $id]"];
        }
        return TeacherResource::toArray($teacher);
    }

    public function update(int $id, TeacherDTO $DTO): array
    {
        $teacher = $this->repository->find($id);
        if ($teacher === null) {
            return ['error' => "teacher not found [id: $id]"];
        }
        $user = $teacher->getUser();
        $user = $this->userService->createOrUpdate($DTO, $user);
        $teacher->setUser($user);
        //$teacher->setThemes($DTO->getThemes());
        $this->manager->persist($teacher);
        $this->manager->flush();

        return TeacherResource::toArray($teacher);
    }

    public function remove(int $id): array
    {
        $teacher = $this->repository->find($id);
        if ($teacher === null) {
            return ['error' => "teacher not found [id: $id]"];
        }
        $this->manager->remove($teacher);
        $this->manager->flush();
        return ['status' => "teacher[id: $id] deleted"];
    }
}