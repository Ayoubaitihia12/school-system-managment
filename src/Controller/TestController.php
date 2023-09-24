<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class TestController extends AbstractController
{
    public function index(Request $request): Response
    {
    
        return $this->render('test/index.html.twig');
    }
}
