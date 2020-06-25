<?php


namespace App\Resource\Factory;


use App\Entity\Student;
use App\Resource\DTO\StudentDTO;

class StudentDTOFactory
{
    public function fromStudent(Student $student): StudentDTO
    {
        return new StudentDTO(
            $student->getId(),
            $student->getUser()->getId(),
            $student->getUser()->getName(),
            $student->getUser()->getEmail(),
            $student->getUser()->getRoles(),
        );
    }
}