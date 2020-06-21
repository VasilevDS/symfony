<?php


namespace App\DTO\Event;


use App\Enum\EventType;
use DateTime;

class FreetimeDTO implements EventDTOInterface
{
    private int $idTeacher;
    private DateTime $dateFrom;
    private DateTime $dateTo;
    private string $type;

    public function __construct(int $idTeacher, DateTime $dateFrom, DateTime $dateTo)
    {
        $this->idTeacher = $idTeacher;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->type = EventType::FREETIME;
    }

    public function getIdTeacher(): int
    {
        return $this->idTeacher;
    }

    public function getDateTo(): DateTime
    {
        return $this->dateTo;
    }

    public function getDateFrom(): DateTime
    {
        return $this->dateFrom;
    }


    public function getType(): string
    {
        return $this->type;
    }
}