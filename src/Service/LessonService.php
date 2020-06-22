<?php


namespace App\Service;


use App\DTO\Event\LessonDTO;
use App\Entity\Lesson;
use App\Repository\FreetimeRepository;
use App\Repository\LessonRepository;
use App\Repository\StudentRepository;
use App\Repository\TeacherRepository;
use App\Repository\ThemeRepository;
use App\Resource\LessonResource;
use Doctrine\ORM\EntityManagerInterface;

class LessonService
{
    private EntityManagerInterface $manager;
    private LessonRepository $repository;
    private EventService $eventService;
    private TeacherRepository $teacherRepository;
    private StudentRepository $studentRepository;
    private ThemeRepository $themeRepository;
    private FreetimeRepository $freetimeRepository;

    public function __construct(
        EntityManagerInterface $manager,
        LessonRepository $repository,
        EventService $eventService,
        TeacherRepository $teacherRepository,
        StudentRepository $studentRepository,
        ThemeRepository $themeRepository,
        FreetimeRepository $freetimeRepository
    )
    {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->eventService = $eventService;
        $this->teacherRepository = $teacherRepository;
        $this->studentRepository = $studentRepository;
        $this->themeRepository = $themeRepository;
        $this->freetimeRepository = $freetimeRepository;
    }

    public function getAll(): array
    {
        $lessons = $this->repository->findAllByIdJoinedToAllRelation();
        $data = [];
        foreach ($lessons as $lesson) {
            $data[] = LessonResource::toArray($lesson);
        }
        return $data;
    }

    public function add(LessonDTO $DTO): array
    {
        $event = $this->eventService->createOrUpdate($DTO);
        $teacher = $this->teacherRepository->find($DTO->getIdTeacher());
        $student = $this->studentRepository->find($DTO->getIdStudent());
        $theme = $this->themeRepository->find($DTO->getIdTheme());
        $freetime = $this->freetimeRepository->find($DTO->getIdFreetime());

        $lesson = new Lesson();
        $lesson
            ->setEvent($event)
            ->setTeacher($teacher)
            ->setStudent($student)
            ->setFreetime($freetime)
            ->setTheme($theme);

        $this->manager->persist($lesson);
        $this->manager->flush();

        return LessonResource::toArray($lesson);
    }

    public function get(int $id): array
    {
        $lesson = $this->repository->findOneByIdJoinedToEventAndTeacher($id);
        if ($lesson === null) {
            return ['error' => "lesson not found [id: $id]"];
        }

        return LessonResource::toArray($lesson);
    }

    public function update(int $id, LessonDTO $DTO): array
    {
        $lesson = $this->repository->findOneByIdJoinedToEventAndTeacher($id);
        if ($lesson === null) {
            return ['error' => "lesson not found [id: $id]"];
        }

        $event = $lesson->getEvent();
        $event = $this->eventService->createOrUpdate($DTO, $event);
        $student = $this->studentRepository->find($DTO->getIdStudent());
        $theme = $this->themeRepository->find($DTO->getIdTheme());

        $lesson
            ->setEvent($event)
            ->setStudent($student)
            ->setTheme($theme);

        $this->manager->persist($lesson);
        $this->manager->flush();

        return LessonResource::toArray($lesson);
    }

    public function remove(int $id): array
    {
        $lesson = $this->repository->find($id);
        if ($lesson === null) {
            return ['error' => "lesson not found [id: $id]"];
        }
        $this->manager->remove($lesson);
        $this->manager->flush();
        return ['status' => "lesson[id: $id] deleted"];
    }
}