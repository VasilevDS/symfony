<?php


namespace App\DTO\Event;


use App\Enum\EventType;
use DateTime;

class LessonDTO implements EventDTOInterface
{
    private int $idTeacher;
    private int $idStudent;
    private int $idTheme;
    private int $idFreetime;
    private DateTime $dateFrom;
    private DateTime $dateTo;
    private string $type;

    public function __construct(
        int $idTeacher,
        int $idStudent,
        int $idTheme,
        int $idFreetime,
        DateTime $dateFrom,
        DateTime $dateTo
    )
    {
        $this->idTeacher = $idTeacher;
        $this->idStudent = $idStudent;
        $this->idTheme = $idTheme;
        $this->idFreetime = $idFreetime;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->type = EventType::LESSON;
    }

    public function getIdTeacher(): int
    {
        return $this->idTeacher;
    }

    public function getIdStudent(): int
    {
        return $this->idStudent;
    }

    public function getIdTheme(): int
    {
        return $this->idTheme;
    }

    public function getIdFreetime(): int
    {
        return $this->idFreetime;
    }

    public function getDateFrom(): DateTime
    {
        return $this->dateFrom;
    }

    public function getDateTo(): DateTime
    {
        return $this->dateTo;
    }

    public function getType(): string
    {
        return $this->type;
    }


}