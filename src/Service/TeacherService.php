<?php /** @noinspection PhpUnhandledExceptionInspection */


namespace App\Service;


use App\DTO\Request\User\TeacherCreateDTO;
use App\DTO\Response\DTO\TeacherDTO;
use App\DTO\Response\Factory\TeacherDTOFactory;
use App\Entity\Teacher;
use App\Repository\TeacherRepository;
use App\Repository\ThemeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class TeacherService
{
    private EntityManagerInterface $manager;
    private TeacherRepository $repository;
    private UserService $userService;
    private ThemeRepository $themeRepository;
    private TeacherDTOFactory $DTOFactory;

    public function __construct(
        EntityManagerInterface $manager,
        TeacherRepository $repository,
        ThemeRepository $themeRepository,
        UserService $userService,
        TeacherDTOFactory $DTOFactory
    )
    {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->userService = $userService;
        $this->themeRepository = $themeRepository;
        $this->DTOFactory = $DTOFactory;
    }

    public function getAll(): array
    {
        $teachers = $this->repository->findAllByIdJoinedToUser();
        $TeachersData = [];
        foreach ($teachers as $teacher) {
            $TeachersData[] = $this->DTOFactory->fromTeacher($teacher);
        }
        return $TeachersData;
    }

    public function add(TeacherCreateDTO $DTO): TeacherDTO
    {
        $user = $this->userService->createOrUpdate($DTO);
        $teacher = new Teacher();
        $teacher->setUser($user);
        $teacher = $this->addThemesToTeacher($teacher, $DTO->getThemes());

        $this->manager->persist($teacher);
        $this->manager->flush();

        return $this->DTOFactory->fromTeacher($teacher);
    }

    public function get(int $id): TeacherDTO
    {
        $teacher = $this->repository->findOneByIdJoinedToUser($id);
        if ($teacher === null) {
            throw new EntityNotFoundException("teacher not found [id: $id]");
        }

        return $this->DTOFactory->fromTeacher($teacher);
    }

    public function update(int $id, TeacherCreateDTO $DTO): TeacherDTO
    {
        $teacher = $this->repository->findOneByIdJoinedToUser($id);
        if ($teacher === null) {
            throw new EntityNotFoundException("teacher not found [id: $id]");
        }
        $user = $teacher->getUser();
        $user = $this->userService->createOrUpdate($DTO, $user);
        $teacher->setUser($user);
        $teacher = $this->addThemesToTeacher($teacher, $DTO->getThemes());

        $this->manager->persist($teacher);
        $this->manager->flush();

        return $this->DTOFactory->fromTeacher($teacher);
    }

    public function remove(int $id): array
    {
        $teacher = $this->repository->find($id);
        if ($teacher === null) {
            throw new EntityNotFoundException("teacher not found [id: $id]");
        }
        $this->manager->remove($teacher);
        $this->manager->flush();
        return ['status' => "teacher[id: $id] deleted"];
    }

    public function addThemesToTeacher(Teacher $teacher, array $themes) :Teacher
    {
        $teacher->getThemes()->clear();
        foreach ($themes as $idTheme)
        {
            $theme = $this->themeRepository->find($idTheme);
            if($theme === null) {
                throw new EntityNotFoundException("theme not found [id: $idTheme]");
            }
            $teacher->addTheme($theme);
        }
        return $teacher;
    }
}