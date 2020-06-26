<?php


namespace App\Enum;


use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class EventType extends AbstractEnumType
{
    const FREETIME = 'FREETIME';
    const LESSON = 'LESSON';
}