<?php


namespace App\Resource\Factory;


use App\Entity\Theme;
use App\Resource\DTO\ThemeDTO;

class ThemeDTOFactory
{
    public function fromTheme(Theme $theme): ThemeDTO
    {
        return new ThemeDTO(
            $theme->getId(),
            $theme->getName()
        );
    }
}