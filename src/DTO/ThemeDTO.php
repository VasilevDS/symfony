<?php


namespace App\DTO;


class ThemeDTO
{
    private string $name;

    /**
     * ThemeDTO constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

}