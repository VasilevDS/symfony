<?php


namespace App\DTO\User;

use App\Enum\RoleType;
use Symfony\Component\Validator\Constraints as Assert;

class TeacherCreateDTO implements UserCreateDTOInterface
{
    /**
     * @Assert\Length(min=2, max=255)
     * @Assert\Type("string")
     */
    private String $name;
    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private String $email;
    private array $roles;
    /**
     * @Assert\Length(min=8, max=255)
     */
    private String $password;

    private array $themes;

    public function __construct(string $name, string $email, string $password, array $themes)
    {
        $this->name = $name;
        $this->email = $email;
        $this->roles = [RoleType::TEACHER];
        $this->password = $password;
        $this->themes = $themes;
    }

    /**
     * @return String
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return String
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return String
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return array
     */
    public function getThemes(): array
    {
        return $this->themes;
    }

}