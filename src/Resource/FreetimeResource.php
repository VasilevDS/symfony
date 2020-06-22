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
          'date_from' => $event->getDateFrom(),
          'date_to' => $event->getDateTo(),
          'event_id' => $event->getId(),
        ];
    }
}