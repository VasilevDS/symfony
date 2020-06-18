<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeacherRepository::class)
 */
class Teacher
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="teacher", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\ManyToMany(targetEntity=Theme::class, mappedBy="teacher")
     * @ORM\JoinTable(name="teachers_themes")
     */
    private $theme;

    /**
     * @ORM\OneToMany(targetEntity=Freetime::class, mappedBy="teacher")
     */
    private $freetimes;

    /**
     * @ORM\OneToMany(targetEntity=Lesson::class, mappedBy="teacher")
     */
    private $lessons;

    public function __construct()
    {
        $this->theme = new ArrayCollection();
        $this->freetimes = new ArrayCollection();
        $this->lessons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return Collection|TeacherTheme[]
     */
    public function getTheme(): Collection
    {
        return $this->theme;
    }

    public function addTheme(TeacherTheme $theme): self
    {
        if (!$this->theme->contains($theme)) {
            $this->theme[] = $theme;
            $theme->addTeacher($this);
        }

        return $this;
    }

    public function removeTheme(TeacherTheme $theme): self
    {
        if ($this->theme->contains($theme)) {
            $this->theme->removeElement($theme);
            $theme->removeTeacher($this);
        }

        return $this;
    }

    /**
     * @return Collection|Freetime[]
     */
    public function getFreetimes(): Collection
    {
        return $this->freetimes;
    }

    public function addFreetime(Freetime $freetime): self
    {
        if (!$this->freetimes->contains($freetime)) {
            $this->freetimes[] = $freetime;
            $freetime->setTeacher($this);
        }

        return $this;
    }

    public function removeFreetime(Freetime $freetime): self
    {
        if ($this->freetimes->contains($freetime)) {
            $this->freetimes->removeElement($freetime);
            // set the owning side to null (unless already changed)
            if ($freetime->getTeacher() === $this) {
                $freetime->setTeacher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Lesson[]
     */
    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    public function addLesson(Lesson $lesson): self
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons[] = $lesson;
            $lesson->setTeacher($this);
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): self
    {
        if ($this->lessons->contains($lesson)) {
            $this->lessons->removeElement($lesson);
            // set the owning side to null (unless already changed)
            if ($lesson->getTeacher() === $this) {
                $lesson->setTeacher(null);
            }
        }

        return $this;
    }
}
