<?php


namespace App\Resource;


use App\Entity\Freetime;

class FreetimeResource
{
    public static function toArray(Freetime $freetime): array
    {
        $event = $freetime->getEvent();
        $teacher = $freetime->getTeacher();

        return [
          'id' => $freetime->getId(),
          'teacher_name' => $teacher->getUser()->getName(),
          'date_to' => $event->getDateTo(),
          'date_from' => $event->getDateFrom(),
          'event_id' => $event->getId(),
        ];
    }
}