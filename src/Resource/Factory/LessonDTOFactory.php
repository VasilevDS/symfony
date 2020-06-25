<?php


namespace App\Resource\Factory;


use App\Entity\Lesson;
use App\Resource\DTO\LessonDTO;

class LessonDTOFactory
{
    public function fromLesson(Lesson $lesson): LessonDTO
    {
        return new LessonDTO(
            $lesson->getId(),
            $lesson->getTeacher()->getId(),
            $lesson->getTeacher()->getUser()->getName(),
            $lesson->getStudent()->getId(),
            $lesson->getStudent()->getUser()->getName(),
            $lesson->getTheme()->getName(),
            $lesson->getEvent()->getDateFrom(),
            $lesson->getEvent()->getDateTo()
        );
    }
}