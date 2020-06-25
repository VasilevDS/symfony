<?php /** @noinspection PhpUnhandledExceptionInspection */


namespace App\Service;


use App\DTO\Event\LessonCreateDTO;
use App\Entity\Lesson;
use App\Repository\FreetimeRepository;
use App\Repository\LessonRepository;
use App\Repository\StudentRepository;
use App\Repository\TeacherRepository;
use App\Repository\ThemeRepository;
use App\Resource\DTO\LessonDTO;
use App\Resource\Factory\LessonDTOFactory;
use App\Validation\LessonValidatorService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class LessonService
{
    private EntityManagerInterface $manager;
    private LessonRepository $repository;
    private EventService $eventService;
    private TeacherRepository $teacherRepository;
    private StudentRepository $studentRepository;
    private ThemeRepository $themeRepository;
    private FreetimeRepository $freetimeRepository;
    private LessonValidatorService $validator;
    private LessonDTOFactory $DTOFactory;

    public function __construct(
        EntityManagerInterface $manager,
        LessonRepository $repository,
        EventService $eventService,
        TeacherRepository $teacherRepository,
        StudentRepository $studentRepository,
        ThemeRepository $themeRepository,
        FreetimeRepository $freetimeRepository,
        LessonDTOFactory $DTOFactory,
        LessonValidatorService $validator
    )
    {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->eventService = $eventService;
        $this->teacherRepository = $teacherRepository;
        $this->studentRepository = $studentRepository;
        $this->themeRepository = $themeRepository;
        $this->freetimeRepository = $freetimeRepository;
        $this->validator = $validator;
        $this->DTOFactory = $DTOFactory;
    }

    public function getAll(): array
    {
        $lessons = $this->repository->findAllByIdJoinedToAllRelation();
        $data = [];
        foreach ($lessons as $lesson) {
            $data[] = $this->DTOFactory->fromLesson($lesson);
        }
        return $data;
    }

    public function add(LessonCreateDTO $DTO): LessonDTO
    {
        $this->validator->validateForCreate($DTO);

        $event = $this->eventService->createOrUpdate($DTO);
        $teacher = $this->teacherRepository->find($DTO->getTeacherId());
        $student = $this->studentRepository->find($DTO->getStudentId());
        $theme = $this->themeRepository->find($DTO->getThemeId());
        $freetime = $this->freetimeRepository->find($DTO->getFreetimeId());

        $lesson = new Lesson();
        $lesson
            ->setEvent($event)
            ->setTeacher($teacher)
            ->setStudent($student)
            ->setFreetime($freetime)
            ->setTheme($theme);

        $this->manager->persist($lesson);
        $this->manager->flush();

        return $this->DTOFactory->fromLesson($lesson);
    }

    public function get(int $id): LessonDTO
    {
        $lesson = $this->repository->findOneByIdJoinedToEventAndTeacher($id);
        if ($lesson === null) {
            throw new EntityNotFoundException("lesson not found [id: $id]");
        }

        return $this->DTOFactory->fromLesson($lesson);
    }

    public function update(int $id, LessonCreateDTO $DTO): LessonDTO
    {
        $lesson = $this->repository->findOneByIdJoinedToEventAndTeacher($id);
        if ($lesson === null) {
            throw new EntityNotFoundException("lesson not found [id: $id]");
        }

        $this->validator->validateForUpdate($DTO, $id);

        $event = $lesson->getEvent();
        $event = $this->eventService->createOrUpdate($DTO, $event);
        $student = $this->studentRepository->find($DTO->getStudentId());
        $theme = $this->themeRepository->find($DTO->getThemeId());

        $lesson
            ->setEvent($event)
            ->setStudent($student)
            ->setTheme($theme);

        $this->manager->persist($lesson);
        $this->manager->flush();

        return $this->DTOFactory->fromLesson($lesson);
    }

    public function remove(int $id): array
    {
        $lesson = $this->repository->find($id);
        if ($lesson === null) {
            throw new EntityNotFoundException("lesson not found [id: $id]");
        }
        $this->manager->remove($lesson);
        $this->manager->flush();
        return ['status' => "lesson[id: $id] deleted"];
    }
}