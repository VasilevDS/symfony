<?php


namespace App\Resource;


use App\Entity\Lesson;

class LessonResource
{
    public static function toArray(Lesson $lesson)
    {
        $teacher = $lesson->getTeacher();
        $student = $lesson->getStudent();
        $theme = $lesson->getTheme();
        $event = $lesson->getEvent();

        return [
            'lesson_id' => $lesson->getId(),
            'teacher_id' => $teacher->getId(),
            'teacher_name' => $teacher->getUser()->getName(),
            'student_id' => $student->getId(),
            'student_name' => $student->getUser()->getName(),
            'theme' => $theme->getName(),
            'date_from' => $event->getDateFrom(),
            'date_to' => $event->getDateTo(),
        ];
    }
}