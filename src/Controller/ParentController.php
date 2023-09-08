<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ParentController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('parent/index.html.twig');
    }
}
