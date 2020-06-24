<?php


namespace App\Resource\Factory;


use App\Entity\Freetime;
use App\Resource\DTO\FreetimeDTO;

class FreetimeDTOFactory
{
    public function fromFreetime(Freetime $freetime)
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