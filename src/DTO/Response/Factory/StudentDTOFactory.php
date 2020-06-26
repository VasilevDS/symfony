<?php


namespace App\DTO\Response\Factory;


use App\DTO\Response\DTO\StudentDTO;
use App\Entity\Student;

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