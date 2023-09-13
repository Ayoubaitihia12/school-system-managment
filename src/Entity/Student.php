<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: StudentRepository::class)]

/** 
* @ORM\Entity() 
* @UniqueEntity(fields={"email"})
* @UniqueEntity(fields={"Admission_id"})
*/

class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $FirstName = null;

    #[ORM\Column(length: 255)]
    private ?string $LastName = null;

    #[ORM\Column(length: 255,unique:true)]
    private ?string $Email = null;

    #[ORM\Column(unique:true)]
    #[Assert\Length(
        min: 6,
    )]
    private ?String $Admission_id = null;

    #[ORM\Column(length: 255)]
    private ?string $Gender = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Date]
    private ?\DateTimeInterface $Date_of_Birth = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Date]
    private ?\DateTimeInterface $Admission_Date = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 6,
    )]
    private ?string $Adress = null;

    #[ORM\Column]
    private ?int $Phone = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Classe $Classe = null;

    #[ORM\Column(length: 255)]
    private ?string $Nationality = null;

    #[ORM\Column(length: 255)]
    private ?string $Password = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): static
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): static
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getAdmissionId(): ?String
    {
        return $this->Admission_id;
    }

    public function setAdmissionId(String $Admission_id): static
    {
        $this->Admission_id = $Admission_id;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->Gender;
    }

    public function setGender(string $Gender): static
    {
        $this->Gender = $Gender;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTime
    {
        return $this->Date_of_Birth;
    }

    public function setDateOfBirth(\DateTime $Date_of_Birth): static
    {
        $this->Date_of_Birth = $Date_of_Birth;

        return $this;
    }

    public function getAdmissionDate(): ?\DateTime
    {
        return $this->Admission_Date;
    }

    public function setAdmissionDate(\DateTime $Admission_Date): static
    {
        $this->Admission_Date = $Admission_Date;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->Adress;
    }

    public function setAdress(string $Adress): static
    {
        $this->Adress = $Adress;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->Phone;
    }

    public function setPhone(int $Phone): static
    {
        $this->Phone = $Phone;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->Classe;
    }

    public function setClasse(?Classe $Classe): static
    {
        $this->Classe = $Classe;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->Nationality;
    }

    public function setNationality(string $Nationality): static
    {
        $this->Nationality = $Nationality;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): static
    {
        $this->Password = $Password;

        return $this;
    }
}
