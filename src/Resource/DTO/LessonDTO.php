<?php /** @noinspection PhpUnused */


namespace App\Resource\DTO;


use DateTime;

class LessonDTO
{

    private int $lessonId;
    private int $teacherId;
    private string $teacherName;
    private int $studentId;
    private string $studentName;
    private string $themeName;
    private DateTime $dateFrom;
    private DateTime $dateTo;

    public function __construct(
        int $lessonId,
        int $teacherId,
        string $teacherName,
        int $studentId,
        string $studentName,
        string $themeName,
        DateTime $dateFrom,
        DateTime $dateTo
    )
    {
        $this->lessonId = $lessonId;
        $this->teacherId = $teacherId;
        $this->teacherName = $teacherName;
        $this->studentId = $studentId;
        $this->studentName = $studentName;
        $this->themeName = $themeName;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    /**
     * @return int
     */
    public function getLessonId(): int
    {
        return $this->lessonId;
    }

    /**
     * @return int
     */
    public function getTeacherId(): int
    {
        return $this->teacherId;
    }

    /**
     * @return string
     */
    public function getTeacherName(): string
    {
        return $this->teacherName;
    }

    /**
     * @return int
     */
    public function getStudentId(): int
    {
        return $this->studentId;
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
    public function getThemeName(): string
    {
        return $this->themeName;
    }

    /**
     * @return DateTime
     */
    public function getDateFrom(): DateTime
    {
        return $this->dateFrom;
    }

    /**
     * @return DateTime
     */
    public function getDateTo(): DateTime
    {
        return $this->dateTo;
    }

}