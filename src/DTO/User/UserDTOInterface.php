<?php


namespace App\DTO\User;


interface UserDTOInterface
{
    public function getName(): string;
    public function getEmail(): string;
    public function getRoles(): array;
    public function getPassword(): string;
}