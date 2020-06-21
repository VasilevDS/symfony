<?php


namespace App\Resource;


use App\Entity\Teacher;
use App\Entity\Theme;

class TeacherResource
{
    public static function toArray(Teacher $teacher): array
    {
        $themesNames = [];
        /** @var Theme $theme */
        foreach ($teacher->getThemes() as $theme) {
            $themesNames[] = $theme->getName();
        }

        return [
            'teacher_id' => $teacher->getId(),
            'user_id' => $teacher->getUser()->getId(),
            'name' => $teacher->getUser()->getName(),
            'email' => $teacher->getUser()->getEmail(),
            'themes' => $themesNames,
            'role' => $teacher->getUser()->getRoles(),
        ];
    }
}