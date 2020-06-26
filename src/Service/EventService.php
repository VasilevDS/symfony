<?php


namespace App\Service;


use App\DTO\Request\Event\EventCreateDTOInterface;
use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;

class EventService
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function createOrUpdate(EventCreateDTOInterface $DTO, Event $event = null): Event
    {
        $event = $event ?? new Event();
        $event->setDateFrom($DTO->getDateFrom())
              ->setDateTo($DTO->getDateTo())
              ->setType($DTO->getType());

        $this->manager->persist($event);
        return $event;
    }
}