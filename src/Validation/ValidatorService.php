<?php /** @noinspection PhpDocSignatureInspection */


namespace App\Validation;


use App\Validation\Rules\DateFromNoEarlierToday;
use App\Validation\Rules\DateFromNoLaterThanDateTo;
use App\Validation\Rules\IsDateRangeIntersectedFreetimes;
use App\Validation\Rules\IsDateRangeIntersectedFreetimesIgnoreId;
use App\Validation\Rules\RuleInterface;

class ValidatorService
{
    /**
     * @var RuleInterface[]
     */
    private array $rules;
    private array $result = [];
    public IsDateRangeIntersectedFreetimes $dateRangeIntersectedFreetimes;
    public DateFromNoEarlierToday $dateFromNoEarlierToday;
    public DateFromNoLaterThanDateTo $dateFromNoLaterThanDateTo;
    public IsDateRangeIntersectedFreetimesIgnoreId $dateRangeIntersectedFreetimesIgnoreId;

    public function __construct(
        DateFromNoEarlierToday $dateFromNoEarlierToday,
        DateFromNoLaterThanDateTo $dateFromNoLaterThanDateTo,
        IsDateRangeIntersectedFreetimesIgnoreId $dateRangeIntersectedFreetimesIgnoreId,
        IsDateRangeIntersectedFreetimes $dateRangeIntersectedFreetimes
    )
    {
        $this->dateRangeIntersectedFreetimes = $dateRangeIntersectedFreetimes;
        $this->dateFromNoEarlierToday = $dateFromNoEarlierToday;
        $this->dateFromNoLaterThanDateTo = $dateFromNoLaterThanDateTo;
        $this->dateRangeIntersectedFreetimesIgnoreId = $dateRangeIntersectedFreetimesIgnoreId;
    }


    public function addRules(RuleInterface ...$rule)
    {
        $this->rules = $rule;
    }

    public function validate(): array
    {
        foreach ($this->rules as $rule) {
            if(!$rule->passes()) {
                $this->result[] = $rule->getErrorMessage();
            }
        }
        return $this->result;
    }
}