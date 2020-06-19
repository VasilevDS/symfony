<?php


namespace App\Enum;


use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class EventType extends AbstractEnumType
{
    const FREETIME = 'FREETIME';
    const LESSON = 'LESSON';

    protected static $choices = [
        self::FREETIME => 'FREETIME',
        self::LESSON => 'LESSON',
    ];
}