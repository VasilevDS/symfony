<?php


namespace App\Validation\Rules;


use DateTime;

class DateFromNoEarlierToday implements RuleInterface
{
    private DateTime $dateFrom;

    public function setParam(DateTime $dateFrom): void
    {
        $this->dateFrom = $dateFrom;
    }
    public function passes(): bool
    {
        return $this->dateFrom > new DateTime();
    }

    public function getErrorMessage(): string
    {
        return 'The date from must be a date after today.';
    }

}