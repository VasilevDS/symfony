<?php


namespace App\Validation\Rules;


use App\Repository\FreetimeRepository;
use DateTime;

class IsDateRangeIntersectedFreetimesIgnoreId implements RuleInterface
{
    private int $teacherId;
    private int $freetimeId;
    private DateTime $dateFrom;
    private DateTime $dateTo;
    private string $errorMsg;
    private FreetimeRepository $repository;

    public function __construct(FreetimeRepository $repository)
    {
        $this->repository = $repository;
    }


    public function setParam(int $teacherId, int $freetimeId, DateTime $dateFrom, DateTime $dateTo): void
    {
        $this->teacherId = $teacherId;
        $this->freetimeId = $freetimeId;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    /** @noinspection DuplicatedCode */
    public function passes(): bool
    {
        $query = $this->repository
            ->createQueryBuilder('f')
            ->join('f.event', 'e')
            ->where('f.teacher = :idTeacher')
            ->andWhere('e.dateFrom <= :dateTo')
            ->andWhere('e.dateTo >= :dateFrom')
            ->andWhere('f.id != :idFreetime')
            ->select('e.dateFrom, e.dateTo')
            ->setParameter('idTeacher', $this->teacherId)
            ->setParameter('dateFrom', $this->dateFrom)
            ->setParameter('dateTo', $this->dateTo)
            ->setParameter('idFreetime', $this->freetimeId)
            ->getQuery();

        $crossing_dates = $query->getResult();

        if ($crossing_dates !== []) {
            $this->errorMsg = "Intersects with time:";
            foreach ($crossing_dates as $dates) {
                $strDateFrom = date_format($dates['dateFrom'], 'd-m-Y H:i:s');
                $strDateTo = date_format($dates['dateTo'], 'd-m-Y H:i:s');
                $this->errorMsg .= "{$strDateFrom} - {$strDateTo};";
            }
            return false;
        }
        return true;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMsg;
    }
}