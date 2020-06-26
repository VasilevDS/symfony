<?php


namespace App\DTO;


use Symfony\Component\Validator\Constraints as Assert;

class ThemeCreateDTO
{
    /**
     * @Assert\Length(min=2, max=255)
     * @Assert\Type("string")
     */
    private string $name;

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