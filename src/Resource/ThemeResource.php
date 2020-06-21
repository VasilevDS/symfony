<?php


namespace App\Resource;


use App\Entity\Theme;

class ThemeResource
{
    public static function toArray(Theme $theme)
    {
        return [
            'id' => $theme->getId(),
            'name' => $theme->getName(),
        ];
    }
}