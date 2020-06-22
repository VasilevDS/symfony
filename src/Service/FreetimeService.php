<?php


namespace App\Service;


use App\DTO\Event\FreetimeDTO;
use App\Entity\Freetime;
use App\Repository\FreetimeRepository;
use App\Repository\TeacherRepository;
use App\Resource\FreetimeResource;
use App\Validation\ValidatorService;
use Doctrine\ORM\EntityManagerInterface;

class FreetimeService
{
    private EntityManagerInterface $manager;
    private FreetimeRepository $repository;
    private EventService $eventService;
    private TeacherRepository $teacherRepository;
    private ValidatorService $validator;

    public function __construct(
        EntityManagerInterface $manager,
        FreetimeRepository $repository,
        EventService $eventService,
        ValidatorService $validator,
        TeacherRepository $teacherRepository
    )
    {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->eventService = $eventService;
        $this->teacherRepository = $teacherRepository;
        $this->validator = $validator;
    }

    public function getAll(): array
    {
        $freetimes = $this->repository->findAllByIdJoinedToEventAndTeacher();
        $data = [];
        foreach ($freetimes as $freetime) {
            $data[] = FreetimeResource::toArray($freetime);
        }
        return $data;
    }

    public function add(FreetimeDTO $DTO): array
    {
        $this->validator->dateFromNoEarlierToday->setParam($DTO->getDateFrom());
        $this->validator->dateFromNoLaterThanDateTo->setParam($DTO->getDateFrom(), $DTO->getDateTo());
        $this->validator->dateRangeIntersectedFreetimes->setParam(
            $DTO->getIdTeacher(),
            $DTO->getDateFrom(),
            $DTO->getDateTo()
        );

        $this->validator->addRules(
            $this->validator->dateFromNoEarlierToday,
            $this->validator->dateFromNoLaterThanDateTo,
            $this->validator->dateRangeIntersectedFreetimes
        );

        $errors = $this->validator->validate();
        if($errors !== []) {
            return ['errors' => $errors];
        }

        $event = $this->eventService->createOrUpdate($DTO);

        $teacher = $this->teacherRepository->find($DTO->getIdTeacher());
        if ($teacher === null) {
            $id = $DTO->getIdTeacher();
            return ['error' => "teacher not found [id: $id]"];
        }

        $freetime = new Freetime();
        $freetime->setEvent($event)
                ->setTeacher($teacher);

        $this->manager->persist($freetime);
        $this->manager->flush();

        return FreetimeResource::toArray($freetime);
    }

    public function get(int $id): array
    {
        $freetime = $this->repository->findOneByIdJoinedToEventAndTeacher($id);
        if ($freetime === null) {
            return ['error' => "freetime not found [id: $id]"];
        }

        return FreetimeResource::toArray($freetime);
    }

    public function update(int $id, FreetimeDTO $DTO)
    {
        $freetime = $this->repository->findOneByIdJoinedToEventAndTeacher($id);
        if ($freetime === null) {
            return ['error' => "freetime not found [id: $id]"];
        }
        $event = $freetime->getEvent();
        $event = $this->eventService->createOrUpdate($DTO, $event);
        $freetime->setEvent($event);

        $this->manager->persist($freetime);
        $this->manager->flush();

        return FreetimeResource::toArray($freetime);
    }

    public function remove(int $id): array
    {
        $freetime = $this->repository->find($id);
        if ($freetime === null) {
            return ['error' => "freetime not found [id: $id]"];
        }
        $this->manager->remove($freetime);
        $this->manager->flush();
        return ['status' => "freetime[id: $id] deleted"];
    }
}