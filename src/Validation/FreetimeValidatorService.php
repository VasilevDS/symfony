<?php


namespace App\Validation;


use App\DTO\Event\FreetimeCreateDTO;
use App\Validation\Rules\DateFromNoEarlierToday;
use App\Validation\Rules\DateFromNoLaterThanDateTo;
use App\Validation\Rules\IsDateRangeIntersectedFreetimes;
use App\Validation\Rules\IsDateRangeIntersectedFreetimesIgnoreId;

class FreetimeValidatorService
{
    private DateFromNoEarlierToday $dateFromNoEarlierToday;
    private DateFromNoLaterThanDateTo $dateFromNoLaterThanDateTo;
    private IsDateRangeIntersectedFreetimesIgnoreId $dateRangeIntersectedFreetimesIgnoreId;
    private IsDateRangeIntersectedFreetimes $dateRangeIntersectedFreetimes;
    private ValidatorService $validator;

    public function __construct(
        DateFromNoEarlierToday $dateFromNoEarlierToday,
        DateFromNoLaterThanDateTo $dateFromNoLaterThanDateTo,
        IsDateRangeIntersectedFreetimesIgnoreId $dateRangeIntersectedFreetimesIgnoreId,
        IsDateRangeIntersectedFreetimes $dateRangeIntersectedFreetimes,
        ValidatorService $validator
    )
    {
        $this->dateFromNoEarlierToday = $dateFromNoEarlierToday;
        $this->dateFromNoLaterThanDateTo = $dateFromNoLaterThanDateTo;
        $this->dateRangeIntersectedFreetimesIgnoreId = $dateRangeIntersectedFreetimesIgnoreId;
        $this->dateRangeIntersectedFreetimes = $dateRangeIntersectedFreetimes;
        $this->validator = $validator;
    }

    public function validateForCreate(FreetimeCreateDTO $DTO): void
    {
        $this->dateFromNoEarlierToday->setParam($DTO->getDateFrom());
        $this->dateFromNoLaterThanDateTo->setParam($DTO->getDateFrom(), $DTO->getDateTo());
        $this->dateRangeIntersectedFreetimes->setParam(
            $DTO->getIdTeacher(),
            $DTO->getDateFrom(),
            $DTO->getDateTo()
        );

        $this->validator->validate(
            $this->dateFromNoEarlierToday,
            $this->dateFromNoLaterThanDateTo,
            $this->dateRangeIntersectedFreetimes
        );
    }

    public function validateForUpdate(FreetimeCreateDTO $DTO, int $freetimeId): void
    {
        $this->dateFromNoEarlierToday->setParam($DTO->getDateFrom());
        $this->dateFromNoLaterThanDateTo->setParam($DTO->getDateFrom(), $DTO->getDateTo());
        $this->dateRangeIntersectedFreetimesIgnoreId->setParam(
            $freetimeId,
            $DTO->getIdTeacher(),
            $DTO->getDateFrom(),
            $DTO->getDateTo()
        );

        $this->validator->validate(
            $this->dateFromNoEarlierToday,
            $this->dateFromNoLaterThanDateTo,
            $this->dateRangeIntersectedFreetimesIgnoreId
        );
    }
}