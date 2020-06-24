<?php /** @noinspection DuplicatedCode */


namespace App\Validation\Rules;


use App\Repository\FreetimeRepository;
use App\Repository\LessonRepository;
use DateTime;

class IsDateRangeIntersectedLessonsIgnoreId implements RuleInterface
{
    private int $freetimeId;
    private int $lessonId;
    private DateTime $dateFrom;
    private DateTime $dateTo;
    private string $errorMsg;
    private LessonRepository $repository;
    private FreetimeRepository $freetimeRepository;

    public function __construct(LessonRepository $repository, FreetimeRepository $freetimeRepository)
    {
        $this->repository = $repository;
        $this->freetimeRepository = $freetimeRepository;
    }


    public function setParam(int $lessonId,int $freetimeId, DateTime $dateFrom, DateTime $dateTo): void
    {
        $this->freetimeId = $freetimeId;
        $this->lessonId = $lessonId;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function passes(): bool
    {
        $queryL = $this->repository
            ->createQueryBuilder('l')
            ->join('l.event', 'e')
            ->where('l.freetime = :freetimeId')
            ->andWhere('l.id <= :lessonId')
            ->andWhere('e.dateFrom <= :dateTo')
            ->andWhere('e.dateTo >= :dateFrom')
            ->select('e.dateFrom, e.dateTo')
            ->setParameter('freetimeId', $this->freetimeId)
            ->setParameter('lessonId', $this->lessonId)
            ->setParameter('dateFrom', $this->dateFrom)
            ->setParameter('dateTo', $this->dateTo)
            ->getQuery();

        $crossingDatesLessons = $queryL->getResult();

        if ($crossingDatesLessons !== []) {
            $this->errorMsg = "Intersects with time:";
            foreach ($crossingDatesLessons as $dates) {
                $strDateFrom = date_format($dates['dateFrom'], 'd-m-Y H:i:s');
                $strDateTo = date_format($dates['dateTo'], 'd-m-Y H:i:s');
                $this->errorMsg .= "{$strDateFrom} - {$strDateTo};";
            }
            return false;
        }

        $queryF = $this->freetimeRepository
            ->createQueryBuilder('f')
            ->join('f.event', 'e')
            ->where('f.id = :freetimeId')
            ->andWhere('e.dateFrom <= :dateTo')
            ->andWhere('e.dateTo >= :dateFrom')
            ->select('count(e)')
            ->setParameter('freetimeId', $this->freetimeId)
            ->setParameter('dateFrom', $this->dateFrom)
            ->setParameter('dateTo', $this->dateTo)
            ->getQuery();

        /** @noinspection PhpUnhandledExceptionInspection */
        $crossingDatesFreetime = $queryF->getOneOrNullResult();

        if(array_shift($crossingDatesFreetime) === 0) {
            $this->errorMsg = 'does not overlap with the teacher’s freetime';
            return false;
        }

        return true;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMsg;
    }

}