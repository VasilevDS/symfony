<?php


namespace App\Validation\Rules;


use DateTime;

class DateFromNoLaterThanDateTo implements RuleInterface
{
    private DateTime $dateFrom;
    private DateTime $dateTo;

    public function setParam(DateTime $dateFrom, DateTime $dateTo): void
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function passes(): bool
    {
        return $this->dateFrom <= $this->dateTo;
    }

    public function getErrorMessage(): string
    {
        return 'The date from must be a date before date to.';
    }
}