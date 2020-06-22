<?php


namespace App\Validation\Rules;


interface RuleInterface
{
    public function passes(): bool;
    public function getErrorMessage(): string;
}