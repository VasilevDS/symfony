<?php /** @noinspection PhpUnused */


namespace App\Resource\DTO;


use DateTime;

class FreetimeDTO
{
    private int $freetimeId;
    private string $teacherName;
    private DateTime $dateFrom;
    private DateTime $dateTo;
    private int $eventId;

    public function __construct(
        int $freetimeId,
        string $teacherName,
        DateTime $dateFrom,
        DateTime $dateTo,
        int $eventId
    )
    {
        $this->freetimeId = $freetimeId;
        $this->teacherName = $teacherName;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->eventId = $eventId;
    }

    public function getFreetimeId(): int
    {
        return $this->freetimeId;
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