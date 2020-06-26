<?php


namespace App\DTO\Response\Factory;


use App\DTO\Response\DTO\LessonDTO;
use App\Entity\Lesson;

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