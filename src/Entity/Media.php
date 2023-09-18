<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $extension = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column]
    private ?bool $associated = null;

    #[Assert\File(
        maxSize: '4024k',
        mimeTypes: ['image/png', 'image/jpeg']
    )]
    
    protected $file;
    
    public function __construct()
    {
        $this->created = new \DateTime();
        $this->associated = true;
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
        $this->name = $name;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): static
    {
        $this->extension = $extension;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): static
    {
        $this->created = $created;

        return $this;
    }

    public function isAssociated(): ?bool
    {
        return $this->associated;
    }

    public function setAssociated(bool $associated): static
    {
        $this->associated = $associated;

        return $this;
    }


    public function upload($path)
    {
       
        $file = $this->getFile();
        // Generate a unique name for the file before saving it
        $this->name =  md5(uniqid());
        $fileName =$this->name.'.'.$file->getClientOriginalExtension();
       
        $mimeType = $file->getClientMimeType();

        $this->setTitle($file->getClientOriginalName());
        $this->setUrl($fileName);
        $this->setType($mimeType);
        $this->setExtension($file->getClientOriginalExtension());
        $file->move(
            $path."/".$file->getClientOriginalExtension(),
            $fileName
        );
    }
    public  function delete($path)
    {
         @unlink($path.$this->getExtension()."/".$this->getUrl());

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
    /**
     * Get url
     *
     * @return string 
     */
    public function getPath()
    {
        return "uploads/".$this->extension."/".$this->url;

    } 
}
