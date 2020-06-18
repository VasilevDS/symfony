<?php


namespace App\Enum;


class EventType extends EnumType
{
    protected $name = 'eventType';
    protected $values = array('FREETIME', 'LESSON');
}