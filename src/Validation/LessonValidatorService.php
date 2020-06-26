<?php


namespace App\Validation;


use App\DTO\Request\Event\LessonCreateDTO;
use App\Validation\Rules\DateFromNoEarlierToday;
use App\Validation\Rules\DateFromNoLaterThanDateTo;
use App\Validation\Rules\IsDateRangeIntersectedLessons;
use App\Validation\Rules\IsDateRangeIntersectedLessonsIgnoreId;

class LessonValidatorService
{
    private ValidatorService $validator;
    private IsDateRangeIntersectedLessons $dateRangeIntersectedLessons;
    private IsDateRangeIntersectedLessonsIgnoreId $dateRangeIntersectedLessonsIgnoreId;
    private DateFromNoEarlierToday $dateFromNoEarlierToday;
    private DateFromNoLaterThanDateTo $dateFromNoLaterThanDateTo;

    public function __construct(
        DateFromNoEarlierToday $dateFromNoEarlierToday,
        DateFromNoLaterThanDateTo $dateFromNoLaterThanDateTo,
        IsDateRangeIntersectedLessons $dateRangeIntersectedLessons,
        IsDateRangeIntersectedLessonsIgnoreId $dateRangeIntersectedLessonsIgnoreId,
        ValidatorService $validator
    )
    {
        $this->validator = $validator;
        $this->dateRangeIntersectedLessons = $dateRangeIntersectedLessons;
        $this->dateRangeIntersectedLessonsIgnoreId = $dateRangeIntersectedLessonsIgnoreId;
        $this->dateFromNoEarlierToday = $dateFromNoEarlierToday;
        $this->dateFromNoLaterThanDateTo = $dateFromNoLaterThanDateTo;
    }

    public function validateForCreate(LessonCreateDTO $DTO): void
    {
        $this->dateFromNoEarlierToday->setParam($DTO->getDateFrom());
        $this->dateFromNoLaterThanDateTo->setParam($DTO->getDateFrom(), $DTO->getDateTo());
        $this->dateRangeIntersectedLessons->setParam(
            $DTO->getFreetimeId(),
            $DTO->getDateFrom(),
            $DTO->getDateTo()
        );

        $this->validator->validate(
            $this->dateFromNoEarlierToday,
            $this->dateFromNoLaterThanDateTo,
            $this->dateRangeIntersectedLessons
        );
    }

    public function validateForUpdate(LessonCreateDTO $DTO, int $lessonId): void
    {
        $this->dateFromNoEarlierToday->setParam($DTO->getDateFrom());
        $this->dateFromNoLaterThanDateTo->setParam($DTO->getDateFrom(), $DTO->getDateTo());
        $this->dateRangeIntersectedLessonsIgnoreId->setParam(
            $lessonId,
            $DTO->getFreetimeId(),
            $DTO->getDateFrom(),
            $DTO->getDateTo()
        );

        $this->validator->validate(
            $this->dateFromNoEarlierToday,
            $this->dateFromNoLaterThanDateTo,
            $this->dateRangeIntersectedLessonsIgnoreId
        );
    }
}