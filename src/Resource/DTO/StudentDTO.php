<?php /** @noinspection PhpUnused */


namespace App\Resource\DTO;


class StudentDTO
{
    private int $studentId;
    private int $userID;
    private string $studentName;
    private string $email;
    private array $role;

    public function __construct(
        int $studentId,
        int $userID,
        string $studentName,
        string $email,
        array $role
    )
    {
        $this->studentId = $studentId;
        $this->userID = $userID;
        $this->studentName = $studentName;
        $this->email = $email;
        $this->role = $role;
    }

    /**
     * @return int
     */
    public function getStudentId(): int
    {
        return $this->studentId;
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
    public function getStudentName(): string
    {
        return $this->studentName;
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

}