<?php


namespace App\Enum;


use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class RoleType extends AbstractEnumType
{
    const TEACHER = 'TEACHER';
    const STUDENT = 'STUDENT';

    protected static $choices = [
        self::TEACHER => 'TEACHER',
        self::STUDENT => 'STUDENT',
    ];
}