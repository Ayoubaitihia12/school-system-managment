<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TeacherController extends AbstractController
{

    public function index(): Response
    {
        return $this->render('teacher/index.html.twig');
    }

    public function add(): Response
    {
        return $this->render('teacher/add.html.twig');
    }
}
