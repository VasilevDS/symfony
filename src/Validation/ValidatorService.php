<?php /** @noinspection PhpDocSignatureInspection */


namespace App\Validation;

use App\Validation\Rules\RuleInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ValidatorService
{
    public function validate(RuleInterface ...$rules): void
    {
        foreach ($rules as $rule) {
            if(!$rule->passes()) {
                throw new BadRequestException($rule->getErrorMessage());
            }
        }
    }
}