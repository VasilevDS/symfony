<?php


namespace App\DTO\Event;


use App\Enum\EventType;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class LessonCreateDTO implements EventCreateDTOInterface
{
    private int $teacherId;
    private int $studentId;
    private int $themeId;
    private int $freetimeId;
    /**
     * @Assert\DateTime()
     */
    private DateTime $dateFrom;
    /**
     * @Assert\DateTime()
     */
    private DateTime $dateTo;
    private string $type;

    public function __construct(
        int $teacherId,
        int $studentId,
        int $themeId,
        int $freetimeId,
        DateTime $dateFrom,
        DateTime $dateTo
    )
    {
        $this->teacherId = $teacherId;
        $this->studentId = $studentId;
        $this->themeId = $themeId;
        $this->freetimeId = $freetimeId;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->type = EventType::LESSON;
    }

    public function getTeacherId(): int
    {
        return $this->teacherId;
    }

    public function getStudentId(): int
    {
        return $this->studentId;
    }

    public function getThemeId(): int
    {
        return $this->themeId;
    }

    public function getFreetimeId(): int
    {
        return $this->freetimeId;
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