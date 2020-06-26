<?php


namespace App\DTO\Response\Factory;


use App\DTO\Response\DTO\FreetimeDTO;
use App\Entity\Freetime;

class FreetimeDTOFactory
{
    public function fromFreetime(Freetime $freetime): FreetimeDTO
    {
        return new FreetimeDTO(
            $freetime->getId(),
            $freetime->getTeacher()->getUser()->getName(),
            $freetime->getEvent()->getDateFrom(),
            $freetime->getEvent()->getDateTo(),
            $freetime->getEvent()->getId()
        );
    }
}