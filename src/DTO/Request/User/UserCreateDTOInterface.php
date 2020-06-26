<?php


namespace App\DTO\Request\User;


interface UserCreateDTOInterface
{
    public function getName(): string;
    public function getEmail(): string;
    public function getRoles(): array;
    public function getPassword(): string;
}