<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: StudentRepository::class)]

/** 
* @ORM\Entity() 
* @UniqueEntity(fields={"email"})
* @UniqueEntity(fields={"Admission_id"})
*/

class Student implements PasswordAuthenticatedUserInterface
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


    #[ORM\Column(length: 255)]
    private ?string $Gender = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 6,
    )]
    private ?string $Adress = null;

    #[ORM\Column]
    private ?int $Phone = null;

    #[ORM\Column(length: 255)]
    private ?string $Nationality = null;

    #[ORM\Column(length: 255)]
    private ?string $Password = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_of_birth = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $admission_date = null;

    #[ORM\ManyToOne(inversedBy: 'student')]
    private ?Parents $parents = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Media $image = null;

    #[Assert\File(
        maxSize: '4024k',
        mimeTypes: ['image/png', 'image/jpeg']
    )]

    protected $file;

    #[ORM\Column(length: 255 , unique:true)]
    #[Assert\Length(exactly: 6)]
    private ?string $admission = null;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: ClassStudent::class)]
    private Collection $classStudents;

    public function __construct()
    {
        $this->classStudents = new ArrayCollection();
    }

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


    public function getGender(): ?string
    {
        return $this->Gender;
    }

    public function setGender(string $Gender): static
    {
        $this->Gender = $Gender;

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

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->date_of_birth;
    }

    public function setDateOfBirth(\DateTimeInterface $date_of_birth): static
    {
        $this->date_of_birth = $date_of_birth;

        return $this;
    }

    public function getAdmissionDate(): ?\DateTimeInterface
    {
        return $this->admission_date;
    }

    public function setAdmissionDate(\DateTimeInterface $admission_date): static
    {
        $this->admission_date = $admission_date;

        return $this;
    }

    public function getParents(): ?Parents
    {
        return $this->parents;
    }

    public function setParents(?Parents $parents): static
    {
        $this->parents = $parents;

        return $this;
    }

    public function getImage(): ?Media
    {
        return $this->image;
    }

    public function setImage(?Media $image): static
    {
        $this->image = $image;

        return $this;
    }

         /**
    * Get file
    * @return  
    */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
    * Set file
    * @return $this
    */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    public function getAdmission(): ?string
    {
        return $this->admission;
    }

    public function setAdmission(string $admission): static
    {
        $this->admission = $admission;

        return $this;
    }

    public function __toString(){
        return $this->getAdmission().' - '.$this->FirstName . ' ' . $this->LastName;
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
            $classStudent->setStudent($this);
        }

        return $this;
    }

    public function removeClassStudent(ClassStudent $classStudent): static
    {
        if ($this->classStudents->removeElement($classStudent)) {
            // set the owning side to null (unless already changed)
            if ($classStudent->getStudent() === $this) {
                $classStudent->setStudent(null);
            }
        }

        return $this;
    }
}
