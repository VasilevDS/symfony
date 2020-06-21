<?php


namespace App\DTO\User;

use App\Enum\RoleType;

class StudentDTO implements UserDTOInterface
{
    private String $name;
    private String $email;
    private array $roles;
    private String $password;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->roles = [RoleType::STUDENT];
        $this->password = $password;
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

}