<?php

namespace App\Model;

use App\Entity\Classe;

class StudentSearch{
    
    /** @var int */ 
    public ?string $admission = '';

    /** @var string */ 
    public ?string $name = '';

    /** @var string */ 
    public ?Classe $class = null;


}