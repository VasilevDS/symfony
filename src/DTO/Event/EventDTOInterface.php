<?php


namespace App\DTO\Event;

use DateTime;

interface EventDTOInterface
{
    public function getDateTo(): DateTime;
    public function getDateFrom(): DateTime;
    public function getType(): string;
}