<?php


namespace App\Service;


use App\DTO\User\TeacherDTO;
use App\Entity\Teacher;
use App\Repository\TeacherRepository;
use App\Repository\ThemeRepository;
use App\Resource\TeacherResource;
use Doctrine\ORM\EntityManagerInterface;

class TeacherService
{
    private EntityManagerInterface $manager;
    private TeacherRepository $repository;
    private UserService $userService;
    private ThemeRepository $themeRepository;

    public function __construct(EntityManagerInterface $manager,
                                TeacherRepository $repository,
                                ThemeRepository $themeRepository,
                                UserService $userService)
    {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->userService = $userService;
        $this->themeRepository = $themeRepository;
    }

    public function getAll(): array
    {
        $teachers = $this->repository->findAll();
        $data = [];
        foreach ($teachers as $theme) {
            $data[] = TeacherResource::toArray($theme);
        }
        return $data;
    }

    public function add(TeacherDTO $DTO): array
    {
        $user = $this->userService->createOrUpdate($DTO);
        $teacher = new Teacher();
        $teacher->setUser($user);
        foreach ($DTO->getThemes() as $idTheme)
        {
            $theme = $this->themeRepository->find($idTheme);
            $teacher->addTheme($theme);
        }

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
        $teacher->getThemes()->clear();
        foreach ($DTO->getThemes() as $idTheme)
        {
            $theme = $this->themeRepository->find($idTheme);
            $teacher->addTheme($theme);
        }

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