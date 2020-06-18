<?php


namespace App\Enum;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class EnumType extends Type
{
    protected $name;
    protected $values = array();

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        $values = array_map(function($val) {
            return "'".$val."'"; },
            $this->values
        );

        return "ENUM(".implode(", ", $values).")";
    }

    public function getName()
    {
        return $this->name;
    }
}