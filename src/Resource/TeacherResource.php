<?php


namespace App\Resource;


use App\Entity\Teacher;

class TeacherResource
{
    public static function toArray(Teacher $teacher)
    {
        return [
            'teacher_id' => $teacher->getId(),
            'user_id' => $teacher->getUser()->getId(),
            'name' => $teacher->getUser()->getName(),
            'email' => $teacher->getUser()->getEmail(),
            'role' => $teacher->getUser()->getRoles(),
        ];
    }
}