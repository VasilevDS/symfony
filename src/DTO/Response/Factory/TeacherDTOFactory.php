<?php


namespace App\DTO\Response\Factory;


use App\DTO\Response\DTO\TeacherDTO;
use App\Entity\Teacher;
use App\Entity\Theme;

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