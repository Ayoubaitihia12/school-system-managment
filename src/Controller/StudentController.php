<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('student/index.html.twig');
    }

    public function add(): Response
    {
        return $this->render('student/add.html.twig');
    }

    public function view(): Response
    {
        return $this->render('student/view.html.twig');
    }
}
