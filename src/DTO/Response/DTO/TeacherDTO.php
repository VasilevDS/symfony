<?php /** @noinspection PhpUnused */


namespace App\DTO\Response\DTO;

class TeacherDTO
{
    private int $teacherId;
    private int $userID;
    private string $teacherName;
    private string $email;
    private array $role;
    private array $themes;

    public function __construct(
        int $teacherId,
        int $userID,
        string $teacherName,
        array $themes,
        string $email,
        array $role
    )
    {
        $this->teacherId = $teacherId;
        $this->userID = $userID;
        $this->teacherName = $teacherName;
        $this->email = $email;
        $this->role = $role;
        $this->themes = $themes;
    }

    /**
     * @return int
     */
    public function getTeacherId(): int
    {
        return $this->teacherId;
    }

    /**
     * @return int
     */
    public function getUserID(): int
    {
        return $this->userID;
    }

    /**
     * @return string
     */
    public function getTeacherName(): string
    {
        return $this->teacherName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function getRole(): array
    {
        return $this->role;
    }

    /**
     * @return array
     */
    public function getThemes(): array
    {
        return $this->themes;
    }

}