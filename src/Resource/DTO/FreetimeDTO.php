<?php /** @noinspection PhpUnused */


namespace App\Resource\DTO;


use DateTime;

class FreetimeDTO
{
    private int $teacherId;
    private string $teacherName;
    private DateTime $dateFrom;
    private DateTime $dateTo;
    private int $eventId;

    public function __construct(
        int $teacherId,
        string $teacherName,
        DateTime $dateFrom,
        DateTime $dateTo,
        int $eventId
    )
    {
        $this->teacherId = $teacherId;
        $this->teacherName = $teacherName;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->eventId = $eventId;
    }

    public function getTeacherId(): int
    {
        return $this->teacherId;
    }

    public function getTeacherName(): string
    {
        return $this->teacherName;
    }

    public function getDateFrom(): DateTime
    {
        return $this->dateFrom;
    }

    public function getDateTo(): DateTime
    {
        return $this->dateTo;
    }

    public function getEventId(): int
    {
        return $this->eventId;
    }

}