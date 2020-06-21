<?php


namespace App\Service;


use App\DTO\Event\EventDTOInterface;
use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;

class EventService
{
    private EntityManagerInterface $manager;
    private EventRepository $repository;

    public function __construct(EntityManagerInterface $manager, EventRepository $repository)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }

    public function createOrUpdate(EventDTOInterface $DTO, Event $event = null): Event
    {
        $event = $event ?? new Event();
        $event->setDateFrom($DTO->getDateFrom())
              ->setDateTo($DTO->getDateTo())
              ->setType($DTO->getType());

        return $event;
    }
}