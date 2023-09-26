<?php

namespace App\Model;

use App\Entity\Classe;

class SubjectSearch{
    
    /** @var string */ 
    public ?string $name = '';

    /** @var string */ 
    public ?string $type = '';

    /** @var string */ 
    public ?Classe $class = null;


}