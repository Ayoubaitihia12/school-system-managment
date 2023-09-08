<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ClasseController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('classe/index.html.twig');
    }
}
