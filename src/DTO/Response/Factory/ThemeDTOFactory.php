<?php


namespace App\DTO\Response\Factory;


use App\DTO\Response\DTO\ThemeDTO;
use App\Entity\Theme;

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