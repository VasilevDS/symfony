<?php


namespace App\Resource\Factory;


use App\Entity\Teacher;
use App\Entity\Theme;
use App\Resource\DTO\TeacherDTO;

class TeacherDTOFactory
{
    public function fromTeacher(Teacher $teacher): TeacherDTO
    {
        $themesNames = [];
        /** @var Theme $theme */
        foreach ($teacher->getThemes()->toArray() as $theme) {
            $themesNames[] = $theme->getName();
        }

        return new TeacherDTO(
            $teacher->getId(),
            $teacher->getUser()->getId(),
            $teacher->getUser()->getName(),
            $themesNames,
            $teacher->getUser()->getEmail(),
            $teacher->getUser()->getRoles(),
        );
    }
}