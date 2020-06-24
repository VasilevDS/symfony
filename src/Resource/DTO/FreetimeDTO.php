<?php


namespace App\Resource\DTO;


use DateTime;

class FreetimeDTO
{
    private int $idTeacher;
    private string $teacherName;
    private DateTime $dateFrom;
    private DateTime $dateTo;
    private int $eventId;

    public function __construct(
        int $idTeacher,
        string $teacherName,
        DateTime $dateFrom,
        DateTime $dateTo,
        int $eventId
    )
    {
        $this->idTeacher = $idTeacher;
        $this->teacherName = $teacherName;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->eventId = $eventId;
    }
}