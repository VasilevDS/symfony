<?php


namespace App\DTO\Event;


use App\Enum\EventType;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class FreetimeCreateDTO implements EventCreateDTOInterface
{
    private int $teacherId;
    /**
     * @Assert\DateTime()
     */
    private DateTime $dateFrom;
    /**
     * @Assert\DateTime()
     */
    private DateTime $dateTo;
    private string $type;

    public function __construct(int $teacherId, DateTime $dateFrom, DateTime $dateTo)
    {
        $this->teacherId = $teacherId;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->type = EventType::FREETIME;
    }

    public function getTeacherId(): int
    {
        return $this->teacherId;
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