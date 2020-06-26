<?php


namespace App\DTO\Request\Event;

use DateTime;

interface EventCreateDTOInterface
{
    public function getDateTo(): DateTime;
    public function getDateFrom(): DateTime;
    public function getType(): string;
}