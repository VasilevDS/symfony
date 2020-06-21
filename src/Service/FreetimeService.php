<?php


namespace App\Service;


use App\DTO\Event\FreetimeDTO;
use App\Entity\Freetime;
use App\Repository\FreetimeRepository;
use App\Repository\TeacherRepository;
use App\Resource\FreetimeResource;
use Doctrine\ORM\EntityManagerInterface;

class FreetimeService
{
    private EntityManagerInterface $manager;
    private FreetimeRepository $repository;
    private EventService $eventService;
    private TeacherRepository $teacherRepository;

    public function __construct(
        EntityManagerInterface $manager,
        FreetimeRepository $repository,
        EventService $eventService,
        TeacherRepository $teacherRepository
    )
    {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->eventService = $eventService;
        $this->teacherRepository = $teacherRepository;
    }

    public function getAll(): array
    {
        $freetimes = $this->repository->findAll();
        $data = [];
        foreach ($freetimes as $freetime) {
            $data[] = FreetimeResource::toArray($freetime);
        }
        return $data;
    }

    public function add(FreetimeDTO $DTO): array
    {
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
        $freetime = $this->repository->find($id);
        if ($freetime === null) {
            return ['error' => "freetime not found [id: $id]"];
        }

        return FreetimeResource::toArray($freetime);
    }

    public function update(int $id, FreetimeDTO $DTO)
    {
        $freetime = $this->repository->find($id);
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