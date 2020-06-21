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
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="Theme")
     * @ORM\JoinTable(name="teacher_theme",
     *     joinColumns={@ORM\JoinColumn(name="teacher_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="theme_id", referencedColumnName="id")}
     *     )
     */
    private $themes;

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
        $this->freetimes = new ArrayCollection();
        $this->lessons = new ArrayCollection();
        $this->themes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getThemes(): ArrayCollection
    {
        return $this->themes;
    }

    /**
     * @param ArrayCollection $themes
     */
    public function setThemes(ArrayCollection $themes): void
    {
        $this->themes = $themes;
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
