<?php


namespace App\Resource;


use App\Entity\Student;

class StudentResource
{
    public static function toArray(Student $student): array
    {
        return [
            'student_id' => $student->getId(),
            'user_id' => $student->getUser()->getId(),
            'name' => $student->getUser()->getName(),
            'email' => $student->getUser()->getEmail(),
            'role' => $student->getUser()->getRoles(),
        ];
    }
}