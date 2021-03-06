<?php /** @noinspection PhpUnhandledExceptionInspection */


namespace App\Service;


use App\DTO\Request\Event\FreetimeCreateDTO;
use App\DTO\Response\DTO\FreetimeDTO;
use App\DTO\Response\Factory\FreetimeDTOFactory;
use App\Entity\Freetime;
use App\Repository\FreetimeRepository;
use App\Repository\TeacherRepository;
use App\Validation\FreetimeValidatorService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class FreetimeService
{
    private EntityManagerInterface $manager;
    private FreetimeRepository $repository;
    private EventService $eventService;
    private TeacherRepository $teacherRepository;
    private FreetimeValidatorService $validator;
    private FreetimeDTOFactory $DTOFactory;

    public function __construct(
        EntityManagerInterface $manager,
        FreetimeRepository $repository,
        EventService $eventService,
        TeacherRepository $teacherRepository,
        FreetimeDTOFactory $DTOFactory,
        FreetimeValidatorService $validator
    )
    {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->eventService = $eventService;
        $this->teacherRepository = $teacherRepository;
        $this->validator = $validator;
        $this->DTOFactory = $DTOFactory;
    }

    public function getAll(): array
    {
        $freetimes = $this->repository->findAllByIdJoinedToEventAndTeacher();
        /** @var FreetimeDTO[] $data */
        $data = [];
        foreach ($freetimes as $freetime) {
            $data[] = $this->DTOFactory->fromFreetime($freetime);
        }
        return $data;
    }

    public function add(FreetimeCreateDTO $DTO): FreetimeDTO
    {
        $this->validator->validateForCreate($DTO);

        $event = $this->eventService->createOrUpdate($DTO);

        $teacher = $this->teacherRepository->find($DTO->getTeacherId());
        if ($teacher === null) {
            $id = $DTO->getTeacherId();
            throw new EntityNotFoundException("teacher not found [id: $id]");
        }

        $freetime = new Freetime();
        $freetime->setEvent($event)
                ->setTeacher($teacher);

        $this->manager->persist($freetime);
        $this->manager->flush();

        return $this->DTOFactory->fromFreetime($freetime);
    }

    public function get(int $id): FreetimeDTO
    {
        $freetime = $this->repository->findOneByIdJoinedToEventAndTeacher($id);
        if ($freetime === null) {
            throw new EntityNotFoundException("freetime not found [id: $id]");
        }
        return $this->DTOFactory->fromFreetime($freetime);
    }

    public function update(int $id, FreetimeCreateDTO $DTO): FreetimeDTO
    {
        $freetime = $this->repository->findOneByIdJoinedToEventAndTeacher($id);
        if ($freetime === null) {
            throw new EntityNotFoundException("freetime not found [id: $id]");
        }

        $this->validator->validateForUpdate($DTO, $id);

        $event = $freetime->getEvent();
        $event = $this->eventService->createOrUpdate($DTO, $event);
        $freetime->setEvent($event);

        $this->manager->persist($freetime);
        $this->manager->flush();

        return $this->DTOFactory->fromFreetime($freetime);
    }

    public function remove(int $id): array
    {
        $freetime = $this->repository->find($id);
        if ($freetime === null) {
            throw new EntityNotFoundException("freetime not found [id: $id]");
        }
        $this->manager->remove($freetime);
        $this->manager->flush();
        return ['status' => "freetime[id: $id] deleted"];
    }
}