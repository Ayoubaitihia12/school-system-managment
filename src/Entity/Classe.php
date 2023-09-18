<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
#[UniqueEntity('name')]
#[UniqueEntity('code')]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255 , unique:true)]
    private ?string $name = null;

    #[ORM\Column(length: 255  , unique:true)]
    #[Assert\Length(exactly: 6)]
    private ?string $code = null;

    #[ORM\OneToMany(mappedBy: 'Class', targetEntity: Subject::class)]
    private Collection $subjects;

    #[ORM\OneToMany(mappedBy: 'class', targetEntity: Teacher::class)]
    private Collection $teachers;

    #[ORM\OneToMany(mappedBy: 'class', targetEntity: ClassStudent::class)]
    private Collection $classStudents;

    public function __construct()
    {
        $this->subjects = new ArrayCollection();
        $this->teachers = new ArrayCollection();
        $this->classStudents = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = strtoupper($name);

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = strtoupper($code);

        return $this;
    }

    /**
     * @return Collection<int, Subject>
     */
    public function getSubjects(): Collection
    {
        return $this->subjects;
    }

    public function addSubject(Subject $subject): static
    {
        if (!$this->subjects->contains($subject)) {
            $this->subjects->add($subject);
            $subject->setClass($this);
        }

        return $this;
    }

    public function removeSubject(Subject $subject): static
    {
        if ($this->subjects->removeElement($subject)) {
            // set the owning side to null (unless already changed)
            if ($subject->getClass() === $this) {
                $subject->setClass(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->name;
    }

    /**
     * @return Collection<int, Teacher>
     */
    public function getTeachers(): Collection
    {
        return $this->teachers;
    }

    public function addTeacher(Teacher $teacher): static
    {
        if (!$this->teachers->contains($teacher)) {
            $this->teachers->add($teacher);
            $teacher->setClass($this);
        }

        return $this;
    }

    public function removeTeacher(Teacher $teacher): static
    {
        if ($this->teachers->removeElement($teacher)) {
            // set the owning side to null (unless already changed)
            if ($teacher->getClass() === $this) {
                $teacher->setClass(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ClassStudent>
     */
    public function getClassStudents(): Collection
    {
        return $this->classStudents;
    }

    public function addClassStudent(ClassStudent $classStudent): static
    {
        if (!$this->classStudents->contains($classStudent)) {
            $this->classStudents->add($classStudent);
            $classStudent->setClass($this);
        }

        return $this;
    }

    public function removeClassStudent(ClassStudent $classStudent): static
    {
        if ($this->classStudents->removeElement($classStudent)) {
            // set the owning side to null (unless already changed)
            if ($classStudent->getClass() === $this) {
                $classStudent->setClass(null);
            }
        }

        return $this;
    }
}
